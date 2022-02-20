<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('styles/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('styles/style.css') }}">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('fonts/css/fontawesome-all.min.css') }}">
        <link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
        <link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">

        @yield('header_script')

    </head>
    <body class="theme-light" data-background="none" data-highlight="red2">
        <div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
        <div>
            <div id="footer-bar" class="footer-bar-1">
                <a class="@yield('menu-active-main')" @if(!isset($view_menu)) href="{{ url('/') }}/main" @endif><i class="fa fa-home @yield('menu-active')"></i><span>Home</span></a>
                <a class="@yield('menu-active-card')" @if(!isset($view_menu)) href="{{ url('/') }}/card" @endif><i class="fa fa-address-card @yield('menu-active')"></i><span>บัตรผู้ป่วย</span></a>
                <a class="@yield('menu-active-emr')" @if(!isset($view_menu)) href="{{ url('/') }}/emr" @endif><i class="fa fa-address-book @yield('menu-active')"></i><span>ประวัติ</span></a>
                <a class="@yield('menu-active-oapp')" @if(!isset($view_menu)) href="{{ url('/') }}/oapp" @endif><i class="fa fa-calendar-alt @yield('menu-active')"></i><span>วันนัด</span></a>
                <a href="#" onclick="closed()"><i class="fa fa-times"></i><span>Close</span></a>
            </div>

<!-- content -->
@yield('content')
<!-- //content -->

        </div>

<!-- //LIFF Script -->
<script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
<script>

  function closed() {
    liff.closeWindow()
  }

</script>
<!-- LIFF Script// -->

<script type="text/javascript" src="{{ URL::asset('scripts/jquery.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('scripts/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('scripts/custom.js') }}"></script>

@yield('footer_script')

    </body>


</html>
