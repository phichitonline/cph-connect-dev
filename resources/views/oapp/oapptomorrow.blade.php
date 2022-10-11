<?php

    $host = config('database.connections.mysql.host');
    $db = config('database.connections.mysql.database');
    $user = config('database.connections.mysql.username');
    $pwd = config('database.connections.mysql.password');
    $db_hos = config('database.connections.mysql_hos.database');

    $myPDO = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    $myPDO -> exec("set names utf8");
    $myPDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $sql = "SELECT t2.lineid AS line_id,o.*,p.pname,p.fname,p.lname
            FROM ".$db_hos.".oapp o
            LEFT OUTER JOIN patientusers u ON u.hn = o.hn
            LEFT OUTER JOIN ".$db_hos.".patient p ON p.hn = o.hn
            INNER JOIN (
                SELECT t1.lineid,t1.hn FROM (
                    SELECT lineid,hn AS hn FROM patientusers
                    UNION ALL
                    SELECT lineid,hn2 AS hn FROM patientusers WHERE hn2 <> ''
                    UNION ALL
                    SELECT lineid,hn3 AS hn FROM patientusers WHERE hn3 <> ''
                ) AS t1
                WHERE t1.hn IN (
                    SELECT o.hn FROM ".$db_hos.".oapp o
                    WHERE o.nextdate = DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 DAY),'%Y-%m-%d')
                )) t2 ON t2.hn = o.hn

            WHERE o.nextdate = DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 DAY),'%Y-%m-%d')";
        $result = $myPDO->query($sql);
        foreach ($result AS $data) {
            $idline = $data['line_id'];
            $app_cause = str_replace("\r\n"," ",$data['note'])." ".str_replace("\r\n"," ",$data['app_cause']);
            $nextdate = "วันที่ ".DateThaiFull($data['nextdate'])."";
            $nexttime = " เวลา ".TimeThai($data['nexttime'])." - ".TimeThai($data['endtime'])." น.";
            $nexttime1 = TimeThai($data['nexttime']);
            $notetext = str_replace("\r\n"," ",$data['note'])." ".str_replace("\r\n"," ",$data['note1']);
            $ptname = $data['pname'].$data['fname']." ".$data['lname'];
            $note = str_replace("\r\n"," ",$data['note']);
            $note1 = str_replace("\r\n"," ",$data['note1']);
            $contact_point = str_replace("\r\n"," ",$data['contact_point']);

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
        "altText": "พรุ่งนี้คุณมีนัด",
        "contents": {

"type": "bubble",
"size": "mega",
"hero": {
"type": "image",
"url": "'.$cph_url.'/images/cphconnect/appointment-cph-tomorrow.jpeg",
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
        "text": "พรุ่งนี้คุณมีนัด",
        "color": "#FF0000",
        "margin": "md",
        "weight": "bold",
        "size": "lg"
      },
      {
        "type": "text",
        "text": "'.$nextdate.' ",
        "margin": "none",
        "size": "sm",
        "color": "#FF0000",
        "wrap": true
      },
      {
        "type": "text",
        "text": "'.$nexttime.' ",
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
"backgroundColor": "#f39c12"
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
