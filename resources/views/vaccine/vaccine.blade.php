@extends('layouts.theme')
@section('menu-active-vac','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

{{-- @foreach($setting as $data)
@php
    $hos_name = $data->hos_name;
    $hos_url = $data->hos_url;
    $hos_tel = $data->hos_tel;
@endphp
@endforeach --}}

<div class="page-content header-clear-small">

    <div class="card card-style shadow-xl rounded-m">
        <div class="cal-footer">

            <h4 class="cal-title text-center text-uppercase font-25 bg-green1-dark color-white">วันนัดของคุณ</h6>
            <span class="cal-message mt-3 mb-3">
                <i class="fa fa-bell font-18 color-green1-dark"></i>
                <strong class="color-gray-dark">คุณสามารถจัดการการนัดหมายเข้ารับบริการได้</strong>
                <strong class="color-gray-dark">หรือติดต่อเจ้าหน้าที่เพื่อขอคำแนะนำหรือเลื่อนนัด</strong>
            </span>
            <div class="divider mb-0"></div>

            <div class="content">
                <h4>นัดออนไลน์รอยืนยัน</h4>
            </div>
            <div class="accordion" id="accordion-1">
                {{-- @foreach($que_card as $data) --}}
                <div class="mb-0">
                    <button class="btn accordion-btn" data-toggle="collapse" data-target="#collapse2">
                        <i class="fa fa-cloud color-blue2-dark mr-2"></i>
                        {{-- {{ DateThaiFull($data->que_date) }} --}}
                        <i class="fa fa-chevron-down font-10 accordion-icon"></i>
                    </button>
                    <div id="collapse2" class="collapse" data-parent="#accordion-1">
                        <div class="pt-1 pb-2 pl-3 pr-3">
                            <ul>
                                {{-- <li>{{ $data->que_cc }}</li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- @endforeach --}}
            </div>

            <div class="content">
                <h4>วันนัดของคุณ</h4>
            </div>
            <div class="accordion" id="accordion-2">
                <div class="mb-0">
                    <button class="btn accordion-btn"  data-toggle="collapse" data-target="#collapse1">
                        <i class="fa fa-cloud color-blue2-dark mr-2"></i>
                        วันที่
                        <i class="fa fa-chevron-down font-10 accordion-icon"></i>
                    </button>
                    <div id="collapse1" class="collapse"  data-parent="#accordion-2">
                        <div class="pt-1 pb-2 pl-3 pr-3">
                            <ul>
                                <li>ชื่อ</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="footer card card-style">
        <a class="footer-title"><span class="color-highlight">หมายเหตุ</span></a>
        <p class="footer-text">
        <span class="font-12">
            <br>- งดจองวันหยุดราชการและวันหยุดนักขัตฤกษ์
            <br>- สามารถจองได้เพียงวันละ 1 คิวเท่านั้น
        </span>
        <span class="font-16">
            <br><br><b>หากมีปัญหา ข้อสงสัย ต้องการคำแนะนำหรือเลื่อนนัดยกเลิกนัด โปรดติดต่อเจ้าหน้าที่ <br>โทร <a href="tel:056621366">056621355</a>
        </span>
        </p>
    </div>

</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
