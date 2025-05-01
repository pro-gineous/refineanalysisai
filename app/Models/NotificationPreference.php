<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    use HasFactory;
    
    /**
     * الحقول التي يمكن تعديلها بشكل جماعي
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'project_updates',
        'task_assignments',
        'comments',
        'mentions',
        'deadlines',
        'team_invitations',
    ];
    
    /**
     * الحقول التي يجب تحويلها إلى أنواع محددة
     *
     * @var array
     */
    protected $casts = [
        'project_updates' => 'boolean',
        'task_assignments' => 'boolean',
        'comments' => 'boolean',
        'mentions' => 'boolean',
        'deadlines' => 'boolean',
        'team_invitations' => 'boolean',
    ];
    
    /**
     * علاقة الارتباط بالمستخدم
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
