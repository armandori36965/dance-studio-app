<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // ... use HasFactory;

    /**
     * 取得此學員的家長 (User)
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * 取得此學員所屬的校區 (School)
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    /**
     * 取得此學員所有的出勤紀錄
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * 取得此學員所有的付款紀錄
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * 取得此學員所有的補課紀錄
     */
    public function makeUpClasses()
    {
        return $this->hasMany(MakeUpClass::class);
    }

    /**
     * 取得此學員收到的所有老師評語
     */
    public function teacherComments()
    {
        return $this->hasMany(TeacherComment::class);
    }
}