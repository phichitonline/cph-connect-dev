<?php

// ผู้ป่วยนอก
$countopd10 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myearb-10-01' AND '$myearb-10-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd10,$row[visitopd]);
}

$countopd11 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myearb-11-01' AND '$myearb-11-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd11,$row[visitopd]);
}

$countopd12 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myearb-12-01' AND '$myearb-12-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd12,$row[visitopd]);
}

$countopd01 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-01-01' AND '$myeare-01-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd01,$row[visitopd]);
}

$countopd02 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-02-01' AND '$myeare-02-29'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd02,$row[visitopd]);
}

$countopd03 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-03-01' AND '$myeare-03-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd03,$row[visitopd]);
}

$countopd04 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-04-01' AND '$myeare-04-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd04,$row[visitopd]);
}

$countopd05 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-05-01' AND '$myeare-05-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd05,$row[visitopd]);
}

$countopd06 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-06-01' AND '$myeare-06-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd06,$row[visitopd]);
}

$countopd07 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-07-01' AND '$myeare-07-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd07,$row[visitopd]);
}

$countopd08 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-08-01' AND '$myeare-08-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd08,$row[visitopd]);
}

$countopd09 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitopd
    FROM vn_stat v
    LEFT OUTER JOIN spclty s ON s.spclty = v.spclty
    WHERE v.vstdate BETWEEN '$myeare-09-01' AND '$myeare-09-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countopd09,$row[visitopd]);
}

// ผู้ป่วยใน
$countipd10 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myearb-10-01' AND '$myearb-10-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd10,$row[visitipd]);
}

$countipd11 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myearb-11-01' AND '$myearb-11-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd11,$row[visitipd]);
}

$countipd12 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myearb-12-01' AND '$myearb-12-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd12,$row[visitipd]);
}

$countipd01 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-01-01' AND '$myeare-01-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd01,$row[visitipd]);
}

$countipd02 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-02-01' AND '$myeare-02-29'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd02,$row[visitipd]);
}

$countipd03 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-03-01' AND '$myeare-03-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd03,$row[visitipd]);
}

$countipd04 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-04-01' AND '$myeare-04-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd04,$row[visitipd]);
}

$countipd05 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-05-01' AND '$myeare-05-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd05,$row[visitipd]);
}

$countipd06 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-06-01' AND '$myeare-06-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd06,$row[visitipd]);
}

$countipd07 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-07-01' AND '$myeare-07-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd07,$row[visitipd]);
}

$countipd08 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-08-01' AND '$myeare-08-31'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd08,$row[visitipd]);
}

$countipd09 = array(); //ตัวแปรแกน y
$sql = "SELECT s.nhso_code,COUNT(*) AS visitipd
    FROM an_stat a
    LEFT OUTER JOIN spclty s ON s.spclty = a.spclty
    WHERE a.regdate BETWEEN '$myeare-09-01' AND '$myeare-09-30'
    GROUP BY s.nhso_code ORDER BY s.nhso_code ASC";
$query = $myPDO->query($sql);
foreach($query as $row) {
    array_push($countipd09,$row[visitipd]);
}     