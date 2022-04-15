@extends('layouts.theme')
@section('menu-active-appointment','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

@foreach($setting as $data)
@php
    $hos_name = $data->hos_name;
    $hos_url = $data->hos_url;
    $hos_tel = $data->hos_tel;
@endphp
@endforeach

<div class="page-content header-clear-small">

    @if (Session::has('oapp-updated'))
    @php $text_alert_message = substr(Session('oapp-updated'), 0 ,strpos(Session('oapp-updated'), "@")); @endphp
    <div class="ml-3 mr-3 alert alert-small rounded-s shadow-xl bg-green1-dark" role="alert">
        <span><i class="fa fa-check"></i></span>
        <strong>{{ $text_alert_message }}</strong>
        <button type="button" class="close color-white opacity-60 font-16" data-dismiss="alert" aria-label="Close">&times;</button>
    </div>

    @php

        $testtext = Session('oapp-updated');
        $testtext1 = substr($testtext,strpos($testtext, "@")+1);
        $testtext2 = substr($testtext1,strpos($testtext1, "@")+1);
        $testtext3 = substr($testtext2,strpos($testtext2, "@")+1);
        $testtext4 = substr($testtext3,strpos($testtext3, "@")+1);
        $testtext5 = substr($testtext4,strpos($testtext4, "@")+1);

        $text_line_message0 = substr($testtext,0,strpos($testtext, "@"));
        $text_line_message1 = substr($testtext1,0,strpos($testtext1, "@"));
        $text_line_message2 = substr($testtext2,0,strpos($testtext2, "@"));
        $text_line_message3 = substr($testtext3,0,strpos($testtext3, "@"));
        $text_line_message4 = substr($testtext4,0,strpos($testtext4, "@"));
        $pushID = substr($testtext5,strpos($testtext5, "@")+0);

        $access_token = config('line-bot.channel_access_token');
        $liff_url = config('line-bot.liff_url');

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{

            "to": "'.$pushID.'",
            "messages": [{
            "type": "flex",
            "altText": "ยืนยันการนัด",
            "contents": {

                "type": "bubble",
                "size": "giga",
                "body": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                    {
                        "type": "text",
                        "text": "'.$text_line_message0.'",
                        "weight": "bold",
                        "size": "xxl",
                        "margin": "md",
                        "color": "#009900"
                    },
                    {
                        "type": "text",
                        "text": "'.$text_line_message1.'",
                        "size": "lg",
                        "weight": "bold"
                    },
                    {
                        "type": "text",
                        "text": "'.$text_line_message2.'",
                        "wrap": true
                    },
                    {
                        "type": "text",
                        "text": "'.$text_line_message3.'"
                    },
                    {
                        "type": "separator",
                        "margin": "xxl"
                    },
                    {
                        "type": "box",
                        "layout": "vertical",
                        "margin": "xxl",
                        "spacing": "sm",
                        "contents": [
                        {
                            "type": "text",
                            "text": "'.$text_line_message4.'",
                            "color": "#ff0000",
                            "weight": "bold",
                            "size": "xxl"
                        }
                        ],
                        "justifyContent": "center",
                        "alignItems": "center"
                    },
                    {
                        "type": "separator",
                        "margin": "xxl"
                    },
                    {
                        "type": "box",
                        "layout": "horizontal",
                        "margin": "md",
                        "contents": [
                        {
                            "type": "text",
                            "text": "รายละเอียดเพิ่มเติม",
                            "size": "xs",
                            "color": "#aaaaaa",
                            "flex": 0,
                            "action": {
                            "type": "uri",
                            "label": "รายละเอียดเพิ่มเติม",
                            "uri": "'.$liff_url.'"
                            }
                        }
                        ]
                    }
                    ]
                },
                "styles": {
                    "footer": {
                    "separator": true
                    }
                }

            }
            }]
        }',

        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$access_token."",
            "Content-Type: application/json"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

    @endphp

    @endif

    <div class="card card-style shadow-xl rounded-m">
        <div class="cal-footer">

            <h4 class="cal-title text-center text-uppercase font-25 bg-green1-dark color-white">บริหารนัดออนไลน์</h6>
            <span class="cal-message mt-3 mb-3">
                <i class="fa fa-bell font-18 color-green1-dark"></i>
                <strong class="color-gray-dark">ระบบบริหารจัดการนัดออนไลน์</strong>
                <strong class="color-gray-dark">สำหรับเจ้าหน้าที่ผู้ดูแลคลินิก</strong>
            </span>
            <div class="divider mb-0"></div>

            <div class="content">
                <h4>นัดออนไลน์รอยืนยัน</h4>
            </div>
            <div class="accordion" id="accordion-1">

                @foreach($que_pt_man as $data)

                <div class="mb-0">
                    <button class="btn accordion-btn" data-toggle="collapse" data-target="#collapse{{ $data->id }}">
                        <i class="fa fa-cloud color-blue2-dark mr-2"></i>
                        {{ $data->ptname }} (HN:{{ $data->hn }})
                        <i class="fa fa-chevron-down font-10 accordion-icon"></i>
                    </button>
                    <div id="collapse{{ $data->id }}" class="collapse" data-parent="#accordion-1">
                        <div class="pt-1 pb-2 pl-3 pr-3">
                            <ul>
                                <li>คลินิก: <b>{{ $data->que_app_flag_name }}</b></li>
                                <li>วันที่: <b>{{ DateThaiFull($data->que_date) }}</b></li>
                                <li>เวลา: <b>{{ $data->que_time_name }}</b></li>
                                <li>อาการ: <b>{{ $data->que_cc }}</b></li>
                                <li>โทรศัพท์: <b><a href="tel:{{ $data->tel }}"><i class="fa fa-phone color-blue2-dark"></i> {{ $data->tel }}</a></b></li>
                                <li>Email: <b><a href="mailto:{{ $data->email }}"> {{ $data->email }}</a></b></li>
                            </ul>
                            <div class="row mb-0">
                                <div class="col-6 pr-1">
                                    {{-- <button type="submit" name="status" value="0" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-red1-light">ยกเลิก</button> --}}
                                    <a href="{{ url('/') }}/appointment/appconfirm?id={{ $data->id }}&status=0&flag={{ $data->que_app_flag_name }}&hn={{ $data->hn }}&date={{ $data->que_date }}&clinic={{ $data->clinic }}&doctor={{ $data->doctor }}&spclty={{ $data->spclty }}&dep={{ $data->depcode }}&stime={{ $data->que_time_start }}&etime={{ $data->que_time_end }}&time={{ $data->que_time_name }}&ptname={{ $data->ptname }}&cc={{ $data->que_cc }}&lineid={{ $data->lineid }}" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-red1-light">ยกเลิก</a>
                                </div>
                                {{-- <div class="col-4 pl-1 pr-1">
                                    <button type="submit" name="status" value="2" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-blue1-light">เลื่อน</button>
                                </div> --}}
                                <div class="col-6 pl-1">
                                    {{-- <button type="submit" name="status" value="1" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-green1-light">ยืนยัน</button> --}}
                                    <a href="{{ url('/') }}/appointment/appconfirm?id={{ $data->id }}&status=1&flag={{ $data->que_app_flag_name }}&hn={{ $data->hn }}&date={{ $data->que_date }}&clinic={{ $data->clinic }}&doctor={{ $data->doctor }}&spclty={{ $data->spclty }}&dep={{ $data->depcode }}&stime={{ $data->que_time_start }}&etime={{ $data->que_time_end }}&time={{ $data->que_time_name }}&ptname={{ $data->ptname }}&cc={{ $data->que_cc }}&lineid={{ $data->lineid }}" class="btn btn-m btn-full mb-3 rounded-xs text-uppercase font-900 shadow-s bg-green1-light">ยืนยัน</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                {{-- </form> --}}
            </div>


        </div>
    </div>

    <div class="footer card card-style">
        <a class="footer-title"><span class="color-highlight">สำหรับเจ้าหน้าที่</span></a>
        <p class="footer-text">
        <span class="font-12">
            <br>เจ้าหน้าที่ที่รับผิดชอบคลินิกสามารถติดต่อกับผู้รับบริการ และยืนยันการจองนัดออนไลน์ ระบบจะทำการลงรายการนัดในโปรแกรมบริการให้โดยอัตโนมัติ
        </span>
        <span class="font-16">
            <br><br><b>หากมีปัญหาข้อสงสัย โปรดติดต่อ Admin</a>
        </span>
        </p>
    </div>

</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
