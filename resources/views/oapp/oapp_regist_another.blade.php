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
                <h4 class="cal-title text-center text-uppercase font-25 bg-green2-dark color-white">คนที่ 1 : {{ $patientuser_hn2 }}</h4>
                @endif
                @if ($patientuser_hn3 || "")
                <h4 class="cal-title text-center text-uppercase font-25 bg-green2-dark color-white">คนที่ 2 : {{ $patientuser_hn3 }}</h4>
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
                <form method="post" action="{{ route('oapp.store') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')

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
                        <input type="number" name="abirthday" placeholder="วันเดือนปีเกิด 05122540" required>
                    </div>

					<div class="clearfix"></div>

                    <button class="btn btn-m btn-full btn-block rounded-s shadow-l bg-green2-dark text-uppercase font-900" type="submit"  name="submit">ลงทะเบียน</button>

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
            <br>คุณสามารถลงทะเบียนรับการแจ้งเตือนให้กับคนในครอบครัว หรือผู้ที่เราต้องการดูแลได้เพียง 2 คนเท่านั้น
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
