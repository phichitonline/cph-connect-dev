@extends('layouts.theme')
@section('menu-active-appointment','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

    <div class="header header-fixed header-logo-center bg-yellow1-dark">
        <a href="#" onclick="goBack()" class="header-title color-white">ย้อนกลับ</a>
        <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
    </div>

    <div class="page-content header-clear-large">

@php

    $hostname_dbnurse = config('database.connections.mysql.host');
    $database_dbnurse = config('database.connections.mysql.database');
    $username_dbnurse = config('database.connections.mysql.username');
    $password_dbnurse = config('database.connections.mysql.password');
    $dbnurse = mysqli_connect($hostname_dbnurse, $username_dbnurse, $password_dbnurse) or trigger_error(mysqli_error(),E_USER_ERROR);
    mysqli_select_db($dbnurse,$database_dbnurse);
    mysqli_set_charset($dbnurse,"utf8");
    date_default_timezone_set("Asia/Bangkok");
    $const_que = $applimit;//จำนวนคิวต่อรอบ

@endphp

        <div class="card card-style">
            <div class="cal-header">
                <h4 class="cal-title text-center text-uppercase font-25 {{ $module_color }} color-white">{{ $module_name }}</h4>
            </div>
            <div class="content mb-0">
                <h4 class="text-center font-70 font-20 text-uppercase mb-4">วันที่ {{ DateThaiFull($que_date) }}</h4>
@if ($user_app_check == "Y")
                <h2 class="text-center font-70 font-20 text-uppercase color-highlight mb-4">วันนี้คุณมีนัดแล้ว</h2>
                <h2 class="text-center font-70 font-20 text-uppercase color-highlight mb-4">"{{ $user_app_name }}"</h2>
				<a href="{{ url('/') }}/oapp" class="btn btn-m btn-full rounded-s shadow-l bg-green1-dark text-uppercase font-900">ตรวจสอบวันนัด</a>
				<div class="clearfix"><br></div>
@else
                <form class="control-group" id="radio_time" method="POST" action="{{ route('appquecc') }}" name=login  data-ajax="false" autocomplete="on" >
					@csrf
					@method('post')
					<input type="hidden" name="que_date" value="{{ $que_date }}" readonly  />
					<input type="hidden" name="que_time" value="" id="que_time" readonly  />
					<input type="hidden" name="flag" value="{{ $flag }}" readonly  />
					<input type="hidden" name="qflag" value="{{ $qflag }}" readonly  />

                    @foreach($app_flag_time as $data)

                    @php
                        if($data->limitcount > $data->cc){
                            $rs9 = '<b>(จองแล้ว '.$data->cc.'/'.$data->limitcount.') <mark class="highlight pl-2 font-12 pr-2 bg-green2-dark">ว่าง</mark></b>';
                            $rd9 = "";
                            $fac9 = "fac-green";
                        } else {
                            $rs9 = '<b>(จองแล้ว '.$data->cc.'/'.$data->limitcount.') <mark class="highlight pl-2 font-12 pr-2 bg-red2-dark">เต็ม</mark></b>';
                            $rd9 ="disabled";
                            $fac9 = "fac-default";
                        }
                    @endphp

                    @if (strpos($data->statusday ,$_GET['day']) !== false)
                        <div class="fac fac-radio {{ $fac9 }}"><span></span>
                            <input id="box{{$data->que_time}}-fac-radio" type="radio" name="rad" value="{{$data->que_time}}" {{ $rd9 }}>
                            <label for="box{{$data->que_time}}-fac-radio">{{ $data->que_time_name }} {!! $rs9 !!}</label>
                        </div>
                    @else
                        <div class="fac fac-radio fac-default"><span></span>
                            <input id="box{{$data->que_time}}-fac-radio" type="radio" disabled>
                            <label for="box{{$data->que_time}}-fac-radio">{{ $data->que_time_name }} <b><mark class="highlight pl-2 font-12 pr-2 bg-red2-dark">ไม่รับนัดช่วงวันเวลานี้</mark></b></label>
                        </div>
                    @endif

                    @endforeach



                    <div class="clearfix"><br></div>

					<button class="btn btn-m btn-full btn-block rounded-s shadow-l {{ $module_color }} text-uppercase font-900" type="submit"  name="submit">ถัดไป</button>

                    <div class="clearfix"></div>
                    <p class="text-center">
                        <a id="bt_book" class="color-theme opacity-50 font-12">คลิกถัดไปเพื่อระบุอาการเบื้องต้น</a>
                    </p>

                </form>
@endif
            </div>
        </div>

    </div>
    <!-- End of Page Content-->


<script>
	document.getElementById("bt_book").disabled = true;

	$('#radio_time input').on('change', function() {
		document.getElementById("que_time").value = $('input[name=rad]:checked', '#radio_time').val();
		document.getElementById("bt_book").disabled = false;
	});
</script>

@endsection

@section('footer_script')

<script>
    function goBack() {
      window.history.back();
    }
</script>


@endsection
