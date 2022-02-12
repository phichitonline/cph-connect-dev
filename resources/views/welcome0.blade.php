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

  <p id="os"><b>OS:</b> </p>
  <p id="language"><b>Language:</b> </p>
  <p id="version"><b>Version:</b> </p>
  <p id="isInClient"><b>isInClient:</b> </p>
  <p id="accessToken"><b>AccessToken:</b> </p>
  <img id="pictureUrl" widgth="250">
  <p id="userId"><b>userId:</b> </p>
  <p id="displayName"><b>displayName:</b> </p>
  <p id="statusMessage"><b>statusMessage:</b> </p>
  <p id="decodedIDToken"><b>email:</b> </p>
  <p id="type"><b>type:</b> </p>
  <p id="viewType"><b>viewType:</b> </p>
  <p id="utouId"><b>utouId:</b> </p>
  <p id="roomId"><b>roomId:</b> </p>
  <p id="groupId"><b>groupId:</b> </p>
  <p id="friendship"><b>isFriendship:</b> </p>
  <p id="scanCode"><b>Code:</b> </p>
  <p id="isLoggedIn"><b>isLoggedIn:</b> </p>
  <p id="universalLink1"><b>Universal Link:</b> </p>
  <p id="universalLink2"><b>Universal Link with Query params:</b> </p>
  <p><a href="path/?param=9">Link to Path</a></p>

  <button id="btnMsg" onclick="sendMsg()">Send Message</button>
  <button id="btnShare" onclick="shareMsg()">Share Target Picker</button>
  <button onclick="openWindow()">Open Window</button>
  <button id="btnScanCode" onclick="scanCode()">Scan Code</button>
  <button id="btnLogOut" onclick="logOut()">Log Out</button>
  <button id="btnClose" onclick="closed()">Close</button>
</div>

  <script src="https://static.line-scdn.net/liff/edge/2.1/sdk.js"></script>
  <script>
    function createUniversalLink() {
    }

    async function shareMsg() {
      await liff.shareTargetPicker([
        {
          type: "text",
          text: "This message was sent by ShareTargetPicker"
        }
      ])
    }

    function logOut() {
      liff.logout()
      window.location.reload()
    }

    function closed() {
      liff.closeWindow()
    }

    async function scanCode() {
      const result = await liff.scanCode()
      document.getElementById("scanCode").append(result.value)
    }
    
    function openWindow() {
      liff.openWindow({
        url: "https://www.tphcp.go.th",
        external: true
      })
    }

    async function getFriendship() {
      const friend = await liff.getFriendship()
      document.getElementById("friendship").append(friend.friendFlag)
      if (!friend.friendFlag) {
        if (confirm("คุณยังไม่ได้เพิ่ม Bot เป็นเพื่อน จะเพิ่มเลยไหม?")) {
          window.location = "https://line.me/R/ti/p/%40357twjwh"
        }
      }
    }

    async function sendMsg() {
      if (liff.getContext().type !== "none") {
        await liff.sendMessages([
          {
            "type": "sticker",
            "stickerId": 1,
            "packageId": 1
          }
        ])
        alert("Message sent")
      }
    }

    function getContext() {
      if (liff.getContext() != null) {
        document.getElementById("type").append(liff.getContext().type)
        document.getElementById("viewType").append(liff.getContext().viewType)
        document.getElementById("utouId").append(liff.getContext().utouId)
        document.getElementById("roomId").append(liff.getContext().roomId)
        document.getElementById("groupId").append(liff.getContext().groupId)
      }
    }

    async function getUserProfile() {
      const profile = await liff.getProfile()
      document.getElementById("pictureUrl").src = profile.pictureUrl
      document.getElementById("userId").append(profile.userId)
      document.getElementById("statusMessage").append(profile.statusMessage)
      document.getElementById("displayName").append(profile.displayName)
      document.getElementById("decodedIDToken").append(liff.getDecodedIDToken().email)
    }
    
    function getEnvironment() {
      document.getElementById("os").append(liff.getOS())
      document.getElementById("language").append(liff.getLanguage())
      document.getElementById("version").append(liff.getVersion())
      document.getElementById("accessToken").append(liff.getAccessToken())
      document.getElementById("isInClient").append(liff.isInClient())
      if (liff.isInClient()) {
        document.getElementById("btnLogOut").style.display = "none"
      } else {
        document.getElementById("btnMsg").style.display = "none"
        document.getElementById("btnScanCode").style.display = "none"
        document.getElementById("btnClose").style.display = "none"
      }
    }

    async function main() {
      liff.ready.then(() => {
        document.getElementById("isLoggedIn").append(liff.isLoggedIn())
        if (liff.isLoggedIn()) {
          getEnvironment()
          getUserProfile()
          getContext()
          getFriendship()
          createUniversalLink()
        } else {
          liff.login()
        }
      })
      await liff.init({ liffId: "1654181242-WLYbaypY" })
    }
    main()
  </script>

<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/bootstrap.min.js"></script>
<script type="text/javascript" src="scripts/custom.js"></script>

</body>
</html>