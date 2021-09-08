<?php

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");
$dt = $dateNow . " " . $timeNow;

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_processName = filter_input(INPUT_POST, 'processName');

$WgData = array(
    "POIsNew" => filter_input(INPUT_POST, 'chkNewPO'),
    "PONumber" => filter_input(INPUT_POST, 'poNumber'),
    "POVLPN" => filter_input(INPUT_POST, 'vlpnNumber'),
    "POSupp" => filter_input(INPUT_POST, 'POSuppName'),
    "POBuyType" => filter_input(INPUT_POST, 'POBuyType'),
    "POWgType" => filter_input(INPUT_POST, 'POWgType'),
    "POWgScale" => filter_input(INPUT_POST, 'POWgScale'),
    "POProduct" => filter_input(INPUT_POST, 'POProduct'),
    "QtyPallet" => filter_input(INPUT_POST, 'cntPallet'),
    "Wg4Pallet" => filter_input(INPUT_POST, 'wg4Pallet'),
    "WgScaleRd" => filter_input(INPUT_POST, 'wgScaleRd'),
    "WgNetValue" => filter_input(INPUT_POST, 'wgScaleNet')
);
$wgNew = $WgData['POIsNew'];
$wg4PONum = $WgData['PONumber'];
$wg4LPN = $WgData['POVLPN'];
//
$wg4SuppCode = '';
list($suppNameF, $suppNameL) = explode(" ", $WgData['POSupp']);
$wg4SuppCode = getValue('tbl_suppliers', 'supp_name', $suppNameF, 2, 'supp_code');
//
$PO_BuyType = $WgData['POBuyType'];
$wgType = $WgData['POWgType'];
$wgScale = $WgData['POWgScale'];
$wg4Product = $WgData['POProduct'];

// Calculation able values
$palletQty = $WgData['QtyPallet'];
$wg4Pallet = $WgData['Wg4Pallet'];
$wgValue = $WgData['WgScaleRd'];
$netWg = $WgData['WgNetValue'];

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'AddWg':
            $sqlcmd_addWg = "INSERT INTO tbl_wg4buy (wg_ponum, wg_vlpn, wg_suppcode, wg_buytype, wg_type, wg_scale, wg_product, wg_palletqty, wg_eachpallet, wg_scalerd, wg_net, wg_createdat) VALUES ('$wg4PONum', '$wg4LPN', '$wg4SuppCode', '$PO_BuyType', '$wgType', '$wgScale', '$wg4Product', $palletQty, $wg4Pallet, $wgValue, $netWg, '$dt')";
            $sqlres_addWg = mysqli_query($dbConn, $sqlcmd_addWg);

            if ($sqlres_addWg) {
                echo "<script>alert('บันทึกการชั่งแล้ว');</script>";
                echo "<script>window.location.href='./poList.php';</script>";
            } else {
                echo "ERROR!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }

            break;
    }
}