<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'profile_image',
        'is_active',
        'job_title',
        'first_name',
        'last_name',
        'advanced_settings',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'advanced_settings' => 'array',
        'last_login_at' => 'datetime',
    ];

    /**
     * Get the role that owns the user.
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    /**
     * Check if user is an administrator
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_id === 1 || $this->role?->name === 'admin';
    }

    /**
     * Get the ideas for the user.
     */
    public function ideas()
    {
        return $this->hasMany(Idea::class, 'owner_id');
    }

    /**
     * Get the projects owned by the user.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'owner_id');
    }
    
    /**
     * Get user notifications.
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }
    
    /**
     * Get user unread notifications.
     */
    public function unreadNotifications()
    {
        return $this->notifications()->where('is_read', false);
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role)
    {
        return $this->role->name === $role;
    }

    /**
     * Get the team members for the user.
     */
    public function teamMembers()
    {
        return $this->hasMany(TeamMember::class, 'user_id');
    }

    /**
     * Get the teams the user is a member of.
     */
    public function teamMemberOf()
    {
        return $this->hasMany(TeamMember::class, 'team_member_id');
    }
    
    /**
     * الحصول على تفضيلات الإشعارات للمستخدم
     * 
     * @return HasOne
     */
    public function notificationPreference(): HasOne
    {
        return $this->hasOne(NotificationPreference::class);
    }
}
