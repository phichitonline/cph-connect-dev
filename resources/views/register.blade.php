@extends('layouts.theme')
@section('menu-active-register','active-nav')
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

    <div class="card card-style">
        <div class="content mb-0">
            <h1 class="text-center font-900 font-40 text-uppercase mb-0">ลงทะเบียน</h1>
            <p class="text-center color-highlight font-11"><br>กรุณากรอกข้อมูลตรวจสอบเพื่อลงทะเบียน</p>

        <form method="post" action="{{ route('sessionregister.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="input-style has-icon input-style-1 input-required">
                <i class="input-icon fa fa-user color-theme"></i>
                <span>เลขบัตรประชาชน</span>
                <em>(required)</em>
                <input type="number" name="cid" placeholder="เลขบัตรประชาชน 13 หลัก" required autofocus>
                <input type="hidden" name="lineid" value="{{ $userid ?? '' }}">
            </div>
            <div class="input-style has-icon input-style-1 input-required">
                <i class="input-icon fa fa-lock color-theme"></i>
                <span>วันเดือนปีเกิด</span>
                <em>(required)</em>
                <input type="number" name="birthday" placeholder="วันเดือนปีเกิด 05122540" required>
            </div>
            <div class="input-style has-icon input-style-1 input-required">
                <i class="input-icon fa fa-phone color-theme"></i>
                <span>เบอร์โทรศัพท์</span>
                <em>(required)</em>
                <input type="number" name="tel" placeholder="เบอร์โทรศัพท์" required>
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="consent" value="{{ $consent }}">
            </div>

            {{-- <button type="submit" class="btn btn-m btn-full rounded-s shadow-l bg-green1-dark text-uppercase font-900">ลงทะเบียน</button> --}}
            <button type="submit" class="btn scale-box btn-m mt-3 btn-center-l rounded-l shadow-xl bg-green1-dark font-800 text-uppercase">ลงทะเบียน</button>
        </form>

            <div class="clear"><br></div>

        </div>
    </div>

</div>

@endsection

@section('footer_script')


@endsection
