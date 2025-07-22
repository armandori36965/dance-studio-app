<?php

namespace App\Policies;

use App\Models\SchoolEvent;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolEventPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role->name === 'Admin') {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true; // 所有人都可以看校區活動
    }

    public function create(User $user)
    {
        // 只有 Admin 或 School Admin 可以建立
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }

    public function update(User $user, SchoolEvent $schoolEvent)
    {
        // 只有 Admin 或 School Admin 可以更新
        // 這裡可以加上更細的邏輯，例如 School Admin 只能更新自己校區的活動
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }

    public function delete(User $user, SchoolEvent $schoolEvent)
    {
        // 只有 Admin 或 School Admin 可以刪除
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }
}