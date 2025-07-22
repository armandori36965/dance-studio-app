@extends('layouts.admin')

@section('title', '編輯使用者')

@section('content')
    <h2>編輯使用者：{{ $user->name }}</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">名稱</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">電子郵件</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">新密碼 (如不變更請留白)</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">確認新密碼</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">角色</label>
            <select class="form-select @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            @error('role_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- 權限設定區塊 -->
        @if($user->role->name === 'Teacher')
            <div class="mb-3 p-3 border rounded">
                <label class="form-label fw-bold">額外權限 (僅限老師)</label>
                @forelse($available_permissions as $permission_key => $permission_name)
                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               name="permissions[]" 
                               value="{{ $permission_key }}" 
                               id="perm_{{ $permission_key }}"
                               @if(in_array($permission_key, $user_permissions)) checked @endif>
                        <label class="form-check-label" for="perm_{{ $permission_key }}">
                            {{ $permission_name }}
                        </label>
                    </div>
                @empty
                    <p class="text-muted">沒有可設定的額外權限。</p>
                @endforelse
            </div>
        @endif
        <!-- /權限設定區塊 -->


        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">取消</a>
        <button type="submit" class="btn btn-primary">儲存變更</button>
    </form>
@endsection
