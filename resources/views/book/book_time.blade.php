@extends('layouts.theme')
@section('menu-active-book','active-nav')
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
    $const_que = 5;//จำนวนคิวต่อรอบ

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
				<form method="post" id="radio_time" action="{{ route('bookcc') }}" data-ajax="false" autocomplete="off" class="form-horizontal">
					@csrf
					@method('post')
					<input type="hidden" name="que_date" value="{{ $que_date }}" readonly  /> 
					<input type="hidden" name="que_time" value="" id="que_time" readonly  /> 
					<input type="hidden" name="flag" value="{{ $flag }}" readonly  /> 
					<input type="hidden" name="qflag" value="{{ $qflag }}" readonly  /> 

                    @php 
							// $tbl="que_card";
							$sql = "select count(*) AS cc from que_card WHERE que_app_flag = '{$qflag}' AND DATE(que_date) = '{$que_date}' AND que_time = '9';";
							$query = mysqli_query($dbnurse,$sql ) or die(mysqli_error());
							$row_name = mysqli_fetch_assoc($query);
							if($const_que > $row_name['cc']){
								$rs9 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-green2-dark">ว่าง</mark></b>';
								$rd9 = "";
								$fac9 = "fac-green";
							} else {
								$rs9 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-red2-dark">เต็ม</mark></b>';
								$rd9 ="disabled";
								$fac9 = "fac-default";
							}

                            $sql = "select count(*) AS cc from que_card WHERE que_app_flag = '{$qflag}' AND DATE(que_date) = '{$que_date}' AND que_time = '12';";
							$query = mysqli_query($dbnurse,$sql ) or die(mysqli_error());
							$row_name = mysqli_fetch_assoc($query);
							if($const_que > $row_name['cc']){
								$rs12 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-green2-dark">ว่าง</mark></b>';
								$rd12 ="";
								$fac12 = "fac-green";
							} else {
								$rs12 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-red2-dark">เต็ม</mark></b>';
								$rd12 ="disabled";
								$fac12 = "fac-default";
							}

                            $sql = "select count(*) AS cc from que_card WHERE que_app_flag = '{$qflag}' AND DATE(que_date) = '{$que_date}' AND que_time = '30';";
							$query = mysqli_query($dbnurse,$sql ) or die(mysqli_error());
							$row_name = mysqli_fetch_assoc($query);
							if($const_que > $row_name['cc']){
								$rs30 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-green2-dark">ว่าง</mark></b>';
								$rd30 ="";
								$fac30 = "fac-green";
							} else {
								$rs30 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-red2-dark">เต็ม</mark></b>';
								$rd30 ="disabled";
								$fac30 = "fac-default";
							}

                            $sql = "select count(*) AS cc from que_card WHERE que_app_flag = '{$qflag}' AND DATE(que_date) = '{$que_date}' AND que_time = '33';";
							$query = mysqli_query($dbnurse,$sql ) or die(mysqli_error());
							$row_name = mysqli_fetch_assoc($query);
							if($const_que > $row_name['cc']){
								$rs33 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-green2-dark">ว่าง</mark></b>';
								$rd33 ="";
								$fac33 = "fac-green";
							} else {
								$rs33 = '<b>'.$row_name['cc'].'/'.$const_que.' <mark class="highlight pl-2 font-12 pr-2 bg-red2-dark">เต็ม</mark></b>';
								$rd33 ="disabled";
								$fac33 = "fac-default";
							}
					@endphp

                    <label class="control-label">เลือกเวลาที่ต้องการมารับบริการ (เช้า)</label>
                        <div class="fac fac-radio {{ $fac9 }}"><span></span>
                            <input id="box1-fac-radio" type="radio" name="rad" value="9" {{ $rd9 }}>
                            <label for="box1-fac-radio">09.00 - 10.30 น. {!! $rs9 !!}</label>
                        </div>
                        <div class="fac fac-radio {{ $fac12 }}"><span></span>
                            <input id="box2-fac-radio" type="radio" name="rad" value="12" {{ $rd12 }}>
                            <label for="box2-fac-radio">10.30 - 12.00 น. {!! $rs12 !!}</label>
                        </div>
                    <div class="clearfix"><br></div>
                    <label class="control-label">เลือกเวลาที่ต้องการมารับบริการ (บ่าย)</label>
                        <div class="fac fac-radio {{ $fac30 }}"><span></span>
                            <input id="box3-fac-radio" type="radio" name="rad" value="30" {{ $rd30 }}>
                            <label for="box3-fac-radio">13.00 - 15.00 น. {!! $rs30 !!}</label>
                        </div>
                        @php
                            if ($_GET['day'] == 5) {
                            } else {
                        @endphp
                        <div class="fac fac-radio {{ $fac33 }}"><span></span>
                            <input id="box5-fac-radio" type="radio" name="rad" value="33" {{ $rd33 }}>
                            <label for="box5-fac-radio">15.00 - 16.30 น. {!! $rs33 !!}</label>
                        </div>
                        @php } @endphp
                    <div class="clearfix"><br></div>

					<button class="btn btn-m btn-full btn-block rounded-s shadow-l {{ $module_color }} text-uppercase font-900" type="submit"  name="submit">ถัดไป</button>

                    <div class="clearfix"></div>
                    <p class="text-center">
                        <a class="color-theme opacity-50 font-12" id="bt_book">คลิกถัดไปเพื่อระบุอาการเบื้องต้น</a>
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