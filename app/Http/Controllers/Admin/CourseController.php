<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseTemplate;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 加上權限檢查：使用者是否可以檢視課程列表
        $this->authorize('viewAny', Course::class);
        // ... 原本的邏輯 ...
    }

    public function create(Request $request)
    {
        // 加上權限檢查：使用者是否可以建立課程
        $this->authorize('create', Course::class);

        $date = $request->query('date');
        $templates = CourseTemplate::all();
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'Teacher');
        })->get();
        $schools = School::all();

        return view('admin.courses.create', [
            'clicked_date' => $date,
            'templates' => $templates,
            'teachers' => $teachers,
            'schools' => $schools,
        ]);
    }

    public function store(Request $request)
    {
        // 加上權限檢查：使用者是否可以建立課程
        $this->authorize('create', Course::class);

        $validatedData = $request->validate([
            'template_id' => ['required', 'exists:course_templates,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'location_id' => ['required', 'exists:schools,id'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i', 'after_or_equal:07:00', 'before_or_equal:22:00'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time', 'before_or_equal:22:00'],
        ]);

        Course::create($validatedData);

        return redirect()->route('admin.calendar.index')
                         ->with('success', '課程已成功新增！');
    }

    /**
     * 顯示指定的課程資料 (API for AJAX).
     */
    public function show(Course $course)
    {
        // 加上權限檢查：使用者是否可以檢視此特定課程
        $this->authorize('view', $course);

        $templates = CourseTemplate::all();
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'Teacher');
        })->get();
        $schools = School::all();

        return response()->json([
            'success'     => true,
            'course'      => $course,
            'templates'   => $templates,
            'teachers'    => $teachers,
            'schools'     => $schools,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // 一般來說 edit 頁面會需要載入課程資料，可以在這裡加上權限
        $course = Course::findOrFail($id);
        $this->authorize('update', $course);
        // ... 顯示編輯畫面的邏輯 ...
    }

    public function update(Request $request, Course $course)
    {
        // 加上權限檢查：使用者是否可以更新此特定課程
        $this->authorize('update', $course);

        $validatedData = $request->validate([
            'template_id' => ['required', 'exists:course_templates,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'location_id' => ['required', 'exists:schools,id'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i', 'after_or_equal:07:00', 'before_or_equal:22:00'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time', 'before_or_equal:22:00'],
        ]);

        $course->update($validatedData);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => '課程已成功更新！']);
        }

        return redirect()->route('admin.calendar.index')->with('success', '課程已成功更新！');
    }

    public function destroy(Request $request, Course $course)
    {
        // 加上權限檢查：使用者是否可以刪除此特定課程
        $this->authorize('delete', $course);

        $course->delete();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => '課程已成功刪除！']);
        }

        return redirect()->route('admin.calendar.index')->with('success', '課程已成功刪除！');
    }
}