<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    // ... use HasFactory; (如果有的話)

    // 加入這個陣列，允許 'name' 欄位被大量賦值
    protected $fillable = ['name'];

    /**
     * 取得此校區的所有課程
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'location_id');
    }

    // ... 在 School.php 檔案的 class School extends Model { ... } 內加入

    /**
     * 取得此校區的所有學員
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'school_id');
    }
}