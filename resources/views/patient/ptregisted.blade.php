@extends('layouts.theme')
@section('menu-active-main','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

@if (session('session-alert-store'))
<div class="header header-fixed header-logo-center bg-red1-dark">
    <a href="{{ config('line-bot.liff_url') }}" class="header-title color-white">หน้าหลักบริการออนไลน์</a>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
    <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
</div>

<div class="page-content header-clear-large">

    <div class="card card-style shadow-xl rounded-m">
        <div class="cal-footer">
            <h4 class="cal-title text-center text-uppercase font-25 bg-green2-dark color-white">{{ session('session-alert-store') }}</h4>
            <div class="content mb-0">
                <div class="clear"><br></div>
                <h4>ชื่อ : {{ $patientname }}</h4>
                <h4>วันเกิด : {{ DateThaiFull($ptbirthday) }}</h4>
                <h4>เลขบัตรประชาชน : {{ $patientcid }}</h4>
                <h4>เบอร์โทรศัพท์ : {{ $patienttel }}</h4>
                <h4>เลขที่โรงพยาบาล (HN) : <strong>{{ $patienthn }}</strong></h4>
                <div class="clear"><br></div>
            </div>

            <div class="clear"><br></div>

        </div>
    </div>
</div>
@endif

<!-- End of Page Content-->

@endsection


@section('footer_script')

@endsection
