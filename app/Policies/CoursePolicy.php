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
     * 決定使用者是否可以檢視任何課程
     */
    public function viewAny(User $user): bool
    {
        // Admin, SchoolAdmin, Teacher 可以看所有課程
        return in_array($user->role->name, ['Admin', 'SchoolAdmin', 'Teacher']);
    }

    /**
     * 決定使用者是否可以檢視特定課程
     */
    public function view(User $user, Course $course): bool
    {
        // Admin, SchoolAdmin, Teacher 可以看
        if (in_array($user->role->name, ['Admin', 'SchoolAdmin', 'Teacher'])) {
            return true;
        }

        // 家長/學生 只能看自己孩子的課程
        if ($user->role->name === 'Parent') {
            // 這部分邏輯需要根據你未來學生和課程的關聯來實作
            return false; 
        }

        return false;
    }

    /**
     * 決定使用者是否可以建立課程
     */
    public function create(User $user): bool
    {
        // 只有 Admin 和 SchoolAdmin 可以建立課程
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }

    //**決定使用者是否可以更新課程
 
public function update(User $user, Course $course): bool
{
    // 只有該課程的老師，並且被賦予 "管理課程" 的額外權限時，才能更新
    // Admin 的權限已由 before() 方法處理，此處不需再判斷
    return $user->id === $course->teacher_id && $user->hasPermissionTo('manage_courses');
}

    /**
     * 決定使用者是否可以刪除課程
     */
    public function delete(User $user, Course $course): bool
    {
        // 只有 Admin 或 SchoolAdmin 可以刪除
        return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
    }
}