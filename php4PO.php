<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$varget_command = filter_input(INPUT_GET, 'command');
$varget_field2Query = filter_input(INPUT_GET, 'field2Query');
$varget_fieldReturn = filter_input(INPUT_GET, 'fieldReturn');
$varget_field2Show = filter_input(INPUT_GET, 'field2Show');
$varget_fieldValue = filter_input(INPUT_GET, 'fieldValue');

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

$varpost_processName = filter_input(INPUT_POST, 'processName');

switch ($varpost_processName) {
    case 'genPONumber':
        $poNumber = '';
//        $sqlcmd_cntPOToday = "SELECT * FROM tbl_purchaseorder WHERE DATE(po_createdat)='" . $dateNow . "'";
        $sqlcmd_cntPOToday = "SELECT * FROM tbl_wg4buy WHERE DATE(wg_createdat)='" . $dateNow . "'";
        $sqlres_cntPOToday = mysqli_query($dbConn, $sqlcmd_cntPOToday);
        if ($sqlres_cntPOToday) {
            $sqlnum_cntPOToday = mysqli_num_rows($sqlres_cntPOToday);
            $poNumber = str_replace("-", "", $dateNow) . str_pad(($sqlnum_cntPOToday + 1), 3, "0", STR_PAD_LEFT) . str_replace(":", "", $timeNow);
        } else {
            echo "Error!!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
        }
        echo $poNumber;
        break;
}

if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'query4po':
//            $sqlcmd = "SELECT * FROM tbl_purchaseorder WHERE " . $varget_fieldReturn . "='" . $varget_fieldValue . "'";
            $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
            $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
            $sqlcmd = "SELECT wg_ponum, wg_suppcode, wg_vlpn FROM tbl_wg4buy WHERE " . $varget_fieldReturn . "='" . $varget_fieldValue . "' AND po_status=1 GROUP BY wg_ponum";
            //echo $sqlcmd;
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                $sqlnum = mysqli_num_rows($sqlres);
                if ($sqlnum == 1) {
                    $sqlfet = mysqli_fetch_assoc($sqlres);
                    if ($varget_field2Show == 'wg_suppcode') {
                        echo getValue('tbl_suppliers', 'supp_code', $sqlfet[$varget_field2Show], 2, 'supp_name');
                        echo " ";
                        echo getValue('tbl_suppliers', 'supp_code', $sqlfet[$varget_field2Show], 2, 'supp_surname');
                    } else {
                        echo $sqlfet[$varget_field2Show];
                    }
                } else if ($sqlnum == 0) {
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
    }
}
