@extends('layouts.admin')

@section('title', '日曆課表')

@section('content')
    <h2>日曆課表</h2>

     {{-- 加入訊息顯示區塊 --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- 在 div 上加上 data-events-url 屬性，並傳入路由網址 --}}
    {{-- 1. 這是日曆的容器，必須保留 --}}
    <div id="calendar" data-events-url="{{ route('admin.calendar.getEvents') }}"></div>

    {{-- 2. 這是彈出式視窗的 HTML，加在日曆容器後面 --}}
    <div class="modal fade" id="courseEditModal" tabindex="-1" aria-labelledby="courseEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courseEditModalLabel">編輯課程</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- 我們下一步會用 AJAX 把表單內容填入這裡 --}}
                    <p>正在載入表單...</p>
                </div>
            </div>
        </div>
    </div>
@endsection