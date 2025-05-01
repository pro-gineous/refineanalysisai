<?php

namespace App\Notifications;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberInvitationResponse extends Notification
{
    use Queueable;

    protected $teamMember;
    protected $responder;
    protected $status;

    /**
     * Create a new notification instance.
     *
     * @param TeamMember $teamMember
     * @param User $responder
     * @param string $status
     */
    public function __construct(TeamMember $teamMember, User $responder, $status)
    {
        $this->teamMember = $teamMember;
        $this->responder = $responder;
        $this->status = $status;
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
                    ->line($this->responder->name . ' has ' . $this->status . ' your team invitation.')
                    ->action('View Team Members', route('user.team-members.index'))
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
            'title' => 'Team Invitation Response',
            'message' => $this->responder->name . ' has ' . $this->status . ' your team invitation.',
            'action_url' => route('user.team-members.index'),
            'icon' => '<svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v2h5v-2zM7 13a4.5 4.5 0 015.284-4.447c.346.956 1.1 1.615 2.056 1.615.956 0 1.71-.659 2.056-1.615A4.5 4.5 0 0119.663 8M7 13V5a2 2 0 012-2h6a2 2 0 012 2v8" /></svg>',
            'created_at' => now()->toDateTimeString(),
            'is_read' => false,
        ];
    }
}
