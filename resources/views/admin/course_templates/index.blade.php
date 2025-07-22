@extends('layouts.admin')

@section('title', '課程模板管理')

@section('content')
    <h2>課程模板管理</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.course-templates.create') }}" class="btn btn-success">新增課程模板</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">#ID</th>
                <th scope="col">模板名稱</th>
                <th scope="col">定價</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($templates as $template)
                <tr>
                    <th scope="row">{{ $template->id }}</th>
                    <td>{{ $template->name }}</td>
                    <td>{{ $template->price }}</td>
                    <td> {{-- 換成這個版本 --}}
                        @can('update', $template)
                            <a href="{{ route('admin.course-templates.edit', $template->id) }}" class="btn btn-sm btn-primary">編輯</a>
                        @endcan
                        
                        @can('delete', $template)
                            <form action="{{ route('admin.course-templates.destroy', $template->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('確定要刪除嗎？');">刪除</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">目前沒有任何課程模板。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection