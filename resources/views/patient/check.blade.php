@extends('layouts.theme')
@section('menu-active-main','')
@section('menu-active',' color-gray1-dark')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="page-content header-clear-small">

@if (session('session-alert'))
    <div class="footer card card-style">
        <a href="#" class="footer-title"><span class="color-highlight">{{ session('session-alert') }}</span></a>
        <div class="clear"><br></div>
    </div><br>
@endif

@if (session('session-alert-cid'))
<div class="header header-fixed header-logo-center bg-red1-dark">
    <a href="#" class="header-title color-white">Invalid CID</a>
    <a href="#" class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
    <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
</div>
<div class="page-content header-clear-small">
<div class="page-content header-clear-small">
<br>
    <div class="footer card card-style">
        <a href="#" class="footer-title"><span class="color-highlight">{{ session('session-alert-cid') }}</span></a>
        <div class="clear"><br></div>
    </div><br>
@endif

<div class="footer card card-style">
    <a href="#" class="footer-title"><span class="color-highlight">
        เพื่อความสะดวกรวดเร็วในการเข้ารับบริการ คุณสามารถลงทะเบียนทำบัตรใหม่ไว้ล่วงหน้า... <br>กรุณาตรวจสอบข้อมูลและลงทะเบียนต่อ
    </span></a>
    <div class="clear"><br></div>
</div><br>

<form method="GET" action="{{ route('ptcheck') }}" autocomplete="off" class="form-horizontal">
    @csrf
    {{-- @method('post') --}}

    <div class="card card-style shadow-xl rounded-m">
        <div class="cal-footer">
            <h4 class="cal-title text-center text-uppercase font-25 bg-blue2-dark color-white">{{ $moduletitle }}</h4>

            <div class="content mb-0">
                <div class="input-style has-icon input-style-2 input-required">
                    <i class="input-icon fa fa-address-card color-theme"></i>
                    <span class="color-highlight input-style-1-active">เลขบัตรประจำตัวประชาชน</span>
                    <em>(required)</em>
                    <input class="form-control" type="tel" name="cid" placeholder="เลขบัตรประชาชน 13 หลัก" required autofocus>
                </div>
                <div class="input-style has-icon input-style-2 input-required">
                    <i class="input-icon fa fa-lock color-theme"></i>
                    <span class="color-highlight input-style-1-active">วันเดือนปี พ.ศ.เกิด</span>
                    <em>(required)</em>
                    <input class="form-control" type="tel" name="birthday" placeholder="รูปแบบเป็นปี พ.ศ.เช่น 31122530" required>
                </div>
            </div>

            <button type="submit" class="btn scale-box mt-3 btn-center-l rounded-l shadow-xl bg-blue2-dark font-800 text-uppercase">ตรวจสอบข้อมูล</button>
            <div class="clear"><br></div>

        </div>
    </div>

</form>



</div>
<!-- End of Page Content-->

@endsection


@section('footer_script')


@endsection
