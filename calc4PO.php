<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_poNumber = filter_input(INPUT_POST, 'poNumber');
$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_id2Update = filter_input(INPUT_POST, 'id');
$varpost_buyPrice = filter_input(INPUT_POST, 'buyPrice');
$varpost_valueDRC = filter_input(INPUT_POST, 'valueDRC');
$varpost_valueBuyType = filter_input(INPUT_POST, 'valueBuyType');
$varpost_valueLocation = filter_input(INPUT_POST, 'valueLocation');
$varpost_valueProduct = filter_input(INPUT_POST, 'valueProduct');
$varpost_valueWgLabour = filter_input(INPUT_POST, 'valueWgLabour');

// GET variable
$varget_command = filter_input(INPUT_GET, 'command');
$varget_poNumber = filter_input(INPUT_GET, 'poNumber');
$varget_poVlpn = filter_input(INPUT_GET, 'poVLpn');
$varget_poSuppcode = filter_input(INPUT_GET, 'poSuppCode');
$varget_poWgNet = filter_input(INPUT_GET, 'poWgNet');
$varget_poTime = filter_input(INPUT_GET, 'wgTimeCalc');

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'updatePrice':
            updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_buyprc', $varpost_buyPrice, 1);
//        header('refresh:0;url=poMgr.php?poNumber=' . $poNumber);
            break;

        case 'updateDRC':
            updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_percent', $varpost_valueDRC, 1);
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
            $sqlcmd_updateWgLabour = "UPDATE tbl_wg4buy SET wg_labour=" . $varpost_valueWgLabour . " WHERE wg_ponum='" . $varpost_poNumber . "'";
            $sqlres_updateWgLabour = mysqli_query($dbConn, $sqlcmd_updateWgLabour);
            if (!$sqlres_updateWgLabour) {
                echo $sqlcmd_updateWgLabour;
                echo "<br>";
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            break;
    }
}

if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'calc4Wg2Time':
            // calculation weight for time weighting
            $sqlcmd_insertCalcWg2T = "INSERT INTO tbl_wg4buy (wg_ponum, wg_vlpn, wg_suppcode, wg_net, wg_createdat) VALUES ('$varget_poNumber', '$varget_poVlpn', '$varget_poSuppcode','$varget_poWgNet', NOW())";//TIMESTAMPADD(SECOND,1,'$varget_poTime')
            $sqlres_insertCalcWg2T = mysqli_query($dbConn, $sqlcmd_insertCalcWg2T);

            if ($sqlres_insertCalcWg2T) {
                echo "<script>alert('คำนวณน้ำหนักแล้ว')</script>";
                echo "<script>window.location.href='poMgrAll.php?poNumber=" . $varget_poNumber . "'</script>";
            } else {
                echo $sqlcmd_insertCalcWg2T;
                echo "<br>";
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }

            break;
    }
}