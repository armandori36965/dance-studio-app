<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // 1. 引用 Role Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // 2. 引用 Hash
use Illuminate\Validation\Rule; // 3. 引用 Rules
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // 使用 with('role') 來預先載入每個使用者的角色資料，避免 N+1 問題
        $users = User::with('role')->get();
        return view('admin.users.index', ['users' => $users]);
    }

    public function create()
    {
        // 為了在下拉選單中顯示所有角色，需要從資料庫中取得它們
        $roles = Role::all();
        return view('admin.users.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        // 驗證規則
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', 'min:6'],
            'role_id' => ['required', 'exists:roles,id'], // 確保 role_id 存在於 roles 表
        ]);

        // 建立新使用者
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')
                         ->with('success', '使用者已成功新增！');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, User $user)
    {
        // 驗證規則
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // email 驗證 unique 時，要忽略掉當前使用者
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // password 設為 nullable，代表可選，不填就不更新
            'password' => ['nullable', 'confirmed', 'min:6'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        // 準備要更新的資料
        $data = $request->only('name', 'email', 'role_id');

        // 如果請求中有 password，才更新密碼
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('success', '使用者已成功更新！');
    }

    public function destroy(User $user)
    {
        // 2. 將 auth()->id() 改成 Auth::id()
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.users.index')
                             ->with('error', '你不能刪除自己的帳號！');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', '使用者已成功刪除！');
    }
}
