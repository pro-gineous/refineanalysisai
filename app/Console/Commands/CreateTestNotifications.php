<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\TeamMember;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DirectTeamInvitation;

class CreateTestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:test {email? : The email of the user to send notifications to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test notifications for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'testt@testt.com';
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found!");
            return 1;
        }
        
        $this->info("Creating test notifications for user: {$user->name} ({$user->email})");
        
        // تحقق من وجود إشعارات للمستخدم
        $currentCount = $user->notifications()->count();
        $this->info("Current notifications count: {$currentCount}");
        
        // إنشاء إشعار تجريبي
        $inviter = User::where('email', '!=', $email)->first();
        
        if (!$inviter) {
            $this->error("No other user found to use as inviter!");
            return 1;
        }
        
        // إرسال إشعار مباشر باستخدام الإشعار الجديد DirectTeamInvitation
        try {
            $notification = new DirectTeamInvitation($inviter);
            $user->notify($notification);
            $this->info("✅ Test notification sent directly to user!");
        } catch (\Exception $e) {
            $this->error("❌ Error sending notification: {$e->getMessage()}");
            return 1;
        }
        
        // تأكد من إضافة الإشعار
        $newCount = $user->notifications()->count();
        $this->info("New notifications count: {$newCount}");
        
        if ($newCount > $currentCount) {
            $this->info("✅ Test notification created successfully!");
            return 0;
        } else {
            $this->error("❌ Failed to create notification!");
            return 1;
        }
    }
}
