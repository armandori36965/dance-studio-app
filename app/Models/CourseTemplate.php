<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseTemplate extends Model
{
    // use HasFactory; // 如果你的檔案有這一行，請保留

    // 加入這個陣列，允許 'name' 和 'price' 欄位被大量賦值
    protected $fillable = ['name', 'price'];

    /**
     * 取得此課程模板對應的所有課程實例
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'template_id');
    }
}