<?php

namespace App\Http\Controllers;

use App\Http\Controllers\NotificationPreferenceController;
use App\Models\TeamMember;
use App\Models\User;
use App\Notifications\DirectTeamInvitation;
use App\Notifications\TeamMemberInvitation;
use App\Notifications\TeamMemberInvitationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class TeamMemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teamMembers = $user->teamMembers;
        $invitations = $user->teamMemberOf()->where('status', 'pending')->get();
        return view('user.team-members.index', compact('teamMembers', 'invitations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = Auth::user();
        $teamMemberUser = User::where('email', $request->email)->first();

        if ($user->id === $teamMemberUser->id) {
            return back()->with('error', 'You cannot add yourself as a team member.');
        }

        $existingMember = TeamMember::where('user_id', $user->id)
            ->where('team_member_id', $teamMemberUser->id)
            ->first();

        if ($existingMember) {
            return back()->with('error', 'This user is already a team member or has a pending invitation.');
        }

        $teamMember = TeamMember::create([
            'user_id' => $user->id,
            'team_member_id' => $teamMemberUser->id,
            'status' => 'pending',
        ]);

        // التحقق من تفضيلات الإشعارات للمستخدم المدعو
        if (NotificationPreferenceController::userWantsNotification('team_invitations', $teamMemberUser->id)) {
            try {
                // إضافة إشعار مباشرة إلى قاعدة البيانات
                \DB::table('notifications')->insert([
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'type' => 'App\\Notifications\\TeamMemberInvitation',
                    'notifiable_type' => 'App\\Models\\User',
                    'notifiable_id' => $teamMemberUser->id,
                    'data' => json_encode([
                        'title' => 'دعوة لعضوية فريق',
                        'message' => $user->name . ' قام بدعوتك للانضمام إلى فريقه',
                        'action_url' => route('user.team-members.index'),
                        'created_at' => now()->toDateTimeString(),
                        'is_read' => false,
                        'icon' => '<svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // للتشخيص
                \Log::info("تم إرسال إشعار الدعوة للمستخدم {$teamMemberUser->email}");
            } catch (\Exception $e) {
                \Log::error("خطأ في إرسال إشعار الدعوة: {$e->getMessage()}");
                // مواصلة التنفيذ حتى في حالة فشل الإشعار
            }
        } else {
            \Log::info("تم تخطي إرسال الإشعار للمستخدم {$teamMemberUser->email} بناءً على تفضيلاته");
        }

        return back()->with('success', 'Team member invitation sent successfully.');
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        if ($teamMember->team_member_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $teamMember->update(['status' => $request->status]);

        // إفادة صاحب الدعوة بالرد
        $inviter = $teamMember->user;
        $statusMessage = $request->status === 'accepted' ? 'قبول' : 'رفض';
        $arabicStatusMessage = $request->status === 'accepted' ? 'قام بقبول دعوة الفريق الخاصة بك' : 'قام برفض دعوة الفريق الخاصة بك';
        
        // التحقق من تفضيلات الإشعارات لصاحب الدعوة
        if (NotificationPreferenceController::userWantsNotification('team_invitations', $inviter->id)) {
            try {
                // إضافة إشعار مباشرة إلى قاعدة البيانات
                \DB::table('notifications')->insert([
                    'id' => \Illuminate\Support\Str::uuid()->toString(),
                    'type' => 'App\\Notifications\\TeamMemberInvitationResponse',
                    'notifiable_type' => 'App\\Models\\User',
                    'notifiable_id' => $inviter->id,
                    'data' => json_encode([
                        'title' => $statusMessage . ' دعوة الفريق',
                        'message' => Auth::user()->name . ' ' . $arabicStatusMessage,
                        'action_url' => route('user.team-members.index'),
                        'created_at' => now()->toDateTimeString(),
                        'is_read' => false,
                        'icon' => '<svg class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v2h5v-2zM7 13a4.5 4.5 0 015.284-4.447c.346.956 1.1 1.615 2.056 1.615.956 0 1.71-.659 2.056-1.615A4.5 4.5 0 0119.663 8M7 13V5a2 2 0 012-2h6a2 2 0 012 2v8" /></svg>'
                    ]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // للتشخيص
                \Log::info("تم إرسال إشعار الرد على الدعوة إلى {$inviter->email}");
            } catch (\Exception $e) {
                \Log::error("خطأ في إرسال إشعار الرد على الدعوة: {$e->getMessage()}");
                // مواصلة التنفيذ حتى في حالة فشل الإشعار
            }
        } else {
            \Log::info("تم تخطي إرسال إشعار الرد للمستخدم {$inviter->email} بناءً على تفضيلاته");
        }

        return back()->with('success', "Team member invitation $statusMessage.");
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->user_id !== Auth::id() && $teamMember->team_member_id !== Auth::id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $teamMember->delete();

        return back()->with('success', 'Team member removed.');
    }
}
