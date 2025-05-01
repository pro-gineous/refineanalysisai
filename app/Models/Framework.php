<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Framework extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category',
        'description',
        'short_description',
        'comprehensive_description',
        'icon',
        'version',
        'is_active',
    ];
    
    /**
     * Los atributos que deben tener valores por defecto.
     *
     * @var array
     */
    protected $attributes = [
        'is_active' => true,
    ];
    
    /**
     * Los atributos que deben ser tratados como fechas.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the projects for the framework.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    
    /**
     * Obtener un conteo preciso de todos los frameworks en la base de datos
     * usando una consulta directa a la tabla frameworks.
     *
     * @return int
     */
    public static function getTotalCount()
    {
        return DB::table('frameworks')->count();
    }
}