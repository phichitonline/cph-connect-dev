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
        $sql = "SELECT pt.lineid,o.hn,o.an,o.vstdate,o.vsttime,o.spclty,s.`name` AS spcltyname,p.pname,p.fname,p.lname
                    FROM ".$db_hos.".ovst o
                    LEFT JOIN ".$db_hos.".spclty s ON o.spclty = s.spclty
                    LEFT JOIN ".$db_hos.".patient p ON p.hn = o.hn
                    LEFT JOIN patientusers pt ON o.hn = pt.hn
                    WHERE o.vstdate = CURDATE() AND CONCAT(o.vstdate,' ',o.vsttime) >= DATE_ADD(NOW(), INTERVAL -5 MINUTE)
                    AND o.hn IN (SELECT hn FROM patientusers)";
        $result = $myPDO->query($sql);
        foreach ($result AS $data) {
            $idline = $data['lineid'];
            $cc = " ";
            $spcltyname = $data['spcltyname'];
            $vstdate = "วันที่ ".date("j",strtotime($data['vstdate']))." ".chMonth($data['vstdate'])." ".chYear($data['vstdate'])."";
            $vsttime = " เวลา ".substr($data['vsttime'],0,5)." น.";
            $ptname = $data['pname'].$data['fname']." ".$data['lname'];

            echo "xxx";

            // ********** ส่งข้อมูลนัดใน Line Official *********** //
            $access_token = config('line-bot.channel_access_token');
            $liff_url = config('line-bot.liff_url');
            $cph_url = config('app.cph_url');
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
    "url": "'.$cph_url.'/images/cphconnect/alert-cphconnect.jpg",
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
            "text": "คุณกำลังรับบริการ",
            "color": "#FF0000",
            "margin": "md",
            "weight": "bold",
            "size": "lg"
          },
          {
            "type": "text",
            "text": "'.$vstdate.' '.$vsttime.' ",
            "margin": "none",
            "size": "sm",
            "color": "#FF0000",
            "wrap": true
          },
          {
            "type": "text",
            "text": "'.$cc.' ",
            "weight": "bold",
            "color": "#1f76de",
            "size": "lg",
            "margin": "md",
            "wrap": true
          }
        ]
      },
      {
        "type": "box",
        "layout": "horizontal",
        "contents": [
          {
            "type": "text",
            "text": "แผนก ",
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
            "text": "'.$spcltyname.' ",
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
        "type": "separator",
        "margin": "md"
      },
      {
        "type": "text",
        "text": "โปรดตรวจสอบหากคุณไม่ได้เข้ารับบริการ ",
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
        "text": "ดูคิวรับบริการ",
        "align": "center",
        "color": "#FFFFFF",
        "action": {
          "type": "uri",
          "label": "action",
          "uri": "'.$liff_url.'"
        }
      }
    ],
    "backgroundColor": "#2E86C1"
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
