<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'idea_id',
        'framework_id',
        'owner_id',
        'title',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    /**
     * Get the idea that owns the project.
     */
    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    /**
     * Get the framework that owns the project.
     */
    public function framework()
    {
        return $this->belongsTo(Framework::class);
    }

    /**
     * Get the user that owns the project.
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the user that owns the project.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}