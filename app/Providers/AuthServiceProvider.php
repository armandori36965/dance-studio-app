<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseTemplate;
use App\Models\School;
use App\Models\SchoolEvent;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\TeacherComment;
use App\Policies\CoursePolicy;
use App\Policies\CourseTemplatePolicy;
use App\Policies\SchoolPolicy;
use App\Policies\SchoolEventPolicy;
use App\Policies\StudentPolicy;
use App\Policies\AttendancePolicy;
use App\Policies\TeacherCommentPolicy;
use App\Policies\UserPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Course::class => CoursePolicy::class,
        CourseTemplate::class => CourseTemplatePolicy::class,
        School::class => SchoolPolicy::class,
        SchoolEvent::class => SchoolEventPolicy::class,
        Student::class => StudentPolicy::class,
        Attendance::class => AttendancePolicy::class,
        TeacherComment::class => TeacherCommentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // 定義一個超級管理員，可以做任何事
        Gate::before(function ($user, $ability) {
            return $user->role->name === 'Admin' ? true : null;
        });

        // 定義「進入後台管理」的權限
        Gate::define('view-admin-panel', function (User $user) {
            // Admin, SchoolAdmin 可以進入
            if (in_array($user->role->name, ['Admin', 'SchoolAdmin'])) {
                return true;
            }
            // 或者是有任何一個額外權限的老師也可以
            if ($user->role->name === 'Teacher' && !empty($user->permissions)) {
                return true;
            }
            return false;
        });

        // 定義「管理校務」的權限 (例如：校區、課程模板)
        Gate::define('manage-school-settings', function (User $user) {
            // 只有 Admin 和 SchoolAdmin 可以
            return in_array($user->role->name, ['Admin', 'SchoolAdmin']);
        });
    }
}
