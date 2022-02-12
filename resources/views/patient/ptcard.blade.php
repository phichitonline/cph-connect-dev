@extends('layouts.theme')
@section('menu-active-card','active-nav')
@section('menu-active',' color-gray1-dark')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="header header-fixed header-logo-center bg-red1-dark">
    <a href="https://liff.line.me/1654103357-zl6xB06Y" class="header-title color-white">หน้าหลักบริการออนไลน์</a>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
    <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
</div>

<div class="page-content header-clear-large">

    <div class="footer card card-style">
        <a href="#" class="footer-title"><span class="color-highlight">
            ข้อมูลการลงทะเบียนออนไลน์นี้จะมีอายุ 90 วัน หากยังไม่เข้ารับบริการจริงที่โรงพยาบาล ข้อมูลการลงทะเบียนนี้จะถูกยกเลิกอัตโนมัติ
        </span></a>
        <div class="clear"><br></div>
    </div><br>
        <!-- ข้อมูลทั่วไปผู้ป่วย -->
    <div class="card card-style shadow-xl rounded-m">
        <div class="cal-footer">
            <h4 class="cal-title text-center text-uppercase font-25 bg-green2-dark color-white">ลงทะเบียนสำเร็จแล้ว</h4>

            <div class="content mb-0">
                <div class="text-center">
                    @php
                    require_once '../vendor/autoload.php';
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    echo '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($patienthn,$generator::TYPE_CODE_128)).'"height="120" width="290">';
                    @endphp
                </div>
                <div class="list-group list-custom-small list-icon-0">
                    <h1 class="font-30 mb-1 text-center">HN: {{ $patienthn }}</h1>
                </div>

            </div>
        </div>
    </div>

        <div class="card card-style">
            <div class="content mb-0">
                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#">
                        <h4 class="font-700 mb-1">ชื่อ: {{ $patientname }}</h4>
                        <h4 class="font-700 mb-1">วันเกิด: {{ DateThaiFull($ptbirthday) }}</h4>
                        <h4 class="font-700 mb-1">เลขบัตรประชาชน: {{ $patientcid }}</h4>
                        <h4 class="font-700 mb-1">เบอร์โทรศัพท์: {{ $patienttel }}</h4>
                    </a>
                </div>
            </div>

        </div>

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
