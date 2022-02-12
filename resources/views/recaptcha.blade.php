@extends('layouts.theme')
@section('menu-active-register','active-nav')
@section('menu-active',' color-gray1-dark')
@section('header_script')
{{-- header --}}
<script src="https://www.google.com/recaptcha/api.js?hl=th" async defer></script>
@endsection

@section('content')

<div class="page-content header-clear-small">

    <div class="card card-style">
        <div class="content mb-0">
            <h1 class="text-center font-900 font-40 text-uppercase mb-0">ลงทะเบียน</h1>
            <p class="text-center color-highlight font-11"><br>กรุณากรอกข้อมูลตรวจสอบเพื่อลงทะเบียน</p>

            <form action="?" method="POST">
                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                <br/>
                <input type="submit" value="Submit">
            </form>

            <div class="clear"><br></div>

        </div>
    </div>

</div>

@endsection

@section('footer_script')


@endsection
