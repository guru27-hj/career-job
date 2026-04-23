<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobApplicationNotification extends Notification
{
    use Queueable;

    private $applicationId;
    private $jobTitle;
    private $applicantName;

    /**
     * Create a new notification instance.
     */
    public function __construct($applicationId, $jobTitle, $applicantName = 'A new candidate')
    {
        $this->applicationId = $applicationId;
        $this->jobTitle = $jobTitle;
        $this->applicantName = $applicantName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Only trigger the database bell ringing
        return ['database'];
    }

    /**
     * Get the array representation of the notification for the database.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => 'New Application',
            'message' => "{$this->applicantName} applied for {$this->jobTitle}.",
            'url' => route('admin.applications.show', $this->applicationId),
            'icon' => 'fas fa-briefcase',
        ];
    }
}
