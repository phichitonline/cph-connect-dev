<html lang="en">
	<head>
	<title>ระบบแจ้งเตือน</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<link rel="stylesheet" href="assets/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body class="no-skin" style="font-family:'Sarabun'">
	<div id="navbar" class="navbar menucls navbar-default navbar-fixed-bottom">
		<div class="navbar-container center" id="navbar-container">
				<div class="btn-group info btn-corner">
					<a class="btn btn btn-info" href="index.php">
						<i class="ace-icon fa fa-home align-top bigger-250 icon-on-right"></i>
					</a>
					<a class="btn btn btn-info" href="card.php">
						<i class="ace-icon fa fa-address-card align-top bigger-250 icon-on-right"></i>
					</a>
					<a class="btn btn btn-info" href="oapp.php">
						<i class="ace-icon fa fa-calendar align-top bigger-250 icon-on-right"></i>
					</a>
					<a class="btn btn btn-primary" href="info.php">
						<i class="ace-icon fa fa-info-circle align-top bigger-250 icon-on-right"></i>
					</a>
				</div>
			</div>
		</div>

		<div class="main-container ace-save-state" id="main-container">
			<div class="page-content center">
				<div class="space-4"></div>
				<div class="center"><img src="images/logo_hosp.png" alt="LOGO" width="120"></div>
				<div class="space-4"></div>
					<span class="bigger-175 blue"><strong>รพร.ตะพานหิน</strong></span>
				<div class="space-18"></div>
				<p class="bigger-110 red">ระบบแจ้งเตือนนัด</p>
				<div class="space-10"></div>


	<?php
	function chYear($find)
	{
		return date("Y", strtotime($find)) + 543;
	}
	function chMonth($find)
	{
		if (date("m", strtotime($find)) == 1) {
			return "มกราคม ";
		} elseif (date("m", strtotime($find)) == 2) {
			return "กุมภาพันธ์ ";
		} elseif (date("m", strtotime($find)) == 3) {
			return "มีนาคม ";
		} elseif (date("m", strtotime($find)) == 4) {
			return "เมษายน";
		} elseif (date("m", strtotime($find)) == 5) {
			return "พฤษภาคม ";
		} elseif (date("m", strtotime($find)) == 6) {
			return "มิถุนายน ";
		} elseif (date("m", strtotime($find)) == 7) {
			return "กรกฎาคม ";
		} elseif (date("m", strtotime($find)) == 8) {
			return "สิงหาคม";
		} elseif (date("m", strtotime($find)) == 9) {
			return "กันยายน ";
		} elseif (date("m", strtotime($find)) == 10) {
			return "ตุลาคม ";
		} elseif (date("m", strtotime($find)) == 11) {
			return "พฤศจิกายน ";
		} elseif (date("m", strtotime($find)) == 12) {
			return "ธันวาคม ";
		}
	}

	//WHERE o.hn IN ('000035634') AND o.nextdate = '2021-05-21'";
	//WHERE o.hn IN (SELECT hn FROM smarthos2.patientusers) AND o.nextdate = DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY),'%Y-%m-%d')";
$host = "200.200.200.12";
$db = "hos";
$user = "ghost";
$pwd = "ghUD2gES";

$myPDO = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
$myPDO -> exec("set names utf8");
$myPDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		try {
			$sql = "SELECT u.lineid AS line_id,o.*,p.pname,p.fname,p.lname FROM oapp o 
        LEFT OUTER JOIN smarthos2.patientusers u ON u.hn = o.hn
        LEFT OUTER JOIN patient p ON p.hn = o.hn 
				WHERE o.hn IN ('000035634') AND o.nextdate = DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY),'%Y-%m-%d')";
			$result = $myPDO->query($sql);
			foreach ($result AS $data) {
                $idline = $data['line_id'];
                $app_cause = str_replace("\r\n"," ",$data['note'])." ".str_replace("\r\n"," ",$data['app_cause']);
                $nextdate = "".date("j",strtotime($data['nextdate']))." ".chMonth($data['nextdate'])." ".chYear($data['nextdate'])."";
                $nexttime = " เวลา ".substr($data['nexttime'],0,5)." - ".substr($data['endtime'],0,5)." น.";
                $nexttime1 = substr($data['nexttime'],0,5);
                $notetext = str_replace("\r\n"," ",$data['note'])." ".str_replace("\r\n"," ",$data['note1']);
                $ptname = $data['pname'].$data['fname']." ".$data['lname'];
                $note = str_replace("\r\n"," ",$data['note']);
                $note1 = str_replace("\r\n"," ",$data['note1']);
                $contact_point = str_replace("\r\n"," ",$data['contact_point']);

				echo "วันนี้คุณมีนัด วันที่ ".date("j",strtotime($data['nextdate']))." ".chMonth($data['nextdate'])." ".chYear($data['nextdate'])." เวลา ".substr($data['nexttime'],0,5)." น.\n".$data['note']."\n(ตรวจสอบรายละเอียดการนัดจากเมนูบริการออนไลน์อีกครั้ง)"; // ข้อความ
				$txtmessage = "วันนี้คุณมีนัด \nวันที่ ".date("j",strtotime($data['nextdate']))." ".chMonth($data['nextdate'])." ".chYear($data['nextdate'])."\nเวลา ".substr($data['nexttime'],0,5)." น.\n\n".$data['note']."\n\n(ตรวจสอบรายละเอียดการนัดจากเมนูบริการออนไลน์อีกครั้ง)"; // ข้อความ

				// ********** ส่งข้อมูลนัดใน Line Official *********** //
				$access_token = "sp7k492nbjfxm3xJPtBc+w0UvesadCjft3LTXjXY6lSq2nIufhr6KEwijysNcBBPrUD5j2EU/CUis+4GJ+CWjeGsNJeyJBNeyNW0ITJfceZYz9Q82c/0vv3NnLAjUFWmr3KaQsPxhlec8COpK/C2dwdB04t89/1O/w1cDnyilFU=";
				$liff_url_oapp = "https://liff.line.me/1656884358-qko66Epp";
				$pushID = $idline;
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.line.me/v2/bot/message/push",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{

            "to": "'.$pushID.'",
            "messages": [{
            "type": "flex",
            "altText": "วันนี้คุณมีนัด",
            "contents": {

  "type": "bubble",
  "size": "mega",
  "hero": {
    "type": "image",
    "url": "https://restful.tphcp.go.th/appointment-tphcp3.jpg",
    "size": "full",
    "aspectRatio": "1600:448",
    "aspectMode": "cover",
    "action": {
      "type": "uri",
      "uri": "'.$liff_url_oapp.'"
    }
  },
  "body": {
    "type": "box",
    "layout": "vertical",
    "contents": [
      {
        "type": "box",
        "layout": "vertical",
        "contents": [
          {
            "type": "text",
            "text": "'.$ptname.' ",
            "margin": "none",
            "size": "lg",
            "weight": "bold"
          },
          {
            "type": "text",
            "text": "วันนี้คุณมีนัด",
            "color": "#FF0000",
            "margin": "md",
            "weight": "bold",
            "size": "lg"
          },
          {
            "type": "text",
            "text": "'.$nextdate.$nexttime.' ",
            "margin": "none",
            "size": "sm",
            "color": "#FF0000",
            "wrap": true
          },
          {
            "type": "text",
            "text": "'.$app_cause.' ",
            "weight": "bold",
            "color": "#1f76de",
            "size": "lg",
            "margin": "md",
            "wrap": true
          }
        ]
      },
      {
        "type": "text",
        "text": "ขั้นตอนการรับบริการ",
        "color": "#b7b7b7",
        "size": "xs",
        "margin": "lg"
      },
      {
        "type": "box",
        "layout": "horizontal",
        "contents": [
          {
            "type": "text",
            "text": "'.$nexttime1.' ",
            "size": "sm",
            "gravity": "center"
          },
          {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "filler"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "cornerRadius": "30px",
                "height": "12px",
                "width": "12px",
                "borderColor": "#EF454D",
                "borderWidth": "2px"
              },
              {
                "type": "filler"
              }
            ],
            "flex": 0
          },
          {
            "type": "text",
            "text": "ยื่นใบนัดรอซักประวัติ",
            "gravity": "center",
            "flex": 4,
            "size": "sm"
          }
        ],
        "spacing": "lg",
        "cornerRadius": "30px",
        "margin": "md"
      },
      {
        "type": "box",
        "layout": "horizontal",
        "contents": [
          {
            "type": "box",
            "layout": "baseline",
            "contents": [
              {
                "type": "filler"
              }
            ],
            "flex": 1
          },
          {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "box",
                "layout": "horizontal",
                "contents": [
                  {
                    "type": "filler"
                  },
                  {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [],
                    "width": "2px",
                    "backgroundColor": "#B7B7B7"
                  },
                  {
                    "type": "filler"
                  }
                ],
                "flex": 1
              }
            ],
            "width": "12px"
          },
          {
            "type": "text",
            "text": "('.$contact_point.')",
            "gravity": "center",
            "flex": 4,
            "size": "xs",
            "color": "#8c8c8c"
          }
        ],
        "spacing": "lg",
        "height": "30px"
      },
      {
        "type": "box",
        "layout": "horizontal",
        "contents": [
          {
            "type": "box",
            "layout": "horizontal",
            "contents": [],
            "flex": 1
          },
          {
            "type": "box",
            "layout": "vertical",
            "contents": [
              {
                "type": "filler"
              },
              {
                "type": "box",
                "layout": "vertical",
                "contents": [],
                "cornerRadius": "30px",
                "width": "12px",
                "height": "12px",
                "borderColor": "#6486E3",
                "borderWidth": "2px"
              },
              {
                "type": "filler"
              }
            ],
            "flex": 0
          },
          {
            "type": "text",
            "text": "รอตรวจ",
            "gravity": "center",
            "flex": 4,
            "size": "sm"
          }
        ],
        "spacing": "lg",
        "cornerRadius": "30px"
      },
      {
        "type": "separator",
        "margin": "md"
      },
      {
        "type": "text",
        "text": "'.$note1.' ",
        "margin": "md",
        "size": "sm",
        "wrap": true
      }
    ]
  },
  "footer": {
    "type": "box",
    "layout": "vertical",
    "contents": [
      {
        "type": "text",
        "text": "รายละเอียดเพิ่มเติม",
        "align": "center",
        "color": "#FFFFFF",
        "action": {
          "type": "uri",
          "label": "action",
          "uri": "'.$liff_url_oapp.'"
        }
      }
    ],
    "backgroundColor": "#FF3333"
  }


            }
            }]
        }',

        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$access_token."",
            "Content-Type: application/json"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

				// ********************************************** //

			}
			echo "ไม่มีนัด";
		}
		catch(PDOException $e) {echo "Connection failed: " . $e->getMessage();}
	
	?>

			</div>
		</div><!-- /.main-container -->

		<script src="assets/js/jquery-2.1.4.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

	</body>
</html>
