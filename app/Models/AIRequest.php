<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIRequest extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ai_requests';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'request_type',
        'model',
        'tokens_input',
        'tokens_output',
        'total_tokens',
        'estimated_cost',
        'prompt',
        'response',
        'metadata',
        'success',
        'error_message',
        'ip_address'
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'json',
        'success' => 'boolean',
        'tokens_input' => 'integer',
        'tokens_output' => 'integer',
        'total_tokens' => 'integer',
        'estimated_cost' => 'decimal:6'
    ];
    
    /**
     * Get the user that made the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
