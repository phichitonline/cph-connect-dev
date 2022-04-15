@extends('layouts.theme')
@section('menu-active-appointment','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

@foreach($setting as $data)
@php
    $hos_tel = $data->hos_tel;
@endphp
@endforeach

    <div class="page-content header-clear-small">

    @if (Session::has('session-alert'))
    @php
    if (Session('session-alert') == "T") {
        $session_color = "green1";
        $module_name = "จองนัดแพทย์แผนไทย";
        $book_text_message = "คุณ".$module_name." สำเร็จ \n\nโปรดตรวจสอบวันเวลานัด และคุณจะได้รับการติดต่อและยืนยันการนัดจากเจ้าหน้าที่อีกครั้ง";
    } else if (Session('session-alert') == "D") {
        $session_color = "yellow2";
        $module_name = "จองนัดทันตกรรม";
        $book_text_message = "คุณ".$module_name." สำเร็จ \n\nโปรดตรวจสอบวันเวลานัด และคุณจะได้รับการติดต่อและยืนยันการนัดจากเจ้าหน้าที่อีกครั้ง";
    } else if (Session('session-alert') == "C") {
        $session_color = "magenta1";
        $module_name = "จองนัดตรวจสุขภาพ";
        $book_text_message = "คุณ".$module_name." สำเร็จ \n\nโปรดตรวจสอบวันเวลานัด และคุณจะได้รับการติดต่อและยืนยันการนัดจากเจ้าหน้าที่อีกครั้ง";
    } else if (Session('session-alert') == "A") {
        $session_color = "blue1";
        $module_name = "จองนัดตรวจโรคทั่วไป";
        $book_text_message = "คุณ".$module_name." สำเร็จ \n\nโปรดตรวจสอบวันเวลานัด และคุณจะได้รับการติดต่อและยืนยันการนัดจากเจ้าหน้าที่อีกครั้ง";
    } else {
        $session_color = "";
        $module_name = "";
        $book_text_message = "";
    }

    require "vendor-line/autoload.php";
    $access_token = config('line-bot.channel_access_token');
    $channelSecret = config('line-bot.channel_secret');
    $pushID = $lineid;
    $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
    $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
    $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($book_text_message);
    $response = $bot->pushMessage($pushID, $textMessageBuilder);

    @endphp

        <div class="ml-3 mr-3 alert alert-small rounded-s shadow-xl bg-green1-dark" role="alert">
            <span><i class="fa fa-check"></i></span>
            <strong>คุณ{{ $module_name }} สำเร็จ</strong>
            <button type="button" class="close color-white opacity-60 font-16" data-dismiss="alert" aria-label="Close">&times;</button>
        </div>

        <div data-card-height="220" class="card card-style rounded-m shadow-xl">
            <div class="card-center text-center">
                <h1 class="color-white font-800 text-shadow-l">{{ $module_name }}</h1>
                <h5 class="color-white font-800 text-shadow-l">
                    โปรดรอการยืนยันจากเจ้าหน้าที่ เมื่อยืนยันแล้วระบบจะแจ้งให้ทราบทางไลน์ และเมื่อถึงวันนัดระบบจะแจ้งเตือนพร้อมรายละเอียดการนัดอีกครั้ง
                </h5>
            <a href="{{ url('/') }}/oapp" class="btn btn-m rounded-s shadow-l bg-red1-dark text-uppercase font-900">กดดูวันนัด</a>
            </div>
            <div class="card-overlay bg-gradient opacity-70"></div>
            <div class="card-overlay bg-gradient bg-gradient-{{ $session_color }} opacity-80"></div>
        </div>
    @endif

        <div class="row text-center mb-0">
        @foreach ($appflag as $data)

            <a href="{{ url('/') }}/appointment/calendar/?flag={{ $data->que_app_flag }}" class="col-6 {{ $data->classcol }}">
                <div class="card card-style {{ $data->classm }} mb-2">
                    <img class="img-fluid" src="{{ URL::asset('images/appointment/'.$data->app_image) }}">
                </div>
            </a>

        @endforeach
        </div>

        <div class="footer card card-style">
            <a class="footer-title"><span class="color-highlight">หมายเหตุ</span></a>
            <p class="footer-text">
            <span class="font-12">
                <br>- งดจองวันหยุดราชการและวันหยุดนักขัตฤกษ์
                <br>- สามารถจองได้เพียงวันละ 1 คิวเท่านั้น
            </span>
            <span class="font-16">
                <br><br><b>หากมีปัญหา ข้อสงสัย ต้องการคำแนะนำหรือเลื่อนนัดยกเลิกนัด โปรดติดต่อเจ้าหน้าที่ <br>โทร <a href="tel:{{ $hos_tel }}">{{ $hos_tel }}</a>
            </span>
            </p>
        </div>

        @if ($isadmin == "A" OR $isadmin == "M")
        <a href="{{ url('/') }}/appointment/appman" class="btn btn-m btn-center-l text-uppercase font-900 bg-green1-dark rounded-sm shadow-xl mt-4 mb-0">นัดออนไลน์รอยืนยัน <span class="badge badge-light">{{ $oapp_wait_confirm }}</span></a>
        @endif
    </div>
    <!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
