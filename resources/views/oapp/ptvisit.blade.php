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
        $sql = "SELECT t2.lineid,o.hn,o.an,o.vstdate,o.vsttime,o.spclty,s.`name` AS spcltyname,p.pname,p.fname,p.lname
                    FROM ".$db_hos.".ovst o
                    LEFT JOIN ".$db_hos.".spclty s ON o.spclty = s.spclty
                    LEFT JOIN ".$db_hos.".patient p ON p.hn = o.hn
                    LEFT JOIN patientusers pt ON o.hn = pt.hn
                    INNER JOIN (
                    	SELECT t1.lineid,t1.hn FROM (
                    		SELECT lineid,hn AS hn FROM patientusers
                    		UNION ALL
                    		SELECT lineid,hn2 AS hn FROM patientusers WHERE hn2 <> ''
                    		UNION ALL
                    		SELECT lineid,hn3 AS hn FROM patientusers WHERE hn3 <> ''
                    	) AS t1
                    	WHERE t1.hn IN (
                    		SELECT o.hn FROM ".$db_hos.".ovst o
                    		WHERE o.vstdate = CURDATE() AND CONCAT(o.vstdate,' ',o.vsttime) >= DATE_ADD(NOW(), INTERVAL -5 MINUTE)
                    	)) t2 ON t2.hn = o.hn

                    WHERE o.vstdate = CURDATE() AND CONCAT(o.vstdate,' ',o.vsttime) >= DATE_ADD(NOW(), INTERVAL -5 MINUTE)";
        $result = $myPDO->query($sql);
        foreach ($result AS $data) {
            $idline = $data['lineid'];
            $cc = " ";
            $spcltyname = $data['spcltyname'];
            $vstdate = "วันที่ ".DateThaiFull($data['vstdate'])."";
            $vsttime = "เวลา ".TimeThai($data['vsttime'])." น.";
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
        "altText": "คุณกำลังรับบริการ",
        "contents": {

            "type": "bubble",
  "size": "mega",
  "hero": {
    "type": "image",
    "url": "'.$cph_url.'/images/cphconnect/alert-cphconnect.jpeg",
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
        echo "ไม่มีนัด";
    }
    catch(PDOException $e) {echo "Connection failed: " . $e->getMessage();}

?>
