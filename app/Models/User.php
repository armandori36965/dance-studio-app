<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // <--- 在這裡加入
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 取得此使用者 (老師) 的所有課程
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

     /**
     * 取得此使用者對應的角色
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ... 在 User.php 檔案的 class User extends Authenticatable { ... } 內加入

    /**
     * 取得此使用者 (家長) 的所有學員小孩
     */
    public function children()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
