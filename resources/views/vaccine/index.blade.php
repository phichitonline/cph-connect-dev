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

            <h4 class="cal-title text-center text-uppercase font-25 bg-pink2-dark color-white">ข้อมูลวัคซีนของคุณ</h6>

            <div class="divider mb-0"></div>

            <div class="accordion" id="accordion-2">
                @foreach($vaccine_list as $data)
                <div class="mb-0">
                    <button class="btn accordion-btn"  data-toggle="collapse" data-target="#collapse{{ $data->vn }}">
                        <i class="fa fa-syringe color-pink2-dark mr-2"></i>
                        {{ DateThaiShort($data->vstdate) }} : {{ $data->vaccine_name }}
                        @if ($data->vaccine_plan_no || null)
                            เข็มที่ {{ $data->vaccine_plan_no }}
                        @endif
                        <i class="fa fa-chevron-down font-10 accordion-icon"></i>
                    </button>
                    <div id="collapse{{ $data->vn }}" class="collapse"  data-parent="#accordion-2">
                        <div class="pt-1 pb-2 pl-3 pr-3">
                            <ul>
                                @if ($data->vaccine_manufacturer_name || null)
                                <li>{{ $data->vaccine_manufacturer_name }}</li>
                                @else
                                <li>ไม่มีข้อมูลอื่นๆ...</li>
                                @endif
                                @if ($data->serial_no || null)
                                <li>Lot number : {{ $data->vaccine_lot_no }}</li>
                                <li>Serial number : {{ $data->serial_no }}</li>
                                @endif
                                @if ($data->moph_certificate_code || null)
                                <li>ใบรับรอง : <a target="_blank" href="https://co19cert.moph.go.th/cert?id={{ $data->moph_certificate_code }}">คลิกดูใบรับรอง</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    <div class="footer card card-style">
        <a class="footer-title"><span class="color-highlight">หมายเหตุ</span></a>
        <p class="footer-text">
        <span class="font-16">
            <br><br><b>หากมีปัญหา ข้อสงสัย ต้องการคำแนะนำ โปรดติดต่อเจ้าหน้าที่ <br>โทร <a href="tel:056621366">056621355</a>
        </span>
        </p>
    </div>

</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
