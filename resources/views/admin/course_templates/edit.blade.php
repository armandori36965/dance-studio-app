@extends('layouts.admin')

@section('title', '編輯課程模板')

@section('content')
        <h1>編輯課程模板</h1> {{-- 2. 修改標題 --}}

        {{-- 將表單送到 update 路由，並傳入要更新的 template id --}}
        <form action="{{ route('admin.course-templates.update', $template->id) }}" method="POST">
            @csrf
            @method('PUT') {{-- 3. 告訴 Laravel 這是更新操作 --}}

            <div class="mb-3">
                <label for="name" class="form-label">模板名稱</label>
                {{-- 4. 在 value 中填入舊資料 --}}
                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" value="{{ old('name', $template->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                @endif
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">定價</label>
                {{-- 4. 在 value 中填入舊資料 --}}
                <input type="number" step="0.01" class="form-control @if($errors->has('price')) is-invalid @endif" id="price" name="price" value="{{ old('price', $template->price) }}">
                @if($errors->has('price'))
                    <div class="invalid-feedback">{{ $errors->first('price') }}</div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">儲存變更</button>
            <a href="{{ route('admin.course-templates.index') }}" class="btn btn-secondary">取消</a>
        </form>
   @endsection