<?php

namespace App\Notifications;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberInvitation extends Notification
{
    use Queueable;

    protected $teamMember;
    protected $inviter;

    /**
     * Create a new notification instance.
     *
     * @param TeamMember $teamMember
     * @param User $inviter
     */
    public function __construct(TeamMember $teamMember, User $inviter)
    {
        $this->teamMember = $teamMember;
        $this->inviter = $inviter;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->inviter->name . ' has invited you to join their team.')
                    ->action('View Invitation', route('user.team-members.index'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Team Member Invitation',
            'message' => $this->inviter->name . ' has invited you to join their team.',
            'action_url' => route('user.team-members.index'),
            'created_at' => now()->toDateTimeString(),
            'is_read' => false,
            'icon' => '<svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>',
        ];
    }
}
