<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    // ... use HasFactory; (如果有的話)

    /**
     * 取得擁有此角色的所有使用者
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}