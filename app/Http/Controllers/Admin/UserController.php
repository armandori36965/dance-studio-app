<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * 定義所有可用的額外權限及其顯示名稱。
     * 設為 public static，方便在 Controller 內外重複使用。
     */
    public static $available_permissions = [
        'manage_courses'          => '管理課程',
        'manage_course_templates' => '管理課程模板',
        'view_all_students'       => '查看所有學生',
        'manage_finances'         => '管理財務報表',
    ];

    /**
     * 顯示使用者列表頁面
     */
    public function index()
    {
        $this->authorize('viewAny', User::class); // 檢查是否有權限查看使用者列表

        $users = User::with('role')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * 顯示建立新使用者的表單
     */
    public function create()
    {
        $this->authorize('create', User::class); // 檢查是否有權限建立使用者

        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * 將新建立的使用者儲存至資料庫
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class); // 權限檢查

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', '使用者已成功建立！');
    }

    /**
     * 顯示編輯使用者的表單
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user); // 檢查是否有權限更新此使用者

        $roles = Role::all();

        // 因為 User Model 已設定 'permissions' => 'array' 的 $casts
        // Laravel 會自動處理 JSON 轉換，我們可以直接當作陣列使用
        $user_permissions = $user->permissions ?? [];

        return view('admin.users.edit', [
            'user'                  => $user,
            'roles'                 => $roles,
            'available_permissions' => self::$available_permissions, // 使用 self:: 存取靜態屬性
            'user_permissions'      => $user_permissions,
        ]);
    }

    /**
     * 更新資料庫中的使用者資訊
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user); // 權限檢查

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'nullable|array', // 允許 permissions 為空或是一個陣列
        ]);

        $userData = $request->only('name', 'email', 'role_id');

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $userData['password'] = Hash::make($request->password);
        }

        // 只有老師角色才處理 permissions 欄位
        if ($request->role_id == Role::where('name', 'Teacher')->first()->id) {
            $userData['permissions'] = $request->input('permissions', []);
        } else {
            $userData['permissions'] = null; // 如果不是老師，清空權限
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', '使用者資訊已成功更新！');
    }

    /**
     * 從資料庫刪除使用者
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user); // 權限檢查

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', '使用者已成功刪除！');
    }
}