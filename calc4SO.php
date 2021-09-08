<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_soNumber = filter_input(INPUT_POST, "soNumber");
$varpost_processName = filter_input(INPUT_POST, "processName");

$varpost_valueWgLabour = filter_input(INPUT_POST, "valueWgLabour");
$varpost_valueWgLabour = str_replace(",", "", $varpost_valueWgLabour);

$varpost_id2Update = filter_input(INPUT_POST, "id");

$varpost_wgDestination = filter_input(INPUT_POST, "valueWgDestination");
$varpost_wgDestination = str_replace(",", "", $varpost_wgDestination);

$varpost_valueDRC = filter_input(INPUT_POST, "valueDRC");

$varpost_valueWgReturn = filter_input(INPUT_POST, "valueWgReturn");
$varpost_valueWgReturn = str_replace(",", "", $varpost_valueWgReturn);

$varpost_buyPrice = filter_input(INPUT_POST, 'buyPrice');
$varpost_valueBuyType = filter_input(INPUT_POST, 'valueBuyType');
$varpost_valueLocation = filter_input(INPUT_POST, 'valueLocation');
$varpost_valueProduct = filter_input(INPUT_POST, 'valueProduct');

// GET variable
$varget_command = filter_input(INPUT_GET, 'command');
$varget_soNumber = filter_input(INPUT_GET, 'soNumber');
$varget_soVlpn = filter_input(INPUT_GET, 'soVLpn');
$varget_soCustomer = filter_input(INPUT_GET, 'soCustomer');
$varget_soWgNet = filter_input(INPUT_GET, 'soWgNet');
$varget_soSuppLogis = filter_input(INPUT_GET, 'soSuppLogisCode');

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'updatePrice':
            updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_buyprc', $varpost_buyPrice, 1);
//        header('refresh:0;url=poMgr.php?poNumber=' . $poNumber);
            break;

        case 'updateBuyType':
            updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_buytype', $varpost_valueBuyType, 2);
            break;

        case 'updateLocation':
            updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_location', $varpost_valueLocation, 2);
            break;

        case 'updateProduct':
            if ($varpost_valueProduct == '0002') {
                updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_percent', 97, 1);
            }
            updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_product', $varpost_valueProduct, 2);
            break;

        case 'updateWgLabour':
            $sqlcmd_updateWgLabour = "UPDATE tbl_wg4sell SET wg_labour=" . $varpost_valueWgLabour . " WHERE wg_sonum='" . $varpost_soNumber . "'";
            echo $sqlcmd_updateWgLabour;
            $sqlres_updateWgLabour = mysqli_query($dbConn, $sqlcmd_updateWgLabour);
            if (!$sqlres_updateWgLabour) {
                echo $sqlcmd_updateWgLabour;
                echo "<br>";
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            break;

        // UNDER WAS OK
        case 'updateDRC':
            updateDB('tbl_wg4sell', 'id', $varpost_id2Update, 1, 'wg_percent', $varpost_valueDRC, 1);
//        header('refresh:0;url=poMgr.php?poNumber=' . $poNumber);
            break;

        case "updateWeightReturn":
            updateDB('tbl_wg4sell', 'id', $varpost_id2Update, 1, 'wg_return', $varpost_valueWgReturn, 1);
            break;

        case "updateWeightDestination":
            updateDB('tbl_wg4sell', 'id', $varpost_id2Update, 1, 'wg_destination', $varpost_wgDestination, 1);
            break;

        default:
            break;
    }
}

if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'calc4Wg2Time':
            // calculation weight for time weighting
            $sqlcmd_insertCalcWg2T = "INSERT INTO tbl_wg4sell (wg_sonum, wg_vlpn, wg_code4supplogis, wg_net, wg_code4customer, wg_created) VALUES ('$varget_soNumber', '$varget_soVlpn', '$varget_soSuppLogis',$varget_soWgNet, '$varget_soCustomer', NOW())";
            $sqlres_insertCalcWg2T = mysqli_query($dbConn, $sqlcmd_insertCalcWg2T);

            if ($sqlres_insertCalcWg2T) {
                echo "<script>alert('คำนวณน้ำหนักแล้ว')</script>";
                echo "<script>window.location.href='soMgrAll.php?soNumber=" . $varget_soNumber . "'</script>";
            } else {
                echo $sqlcmd_insertCalcWg2T;
                echo "<br>ERROR !!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;

        default:
            // Do nothing
            break;
    }
}