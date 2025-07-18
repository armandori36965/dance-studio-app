<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course; // 引用 Course Model

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index');
    }

    // 新增這個方法
    public function getEvents()
    {
        // 查詢所有課程，並預先載入關聯的模板和老師資料
        $courses = Course::with(['template', 'teacher'])->get();

        // 將查詢結果轉換成 FullCalendar 需要的格式
        $events = $courses->map(function ($course) {
            return [
                'id'      => $course->id,
                'title'   => optional($course->template)->name . ' - ' . optional($course->teacher)->name,
                'start'   => $course->date . 'T' . $course->start_time,
                'end'     => $course->date . 'T' . $course->end_time,
            ];
        });

        return response()->json($events);
    }
}