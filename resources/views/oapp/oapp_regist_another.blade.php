@extends('layouts.theme')
@section('menu-active-oapp','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

@foreach($setting as $data)
@php
    $hos_name = $data->hos_name;
    $hos_url = $data->hos_url;
    $hos_tel = $data->hos_tel;
@endphp
@endforeach

    <div class="header header-fixed header-logo-center bg-green1-dark">
        <a href="#" onclick="goBack()" class="header-title color-white">ย้อนกลับ</a>
        <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
    </div>

    <div class="page-content header-clear-large">


        <div class="card card-style">
            <div class="cal-header">
                <h4 class="cal-title text-center text-uppercase font-25 bg-green2-dark color-white">{{ $app_regist_another }}</h4>
                @if ($patientuser_hn2 || "")
                <h4 class="cal-title text-center text-uppercase font-20 bg-green2-dark color-white">คนที่ 1 HN : {{ $patientuser_hn2 }} <a href="#" data-menu="ad-timed-2" data-timed-ad="5"><i class="fa font-20 fa-info-circle color-white2-dark"></i></a></h4>
                @endif
                @if ($patientuser_hn3 || "")
                <h4 class="cal-title text-center text-uppercase font-20 bg-green2-dark color-white">คนที่ 2 HN : {{ $patientuser_hn3 }} <a href="#" data-menu="ad-timed-3" data-timed-ad="5"><i class="fa font-20 fa-info-circle color-white2-dark"></i></a></h4>
                @endif
                @if ($regist_number == "คุณลงทะเบียนครบแล้ว")
                <h4 class="cal-title text-center text-uppercase font-25 bg-red2-dark color-white">{{ $regist_number }}</h4>
                @else
                <h4 class="cal-title text-center text-uppercase font-25 color-highlight">{{ $regist_number }}</h4>
                @endif
            </div>

        @if ($patientuser_hn3 || "")
        @else
            <div class="content mb-0">
                <form method="GET" action="{{ route('oappupdatecheck') }}" autocomplete="off" class="form-horizontal">
                    @csrf

                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-user color-theme"></i>
                        <span>เลขบัตรประชาชน</span>
                        <em>(required)</em>
                        <input type="number" name="acid" placeholder="เลขบัตรประชาชน 13 หลัก" required autofocus>
                    </div>
                    <div class="input-style has-icon input-style-1 input-required">
                        <i class="input-icon fa fa-lock color-theme"></i>
                        <span>วันเดือนปีเกิด</span>
                        <em>(required)</em>
                        <input type="number" name="abirthday" placeholder="" required>
                        <input type="hidden" name="regist_number" value="{{ $regist_number }}">
                        <input type="hidden" name="patientuser_hn2" value="{{ $patientuser_hn2 }}">
                        <input type="hidden" name="patientuser_hn3" value="{{ $patientuser_hn3 }}">
                    </div>

					<div class="clearfix"></div>

                    <button class="btn btn-m btn-full btn-block rounded-s shadow-l bg-green2-dark text-uppercase font-900" type="submit"  name="submit">ตรวจสอบลงทะเบียน</button>

                    <div class="clearfix"></div>

                    <p class="text-center">
                        <br>
                    </p>

                </form>

            </div>
        @endif

        </div>

    <div class="footer card card-style">
        <a class="footer-title"><span class="color-highlight">หมายเหตุ</span></a>
        <p class="footer-text">
        <span class="font-14">
            <br>คุณสามารถลงทะเบียนรับการแจ้งเตือนให้กับคนในครอบครัว หรือผู้ที่เราต้องการดูได้ได้เพียง 2 คนเท่านั้น
        </span>
        <span class="font-16">
            <br><br><b>หากมีปัญหา ข้อสงสัย ต้องการคำแนะนำ โปรดติดต่อเจ้าหน้าที่ <br>โทร <a href="tel:{{ $hos_tel }}">
                {{ $hos_tel }}</a>
        </span>
        </p>
    </div>

    </div>
    <!-- End of Page Content-->

    <div id="ad-timed-2" class="menu menu-box-modal menu-box-detached round-large" data-menu-width="340" data-menu-height="340" data-menu-effect="menu-over">
        <div class="card" data-card-height="340">
            <div class="card-top">
                <span class="color-white bg-black font-10 opacity-50 pb-1 pt-1 pl-2 pr-2 ml-1">HN : {{ $patientuser_hn2 }}</span>
            </div>
            <div class="card-center ml-2 mr-2">
                <h1 class="color-white text-center mb-3">{{ $pname2.$fname2." ".$lname2 }}</h1>
                <div class="content mb-0">
                    <h4 class="color-white">วันเกิด : {{ DateThaiFull($birthday2) }}</h4>
                    <h4 class="color-white">เลขบัตรประชาชน : {{ $cid2 }}</h4>
                    <h4 class="color-white">เลขที่โรงพยาบาล (HN) : {{ $hn2 }}</h4>
                </div>
                <a href="#" class="close-menu mr-3 ml-3 mt-5 btn btn-m btn-full rounded-s shadow-xl text-uppercase font-900 bg-red2-dark">ปิด</a>
            </div>
            <div class="card-overlay bg-black opacity-50"></div>
        </div>
    </div>

    <div id="ad-timed-3" class="menu menu-box-modal menu-box-detached round-large" data-menu-width="340" data-menu-height="340" data-menu-effect="menu-over">
        <div class="card" data-card-height="340">
            <div class="card-top">
                <span class="color-white bg-black font-10 opacity-50 pb-1 pt-1 pl-2 pr-2 ml-1">HN : {{ $patientuser_hn3 }}</span>
            </div>
            <div class="card-center ml-2 mr-2">
                <h1 class="color-white text-center mb-3">{{ $pname3.$fname3." ".$lname3 }}</h1>
                <div class="content mb-0">
                    <h4 class="color-white">วันเกิด : {{ DateThaiFull($birthday3) }}</h4>
                    <h4 class="color-white">เลขบัตรประชาชน : {{ $cid3 }}</h4>
                    <h4 class="color-white">เลขที่โรงพยาบาล (HN) : {{ $hn3 }}</h4>
                </div>
                <a href="#" class="close-menu mr-3 ml-3 mt-5 btn btn-m btn-full rounded-s shadow-xl text-uppercase font-900 bg-red2-dark">ปิด</a>
            </div>
            <div class="card-overlay bg-black opacity-50"></div>
        </div>
    </div>

@endsection

@section('footer_script')

<script>
    function goBack() {
      window.history.back();
    }
</script>

@endsection
