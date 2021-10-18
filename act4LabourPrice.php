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

$varpost_processName = filter_input(INPUT_POST, 'processName');
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
$lbWeight = str_replace(",", "", $lbWeight);

$lbPrice = filter_input(INPUT_POST, 'price');

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case "addLabourPriceIn":
            insertDB("tbl_labourin", "lb_code", $lbCode, 2);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_date", $lbDate, 2);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_supplier", $lbSupp, 2);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_vlpn", $lbVLpn, 2);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_weight", $lbWeight, 1);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_price", $lbPrice, 1);

            echo "<script>alert(\"บันทึกข้อมูลแล้ว\")</script>";
            echo "<script>window.location.href='adminLabourIn.php'</script>";
            break;

        case "editLabourPriceIn":
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_date", $lbDate, 2);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_supplier", $lbSupp, 2);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_vlpn", $lbVLpn, 2);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_weight", $lbWeight, 1);
            updateDB("tbl_labourin", "lb_code", $lbCode, 2, "lb_price", $lbPrice, 1);

            echo "<script>alert(\"บันทึกข้อมูลแล้ว\")</script>";
            echo "<script>window.location.href='adminLabourIn.php'</script>";
            break;
    }
}