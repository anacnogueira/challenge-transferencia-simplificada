<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionCompleted extends Notification
{
    use Queueable;

    public $value;
    public $payerName;

    /**
     * Create a new notification instance.
     */
    public function __construct(float $value, string $payerName)
    {
        $this->value = $value;
        $this->payerName = $payerName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $title = 'You received a transfer!';
        
        return (new MailMessage)
        ->subject($title)
        ->view(
            'emails.transfer-completed',
            [
                'title' => $title,
                'value' => $this->value,
                'payerName' => $this->payerName,
            ]
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
