<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    // ... use HasFactory;

    /**
     * 取得此紀錄對應的課程
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * 取得此紀錄對應的學員
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}