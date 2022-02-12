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


        <div class="card card-style">
            <div class="cal-header">
                <h4 class="cal-title text-center text-uppercase font-25 {{ $module_color }} color-white">{{ $module_name }}</h4>
            </div>
            <div class="content mb-0">
            @if ($que_rad == "")
                <h4 class="text-center font-70 font-20 text-uppercase mb-4">วันที่ {{ DateThaiFull($que_date) }}</h4>
                <h4 class="text-center font-70 font-20 text-uppercase {{ $que_time_c }} mb-4">{!! $que_time !!}</h4>
            @else
                <h4 class="text-center font-70 font-20 text-uppercase mb-4">วันที่ {{ DateThaiFull($que_date) }}</h4>
                <h4 class="text-center font-70 font-20 text-uppercase {{ $que_time_c }} mb-4">{!! $que_time !!}</h4>

                {{-- <form class="control-group" id="radio_time" method="POST" action="book_phanthai_cc.php" name="time"  data-ajax="false" autocomplete="on" > --}}
                <form method="post" action="{{ route('bookstore') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <input type="hidden" name="que_time" value="{{ $que_rad }}" readonly  /> 
					<input type="hidden" name="que_date" value="{{ $que_date }}" readonly  /> 
					<input type="hidden" name="cid" value="{{ $_SESSION['cid'] }}" readonly  />
					<input type="hidden" name="hn" value="{{ $_SESSION['hn'] }}" readonly  />
					<input type="hidden" name="lid" value="{{ $_SESSION['lineid'] }}" readonly  />
					<input type="hidden" name="pname" value="{{ $ptname }}" readonly  />
                    <input type="hidden" name="que_dep" value="{{ $qdep }}" readonly  />
                    <input type="hidden" name="que_app_flag" value="{{ $qflag }}" readonly  />
                    <input type="hidden" name="module_name" value="{{ $module_name }}" readonly  />
                    <input type="hidden" name="que_time_c" value="{{ $que_time_c }}" readonly  />

					<div class="input-style input-style-2 input-required">
						<span>ระบุอาการเบื้องต้น</span>
						<textarea name="que_cc" class="form-control" placeholder="" required></textarea>
					</div>
					<div class="clearfix"></div>

                    {{-- <a href="#" class="btn btn-m btn-full rounded-s shadow-l {{ $module_color }} text-uppercase font-900">บันทึกจองนัด</a> --}}
                    <button class="btn btn-m btn-full btn-block rounded-s shadow-l {{ $module_color }} text-uppercase font-900" type="submit"  name="submit">บันทึกจองนัด</button>

                    <div class="clearfix"></div>

                    <p class="text-center">
                        <a href="#" class="color-theme opacity-50 font-12">กรุณาตรวจสอบการทำรายการให้มั่นใจก่อนบันทึก</a>
                    </p>

                </form>
            @endif

            </div>
        </div>

    </div>
    <!-- End of Page Content--> 

@endsection

@section('footer_script')

<script>
    function goBack() {
      window.history.back();
    }
</script>

@endsection