<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'key', 'value', 'group', 'type', 'name', 'description', 'is_public', 'sort_order'
    ];
    
    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        // Use cache to prevent frequent DB queries
        return Cache::rememberForever("setting.{$key}", function() use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }
            
            return $setting->getValue();
        });
    }
    
    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @param array $attributes Additional attributes to update
     * @return bool
     */
    public static function set(string $key, $value, array $attributes = [])
    {
        $setting = static::where('key', $key)->first();
        
        // If setting doesn't exist yet, create it
        if (!$setting) {
            $setting = new static(array_merge(
                ['key' => $key], 
                $attributes
            ));
        } else {
            // Update additional attributes if provided
            $setting->fill($attributes);
        }
        
        $setting->value = static::formatValue($value, $setting->type ?? 'text');
        $saved = $setting->save();
        
        // Clear cache for this key
        if ($saved) {
            Cache::forget("setting.{$key}");
        }
        
        return $saved;
    }
    
    /**
     * Get the correctly formatted value based on setting type
     *
     * @return mixed
     */
    public function getValue()
    {
        switch ($this->type) {
            case 'boolean':
                return (bool) $this->value;
            case 'integer':
                return (int) $this->value;
            case 'float':
                return (float) $this->value;
            case 'json':
                return json_decode($this->value, true);
            case 'image':
                if (empty($this->value)) {
                    return null;
                }
                return asset('storage/' . $this->value);
            default:
                return $this->value;
        }
    }
    
    /**
     * Format a value for storage based on type
     *
     * @param mixed $value
     * @param string $type
     * @return string
     */
    protected static function formatValue($value, string $type)
    {
        switch ($type) {
            case 'json':
                return json_encode($value);
            case 'boolean':
                return $value ? '1' : '0';
            default:
                return (string) $value;
        }
    }
    
    /**
     * Get all settings grouped by their group
     *
     * @return array
     */
    public static function getAllGrouped()
    {
        $settings = static::orderBy('group')->orderBy('sort_order')->get();
        $grouped = [];
        
        foreach ($settings as $setting) {
            $grouped[$setting->group][] = $setting;
        }
        
        return $grouped;
    }
    
    /**
     * Get all public settings
     *
     * @return array
     */
    public static function getPublic()
    {
        return Cache::rememberForever('public_settings', function() {
            $settings = static::where('is_public', true)->get();
            $result = [];
            
            foreach ($settings as $setting) {
                $result[$setting->key] = $setting->getValue();
            }
            
            return $result;
        });
    }
    
    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::forget('public_settings');
        
        // Clear individual setting caches
        $keys = static::pluck('key')->toArray();
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
    }
}
