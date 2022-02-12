@extends('layouts.theme')
@section('menu-active-card','active-nav')
@section('menu-active',' color-gray1-dark')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="header header-fixed header-logo-center bg-red1-dark">
    <a href="https://restful.tphcp.go.th/smarthospital/" class="header-title color-white">หน้าหลักบริการออนไลน์</a>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
    <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
</div>

<!-- Begin of Page Content-->
<div class="page-content header-clear-large">


        <div class="footer card card-style">
            <a href="#" class="footer-title"><span class="color-highlight">หมายเหตุ</span></a>
            <p class="footer-text">
                <span class="font-16">
                    <br><b>คุณสามารถนำบัตรนี้แสดงต่อเจ้าหน้าที่ และสแกนรับบัตรคิว เพื่อขอรับบริการในแผนกต่างๆของโรงพยาบาลได้</b>
                </span>
            </p>
        </div>

</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
