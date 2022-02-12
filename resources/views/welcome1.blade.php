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
                    <img class="preload-img img-fluid pl-3 pr-3" data-src="images/logo-neoq.png">
                    <p class="mt-1 mb-0 color-highlight font-12"><a href="#" onclick="openWindowWEB()">เว็บหลัก รพร.ตะพานหิน</a></p>
                    <p class="mt-1 mb-0 color-highlight font-12"><a href="#" onclick="openWindowNHSO()">MIS40 รพร.ตะพานหิน</a></p>
					<div id="btnClose2">
                    <button id="btnScanCode" onclick="scanCode()" class="btn scale-box btn-m mt-3 btn-center-l rounded-l shadow-xl bg-highlight font-800 text-uppercase">Scan QRcode</button>
					<!-- <p id="scanCode"><b>Code:</b> </p> -->
					<form action="#" method="post">
						<input type="text" name="scanCode" placeholder="รหัส" required="" id="scanCode" value="">
						<input type="submit" class="btn scale-box btn-m mt-3 btn-center-l rounded-l shadow-xl bg-highlight font-800 text-uppercase" value="ตรวจสอบ">
					</form>
					</div>
                    
                    <p class="mt-2 mb-0 boxed-text-xl">กด "เริ่มใช้งาน" เพื่อเข้าบริการออนไลน์</p>
                    <p class="mt-0 mb-0 boxed-text-xl">{{ config('app.name') }}</p>
                    
                        <button id="btnClose" onclick="closed()" class="btn scale-box btn-m mt-3 btn-center-l rounded-l shadow-xl bg-highlight font-800 text-uppercase">เริ่มใช้งาน</button>

                </div>
            </div>
        </div>       
    
    </div>

    
</div>



<!-- //LIFF Script -->
<script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>

<script>

  async function main() {
      await liff.init({ liffId: "1654181242-WLYbaypY" })
  }
  main()

  function closed() {
    liff.closeWindow()
  }

  async function scanCode() {
    const result = await liff.scanCode()
    $('#scanCode').val(result.value);
  }

  function openWindowWEB() {
    liff.openWindow({
      url: "https://www.tphcp.go.th",
      external: true
    })
  }

  function openWindowNHSO() {
    liff.openWindow({
      url: "http://eservices.nhso.go.th/eServices/mobile/login.xhtml",
      external: true
    })
  }

  function getEnvironment() {
    if (liff.isInClient()) {
    //   document.getElementById("btnCloseApp").style.display = "none"
    } else {
      document.getElementById("btnScanCode").style.display = "none"
    }
  }


</script>
<!-- LIFF Script// -->


<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>

</body>
</html>