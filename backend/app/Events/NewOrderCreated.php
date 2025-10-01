<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $orderId;

    /**
     * Create a new event instance.
     */
    public function __construct(int $orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        $order = Order::find($this->orderId);

        // This ensures the event is only sent to the specific tenant
        // And protects against a deleted order causing an error
        return $order ? [new PrivateChannel('tenant.' . $order->tenant_id)] : [];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'new.order';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        $order = Order::with('student')->findOrFail($this->orderId);

        return [
            'order_code' => $order->order_code,
            'student_name' => $order->student->name,
            'total_price' => $order->total_price,
            'order_url' => route('tenant.orders.show', $order->id),
        ];
    }
}
