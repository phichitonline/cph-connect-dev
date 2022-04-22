@extends('layouts.theme')
@section('menu-active-emr','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')


<div class="page-content header-clear-small">

    <div class="card card-style">
        <div class="d-flex content">
            <div class="flex-grow-1">
                <div>
                    <h1 class="font-700 mb-1">{{ $moduletitle }}</h1>
                    <p class="mb-0 pb-1 pr-3">
                        {{ $ptname }}
                    </p>
                </div>
            </div>
            <div>
                <img src="{{ $pic }}" data-src="{{ $pic }}" width="50" class="rounded-circle mt- shadow-xl preload-img">
            </div>
        </div>
    </div>

    @if (Session::has('settingemr-updated'))
    <div class="ml-3 mr-3 alert alert-small rounded-s shadow-xl bg-green1-dark" role="alert">
        <span><i class="fa fa-check"></i></span>
        <strong>{{ Session('settingemr-updated') }}</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-dismiss="alert" aria-label="Close">&times;</button>
    </div>

    @endif

    <div class="card card-style">
        <div class="content mt-0 mb-0">
            <div class="list-group list-custom-large list-icon-0">
                @foreach ($visit_list as $data)
                <a href="{{ route('emr.show', $data->vn) }}">
                    @if ($data->an !== NULL)
                        <i class="fa font-19 fa-bed rounded-s color-red1-dark"></i>
                        <span class="color-red2-dark">{{ DateThaiShort($data->vstdate) }} (ผู้ป่วยใน)</span>
                        <strong class="color-red2-dark">{{ $data->cc }}</strong>
                    @else
                        @if (strpos($data->visitdiag, $emr_checkup_icd10) === FALSE)
                            <i class="fa font-19 fa-stethoscope rounded-s color-green1-dark"></i>
                            <span>{{ DateThaiShort($data->vstdate) }}</span>
                            <strong>{{ $data->cc }}</strong>
                        @else
                            <i class="fa font-19 fa-user-md rounded-s color-blue1-dark"></i>
                            <span>{{ DateThaiShort($data->vstdate) }}</span>
                            <strong>{{ $data->cc }}</strong>
                        @endif
                    @endif

                    <i class="fa fa-chevron-right opacity-30"></i>
                </a>
                @endforeach
            </div>
        </div>
    </div>


@if ($isadmin == "A")
    <div class="card card-style">
        <div class="content mb-0 mt-0">
            <div class="list-group list-custom-large list-icon-0">
                <a href="{{ route('emr.edit',1)}}">
                    <i class="fa font-19 fa-cog rounded-s color-blue2-dark"></i>
                    <span>Settings</span>
                    <strong>ตั้งค่าระบบ EMR และกำหนดค่ามาตรฐาน</strong>
                    <i class="fa fa-chevron-right opacity-30"></i>
                </a>

            </div>
        </div>
    </div>
@endif

    <div class="footer card card-style">
        <a href="#" class="footer-title"><span class="color-highlight">หมายเหตุ</span></a>
        <p class="footer-text">
            <span>แสดงประวัติการรับบริการทั่วไปล่าสุด {{ $emr_visit_limit }} ปี
                <br>ประวัติตรวจสุขภาพประจำปีย้อนหลังทุกครั้ง
            </span>
        <div class="clear"></div>
    </div>
</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')

@endsection
