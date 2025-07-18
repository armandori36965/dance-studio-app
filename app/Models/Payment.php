<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // ... use HasFactory;

    /**
     * 取得此付款單對應的學員
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}