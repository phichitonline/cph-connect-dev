@extends('layouts.theme')
@section('menu-active-oapp','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

<div class="page-content header-clear-small">

	@foreach($setting as $data)
    @php
        $hos_name = $data->hos_name;
        $hos_url = $data->hos_url;
        $hos_tel = $data->hos_tel;
        $ext_q_status = $data->ext_q_status;
    @endphp
    @endforeach

    @foreach($oapp_detail as $data)
        @php
            if ($data->oapp_status_id == 1) {
                if ($data->nextdate == date("Y-m-d")) {
                    $oapp_status2 = "วันนี้คุณมีนัด";
                    $oapp_status_color = "green";
                } else if ($data->nextdate < date("Y-m-d")) {
                    $oapp_status2 = "วันนัดผ่านมาแล้ว";
                    $oapp_status_color = "red";
                } else {
                    $oapp_status2 = $data->oapp_status_name;
                    $oapp_status_color = "blue";
                }
            } else if ($data->oapp_status_id == 9) {
                if ($data->nextdate == date("Y-m-d")) {
                    $oapp_status2 = "วันนี้คุณมีนัด";
                    $oapp_status_color = "green";
                } else if ($data->nextdate < date("Y-m-d")) {
                    $oapp_status2 = "วันนัดผ่านมาแล้ว";
                    $oapp_status_color = "red";
                } else {
                    $oapp_status2 = $data->oapp_status_name;
                    $oapp_status_color = "blue";
                }
            } else {
                $oapp_status2 = $data->oapp_status_name;
                $oapp_status_color = "gray";
            }
        @endphp

				<div class="card card-overflow card-style">
					<div class="content">
						<div class="d-flex">
							<div class="flex-grow-1">
								<h1 class="font-30">บัตรนัด</h1>
								<!-- <h4 class="font-15">วันที่ {{ DateThaiFull($data->nextdate) }} เวลา {{ substr($data->nexttime,0,5) }} น.</h4> -->
							</div>
							<div class="flex-shrink-1">
								<span class="bg-{{ $oapp_status_color }}2-dark float-right rounded-xs text-uppercase font-900 font-9 pr-2 pl-2 pb-0 pt-0 line-height-s mt-n2">{{ $oapp_status2 }}</span>
							</div>
						</div>

						<div class="row">
							<div class="col-6">
								<span class="font-11">วันที่</span>
								<p class="mt-n2 mb-0">
									<strong class="color-theme">{{ DateThaiFull($data->nextdate) }}</strong>
								</p>
							</div>
							<div class="col-6">
								<span class="font-11">เวลา</span>
								<p class="mt-n2 mb-0">
									<strong class="color-theme">{{ substr($data->nexttime,0,5) }} - {{ substr($data->nexttime_end,0,5) }}</strong>
								</p>
							</div>
						</div>

						<div class="divider mt-n3 mb-3"></div>

						<span class="font-11 color-blue2-dark">เหตุที่นัด</span>
						<p class="mt-n2 mb-2"><h5>{{ $data->app_cause }}</h5></p>

						<span class="font-11 color-blue2-dark">การปฏิบัติตัว</span>
						<p class="mt-n2 mb-2"><h2 class="color-highlight">{{ $data->note1." ".$data->note2 }}</h2></p>

						<span class="font-11 color-blue2-dark">หมายเหตุ</span>
						<p class="mt-n2 mb-2"><h2 class="color-highlight">{{ $data->note }}</h2></p>

						<div class="row">
							<div class="col-12">
								<span class="font-11">แพทย์/ผู้นัด</span>
								<p class="mt-n2 mb-1">
									<strong class="color-theme">{{ $data->doctor_name }}</strong>
								</p>
							</div>
							<div class="col-12">
								<span class="font-11">ติดต่อที่</span>
								<p class="mt-n2 mb-1">
									<strong class="color-theme">{{ $data->contact_point }}</strong>
								</p>
							</div>
							<div class="col-12">
								<span class="font-11">ห้องตรวจ</span>
								<p class="mt-n2 mb-1">
									<strong class="color-theme">{{ $data->department }}</strong>
								</p>
							</div>
							<div class="col-12">
								<span class="font-11">คลินิก/แผนก</span>
								<p class="mt-n2 mb-1">
									<strong class="color-theme">{{ $data->clinic_name }}</strong>
								</p>
							</div>
						</div>

						<div class="divider mt-n3 mb-3"></div>

						<div class="d-flex mt-3">
							<div class="flex-grow-1">
								<span class="font-11">LAB </span>
								<p class="mt-n2">
									<strong class="color-theme">{{ $data->lab_list_text }}</strong>
								</p>
							</div>
							<div class="flex-shrink-1 mt-1">
								<a href="#" data-menu="menu-share" class="icon icon-xs rounded-xl shadow-m ml-2 bg-blue2-dark"><i class="ace-icon fa fa-solid fa-microscope"></i></a>
							</div>
						</div>
						<div class="d-flex mt-3">
							<div class="flex-grow-1">
								<span class="font-11">X-Ray </span>
								<p class="mt-n2">
									<strong class="color-theme">{{ $data->xray_list_text }}</strong>
								</p>
							</div>
							<div class="flex-shrink-1 mt-1">
								<a href="#" data-menu="menu-share" class="icon icon-xs rounded-xl shadow-m ml-2 bg-red2-dark"><i class="ace-icon fa fa-solid fa-radiation"></i></a>
							</div>
						</div>

						<div class="clear"><br></div>

						@if($oapp_status_color == "green")
						@if (!isset($vn))

                    <div class="clear">
                        <form name="checkinform" id="checkinform" action="{{route('checkin')}}" method="GET">
                            {{-- @csrf --}}
                            {{-- <input type="text" class="text-center" name="gps_stamp1" id="locationPoint1" value="{{ old('gps_stamp') }}" placeholder="พิกัด GPS" disabled> --}}
                            <input type="hidden" name="gps_stamp" id="locationPoint" value="{{ old('gps_stamp') }}" required>
                            <input type="hidden" name="oappid" value="{{ $oappid }}">
                            {{-- <a href="#" class="btn btn-m btn-full rounded-s shadow-l text-center text-uppercase font-25 bg-blue2-dark color-white" id="btnScanCode" onclick="getLocation()">
                                <i class="fa font-14 fa-check"></i> อ่านพิกัด GPS
                            </a> --}}
                            {{-- <input type="submit" value=" ยืนยัน "> --}}

                            <a href="#" id="btnScanCode" onclick="getLocation()" class="btn btn-m btn-full rounded-s shadow-l text-center text-uppercase font-25 bg-red2-dark color-white">
                                <i class="fa font-14 fa-check"></i> CHECKIN ยืนยันเข้ารับบริการ
                            </a>

                        </form>
                    </div>



                        <h1 class="font-20 color-highlight text-center mt-4">คำแนะนำ</h1>
                        <p class="footer-text mt-0">
                            <span class="font-16">
                                <br><b>ก่อนกดปุ่ม CHECKIN คุณต้องเตรียมความพร้อมเพื่อจะเข้ารับบริการ และอยู่ในโรงพยาบาลแล้วเท่านั้น</b>
                            </span>
                        </p>
						@else
                        @if ($ext_q_status == "Y")
							<a href="{{ url('/') }}/statusq?oappid={{ $oappid }}" class="btn btn-m btn-full rounded-s shadow-l text-center text-uppercase font-25 bg-green2-dark color-white">
								<i class="fa font-14 fa-check"></i> ดูสถานะคิวของคุณ
							</a>
						@endif
						@endif
						@endif

					</div>
				</div>

	@endforeach

</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')

    <script>
        var x = document.getElementById("locationPoint");
        var x1 = document.getElementById("locationPoint1");

        function submitform() {
            setTimeout(function () {
                document.forms["checkinform"].submit();
            }, 100);
        }

        async function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
          }
          await submitform();
        }

        function showPosition(position) {
            x.value = position.coords.latitude + "," + position.coords.longitude;
            x1.value = position.coords.latitude + "," + position.coords.longitude;
        }

    </script>

@endsection
