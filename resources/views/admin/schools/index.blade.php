@extends('layouts.admin')

@section('title', '校區管理')

@section('content')
    <h2>校區管理</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('admin.schools.create') }}" class="btn btn-success">新增校區</a>
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
                <th scope="col">校區名稱</th>
                <th scope="col">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($schools as $school)
                <tr>
                    <th scope="row">{{ $school->id }}</th>
                    <td>{{ $school->name }}</td>
                    <td>
                        <a href="{{ route('admin.schools.edit', $school->id) }}" class="btn btn-sm btn-primary">編輯</a>
                        <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('確定要刪除嗎？');">刪除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">目前沒有任何校區。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection