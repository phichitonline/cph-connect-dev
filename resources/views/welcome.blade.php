@php
	session_start();
	session_destroy();
@endphp

<!DOCTYPE HTML>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
<title>{{ config('app.name') }}</title>
<link rel="stylesheet" type="text/css" href="styles/bootstrap.css">
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i|Source+Sans+Pro:300,300i,400,400i,600,600i,700,700i,900,900i&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="fonts/css/fontawesome-all.min.css">
<link rel="manifest" href="_manifest.json" data-pwa-version="set_in_manifest_and_pwa_js">
<link rel="apple-touch-icon" sizes="180x180" href="app/icons/icon-192x192.png">
</head>

<body class="theme-light" data-background="none" data-highlight="red2">

<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>

<div>

    <div class="page-content pb-0">

        <div class="card" data-card-height="cover">
            <div class="card-center text-center">
                <div class="content mr-0 ml-0 mb-0">
                    <img class="preload-img img-fluid pl-3 pr-3" data-src="images/cphconnect/cph-connect-logo.png">
                    <p class="mt-1 mb-0 color-highlight font-12"><b>ยินดีต้อนรับ </b> </p>
                    <h1 id="displayName" class="mt-2 mb-0 font-30"> </h1>
                    {{-- <p id="userId" class="mt-n1 mb-0 color-highlight font-12"><b>LineID:</b> </p> --}}
                    {{-- <p id="decodedIDToken" class="mt-n1 color-highlight font-12"><b>Email:</b> </p> --}}


                    <p class="mt-2 mb-0 boxed-text-xl">กำลังตรวจสอบข้อมูล เพื่อเข้าบริการออนไลน์</p>
                    <p class="mt-0 mb-0 boxed-text-xl">{{ config('app.hosname') }}</p>

                    <form method="get" action="{{ url("/") }}/home" name="loginform" id="loginform">
                        <input class="form-control" type="hidden" id="userId" name="userId">
                        <input class="form-control" type="hidden" id="decodedIDToken2" name="decodedIDToken2">
                        <a href="#" type="submit" class="btn scale-box btn-m mt-3 btn-center-l rounded-l shadow-xl bg-highlight font-800 text-uppercase">กรุณารอสักครู่...</a>
                        {{-- <a href="#" data-back-button class="btn scale-box btn-m mt-5 btn-center-l rounded-l shadow-xl bg-highlight font-800 text-uppercase">เริ่มใช้งาน</a> --}}
                    </form>

                </div>
            </div>
        </div>

    </div>


</div>

<?php

$LineLiffID = config('line-bot.liff_id');
echo '<script type="text/javascript">';
echo "var LineLiffID = '$LineLiffID';";
echo '</script>';

?>

<script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>

<script>
    let lineliffid = LineLiffID;
    async function main() {
        liff.ready.then(() => {
            // document.getElementById("isLoggedIn").append(liff.isLoggedIn())
            if (liff.isLoggedIn()) {
                getUserProfile()
            } else {
                liff.login()
            }
        })
        await liff.init({ liffId: lineliffid })
    }
    main()

    async function getUserProfile() {
        const profile = await liff.getProfile()
        document.getElementById("displayName").append(profile.displayName)
        document.getElementById("userId").append(profile.userId)
        // document.getElementById("decodedIDToken").append(liff.getDecodedIDToken().email)
        $('#displayName').val(profile.displayName);
        $('#userId').val(profile.userId);
        $('#decodedIDToken2').val(liff.getDecodedIDToken().email);
    }

</script>

<script type="text/javascript">
    window.onload=function(){
        var auto = setTimeout(function(){ autoRefresh(); }, 100);

        function submitform(){
        //   alert('Enter');
          document.forms["loginform"].submit();
        }

        function autoRefresh(){
           clearTimeout(auto);
           auto = setTimeout(function(){ submitform(); autoRefresh(); }, 5000);
        }
    }
</script>

<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>

</body>
</html>
