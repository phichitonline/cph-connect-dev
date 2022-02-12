@extends('layouts.theme')
@section('menu-active-main','active-nav')
@section('menu-active',' color-gray1-dark')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="header header-fixed header-logo-center bg-red1-dark">
    <a href="#" onclick="goBack()" class="header-title color-white">ตรวจตอบอีกครั้ง</a>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
    <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
</div>

<div class="page-content header-clear-large">

@if (session('session-alert'))
    <div class="card card-style shadow-xl rounded-m">
        <div class="cal-footer">
            <h4 class="cal-title text-center text-uppercase font-25 bg-red2-dark color-white">{{ session('session-alert') }}</h4>

            <div class="content mb-0">
                <div class="clear"><br></div>
                <h4>ชื่อ : {{ $pname }}{{ $fname }}  {{ $lname }}</h4>
                <h4>วันเกิด : {{ DateThaiFull($birthday) }}</h4>
                <h4>เลขบัตรประชาชน : {{ $cid }}</h4>
                <h4>เลขที่โรงพยาบาล (HN) : {{ $hn }}</h4>
                <div class="clear"><br></div>
            </div>

            <div class="clear"><br></div>

        </div>
    </div>
@endif

@if (session('session-alert-invalid-cid'))
    <div class="card card-style shadow-xl rounded-m">
        <div class="cal-footer">
            <h4 class="cal-title text-center text-uppercase font-25 bg-red2-dark color-white">{{ session('session-alert-invalid-cid') }}</h4>

        </div>
    </div>
@endif

</div>
<!-- End of Page Content-->

@endsection


@section('footer_script')

<script>
    function goBack() {
      window.history.back();
    }
</script>

@endsection
