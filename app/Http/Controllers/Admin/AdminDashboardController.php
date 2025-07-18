<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseTemplate; // 1. 引用 CourseTemplate Model
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * 顯示管理者儀表板，並列出所有課程模板.
     */
    public function index()
    {
        // 2. 從資料庫讀取所有課程模板資料
        $templates = CourseTemplate::all();

        // 3. 將資料傳遞到視圖中 ('templates' 是我們傳到畫面的變數名稱)
        return view('admin.dashboard', ['templates' => $templates]);
    }
}