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

    $host = config('database.connections.mysql.host');
    $db = config('database.connections.mysql.database');
    $user = config('database.connections.mysql.username');
    $pwd = config('database.connections.mysql.password');
    $db_hos = config('database.connections.mysql_hos.database');

    $myPDO = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    $myPDO -> exec("set names utf8");
    $myPDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $sql = "SELECT u.lineid AS line_id,o.*,p.pname,p.fname,p.lname FROM ".$db_hos.".oapp o
            LEFT OUTER JOIN patientusers u ON u.hn = o.hn
            LEFT OUTER JOIN ".$db_hos.".patient p ON p.hn = o.hn
            WHERE o.hn IN (SELECT hn FROM patientusers) AND o.nextdate = DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 0 DAY),'%Y-%m-%d')";
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
            $access_token = config('line-bot.channel_access_token');
            $liff_url = config('line-bot.liff_url');
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
  "uri": "'.$liff_url.'"
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
      "uri": "'.$liff_url.'"
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
