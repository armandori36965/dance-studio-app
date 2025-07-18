@extends('layouts.admin')

@section('title', '新增課程')

@section('content')
    <h1>新增課程</h1>

    <form action="{{ route('admin.courses.store') }}" method="POST">
        @csrf

        <div class="row">
            {{-- 課程模板 --}}
            <div class="col-md-6 mb-3">
                <label for="template_id" class="form-label">課程模板</label>
                <select class="form-select @if($errors->has('template_id')) is-invalid @endif" id="template_id" name="template_id">
                    <option value="">請選擇模板</option>
                    @foreach ($templates as $template)
                        <option value="{{ $template->id }}" {{ old('template_id') == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('template_id'))
                    <div class="invalid-feedback">{{ $errors->first('template_id') }}</div>
                @endif
            </div>

            {{-- 授課老師 --}}
            <div class="col-md-6 mb-3">
                <label for="teacher_id" class="form-label">授課老師</label>
                <select class="form-select @if($errors->has('teacher_id')) is-invalid @endif" id="teacher_id" name="teacher_id">
                    <option value="">請選擇老師</option>
                    @foreach ($teachers as $teacher)
                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('teacher_id'))
                    <div class="invalid-feedback">{{ $errors->first('teacher_id') }}</div>
                @endif
            </div>
        </div>

        <div class="row">
            {{-- 上課地點 --}}
            <div class="col-md-6 mb-3">
                <label for="location_id" class="form-label">上課地點</label>
                <select class="form-select @if($errors->has('location_id')) is-invalid @endif" id="location_id" name="location_id">
                    <option value="">請選擇地點</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('location_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                    @endforeach
                </select>
                @if($errors->has('location_id'))
                    <div class="invalid-feedback">{{ $errors->first('location_id') }}</div>
                @endif
            </div>

            {{-- 課程日期 --}}
            <div class="col-md-6 mb-3">
                <label for="date" class="form-label">課程日期</label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $clicked_date) }}">
            </div>
        </div>

        <div class="row">
            {{-- 開始時間 --}}
            <div class="col-md-6 mb-3">
                <label for="start_time" class="form-label">開始時間</label>
                <input type="text" class="form-control timepicker" id="start_time" name="start_time" value="{{ old('start_time') }}">
            </div>

            {{-- 結束時間 --}}
            <div class="col-md-6 mb-3">
                <label for="end_time" class="form-label">結束時間</label>
                <input type="text" class="form-control timepicker" id="end_time" name="end_time" value="{{ old('end_time') }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">儲存</button>
        <a href="{{ route('admin.calendar.index') }}" class="btn btn-secondary">返回日曆</a>
    </form>
@endsection