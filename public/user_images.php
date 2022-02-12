<?php
header("Content-type: image/jpeg");

	try {
		$host = "203.157.220.244";
        $db = "hos";
        $user = "sa";
        $pwd = "p6rik=9trkosbo";

        $myPDO = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
        $myPDO -> exec("set names utf8");
        $myPDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$sql = "SELECT image FROM patient_image WHERE hn = '".$_GET['hn']."'  ";
		$query = $myPDO->query($sql);
		foreach($query as $row) {
			echo $row['image'];
		}

	} catch (PDOException $e) {
		echo "ไม่สามารถเชื่อมต่อฐานข้อมูลได้ : ".$e->getMessage();
	}

?>
