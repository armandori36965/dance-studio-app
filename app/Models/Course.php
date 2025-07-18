<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    // ... use HasFactory; (如果有的話)

    // 加入這個陣列，定義可以被大量賦值的欄位
    protected $fillable = [
        'template_id',
        'teacher_id',
        'location_id',
        'date',
        'start_time',
        'end_time',
        'capacity',
        'course_type',
    ];

    public function template()
    {
        return $this->belongsTo(CourseTemplate::class, 'template_id');
    }

    /**
     * 取得此課程的授課老師 (User)
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * 取得此課程的上課地點 (School)
     */
    public function location()
    {
        // 假設地點就是校區，所以關聯到 School Model
        return $this->belongsTo(School::class, 'location_id');
    }
}