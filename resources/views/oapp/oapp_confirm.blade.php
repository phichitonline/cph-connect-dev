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
        $sql = "SELECT t2.lineid,o.hn,o.vstdate,o.spclty,s.`name` AS spcltyname,p.pname,p.fname,p.lname,o.nextdate,o.nexttime,o.note
                    FROM ".$db_hos.".oapp o
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
                    		SELECT o.hn FROM ".$db_hos.".oapp o
                    		WHERE o.vstdate = CURDATE() AND CONCAT(o.entry_date,' ',o.entry_time) BETWEEN DATE_ADD(NOW(), INTERVAL -5 MINUTE) AND NOW()
                    	)) t2 ON t2.hn = o.hn

                    WHERE o.vstdate = CURDATE() AND CONCAT(o.entry_date,' ',o.entry_time) BETWEEN DATE_ADD(NOW(), INTERVAL -5 MINUTE) AND NOW()";
        $result = $myPDO->query($sql);
        foreach ($result AS $data) {
            $idline = $data['lineid'];
            $cc = " ";
            $spcltyname = $data['spcltyname'];
            $vstdate = "วันที่ ".DateThaiFull($data['nextdate'])."";
            $vsttime = "เวลา ".TimeThai($data['nexttime'])." น.";
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
            "altText": "ยืนยันการนัด",
            "contents": {

                "type": "bubble",
                "size": "giga",
                "body": {
                    "type": "box",
                    "layout": "vertical",
                    "contents": [
                    {
                        "type": "text",
                        "text": "text_line_message0",
                        "weight": "bold",
                        "size": "xxl",
                        "margin": "md",
                        "color": "#009900"
                    },
                    {
                        "type": "text",
                        "text": "text_line_message1",
                        "size": "lg",
                        "weight": "bold"
                    },
                    {
                        "type": "text",
                        "text": "text_line_message2",
                        "wrap": true
                    },
                    {
                        "type": "text",
                        "text": "text_line_message3"
                    },
                    {
                        "type": "separator",
                        "margin": "xxl"
                    },
                    {
                        "type": "box",
                        "layout": "vertical",
                        "margin": "xxl",
                        "spacing": "sm",
                        "contents": [
                        {
                            "type": "text",
                            "text": "text_line_message4",
                            "color": "#ff0000",
                            "weight": "bold",
                            "size": "xxl"
                        }
                        ],
                        "justifyContent": "center",
                        "alignItems": "center"
                    },
                    {
                        "type": "separator",
                        "margin": "xxl"
                    },
                    {
                        "type": "box",
                        "layout": "horizontal",
                        "margin": "md",
                        "contents": [
                        {
                            "type": "text",
                            "text": "รายละเอียดเพิ่มเติม",
                            "size": "xs",
                            "color": "#aaaaaa",
                            "flex": 0,
                            "action": {
                            "type": "uri",
                            "label": "รายละเอียดเพิ่มเติม",
                            "uri": "'.$liff_url.'"
                            }
                        }
                        ]
                    }
                    ]
                },
                "styles": {
                    "footer": {
                    "separator": true
                    }
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

            // ********************************************** //

        }
        echo "No data";
    }
    catch(PDOException $e) {echo "Connection failed: " . $e->getMessage();}

?>
