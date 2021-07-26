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
if($varget_fieldReturn=='po_suppcode'){
    $varget_fieldValue = getValue('tbl_suppliers', 'supp_name', $varget_fieldValue, 2, 'supp_code');
}
# unicode

$varget_suppName = filter_input(INPUT_GET, 'suppName');

$varpost_processName = filter_input(INPUT_POST, 'processName');

switch ($varpost_processName) {
    case 'genPONumber':
        $poNumber = '';
        $sqlcmd_cntPOToday = "SELECT * FROM tbl_purchaseorder WHERE DATE(po_createdat)='" . $dateNow . "'";
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
            $sqlcmd = "SELECT * FROM tbl_purchaseorder WHERE " . $varget_fieldReturn . "='" . $varget_fieldValue . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                $sqlnum = mysqli_num_rows($sqlres);
                if ($sqlnum == 1) {
                    $sqlfet = mysqli_fetch_assoc($sqlres);
                    if ($varget_field2Show == 'po_suppcode') {
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
    }
}

function je2utf8($jed)
{
    return preg_replace("/(\\\|%)u([0-9A-F]{4})/e", "ncr_utf8_2('&#x\\2;')", $jed);
}

function je2utf8_2($jed)
{
    return preg_replace("/(\\\|%)u([A-Z0-9]{4})/e","mb_convert_encoding(('&#'.hexdec('\\2').';'), 'UTF-8','HTML-ENTITIES')", $jed);
}