@extends('layouts.admin')

@section('title', '編輯使用者')

@section('content')
    <h1>編輯使用者</h1>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">名稱</label>
            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" value="{{ old('name', $user->name) }}">
            @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @if($errors->has('email')) is-invalid @endif" id="email" name="email" value="{{ old('email', $user->email) }}">
            @if($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">新密碼</label>
            <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" id="password" name="password">
            <div class="form-text">留空代表不變更密碼。</div>
            @if($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">確認新密碼</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="mb-3">
            <label for="role_id" class="form-label">角色</label>
            <select class="form-select @if($errors->has('role_id')) is-invalid @endif" id="role_id" name="role_id">
                <option value="">請選擇角色</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            @if($errors->has('role_id'))
                <div class="invalid-feedback">{{ $errors->first('role_id') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">儲存變更</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">取消</a>
    </form>
@endsection