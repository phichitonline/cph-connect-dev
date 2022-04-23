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

    $host = config('database.connections.mysql_hos.host');
    $db = config('database.connections.mysql_hos.database');
    $user = config('database.connections.mysql_hos.username');
    $pwd = config('database.connections.mysql_hos.password');
    $db_hos = config('database.connections.mysql_hos.database');

    $myPDO = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    $myPDO -> exec("set names utf8");
    $myPDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $sql = "SELECT o.hn,o.vn,o.vstdate,o.vsttime,s.service16,op.icode,GROUP_CONCAT(d.`name`,' (',op.qty,')') AS druglist,'Ub6b2ab13fea3e802ad277fb2de13f26a' AS lineid,sp.`name` AS spcltyname,pt.pname,pt.fname,pt.lname,COUNT(*) AS dcount
            FROM ovst o
            LEFT JOIN patient pt ON o.hn = pt.hn
            LEFT JOIN spclty sp ON o.spclty = sp.spclty
            LEFT JOIN service_time s ON o.vn = s.vn
            LEFT JOIN opitemrece op ON o.vn = op.vn
            LEFT JOIN drugitems d ON op.icode = d.icode
            WHERE o.vstdate = CURDATE() AND o.hn = '000035634' AND op.sub_type = '1'
            GROUP BY o.hn
        ";
        $result = $myPDO->query($sql);
        foreach ($result AS $data) {
            $idline = $data['lineid'];
            $cc = "รายการยา";
            $med = "จำนวน ".$data['dcount']." รายการ";
            $spcltyname = $data['spcltyname'];
            $vstdate = "วันที่ ".date("j",strtotime($data['vstdate']))." ".chMonth($data['vstdate'])." ".chYear($data['vstdate'])."";
            $vsttime = " เวลา ".substr($data['service16'],0,5)." น.";
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
        "altText": "สรุปรับบริการ",
        "contents": {

  "type": "bubble",
  "size": "mega",
  "hero": {
    "type": "image",
    "url": "'.$cph_url.'/images/cphconnect/med-cphconnect.jpg",
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
            "text": "สรุปรับบริการ",
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
            "text": "ยา ",
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
            "text": "'.$med.' ",
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
        "text": "ตรวจสอบรายการต่างๆได้ภายในแอป ",
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
        echo "No data";
    }
    catch(PDOException $e) {echo "Connection failed: " . $e->getMessage();}

?>
