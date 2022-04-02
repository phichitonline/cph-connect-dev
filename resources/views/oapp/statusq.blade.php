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
        $ext_q_name = $data->ext_q_name;
        $ext_q_url = $data->ext_q_url;
        $ext_q_img = $data->ext_q_img;
    @endphp
    @endforeach

    @if (session('oapp-statusq'))
        <div class="footer card card-style">
            <a href="#" class="footer-title"><span class="color-highlight">{{ session('oapp-statusq') }}</span></a>
            <div class="clear"><br></div>
        </div><br>
    @endif
				<div class="card card-overflow card-style">
					<div class="content">
						<div class="d-flex">
							<div class="flex-grow-1">
								<h1 class="font-30">สถานะคิวของคุณ</h1>
							</div>
							<div class="flex-shrink-1">
								<span class="float-right rounded-xs text-uppercase font-900 font-9 pr-2 pl-2 pb-0 pt-0 line-height-s mt-n2">{{ $q_status }}</span>
							</div>
						</div>

							<div class="col-12">
								<span class="font-11">เข้ารับบริการ</span>
								<p class="mt-n2 mb-0">
									<strong class="color-theme">{{ DateThaiFull($vstdate) }} เวลา {{ TimeThai($vsttime) }} น.</strong>
								</p>
							</div>


					</div>
				</div>

        <!-- แสดงคิวเมื่อมี visit วันนี้ -->
        @if (isset($vn))
        <div data-card-height="210" class="card card-style rounded-m shadow-xl">
            <div class="card-center text-center">
            @if ($room_code == 0)
                <h1 class="color-white font-800 fa-5x text-shadow-l">{{ $webq }}</h1>
                @if ($q_status == "1")
                <h1 class="color-white font-800 text-shadow-l"><br>คิวของคุณ รออีก {{ $waitq }} คิว</h1>
                <h2 class="color-white font-800 text-shadow-l">{{ $department }}</h2>
                @elseif ($q_status == "2")
                <h1 class="color-white font-800 color-highlight text-shadow-l"><br>เรียกรับบริการ</h1>
                <h2 class="color-white font-800 text-shadow-l">{{ $department }}</h2>
                @else
                <h1 class="color-white font-800 color-green2 text-shadow-l"><br>เสร็จสิ้นการรับบริการแล้ว</h1>
                <h2 class="color-white font-800 text-shadow-l">เวลา {{ $time }}</h2>
                @endif
            </div>
            <p class="card-bottom text-center mb-0 pb-2 color-white font-15 text-shadow-s">
                แผนก: {{ $spcltyname }}
            </p>
            @else
                <h1 class="color-white font-800 color-green2 text-shadow-l"><br>เสร็จสิ้นการรับบริการแล้ว</h1>
                <h2 class="color-white font-800 text-shadow-l">เวลา {{ $time }}</h2>
                </div>
            @endif

            <div class="card-overlay bg-gradient opacity-70"></div>
            <div class="card-overlay bg-gradient bg-gradient-{{ $pri_color }}1 opacity-80"></div>
            <img class="img-fluid" src="images/{{ $ext_q_img }}">

        </div>

		<div class="card card-overflow card-style">
			<a href="{{ $ext_q_url }}{{ $vn }}" class="btn btn-m btn-full rounded-s shadow-l text-center text-uppercase font-25 bg-green1-dark color-white">
				<i class="fa font-14 fa-sync-alt"></i> คลิกดูสถานะคิว {{ $ext_q_name }}
			</a>
		</div>

		<div class="card card-overflow card-style">
			<a href="{{ url('/') }}/statusq?oappid={{ $oappid }}" class="btn btn-m btn-full rounded-s shadow-l text-center text-uppercase font-25 bg-green2-dark color-white">
				<i class="fa font-14 fa-sync-alt"></i> REFRESH ปรับปรุงสถานะคิว
			</a>
		</div>

        <!-- ยังไม่ได้ออก visit -->
		@else
        <div class="card card-overflow card-style">
			<div class="content">
                <a href="{{ url('/') }}/checkin/?oappid={{ $oappid }}" class="btn btn-m btn-full rounded-s shadow-l text-center text-uppercase font-25 bg-red2-dark color-white">
                    <i class="fa font-14 fa-check"></i> CHECKIN ยืนยันเข้ารับบริการ
                </a>
                <h1 class="font-20 color-highlight text-center mt-4">คุณยังไม่ได้ยืนยันเข้ารับบริการ</h1>
                <p class="footer-text mt-0">
                    <span class="font-16">
                        <br><b>กดปุ่ม CHECKIN หรือติดต่อเจ้าหน้าที่เพื่อยืนยันเข้ารับบริการ และชั่งน้ำหนัก วัดส่วนสูง วัดความดัน รอเรียกซักประวัติที่จุดบริการได้เลยค่ะ</b>
                    </span>
                </p>
		    </div>
		</div>
        @endif


</div>
<!-- End of Page Content-->

@endsection

@section('footer_script')


@endsection
