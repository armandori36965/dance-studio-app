<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MakeUpClass extends Model
{
    // ... use HasFactory;

    /**
     * 取得此紀錄對應的學員
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * 取得原始請假的課程
     */
    public function originalCourse()
    {
        return $this->belongsTo(Course::class, 'original_course_id');
    }

    /**
     * 取得實際補課的課程
     */
    public function makeUpCourse()
    {
        return $this->belongsTo(Course::class, 'make_up_course_id');
    }
}