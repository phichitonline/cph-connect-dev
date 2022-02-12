@extends('layouts.theme')
@section('menu-active',' color-gray1-dark')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="header header-fixed header-logo-center bg-red2-dark">
    <a href="" onclick="closed()" class="header-title color-white">ปิดโปรแกรม</a>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-times"></i></a>
    <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-lightbulb"></i></a>
</div>

    <div class="page-content header-clear-large">
    <div class="footer card card-style">
        <a href="#" class="footer-title"><span class="color-highlight">เกิดข้อผิดพลาด!</span></a>

        @if (session('session-alert'))
        <a href="#" class="footer-title"><span class="color-highlight"><br>{{ session('session-alert') }}</span></a><br>
        @endif

        <p class="footer-text"><span>กรุณาปิดแล้วเริ่มต้นใหม่อีกครั้ง</span><br>

        <div class="clear"></div>
    </div>    
</div>

@endsection

@section('footer_script')


@endsection