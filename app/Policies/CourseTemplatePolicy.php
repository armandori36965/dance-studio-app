<?php

namespace App\Policies;

use App\Models\CourseTemplate;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CourseTemplatePolicy
{
    /**
     * 在執行其他權限檢查前，先執行此方法
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return bool|null
     */
    public function before(User $user, string $ability): bool|null
    {
        // 如果角色是 Admin，則允許所有操作。使用 `?->` 以避免 role 不存在時出錯。
        if ($user->role?->name === 'Admin') {
            return true;
        }
        // 回傳 null 表示繼續執行後續的權限檢查方法
        return null;
    }

    /**
     * 判斷使用者是否可以檢視任何課程模板
     */
    public function viewAny(User $user): bool
    {
        // Admin 已在 before 方法中處理，這裡只需判斷 SchoolAdmin
        return $user->role?->name === 'SchoolAdmin';
    }

    /**
     * 判斷使用者是否可以檢視特定的課程模板
     */
    public function view(User $user, CourseTemplate $courseTemplate): bool
    {
        // Admin 已在 before 方法中處理，這裡只需判斷 SchoolAdmin
        return $user->role?->name === 'SchoolAdmin';
    }

    /**
     * 判斷使用者是否可以建立課程模板
     */
    public function create(User $user): bool
    {
        // Admin 已在 before 方法中處理，這裡只需判斷 SchoolAdmin
        return $user->role?->name === 'SchoolAdmin';
    }

    /**
     * 判斷使用者是否可以更新課程模板
     */
    public function update(User $user, CourseTemplate $courseTemplate): bool
    {
        // Admin 已在 before 方法中處理，這裡只需判斷 SchoolAdmin
        return $user->role?->name === 'SchoolAdmin';
    }

    /**
     * 判斷使用者是否可以刪除課程模板
     */
    public function delete(User $user, CourseTemplate $courseTemplate): bool
    {
        // Admin 已在 before 方法中處理，這裡只需判斷 SchoolAdmin
        return $user->role?->name === 'SchoolAdmin';
    }
}
