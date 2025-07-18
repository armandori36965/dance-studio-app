<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School; // 引用 School Model

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::all();
        return view('admin.schools.index', ['schools' => $schools]);
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:schools',
        ]);

        School::create($request->all());

        return redirect()->route('admin.schools.index')
                         ->with('success', '校區已成功新增！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(School $school)
    {
        return view('admin.schools.edit', ['school' => $school]);
    }

    public function update(Request $request, School $school)
    {
        // 更新時的驗證規則，unique 需要忽略掉自己本身
        $request->validate([
            'name' => 'required|string|max:255|unique:schools,name,' . $school->id,
        ]);

        $school->update($request->all());

        return redirect()->route('admin.schools.index')
                         ->with('success', '校區已成功更新！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        $school->delete();

        return redirect()->route('admin.schools.index')
                         ->with('success', '校區已成功刪除！');
    }
}
