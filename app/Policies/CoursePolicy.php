<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * 只有 Admin 可以繞過所有檢查
     */
    public function before(User $user, $ability)
    {
        if ($user->role->name === 'Admin') {
            return true;
        }
    }

    /**
     * 決定使用者是否可以檢視任何課程.
     */
    public function viewAny(User $user): bool
    {
        // Admin, SchoolAdmin, Teacher 可以看所有課程
        return in_array($user->role->name, ['Admin', 'SchoolAdmin', 'Teacher']);
    }

    /**
     * 決定使用者是否可以檢視特定課程.
     */
    public function view(User $user, Course $course): bool
    {
        // Admin, SchoolAdmin, Teacher 可以看
        // 家長/學生 只能看自己孩子的課程 (這裡假設你有 student 和 course 的關聯)
        if (in_array($user->role->name, ['Admin', 'SchoolAdmin', 'Teacher'])) {
            return true;
        }

        if ($user->role->name === 'Parent') {
            // 這裡需要你自己實作學生與課程的關聯邏輯
            // return $user->children()->whereHas('courses', fn($q) => $q->where('id', $course->id))->exists();
            return false; // 暫時先關閉
        }

        return false;
    }

    /**
     * 決定使用者是否可以建立課程.
     */
    public function create(User $user): bool
    {
        // 只有 Admin 和 SchoolAdmin 可以建立課程
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }

    /**
     * 決定使用者是否可以更新課程.
     */
    public function update(User $user, Course $course): bool
    {
        // Admin 或 SchoolAdmin 可以更新
        // 或是該課程的老師，並且有 "管理課程" 權限
        if (in_array($user->role->name, ['Admin', 'SchoolAdmin'])) {
            return true;
        }

        // 假設 users table 有一個 permissions json 欄位
        $permissions = json_decode($user->permissions, true) ?? [];
        return $user->id === $course->teacher_id && in_array('manage_courses', $permissions);
    }

    /**
     * 決定使用者是否可以刪除課程.
     */
    public function delete(User $user, Course $course): bool
    {
        // 只有 Admin 或 SchoolAdmin 可以刪除
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }
}