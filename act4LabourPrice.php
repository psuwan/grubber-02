<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

/*
echo "<pre>";
var_dump($_POST);
echo "</pre>";
*/

// USE BOTH
$varpost_processName = filter_input(INPUT_POST, 'processName');

// PARAMETER FOR LABOUR
$lbCode = filter_input(INPUT_POST, 'labourCode2Edit');
if (empty($lbCode)) {
    $lbCode = str_replace("-", "", $dateNow) . str_replace(":", "", $timeNow);
}

$lbDate = filter_input(INPUT_POST, 'dateLabourIn');
list($ddd, $mmm, $yyy) = explode("-", $lbDate);
if ($yyy > (date("Y") + 543)) {
    $yyy = date("Y") + 543;
}
$lbDate = ($yyy - 543) . "-" . $mmm . "-" . $ddd;

$lbSupp = filter_input(INPUT_POST, 'supplier');
$lbVLpn = filter_input(INPUT_POST, 'vLpn');
$lbWeight = filter_input(INPUT_POST, 'weight');
//$lbWeight = str_replace(",", "", $lbWeight);
$lbPrice = filter_input(INPUT_POST, 'price');
// PARAMETER FOR LABOUR

// PARAMETER FOR LOGIS
$lgCode = filter_input(INPUT_POST, 'logisCode2Edit');
if (empty($lgCode)) {
    $lgCode = str_replace("-", "", $dateNow) . str_replace(":", "", $timeNow);
}

$lgDate = filter_input(INPUT_POST, 'dateLogis');
list($ddd, $mmm, $yyy) = explode("-", $lgDate);
if ($yyy > (date("Y") + 543)) {
    $yyy = date("Y") + 543;
}
$lgDate = ($yyy - 543) . "-" . $mmm . "-" . $ddd;

$lgSuppLogis = filter_input(INPUT_POST, 'suppLogis');
$lgLocUp = filter_input(INPUT_POST, 'locationUp');
$lgLocDw = filter_input(INPUT_POST, 'locationDown');
$lgWeight = filter_input(INPUT_POST, 'weight');
$lgPrice = filter_input(INPUT_POST, 'price');

// PARAMETER FOR LOGIS

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case "addLabourPriceIn":
            insertDB("tbl_labourprice", "lb_code", $lbCode, 2);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_date", $lbDate, 2);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_supplier", $lbSupp, 2);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_vlpn", $lbVLpn, 2);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_weight", $lbWeight, 1);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_price", $lbPrice, 1);

            echo "<script>alert(\"บันทึกข้อมูลแล้ว\")</script>";
            echo "<script>window.location.href='adminLabourPrice.php'</script>";
            break;

        case "editLabourPriceIn":
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_date", $lbDate, 2);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_supplier", $lbSupp, 2);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_vlpn", $lbVLpn, 2);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_weight", $lbWeight, 1);
            updateDB("tbl_labourprice", "lb_code", $lbCode, 2, "lb_price", $lbPrice, 1);

            echo "<script>alert(\"บันทึกข้อมูลแล้ว\")</script>";
            echo "<script>window.location.href='adminLabourPrice.php'</script>";
            break;

        case "addLabourPriceOut":
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";

            insertDB("tbl_logisprice", "lg_code", $lgCode, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_date", $lgDate, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_supplogis", $lgSuppLogis, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_locationup", $lgLocUp, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_locationdown", $lgLocDw, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_weight", $lgWeight, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_price", $lgPrice, 2);

            echo "<script>alert(\"บันทึกข้อมูลแล้ว\")</script>";
            echo "<script>window.location.href='adminLogisPrice.php'</script>";
            break;

        case "editLabourPriceOut":
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_date", $lgDate, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_supplogis", $lgSuppLogis, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_locationup", $lgLocUp, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_locationdown", $lgLocDw, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_weight", $lgWeight, 2);
            updateDB("tbl_logisprice", "lg_code", $lgCode, 2, "lg_price", $lgPrice, 2);

            echo "<script>alert(\"บันทึกข้อมูลแล้ว\")</script>";
            echo "<script>window.location.href='adminLogisPrice.php'</script>";
            break;
    }
}