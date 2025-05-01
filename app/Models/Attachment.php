<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'filename',
        'original_filename',
        'file_path',
        'mime_type',
        'file_size',
        'description',
        'uploaded_by'
    ];

    /**
     * Obtiene el proyecto al que pertenece este adjunto.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
