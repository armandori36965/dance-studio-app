<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseTemplate; // 引用 Model
use Illuminate\Http\Request;

class CourseTemplateController extends Controller
{
    /**
     * 顯示所有課程模板的列表.
     */
    public function index()
    {
        $templates = CourseTemplate::all();
        // 注意：視圖路徑我們稍後會修改成 course_templates.index
        return view('admin.course_templates.index', ['templates' => $templates]);
    }

    /**
     * 顯示建立新課程模板的表單.
     */
    public function create()
    {
        return view('admin.course_templates.create');
    }

    /**
     * 將新建立的課程模板儲存到資料庫.
     */
    public function store(Request $request)
    {
        // 1. 驗證表單資料
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
        ]);

        // 2. 建立新資料
        CourseTemplate::create($request->all());

        // 3. 導回列表頁，並帶一個成功訊息
        return redirect()->route('admin.course-templates.index')
                         ->with('success', '課程模板已成功新增！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * 顯示編輯特定課程模板的表單.
     * Laravel 會自動根據網址中的 id 找到對應的 CourseTemplate 物件
     */
    public function edit(CourseTemplate $courseTemplate)
    {
        return view('admin.course_templates.edit', ['template' => $courseTemplate]);
    }

    /**
     * 更新資料庫中的特定課程模板.
     */
    public function update(Request $request, CourseTemplate $courseTemplate)
    {
        // 驗證規則與 store 方法相同
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0',
        ]);

        // 更新資料
        $courseTemplate->update($request->all());

        // 導回列表頁，並帶一個成功訊息
        return redirect()->route('admin.course-templates.index')
                         ->with('success', '課程模板已成功更新！');
    }

    /**
     * 從資料庫中刪除指定的課程模板.
     */
    public function destroy(CourseTemplate $courseTemplate)
    {
        // 執行刪除
        $courseTemplate->delete();

        // 導回列表頁，並帶一個成功訊息
        return redirect()->route('admin.course-templates.index')
                         ->with('success', '課程模板已成功刪除！');
    }
}
