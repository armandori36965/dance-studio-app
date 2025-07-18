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
        //
    }

    public function create(Request $request)
    {
        // 從網址參數中取得點擊的日期
        $date = $request->query('date');

        // 取得所有課程模板
        $templates = CourseTemplate::all();

        // 取得所有角色為 'Teacher' 的使用者
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'Teacher');
        })->get();

        // 取得所有校區
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
        // 1. 驗證表單資料
        $validatedData = $request->validate([
            'template_id' => ['required', 'exists:course_templates,id'],
            'teacher_id' => ['required', 'exists:users,id'],
            'location_id' => ['required', 'exists:schools,id'],
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i', 'after_or_equal:07:00', 'before_or_equal:22:00'],
'end_time' => ['required', 'date_format:H:i', 'after:start_time', 'before_or_equal:22:00'],
        ]);

        // 2. 建立新資料
        Course::create($validatedData);

        // 3. 導回日曆頁，並帶一個成功訊息
        return redirect()->route('admin.calendar.index')
                         ->with('success', '課程已成功新增！');
    }
    
    /**
     * 顯示指定的課程資料 (API for AJAX).
     */
    public function show(Course $course)
    {
        // 為了讓編輯表單的下拉選單有資料，我們一併把模板、老師、校區清單都送回去
        $templates = CourseTemplate::all();
        $teachers = User::whereHas('role', function ($query) {
            $query->where('name', 'Teacher');
        })->get();
        $schools = School::all();

        return response()->json([
            'success'       => true,
            'course'        => $course,
            'templates'     => $templates,
            'teachers'      => $teachers,
            'schools'       => $schools,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, Course $course)
{
    // 驗證規則與 store 方法類似
    $validatedData = $request->validate([
        'template_id' => ['required', 'exists:course_templates,id'],
        'teacher_id' => ['required', 'exists:users,id'],
        'location_id' => ['required', 'exists:schools,id'],
        'date' => ['required', 'date'],
        'start_time' => ['required', 'date_format:H:i', 'after_or_equal:07:00', 'before_or_equal:22:00'],
'end_time' => ['required', 'date_format:H:i', 'after:start_time', 'before_or_equal:22:00'],
    ]);

    $course->update($validatedData);

    // 如果是 AJAX 請求，就回傳 JSON
    if ($request->wantsJson()) {
        return response()->json(['success' => true, 'message' => '課程已成功更新！']);
    }

    // (備用) 如果是傳統表單提交，則重新導向
    return redirect()->route('admin.calendar.index')->with('success', '課程已成功更新！');
}

    public function destroy(Request $request, Course $course)
{
    $course->delete();

    // 如果是 AJAX 請求，就回傳 JSON
    if ($request->wantsJson()) {
        return response()->json(['success' => true, 'message' => '課程已成功刪除！']);
    }

    // (備用) 如果是傳統表單提交，則重新導向
    return redirect()->route('admin.calendar.index')->with('success', '課程已成功刪除！');
}

}
