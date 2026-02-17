<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    protected $message;
    protected $actionUrl;
    protected $type; // 'info', 'success', 'warning', 'error'

    /**
     * Create a new notification instance.
     */
    public function __construct($message, $actionUrl = null, $type = 'info')
    {
        $this->message = $message;
        $this->actionUrl = $actionUrl;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'action_url' => $this->actionUrl,
            'type' => $this->type,
            'icon' => $this->getIcon(),
        ];
    }

    protected function getIcon()
    {
        return match($this->type) {
            'success' => 'check-circle',
            'warning' => 'exclamation-circle',
            'error' => 'x-circle',
            default => 'information-circle',
        };
    }
}
