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
        $sql = "SELECT o.hn,p.pname,p.fname,p.lname,o.vstdate,o.vsttime,t2.lineid
                    FROM "$db_hos".ovst o
                    LEFT JOIN "$db_hos".patient p ON p.hn = o.hn
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
                    		SELECT o.hn FROM "$db_hos".ovst o
                    		WHERE o.vstdate = CURDATE() AND CONCAT(o.vstdate,' ',o.vsttime) >= DATE_ADD(NOW(), INTERVAL -5 MINUTE)
                    	)) t2 ON t2.hn = o.hn

                    WHERE o.vstdate = CURDATE() AND CONCAT(o.vstdate,' ',o.vsttime) >= DATE_ADD(NOW(), INTERVAL -5 MINUTE)";
        $result = $myPDO->query($sql);
        foreach ($result AS $data) {
            $hn = $data['hn'];
            $idline = $data['lineid'];
            $cc = ">>> ตรวจสอบคิวและรอรับยา...";
            $vstdate = "วันที่ ".DateThaiFull($data['vstdate'])."";
            $vsttime = "เวลา ".TimeThai($data['vsttime'])." น.";
            $ptname = "คุณ".$data['fname']." ".$data['lname'];
            $text_message = "## แจ้งเตือนบริการ ## \n".$ptname." \n".$vstdate." \n".$vsttime." \n\n".$cc;

            echo $hn.",";

            // ********** ส่งข้อมูลนัดใน Line Official *********** //
            $lineidpush = $idline;

            require "vendor-line/autoload.php";
            $access_token = config('line-bot.channel_access_token');
            $channelSecret = config('line-bot.channel_secret');
            $pushID = $lineidpush;
            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);
            $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($text_message);
            $response = $bot->pushMessage($pushID, $textMessageBuilder);
            // ********************************************** //

        }

        echo "#FINISH#";
    }
    catch(PDOException $e) {echo "Connection failed: " . $e->getMessage();}

?>
