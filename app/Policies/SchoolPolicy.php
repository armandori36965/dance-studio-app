<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SchoolPolicy
{
    /**
     * 在執行其他權限檢查前，先執行此方法
     */
    public function before(User $user, string $ability): bool|null
    {
        // 如果角色是 Admin，則允許所有操作
        if ($user->role?->name === 'Admin') {
            return true;
        }
        
        return null;
    }

    /**
     * 判斷使用者是否可以檢視任何校區
     */
    public function viewAny(User $user): bool
    {
        // Admin 已在 before 處理，這裡讓 SchoolAdmin 也可以看列表
        return $user->role?->name === 'SchoolAdmin';
    }

    /**
     * 判斷使用者是否可以檢視特定的校區
     */
    public function view(User $user, School $school): bool
    {
        // SchoolAdmin 只能看自己所屬的校區
        return $user->role?->name === 'SchoolAdmin' && $user->school_id === $school->id;
    }

    /**
     * 判斷使用者是否可以建立校區
     */
    public function create(User $user): bool
    {
        // 只有 Admin 能建立 (before 會處理)，其他角色不行
        return false;
    }

    /**
     * 判斷使用者是否可以更新校區
     */
    public function update(User $user, School $school): bool
    {
        // SchoolAdmin 只能更新自己所屬的校區
        return $user->role?->name === 'SchoolAdmin' && $user->school_id === $school->id;
    }

    /**
     * 判斷使用者是否可以刪除校區
     */
    public function delete(User $user, School $school): bool
    {
        // 只有 Admin 能刪除 (before 會處理)，其他角色不行
        return false;
    }
}
