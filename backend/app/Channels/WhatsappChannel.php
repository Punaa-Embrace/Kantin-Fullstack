<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class WhatsappChannel
{
  /**
   * Send the given notification.
   */
  public function send($notifiable, Notification $notification)
  {
    $target = $notifiable->routeNotificationFor('whatsapp');
    $message = $notification->toWhatsapp($notifiable);

    if (!$target || !$message) {
      return;
    }

    $token = config('services.fonnte.token');
    if (!$token) {
      Log::error('Fonnte token is not configured. Please check your .env and config/services.php files.');
      return;
    }

    $response = $this->sendMessage($target, $message, $token);

    if (!$response['success']) {
      Log::error('Failed to send WhatsApp message via Fonnte', [
        'error' => $response['error'] ?? 'Unknown error',
        'target' => $target,
        'response' => $response['response'] ?? null,
      ]);
    }
  }

  /**
   * Send a message using the Fonnte API.
   */
  private function sendMessage(string $target, string $message, string $token)
  {
    $curl = curl_init();

    curl_setopt_array($curl, [
      CURLOPT_URL => 'https://api.fonnte.com/send',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => [
        'target' => $target,
        'message' => $message,
        'countryCode' => '62',
      ],
      CURLOPT_HTTPHEADER => [
        'Authorization: ' . $token,
      ],
    ]);

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
      $error_msg = curl_error($curl);
      curl_close($curl);
      return ['success' => false, 'error' => $error_msg];
    }

    curl_close($curl);
    $decodedResponse = json_decode($response, true);
    return ['success' => ($decodedResponse['status'] ?? false), 'response' => $response];
  }
}