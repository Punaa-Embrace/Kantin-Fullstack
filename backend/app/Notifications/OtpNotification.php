<?php

namespace App\Notifications;

use App\Channels\WhatsappChannel;
use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtpNotification extends Notification
{
    use Queueable;

    public Otp $otp;

    /**
     * Create a new notification instance.
     * @param Otp $otp The OTP model instance.
     */
    public function __construct(Otp $otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return [WhatsappChannel::class];
    }

    /**
     * Get the WhatsApp representation of the notification.
     */
    public function toWhatsapp(object $notifiable): string
    {
        return "JakaAja: Kode OTP Anda adalah *{$this->otp->code}*. Jangan berikan kode ini kepada siapa pun.";
    }
}
