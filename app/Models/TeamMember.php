<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'user_id',
        'name',
        'email',
        'role',
        'permissions',
        'invitation_accepted',
        'invitation_token',
        'invitation_sent_at',
        'team_member_id',
        'status',
    ];

    /**
     * Los atributos que deben convertirse.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'permissions' => 'array',
        'invitation_accepted' => 'boolean',
        'invitation_sent_at' => 'datetime',
    ];

    /**
     * Obtener el propietario del equipo.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Obtener el usuario miembro del equipo.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtener el miembro del equipo.
     */
    public function teamMember(): BelongsTo
    {
        return $this->belongsTo(User::class, 'team_member_id');
    }
}
