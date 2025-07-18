<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', '管理者後台')</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">管理者後台</a>

            {{-- 1. 新增漢堡按鈕 --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- 2. 在 div 加上 id="navbarNav" 來跟按鈕對應 --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    {{-- 2. 新增日曆課表連結 --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.calendar.index') }}">日曆課表</a>
                </li>
                
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.course-templates.index') }}">課程模板管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.schools.index') }}">校區管理</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">使用者管理</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <main class="container mt-4">
        @yield('content')
    </main>
</body>

</html>
