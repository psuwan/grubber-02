<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

/* OK for SO variables */
$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_vehicleOwner = filter_input(INPUT_POST, 'vehicleOwner');
/* OK for SO variables */

/* GET VARIABLEs */
$varget_command = filter_input(INPUT_GET, 'command');
$varget_soNumber = filter_input(INPUT_GET, 'soNumber');

// USE FOR CASE "getSONumber4SuppLogis"
$varget_suppLogisCode = filter_input(INPUT_GET, 'code4SuppLogis');

$varget_field2Query = filter_input(INPUT_GET, 'field2Query');
$varget_fieldReturn = filter_input(INPUT_GET, 'fieldReturn');
$varget_field2Show = filter_input(INPUT_GET, 'field2Show');
$varget_fieldValue = filter_input(INPUT_GET, 'fieldValue');
/* GET VARIABLEs */

# unicode
$varget_fieldValue = trim($varget_fieldValue);
$unescaped = str_replace("%u", "\u", $varget_fieldValue);
$varget_fieldValue = json_decode('"' . $unescaped . '"');
if ($varget_fieldReturn == 'wg_suppcode') {
    $varget_fieldValue = getValue('tbl_suppliers', 'supp_name', $varget_fieldValue, 2, 'supp_code');
}
# unicode
$varget_suppName = filter_input(INPUT_GET, 'suppName');
$varget_vlpn2Check = filter_input(INPUT_GET, 'vlpn');
$varget_wgScaleCode = filter_input(INPUT_GET, 'wgSCaleCode');

/* WORKING WITH POST */
switch ($varpost_processName) {
    case "genSONumber":
        $soNumber = '';
        $sqlcmd_cntSOToday = "SELECT * FROM tbl_wg4sell WHERE DATE(wg_createdat)='" . $dateNow . "'";
        $sqlres_cntSOToday = mysqli_query($dbConn, $sqlcmd_cntSOToday);
        if ($sqlres_cntSOToday) {
            $sqlnum_cntSOToday = mysqli_num_rows($sqlres_cntSOToday);
            $soNumber = str_replace("-", "", $dateNow) . str_pad(($sqlnum_cntSOToday + 1), 3, "0", STR_PAD_LEFT) . str_replace(":", "", $timeNow);
        } else {
            echo "Error!!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
        }
        echo $soNumber;
        break;

    case "listVlpn4SuppLogis":
        $sqlcmd_listVlpn = "SELECT supplogis_vlpn FROM tbl_supplogis WHERE supplogis_name='" . $varpost_vehicleOwner . "'";
        $sqlres_listVlpn = mysqli_query($dbConn, $sqlcmd_listVlpn);

        $listVlpn = array();

        foreach ($sqlres_listVlpn as $val)
            $listVlpn[] = $val;

        echo json_encode($listVlpn);
        break;
}/* WORKING WITH POST */

/* WORKING WITH GET */
if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'query4SO':
            $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
            $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
            $sqlcmd = "SELECT wg_sonum, wg_code4supplogis, wg_vlpn, wg_code4customer FROM tbl_wg4sell WHERE " . $varget_fieldReturn . "='" . $varget_fieldValue . "' AND so_status=1 GROUP BY wg_sonum";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                $sqlnum = mysqli_num_rows($sqlres);
                if ($sqlnum === 1) {
                    $sqlfet = mysqli_fetch_assoc($sqlres);
                    if ($varget_field2Show === 'wg_vlpn') {
                        $suppLogisName = getValue("tbl_supplogis", "supplogis_vlpn", $sqlfet[$varget_field2Show], 2, "supplogis_name");
                        echo $sqlfet[$varget_field2Show] . "/" . $suppLogisName;
                    } elseif ($varget_field2Show === 'wg_code4customer') {
                        //$customerName = getValue("tbl_customers", "customer_code", $sqlfet[$varget_field2Show], 2, "customer_name");
                        echo $sqlfet[$varget_field2Show];
                    }
                } else if ($sqlnum === 0) {
                    echo "ไม่พบผู้ขาย";
                } else {
                    echo "ผิดพลาดไม่รู้ที่มา!!! แจ้งผู้พัฒนาโปรแกรม";
                }
            }
            break;

        case 'getSuppCode':
            $sqlcmd = "SELECT * FROM tbl_suppliers WHERE supp_name='" . $varget_suppName . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                $sqlfet = mysqli_fetch_assoc($sqlres);
                echo $sqlfet['supp_code'];
            }
            break;

        case 'checkVLPN':
//            $sqlcmd = "SELECT * FROM tbl_purchaseorder WHERE po_vlpn='" . $varget_vlpn2Check . "' AND po_status=1";
            $sqlcmd = "SELECT * FROM tbl_wg4buy WHERE wg_vlpn='" . $varget_vlpn2Check . "' AND po_status=1";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                $sqlnum = mysqli_num_rows($sqlres);
                if ($sqlnum == 0) {
                    echo "0";
                } else {
                    echo "1";
                }
            }
            break;

        case 'checkWgScaleLevel':
            echo getValue('tbl_wgscale', 'wgscale_code', $varget_wgScaleCode, 2, 'wgscale_level');
            break;

        // 20210908083300 GET WEIGHT FROM SELL ORDER DETAILS
        case "getWeight4SO":
            echo getValue("tbl_sellorder", "so_number", $varget_soNumber, 2, "so_wgordered");
            break;

        // 20210908163500 GET SO-NUMBER FOR SUPPLIER LOGISTIC
        case "getSONumber4SuppLogis":
            $code4SuppLogis = getValue("tbl_supplogis", "supplogis_vlpn", $varget_suppLogisCode, 2, "supplogis_code");
            $soNumber4Supplogis = getValue("tbl_wg4sell", "wg_code4supplogis", $code4SuppLogis, 2, "wg_sonum");
            $customer4Supplogis = getValue("tbl_wg4sell", "wg_code4supplogis", $code4SuppLogis, 2, "wg_code4customer");
            $customer4Supplogis = getValue("tbl_customers", "customer_code", $customer4Supplogis, 2, "customer_name") . " " . getValue("tbl_customers", "customer_code", $customer4Supplogis, 2, "customer_surname");
            echo $soNumber4Supplogis . " / " . $customer4Supplogis;
            break;
    }
}/* WORKING WITH GET */
