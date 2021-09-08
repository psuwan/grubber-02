<?php
date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");
$dt = $dateNow . " " . $timeNow;

include_once "./lib/apksFunctions.php";
$dbConn = dbConnect();

$varget_command = filter_input(INPUT_GET, 'command');

$varpost_processName = filter_input(INPUT_POST, "processName");
$varpost_soNumber = filter_input(INPUT_POST, "soNumber");
$varpost_soCustomer = filter_input(INPUT_POST, "soCustomer");
$varpost_soWeight = filter_input(INPUT_POST, "soWeight");
$varpost_soPrice = filter_input(INPUT_POST, "soPrice");
/*
["SOSuppLogis"]=>
string(29) "กก-4321 / ทดสอบ"
["SONumber"]=>
string(77) "20210907002124126 / น.ส.กนกนันท์ หัตถินาท"
["SOWgType"]=>
string(4) "0001"
["SOWgScale"]=>
string(4) "0001"
["SOProduct"]=>
string(4) "0000"
["cntPallet"]=>
string(1) "0"
["wg4Pallet"]=>
string(1) "0"
["wgScaleRd"]=>
string(4) "2345"
["wgScaleNet"]=>
string(7) "2345.00"
["processName"]=>
string(8) "addWg4SO"
 */

/*
echo "<pre>";
var_dump($_POST);
echo "</pre>";
*/

$wgData = array(
    "soSuppLogis" => filter_input(INPUT_POST, "SOSuppLogis"),
    "soNumber" => filter_input(INPUT_POST, "SONumber"),
    "soWgType" => filter_input(INPUT_POST, "SOWgType"),
    "soWgScale" => filter_input(INPUT_POST, "SOWgScale"),
    "soProduct" => filter_input(INPUT_POST, "SOProduct"),
    "cntPallet" => filter_input(INPUT_POST, "cntPallet"),
    "wg4Pallet" => filter_input(INPUT_POST, "wg4Pallet"),
    "wgScaleRd" => filter_input(INPUT_POST, "wgScaleRd"),
    "wgScaleNet" => filter_input(INPUT_POST, "wgScaleNet")
);
list($so_suppLogisVlpn, $so_suppLogisName) = explode(" / ", $wgData["soSuppLogis"]);
$soSuppLogis = getValue("tbl_supplogis", "supplogis_vlpn", $so_suppLogisVlpn, 2, "supplogis_code");

list($soNumber, $so_customer) = explode(" / ", $wgData["soNumber"]);
list($soCustomerName, $soCustomerSurname) = explode(" ", $so_customer);
$soCustomer = getValue("tbl_customers", "customer_name", $soCustomerName, 2, "customer_code");

$soWgType = $wgData["soWgType"];
$soWgScale = $wgData["soWgScale"];
$soProduct = $wgData["soProduct"];
$soCntPallet = $wgData["cntPallet"];
$soWg4Pallet = $wgData["wg4Pallet"];
$soWgScaleRd = $wgData["wgScaleRd"];
$soWgScaleNet = $wgData["wgScaleNet"];

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'openSO':
            insertDB("tbl_sellorder", "so_number", $varpost_soNumber, 2);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_customer", $varpost_soCustomer, 2);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_product", '0001', 2);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_weight", $varpost_soWeight, 1);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_price", $varpost_soPrice, 1);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_created", $dt, 2);

            echo "<script>alert(\"เปิดการขายแล้ว\")</script>";
            echo "<script>window.location.href=\"./sellOrder.php\"</script>";
            break;

        case 'editSO':
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_customer", $varpost_soCustomer, 2);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_product", '0001', 2);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_weight", $varpost_soWeight, 1);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_price", $varpost_soPrice, 1);
            updateDB("tbl_sellorder", "so_number", $varpost_soNumber, 2, "so_created", $dt, 2);

            echo "<script>alert(\"แก้ไขข้อมูลการขายแล้ว\")</script>";
            echo "<script>window.location.href=\"./sellOrder.php\"</script>";
            break;

        case "addWg4SO":
            $sqlcmd_wg4SO = "INSERT INTO tbl_wg4sell (wg_sonum, wg_code4supplogis, wg_code4customer, wg_code4wgtype, wg_code4scale, wg_code4product, qty_pallet, wg_eachpallet, wg_scalerd, wg_net, wg_created) VALUES ('$soNumber', '$soSuppLogis', '$soCustomer', '$soWgType', '$soWgScale', '$soProduct', $soCntPallet, $soWg4Pallet, $soWgScaleRd, $soWgScaleNet, NOW())";
            $sqlres_wg4SO = mysqli_query($dbConn, $sqlcmd_wg4SO);

            if ($sqlres_wg4SO) {
                updateDB("tbl_supplogis", "supplogis_code", $soSuppLogis, 2, "supplogis_status", 1, 1);
                echo "<script>alert(\"บันทึกข้อมูลการชั่งแล้ว\")</script>";
                echo "<script>window.location.href=\"./soList.php\"</script>";
            } else {
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;

        default:
            echo "<script>alert(\"ไม่มีการทำงาน\")</script>";
            echo "<script>window.history.go(-1)</script>";
            break;
    }
}