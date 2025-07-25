<?php

namespace App\Policies;

use App\Models\TeacherComment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeacherCommentPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role->name === 'Admin') {
            return true;
        }
    }

    public function view(User $user, TeacherComment $comment)
{
    // 移除 SchoolAdmin 的判斷
    // if ($user->role->name === 'SchoolAdmin') {
    //     return true;
    // }

    // 撰寫評語的老師、該學生的家長可以看到
    if ($user->id === $comment->teacher_id) {
        return true;
    }

    if ($user->role->name === 'Parent' && $user->children()->where('id', $comment->student_id)->exists()) {
        return true;
    }

    return false;
}

    public function create(User $user)
    {
        // 只有老師可以新增評語
        return $user->role->name === 'Teacher';
    }

    public function update(User $user, TeacherComment $comment)
    {
        // 只有撰寫該評語的老師可以更新
        return $user->id === $comment->teacher_id;
    }

   public function delete(User $user, TeacherComment $comment)
{
    // 移除 SchoolAdmin 的判斷
    // if ($user->role->name === 'SchoolAdmin') {
    //     return true;
    // }
    
    // 只有撰寫該評語的老師可以刪除
    return $user->id === $comment->teacher_id;
}
}