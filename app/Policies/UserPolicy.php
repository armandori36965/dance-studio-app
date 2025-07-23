<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * 在執行其他權限檢查前，先執行此方法
     */
    public function before(User $user, $ability)
    {
        if ($user->role->name === 'Admin') {
            return true;
        }
    }

    /**
     * 判斷使用者是否可以檢視任何使用者
     */
    public function viewAny(User $user): bool
    {
        // 只有 Admin 或 SchoolAdmin 可以看使用者列表
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }

    /**
     * 判斷使用者是否可以建立新使用者
     */
    public function create(User $user): bool
    {
        // 只有 Admin 可以建立使用者
        return $user->role->name === 'Admin';
    }

    /**
     * 判斷使用者是否可以更新特定使用者
     */
    public function update(User $user, User $model): bool
    {
        // Admin 可以更新任何人
        // SchoolAdmin 只能更新自己校區的老師或家長
        if ($user->role->name === 'SchoolAdmin') {
            return $user->school_id === $model->school_id && in_array($model->role->name, ['Teacher', 'Parent']);
        }
        // Admin 的權限已由 before() 方法處理
        return false;
    }

    /**
     * 判斷使用者是否可以刪除特定使用者
     */
    public function delete(User $user, User $model): bool
    {
        // 使用者不能刪除自己
        if ($user->id === $model->id) {
            return false;
        }

        // SchoolAdmin 只能刪除自己校區的老師或家長
        if ($user->role->name === 'SchoolAdmin') {
            return $user->school_id === $model->school_id && in_array($model->role->name, ['Teacher', 'Parent']);
        }
        
        // Admin 的權限已由 before() 方法處理
        return false;
    }
}