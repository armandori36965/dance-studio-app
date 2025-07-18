<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherComment extends Model
{
    // ... use HasFactory;

    /**
     * 取得此評語對應的學員
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * 取得撰寫此評語的老師 (User)
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * 取得此評語關聯的課程 (可選)
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}