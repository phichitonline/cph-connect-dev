@extends('layouts.theme')
@section('menu-active-emr','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

@php
    if ($status_type == "IPD") {
        $h_color = "bg-red2-dark";
        $h_icon = "fa fa-bed";
    } elseif ($status_type == "NOR") {
        $h_color = "bg-green2-dark";
        $h_icon = "fas fa-stethoscope";
    } elseif ($status_type == "CHK") {
        $h_color = "bg-blue2-dark";
        $h_icon = "fa fa-user-md";
    } else {
        $h_color = "";
        $h_icon = "fas fa-stethoscope";
    }
@endphp

@foreach ($settingemr as $data)
@php
    $emr_bps = $data->emr_bps;
    $emr_bpd = $data->emr_bpd;
    $emr_temperature = $data->emr_temperature;
    $emr_pulse = $data->emr_pulse;
    $emr_bw = $data->emr_bw;
    $emr_height = $data->emr_height;
    $emr_bmi1 = $data->emr_bmi1;
    $emr_bmi2 = $data->emr_bmi2;

@endphp
@endforeach

<div class="header header-fixed header-logo-center {{ $h_color }}">
    <a href="#" class="header-title color-white">{{ DateThaiShort($vstdate) }}</a>
    <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
    <a href="#" class="header-icon header-icon-4"><i class="{{ $h_icon }}"></i></a>
</div>

@foreach ($visit_detail as $data)
<div class="page-content header-clear-medium">

    {{-- <div class="row text-center mb-0 mt-n2">
        <a href="#" data-menu="menu-transaction-transfer" class="col-6 pr-0">
            <div class="card card-style mr-2 mb-3">
                <i class="fa fa-arrow-up color-magenta2-dark fa-2x mt-3"></i>
                <h1 class="pt-2 font-18">Transfer</h1>
                <p class="font-11 opacity-50 mt-n2 mb-3">Tap to Transfer Funds</p>
            </div>
        </a>
        <a href="#" data-menu="menu-transaction-request" class="col-6 pl-0">
            <div class="card card-style ml-2 mb-3">
                <i class="fa fa-arrow-down color-highlight fa-2x mt-3"></i>
                <h1 class="pt-2 font-18">Request</h1>
                <p class="font-11 opacity-50 mt-n2 mb-3">Tap to Request Funds</p>
            </div>
        </a>
    </div> --}}

        <div class="card card-style">
        <div class="content mb-0">
            <h4 class="font-700 text-uppercase font-12 opacity-30 mb-3 mt-n2">อาการสำคัญ</h4>
            <div class="row mb-3">
                <div class="col-12"><p class="font-13 mb-0 font-500 color-theme text-left">
                    {{ $data->cc }}
                </p></div>
                <div class="divider w-100 mb-2 mt-2"></div>
            </div>

            <h4 class="font-700 text-uppercase font-12 opacity-30 mb-3 mt-n2">ตรวจร่างกาย</h4>
            <div class="row mb-0">
                <div class="col-4">
                    <div class="mx-0 mb-0">
                        <h6 class="font-14 font-700">ความดัน</h6>
                        <h1 class="@if ($data->bps > $emr_bps OR $data->bpd > $emr_bpd) {{ 'color-highlight' }} @else {{ 'color-blue2-dark' }} @endif mb-2">@if ($data->bps || "") {{ $data->bps }}/{{ $data->bpd }} @endif</h1>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <div class="mx-0 mb-0">
                        <h6 class="font-14 font-700">อุณหภูมิ(C)</h6>
                        <h1 class="@if ($data->temperature > $emr_temperature) {{ 'color-highlight' }} @else {{ 'color-blue2-dark' }} @endif mb-2">{{ $data->temperature }}</h1>
                    </div>
                </div>
                <div class="col-4 pr-3 text-right">
                    <div class="mx-0 mb-0">
                        <h6 class="font-14 font-700">ชีพจร</h6>
                        <h1 class="@if ($data->pulse > $emr_pulse) {{ 'color-highlight' }} @else {{ 'color-blue2-dark' }} @endif mb-2">{{ $data->pulse }}</h1>
                    </div>
                </div>
            </div>
            <div class="divider mt-2 mb-3"></div>
            <div class="row mb-0">
                <div class="col-4">
                    <div class="mx-0 mb-3">
                        <h6 class="font-14 font-700">น้ำหนัก(กก.)</h6>
                        <h3 class="@if ($data->bw > $emr_bw) {{ 'color-highlight' }} @else {{ 'color-blue2-dark' }} @endif font-20 mb-0">{{ $data->bw }}</h3>
                    </div>
                </div>
                <div class="col-4 text-center">
                    <div class="mx-0 mb-3">
                        <h6 class="font-14 font-700">ส่วนสูง(ซม.)</h6>
                        <h3 class="@if ($data->height < $emr_height) {{ 'color-highlight' }} @else {{ 'color-blue2-dark' }} @endif font-20 mb-0">{{ $data->height }}</h3>
                    </div>
                </div>
                <div class="col-4 pr-3 text-right">
                    <div class="mx-0 mb-3">
                        <h6 class="font-14 font-700">BMI</h6>
                        <h3 class="@if ($data->bmi < $emr_bmi1 OR $data->bmi > $emr_bmi2) {{ 'color-highlight' }} @else {{ 'color-blue2-dark' }} @endif font-20 mb-0">{{ $data->bmi }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="card card-style">-->
    <!--    <div class="content mb-0">-->
    <!--        <h4 class="font-700 text-uppercase font-12 opacity-30 mb-3 mt-n2">วินิจฉัย</h4>-->
    <!--        <div class="row mb-3">-->
    <!--            @foreach ($visit_diag as $data)-->
    <!--            <div class="col-12"><p class="font-13 mb-0 font-500 color-theme text-left">-->
    <!--                {{ $data->icd10 }} : {{ $data->name }} @if ($data->tname || "") ({{ $data->tname }}) @endif-->
    <!--            </p></div>-->
    <!--            <div class="divider w-100 mb-2 mt-2"></div>-->
    <!--            @endforeach-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    <div class="card card-style">
        <div class="content mb-0">
            <i class="fa font-14 fa-solid fa-prescription color-black2-dark opacity-30"></i>
            <!--<h4 class="font-700 text-uppercase font-12 opacity-30 mb-3 mt-n2">ยา</h4>-->
            <span class="font-700 text-uppercase font-12 opacity-30">ยา</span>
            <div class="row mb-3">
                <div class="col-8"><p class="font-14 mb-0 font-800 color-theme text-left"></i> รายการยา</p></div>
                <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-right">จำนวน</p></div>
                <div class="divider w-100 mb-2 mt-2"></div>
                @foreach ($visit_drug as $data)


                <a data-toggle="collapse" href="#collapse-{{ $data->icode }}">
                    <div class="col-8"><p class="font-13 mb-0 font-500 color-theme text-left">{{ $data->name }}</p></div>
                    <div class="col-4"><p class="font-13 mb-0 font-800 color-theme text-right">{{ $data->qty }} {{ $data->units }}</p></div>
                    <div class="divider w-100 mb-2 mt-2"></div>
                </a>
                <div class="col-8 collapse" id="collapse-{{ $data->icode }}">
                    {{ $data->name1 }} {{ $data->name2 }} {{ $data->name3 }}
                </div>
                <div class="col-4"></div>

                @endforeach
            </div>

        </div>
    </div>
    <div class="card card-style">
        <div class="content mb-0">
            <h4 class="font-700 text-uppercase font-12 opacity-30 mb-3 mt-n2">LAB/X-Ray</h4>

                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#collapse-1">
                        <i class="fa font-14 fa-tint color-red2-dark"></i>
                        <span class="font-14">ตรวจเลือด</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="col-12 collapse" id="collapse-1">
                    <div class="row mb-3">
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-left">รายการ</p></div>
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-center">ค่าปกติ</p></div>
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-right">ผลตรวจ</p></div>
                        <div class="divider w-100 mb-0 mt-0"></div>
                        @foreach ($visit_lab_blood as $data)
                            <div class="col-4"><p class="font-13 mb-0 font-500 color-theme text-left">{{ $data->lab_items_name }}</p></div>
                            <div class="col-4"><p class="font-13 mb-0 font-800 color-theme text-center">{{ $data->lab_items_normal_value }}</p></div>
                            @php
                            if ($data->range_check_max || NULL) {
                                if ($data->lab_order_result > $data->range_check_max) {
                                    $r_result = "color-red2-dark";
                                    $a_result = ""; //fa fa-arrow-up
                                } else if ($data->lab_order_result < $data->range_check_min) {
                                    $r_result = "color-green2-dark";
                                    $a_result = ""; //fa fa-arrow-down
                                } else {
                                    $r_result = "";
                                    $a_result = "";
                                }
                            } else {
                                $r_result = "";
                                $a_result = "";
                            }
                            @endphp
                            <div class="col-4"><p class="font-13 mb-0 font-800 {{ $r_result }} text-right">
                                <i class="{{ $a_result }} {{ $r_result }} pr-1"></i> {{ $data->lab_order_result }}
                            </p></div>
                            <div class="divider w-100 mb-0 mt-0"></div>
                        @endforeach

                    </div>
                </div>

                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#collapse-2">
                        <i class="fa font-14 fa-solid fa-flask color-blue2-dark"></i>
                        <span class="font-14">ตรวจปัสสาวะ</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="col-12 collapse" id="collapse-2">
                    <div class="row mb-3">
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-left">รายการ</p></div>
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-center">ค่าปกติ</p></div>
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-right">ผลตรวจ</p></div>
                        <div class="divider w-100 mb-0 mt-0"></div>
                        @foreach ($visit_lab_urine as $data)
                            <div class="col-4"><p class="font-13 mb-0 font-500 color-theme text-left">{{ $data->lab_items_name }}</p></div>
                            <div class="col-4"><p class="font-13 mb-0 font-800 color-theme text-center">{{ $data->lab_items_normal_value }}</p></div>
                            @php
                            if ($data->range_check_max || NULL) {
                                if ($data->lab_order_result > $data->range_check_max) {
                                    $r_result = "color-red2-dark";
                                    $a_result = ""; //fa fa-arrow-up
                                } else if ($data->lab_order_result < $data->range_check_min) {
                                    $r_result = "color-green2-dark";
                                    $a_result = ""; //fa fa-arrow-down
                                } else {
                                    $r_result = "";
                                    $a_result = "";
                                }
                            } else {
                                $r_result = "";
                                $a_result = "";
                            }
                            @endphp
                            <div class="col-4"><p class="font-13 mb-0 font-800 {{ $r_result }} text-right">
                                <i class="{{ $a_result }} {{ $r_result }} pr-1"></i> {{ $data->lab_order_result }}
                            </p></div>
                            <div class="divider w-100 mb-0 mt-0"></div>
                        @endforeach

                    </div>
                </div>

                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#collapse-22">
                        <i class="fa font-14 fa-solid fa-vial color-black2-dark"></i>
                        <span class="font-14">อื่นๆ</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="col-12 collapse" id="collapse-22">
                    <div class="row mb-3">
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-left">รายการ</p></div>
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-center">ค่าปกติ</p></div>
                        <div class="col-4"><p class="font-14 mb-0 font-800 color-theme text-right">ผลตรวจ</p></div>
                        <div class="divider w-100 mb-0 mt-0"></div>
                        @foreach ($visit_lab_other as $data)
                            <div class="col-4"><p class="font-13 mb-0 font-500 color-theme text-left">{{ $data->lab_items_name }}</p></div>
                            <div class="col-4"><p class="font-13 mb-0 font-800 color-theme text-center">{{ $data->lab_items_normal_value }}</p></div>
                            @php
                            if ($data->range_check_max || NULL) {
                                if ($data->lab_order_result > $data->range_check_max) {
                                    $r_result = "color-red2-dark";
                                    $a_result = ""; //fa fa-arrow-up
                                } else if ($data->lab_order_result < $data->range_check_min) {
                                    $r_result = "color-green2-dark";
                                    $a_result = ""; //fa fa-arrow-down
                                } else {
                                    $r_result = "";
                                    $a_result = "";
                                }
                            } else {
                                $r_result = "";
                                $a_result = "";
                            }
                            @endphp
                            <div class="col-4"><p class="font-13 mb-0 font-800 {{ $r_result }} text-right">
                                <i class="{{ $a_result }} {{ $r_result }} pr-1"></i> {{ $data->lab_order_result }}
                            </p></div>
                            <div class="divider w-100 mb-0 mt-0"></div>
                        @endforeach

                    </div>
                </div>

                <div class="list-group list-custom-small list-icon-0">
                    <a data-toggle="collapse" href="#collapse-3">
                        <i class="fa font-14 fa-solid fa-radiation color-red2-dark"></i>
                        <span class="font-14">X-Ray</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                </div>
                <div class="col-12 collapse" id="collapse-3">
                    <div class="row mb-3">
                        <div class="col-8"><p class="font-14 mb-0 font-800 color-theme text-left">รายการสั่ง X-Ray</p></div>
                        <div class="divider w-100 mb-0 mt-0"></div>
                        @foreach ($visit_xray as $data)
                        <div class="col-8"><p class="font-13 mb-0 font-500 color-theme text-left">{{ $data->xray_list }}</p></div>
                        <div class="divider w-100 mb-0 mt-0"></div>
                        @endforeach
                    </div>
                </div>

        </div>
    </div>


</div>
<!-- End of Page Content-->
@endforeach

@endsection

@section('footer_script')

@endsection
