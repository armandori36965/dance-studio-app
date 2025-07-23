@extends('layouts.admin')

@section('title', '使用者管理')

@section('content')
    <h2>使用者管理</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">新增使用者</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- 新增這個區塊 --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">名稱</th>
                <th scope="col">Email</th>
                <th scope="col">角色</th>
                <th scope="col">額外權限</th> {{-- <-- 新增欄位 --}}
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                    {{-- 新增這段邏輯來顯示權限 --}}
                    @if($user->role->name === 'Teacher' && !empty($user->permissions))
                        @foreach($user->permissions as $permission)
                            <span class="badge bg-info text-dark">
                                {{ \App\Http\Controllers\Admin\UserController::$available_permissions[$permission] ?? $permission }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-muted">無</span>
                    @endif
                </td>
                    <td>
    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">編輯</a>

    {{-- 如果當前登入的使用者 id 不等於列表中的使用者 id，才顯示刪除按鈕 --}}
    @if(Auth::id() !== $user->id)
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('確定要刪除嗎？');">刪除</button>
        </form>
    @endif
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">目前沒有任何使用者。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection