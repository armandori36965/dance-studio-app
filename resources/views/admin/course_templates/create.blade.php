@extends('layouts.admin')

@section('title', '新增課程模板')

@section('content')
        <h1>新增課程模板</h1>

        {{-- 將表單送到 store 路由 --}}
        <form action="{{ route('admin.course-templates.store') }}" method="POST">
            @csrf  {{-- Laravel 安全機制，必要 --}}

            {{-- 將 name 欄位的 div 修改如下 --}}
<div class="mb-3">
    <label for="name" class="form-label">模板名稱</label>
    <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" value="{{ old('name') }}">
    @if($errors->has('name'))
        <div class="invalid-feedback">
            {{ $errors->first('name') }}
        </div>
    @endif
</div>

            {{-- 將 price 欄位的 div 修改如下 --}}
<div class="mb-3">
    <label for="price" class="form-label">定價</label>
    <input type="number" step="0.01" class="form-control @if($errors->has('price')) is-invalid @endif" id="price" name="price" value="{{ old('price') }}">
    @if($errors->has('price'))
        <div class="invalid-feedback">
            {{ $errors->first('price') }}
        </div>
    @endif
</div>

            <button type="submit" class="btn btn-primary">儲存</button>
            <a href="{{ route('admin.course-templates.index') }}" class="btn btn-secondary">取消</a>
        </form>
@endsection