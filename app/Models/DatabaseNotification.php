<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification as BaseDatabaseNotification;

class DatabaseNotification extends BaseDatabaseNotification
{
    // اسم الجدول
    protected $table = 'notifications';
    
    // تعريف البيانات التي يمكن ملؤها
    protected $fillable = [
        'id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at'
    ];
    
    // تعريف التحويلات
    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];
    
    // إضافة خاصية محسوبة لسهولة الوصول
    protected $appends = ['is_read', 'created_at_formatted'];
    
    // تحديد ما إذا كان الإشعار مقروءًا
    public function getIsReadAttribute()
    {
        return $this->read_at !== null;
    }
    
    // الحصول على تاريخ الإنشاء بتنسيق سهل الاستخدام
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    
    // الوصول إلى بيانات الإشعار
    public function getDataAttribute($value)
    {
        $data = json_decode($value, true);
        
        // إضافة جميع بيانات الإشعار كخصائص مباشرة
        foreach ($data as $key => $val) {
            $this->attributes[$key] = $val;
        }
        
        return $data;
    }
}
