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
                <h4 class="cal-title text-center text-uppercase font-20 bg-green2-dark color-white">คนที่ 1 HN : {{ $patientuser_hn2 }}</h4>
                @endif
                @if ($patientuser_hn3 || "")
                <h4 class="cal-title text-center text-uppercase font-20 bg-green2-dark color-white">คนที่ 2 HN : {{ $patientuser_hn3 }}</h4>
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

                <h4>ชื่อ : {{ $pname }}{{ $fname }}  {{ $lname }}</h4>
                <h4>วันเกิด : {{ DateThaiFull($birthday) }}</h4>
                <h4>เลขบัตรประชาชน : {{ $cid }}</h4>
                <h4>เลขที่โรงพยาบาล (HN) : {{ $hn }}</h4>
                <div class="clear"><br></div>

                <form method="POST" action="{{ route('oapp.update', $lineid) }}">
                    @csrf
                    @method('put')

                        <input type="hidden" name="acid" value="{{ $cid }}">
                        <input type="hidden" name="abirthday" value="{{ $birthday }}">
                        <input type="hidden" name="regist_number" value="{{ $regist_number }}">


					<div class="clearfix"></div>

                    <button class="btn btn-m btn-full btn-block rounded-s shadow-l bg-red2-dark text-uppercase font-900" type="submit"  name="submit">ยืนยันลงทะเบียน</button>

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

@endsection

@section('footer_script')

<script>
    function goBack() {
      window.history.back();
    }
</script>

@endsection
