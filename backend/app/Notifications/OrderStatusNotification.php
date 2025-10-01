<?php

namespace App\Notifications;

use App\Channels\WhatsappChannel;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Order $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order->load(['tenant.building', 'tenant.manager', 'items']);
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return $notifiable->phone ? [WhatsappChannel::class] : [];
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsapp(object $notifiable): string
    {
        $tenantName = $this->order->tenant->name;
        $orderCode = "*{$this->order->order_code}*";

        $statusMessage = match ($this->order->order_status) {
            'preparing' => "✅ Pesanan Anda di *{$tenantName}* ({$orderCode}) telah dikonfirmasi dan sedang disiapkan!",
            'rejected' => "❌ Mohon maaf, pesanan Anda di *{$tenantName}* ({$orderCode}) telah ditolak.",
            'ready_to_pickup' => "🎉 Hore! Pesanan Anda di *{$tenantName}* ({$orderCode}) sudah siap diambil. Silakan menuju ke lokasi kantin di {$this->order->tenant->building->name}.",
            'completed' => "🙏 Terima kasih! Pesanan Anda di *{$tenantName}* ({$orderCode}) telah selesai.",
            default => null,
        };

        if (is_null($statusMessage)) {
            return '';
        }

        $details = "";
        if ($this->order->order_status === 'preparing') {
            $details .= "\n\n*Rincian Pesanan:*\n";
            foreach ($this->order->items as $item) {
                $details .= "- {$item->item_name} (x{$item->quantity})\n";
            }

            if ($this->order->student_notes) {
                $details .= "\n*Catatan Anda:*\n";
                $details .= "_{$this->order->student_notes}_";
            }
        }
        
        $footer = "\n\nTerima kasih,\n*{$tenantName}*";
        if ($this->order->tenant->manager?->name) {
            $footer .= " ({$this->order->tenant->manager->name})";
        }
        if ($this->order->tenant->building?->name) {
            $footer .= "\n📍 {$this->order->tenant->building->name}";
        }

        return $statusMessage . $details . $footer;
    }
    
    /**
     * Determine if the notification should be sent.
     */
    public function shouldSend(object $notifiable, string $channel): bool
    {
        return in_array($this->order->order_status, [
            'preparing',
            'rejected',
            'ready_to_pickup',
            // 'completed'
        ]);
    }
}
