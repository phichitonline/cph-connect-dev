@extends('layouts.theme')
@section('menu-active-card','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')
                
    <div class="page-content header-clear-small">
        
        <div class="card card-style">
        <div class="card mb-0 preload-img" data-src="{{ $pic }}" data-card-height="65vh">
            <div class="card-bottom ml-3">
                <h4 class="font-25 line-height-xl text-center">{{ $ptname }}</h4>
            </div>
            {{-- <div class="card-overlay bg-gradient-fade-small"></div> --}}
        </div>
        </div>

        <!-- ข้อมูลทั่วไปผู้ป่วย -->
        <div class="card card-style">

            <div class="content mb-0">
                <div class="text-center">
                    @php
                    require_once '../vendor/autoload.php';
                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();
                    echo '<img src="data:image/png;base64,'.base64_encode($generator->getBarcode($_SESSION['hn'],$generator::TYPE_CODE_128)).'"height="120" width="290">';
                    @endphp
                </div>
                <div class="list-group list-custom-small list-icon-0">
                    <h1 class="font-30 mb-1 text-center">HN: {{ $hn }}</h1>
                </div>

            </div>
        </div>

        <div class="card card-style">
            <div class="content mb-0">
                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#">
                        <h4 class="font-700 mb-1">วันเกิด: {{ DateThaiFull($birthday) }}</h4>
                        <h4 class="font-700 mb-1">อายุ: {{ $age_year }} ปี</h4>
                        <h4 class="font-700 mb-1">เลขบัตรประชาชน: {{ $cid }}</h4>
                    </a>        
                </div>

                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#">
                        <i class="fa font-14 fa-address-card color-blue2-dark"></i>
                        <span class="font-14">สิทธิรักษา: <b>{{ $pttypename }}</b></span>
                    </a>        
                </div>
                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#">
                        <i class="fa font-14 fa-tint color-red2-dark"></i>
                        <span class="font-14">กรุ๊ปเลือด: <b>{{ $bloodgrp }}</b></span>
                    </a>        
                </div>
                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#collapse-1">
                        <i class="fa font-14 fa-share-alt color-red2-dark"></i>
                        <span class="font-14">ข้อมูลแพ้ยา/โรคประจำตัว</span>
                        <i class="fa fa-angle-down"></i>
                    </a>        
                </div>
                <div class="collapse" id="collapse-1">
                    <div class="list-group list-custom-small pl-3">
                        <a href="#">
                            <i class="fa font-14 fa-pills color-red2-dark"></i>
                            <span>แพ้ยา: <b>{{ $drugallergy }}</b></span>
                        </a>        
                        <a href="#">
                            <i class="fa font-14 fa-universal-access color-red2-dark"></i>
                            <span>โรคประจำตัว: <b>{{ $clinic }}</b></span>
                        </a>        
                    </div>
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