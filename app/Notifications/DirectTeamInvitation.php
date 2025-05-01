<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DirectTeamInvitation extends Notification
{
    use Queueable;

    protected $inviter;
    protected $invitationMessage;
    protected $teamName;
    protected $actionUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $inviter, $teamName = null, $actionUrl = null, $message = null)
    {
        $this->inviter = $inviter;
        $this->teamName = $teamName ?? 'Team';
        $this->actionUrl = $actionUrl ?? route('user.team-members.index');
        $this->invitationMessage = $message ?? 'has invited you to join their team.';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Team Member Invitation')
                    ->greeting('Hello ' . $notifiable->name . '!')
                    ->line($this->inviter->name . ' ' . $this->invitationMessage)
                    ->action('View Invitation', $this->actionUrl)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Team Member Invitation - ' . $this->teamName,
            'message' => $this->inviter->name . ' ' . $this->invitationMessage,
            'action_url' => $this->actionUrl,
            'created_at' => now()->toDateTimeString(),
            'is_read' => false,
            'icon' => 'users',
        ];
    }
}
