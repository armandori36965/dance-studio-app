@extends('layouts.admin')

@section('title', '新增校區')

@section('content')
    <h1>新增校區</h1>

    <form action="{{ route('admin.schools.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">校區名稱</label>
            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" value="{{ old('name') }}">
            @if($errors->has('name'))
                <div class="invalid-feedback">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.schools.index') }}" class="btn btn-secondary">取消</a>
    </form>
@endsection