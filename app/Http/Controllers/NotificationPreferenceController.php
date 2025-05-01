<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationPreferenceController extends Controller
{
    /**
     * عرض صفحة تفضيلات الإشعارات.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        // الحصول على تفضيلات الإشعارات أو إنشاء سجل جديد إذا لم يكن موجودًا
        $preferences = $user->notificationPreference;
        
        if (!$preferences) {
            $preferences = NotificationPreference::create([
                'user_id' => $user->id,
                'project_updates' => true,
                'task_assignments' => true,
                'comments' => true,
                'mentions' => true,
                'deadlines' => true,
                'team_invitations' => true,
            ]);
        }
        
        return view('user.notification-preferences', compact('preferences'));
    }
    
    /**
     * تحديث تفضيلات الإشعارات للمستخدم.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // الحصول على تفضيلات الإشعارات أو إنشاء سجل جديد إذا لم يكن موجودًا
        $preferences = $user->notificationPreference;
        
        if (!$preferences) {
            $preferences = new NotificationPreference(['user_id' => $user->id]);
        }
        
        // تحديث التفضيلات بناءً على البيانات المقدمة
        $preferences->project_updates = $request->has('project_updates');
        $preferences->task_assignments = $request->has('task_assignments');
        $preferences->comments = $request->has('comments');
        $preferences->mentions = $request->has('mentions');
        $preferences->deadlines = $request->has('deadlines');
        $preferences->team_invitations = $request->has('team_invitations');
        
        $preferences->save();
        
        return back()->with('success', 'Notification preferences updated successfully.');
    }
    
    /**
     * التحقق من إذا كان المستخدم يرغب في تلقي الإشعار المحدد.
     *
     * @param  string  $type نوع الإشعار (project_updates, task_assignments, إلخ)
     * @param  int|null  $userId معرف المستخدم (اختياري)
     * @return bool
     */
    public static function userWantsNotification($type, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) {
            return true; // الافتراضي هو إرسال الإشعارات إذا لم نتمكن من التحقق
        }
        
        $preference = NotificationPreference::where('user_id', $userId)->first();
        
        if (!$preference) {
            return true; // الافتراضي هو إرسال الإشعارات إذا لم تكن التفضيلات معروفة
        }
        
        // تحقق من وجود الخاصية المطلوبة لتجنب الأخطاء إذا كان هناك نوع غير معروف
        if (property_exists($preference, $type)) {
            return $preference->$type;
        }
        
        return true; // للأنواع غير المعروفة، نسمح بالإشعارات افتراضيًا
    }
}
