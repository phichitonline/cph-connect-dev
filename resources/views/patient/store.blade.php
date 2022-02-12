@extends('layouts.theme')
@section('menu-active-main','active-nav')
@section('header_script')
{{-- header --}}
@endsection

@section('content')

    <div class="header header-fixed header-logo-center bg-red1-dark">
        <a href="#" onclick="goBack()" class="header-title color-white">ตรวจสอบอีกครั้ง</a>
        <a href="#" data-back-button class="header-icon header-icon-1"><i class="fas fa-arrow-left"></i></a>
        <a href="#" data-toggle-theme class="header-icon header-icon-4"><i class="fas fa-bell"></i></a>
    </div>

<div class="page-content header-clear-large">
<!--<div class="page-content header-clear-small">-->


{{ print_r($regisdata) }}
<br><br>
chwpart = {{ $chwpart }}
<br>
amppart = {{ $amppart }}
<br>
tmbpart = {{ $tmbpart }}
<br>
birthday = {{ $birthday }}
<br>
pname = {{ $pname }}
<br>
sex = {{ $sex }}
<br>
hos_guid = {{ $hos_guid }}
<br>
serial_no = {{ $serial_no }}
<br>
hn = {{ $hn }}


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
