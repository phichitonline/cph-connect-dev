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
    @endphp
    @endforeach

				<div class="card card-overflow card-style">
					<div class="content">
						<div class="d-flex">
							<div class="flex-grow-1">
								<h1 class="font-30">สถานะคิวของคุณ</h1>
							</div>
							<div class="flex-shrink-1">
								<span class="bg-green2-dark float-right rounded-xs text-uppercase font-900 font-9 pr-2 pl-2 pb-0 pt-0 line-height-s mt-n2">{{ $oappid }}</span>
							</div>
						</div>
						
						<div class="row">
							<div class="col-6">
								<span class="font-11">วันที่</span>
								<p class="mt-n2 mb-0">
									<strong class="color-theme">20 พฤศจิกายน 2563</strong>
								</p>
							</div>
							<div class="col-6">
								<span class="font-11">เวลา</span>
								<p class="mt-n2 mb-0">
									<strong class="color-theme">09.00 - 10.30 น.</strong>
								</p>
							</div>
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
            <img class="img-fluid" src="images/logo-neoq3.png">

        </div>

		<div class="card card-overflow card-style">
			<a href="{{ url('/') }}/statusq/?oappid={{ $oappid }}" class="btn btn-m btn-full rounded-s shadow-l text-center text-uppercase font-25 bg-green2-dark color-white">
				<i class="fa font-14 fa-check"></i> Refresh ปรับปรุงข้อมูล
			</a>
		</div>

        @endif
		

</div>
<!-- End of Page Content--> 

@endsection

@section('footer_script')


@endsection