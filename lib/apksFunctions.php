<?php
date_default_timezone_set('Asia/Bangkok');
$dateNow = date('Y-m-d');
$timeNow = date('H:i:s');

$baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;

if (file_exists($baseDir . "apksDBConf.json")) {
//    echo "file existing...<br>";
    $db_param = file_get_contents($baseDir . "apksDBConf.json");

    $db_param = json_decode($db_param);

    $db_host = $db_param->db_host;
    $db_user = $db_param->db_user;
    $db_pass = $db_param->db_pass;
    $db_name = $db_param->db_name;
    $db_port = $db_param->db_port;
    $db_char = $db_param->db_char;
} else {
    echo "No existing files plese create...<br>";
}

function dbConnect()
{
    $conn = mysqli_connect($GLOBALS['db_host'], $GLOBALS['db_user'], $GLOBALS['db_pass'], $GLOBALS['db_name'], $GLOBALS['db_port']);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
//        echo "Connect OK";
        $conn->set_charset($GLOBALS['db_char']);
        return $conn;
    }
}

function insertDB($tblName, $colName, $colValue, $colType)
{
    $dbConnect = dbConnect();
    $sqlcmd = '';

    if ($colType == 1)
        $sqlcmd = "INSERT INTO " . $tblName . " (" . $colName . ") VALUES (" . $colValue . ")";
    else if ($colType == 2)
        $sqlcmd = "INSERT INTO " . $tblName . " (" . $colName . ") VALUES ('" . $colValue . "')";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        // Do nothing...
    } else {
        echo "ERROR : " . mysqli_error($dbConnect);
        echo "<br>" . $sqlcmd . "<br>";
    }
}

// dataType 1:int, 2:char or string, 3:timestamp
function updateDB($tblName, $refColumn, $refValue, $refType, $colName, $colValue, $dataType)
{
    $dbConnect = dbConnect();
    $sqlcmd = '';

    $errProtect = ($refType * 10) + $dataType;
    switch ($errProtect) {
        case 11:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "=" . $colValue . " WHERE " . $refColumn . "=" . $refValue;
            break;
        case 12:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "='" . $colValue . "' WHERE " . $refColumn . "=" . $refValue;
            break;
        case 21:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "=" . $colValue . " WHERE " . $refColumn . "='" . $refValue . "'";
            break;
        case 22:
            $sqlcmd = "UPDATE " . $tblName . " SET " . $colName . "='" . $colValue . "' WHERE " . $refColumn . "='" . $refValue . "'";
            break;
    }

    $sqlres = mysqli_query($dbConnect, $sqlcmd);
    if ($sqlres) {
        // Do nothing...
        // echo "<br><br><br><br><br><br>" . $sqlcmd . "<br>";
        // echo "[QQQQQ]" . $sqlcmd . "[PPPPP]";
    } else {
        echo "ERROR : " . $colName . " | " . mysqli_error($dbConnect);
        echo "<br>" . $sqlcmd . "<br>";
    }
}

function deleteDB($tblName, $refColumn, $refValue, $refType)
{
    $dbConnect = dbConnect();
    $sqlcmd = '';

    if ($refType == 1)
        $sqlcmd = "DELETE FROM " . $tblName . " WHERE " . $refColumn . "=" . $refValue;
    else if ($refType == 2)
        $sqlcmd = "DELETE FROM " . $tblName . " WHERE " . $refColumn . "='" . $refValue . "'";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        // Do nothing...
    } else {
        echo "ERROR : " . mysqli_error($dbConnect);
        echo "<br>" . $sqlcmd . "<br>";
    }
}

function countDB($tblName, $refColumn, $refValue, $refType)
{
    $dbConnect = dbConnect();
    $sqlcmd = '';

    switch ($refType) {
        case 1:
            $sqlcmd = "SELECT COUNT(*) AS cntDB FROM " . $tblName . " WHERE " . $refColumn . "=" . $refValue;
            break;

        case 2:
            $sqlcmd = "SELECT COUNT(*) AS cntDB FROM " . $tblName . " WHERE " . $refColumn . "='" . $refValue . "'";
//            echo $sqlcmd;
            break;

        default:
            break;
    }
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['cntDB'];
    } else {
        echo "ERROR : " . mysqli_error($dbConnect);
        //echo "<br>" . $sqlcmd . "<br>";
    }
}

function countAllRow($tblName)
{
    $dbConnect = dbConnect();
    $sqlcmd = "SELECT * FROM " . $tblName . " WHERE 1";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        $sqlnum = mysqli_num_rows($sqlres);
        return $sqlnum;
    } else {
        echo "ERROR : " . mysqli_error($dbConnect);
        echo "<br>" . $sqlcmd . "<br>";
    }
}

function getValue($tblName, $refColumn, $refValue, $refType, $colName)
{
    $dbConnect = dbConnect();

    if ($refType == 1)
        $sqlcmd = "SELECT * FROM " . $tblName . " WHERE " . $refColumn . "=" . $refValue;
    else if ($refType == 2)
        $sqlcmd = "SELECT * FROM " . $tblName . " WHERE " . $refColumn . "='" . $refValue . "'";
    $sqlres = mysqli_query($dbConnect, $sqlcmd);

    if ($sqlres) {
        // echo $sqlcmd;
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet[$colName];
    } else {
        return "ERROR : " . mysqli_error($dbConnect);
        return "<br>" . $sqlcmd . "<br>";
    }
}

function writeLog($logType, $logText)
{

    $logFolder = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "log" . DIRECTORY_SEPARATOR;

    $log2Write = $GLOBALS['dateNow'] . " " . $GLOBALS['timeNow'] . ", " . $logType . ", " . $logText;

    file_put_contents($logFolder . $GLOBALS['dateNow'] . ".log", $log2Write . "\n", FILE_APPEND);
}

function writeLogStock($logType, $logText)
{

    $logFolder = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . "log" . DIRECTORY_SEPARATOR;

    $log2Write = $GLOBALS['dateNow'] . " " . $GLOBALS['timeNow'] . ", " . $logType . ", " . $logText;

    file_put_contents($logFolder . $GLOBALS['dateNow'] . "_STOCK.log", $log2Write . "\n", FILE_APPEND);
}

function logEvent($eventValue)
{
    date_default_timezone_set('Asia/Bangkok');
    $dbConn = dbConnect();

    $sqlcmd = "SELECT * FROM tbl_events WHERE DATE(event_timestamp)='" . date("Y-m-d") . "'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlnum = mysqli_num_rows($sqlres);

        $eventCode = str_replace("-", "", date("Y-m-d")) . str_replace(":", "", date("H:i:s"));

        $sqlcmd_update = "INSERT INTO tbl_events (event_code, event_value, event_timestamp) VALUES ('$eventCode', '$eventValue', NOW())";
        $sqlres_update = mysqli_query($dbConn, $sqlcmd_update);

        if (!$sqlres_update) {
            return "ERROR : " . mysqli_error($dbConn);
        }

        return 0;
    } else {
        return "ERROR : " . mysqli_error($dbConn);
    }
}

//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDiff($date_1, $date_2, $differenceFormat = '%y, %m, %d')
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}

function dateBE($dateAD)
{
    list($yy, $mm, $dd) = explode('-', $dateAD);
    return ($yy + 543) . "-" . $mm . "-" . $dd;
}

function dateAD($dateBE)
{
    list($yy, $mm, $dd) = explode('-', $dateBE);
    return ($yy - 543) . "-" . $mm . "-" . $dd;
}

function monthThai($dateBE)
{
    list($yy, $mm, $dd) = explode('-', $dateBE);
    $mm = str_replace(
        array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'),
        array('ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'),
        $mm
    );
    return number_format($dd) . " " . $mm . " " . $yy;
}

function confParam($confFolder, $confFile, $retParam)
{
    $confParam = dirname(dirname(__FILE__) . DIRECTORY_SEPARATOR);

    $confParam .= DIRECTORY_SEPARATOR . $confFolder . DIRECTORY_SEPARATOR . $confFile;

    if (file_exists($confParam)) {
        $parameter = file_get_contents($confParam);
        $parameter = json_decode($parameter);

        return $parameter->$retParam;
    } else {
        return '';
    }
}

// Generate token
function getToken($length)
{
    $token = '';
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max - 1)];
    }

    return $token;
}

/* ABOUT USER */
function cntUserLogin($nameTable, $loginUser)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT * FROM " . $nameTable . " WHERE login_user='" . $loginUser . "'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlnum = mysqli_num_rows($sqlres);
        return $sqlnum;
    } else {
        return "ERROR : " . mysqli_error($dbConn);
        return "<br>[" . $sqlcmd . "]<br>";
    }
}

/* ABOUT USER */

/* --------------------------------------- */
// Function only use for GoldRubber's project
function calcWgMinusWater4PO($poNumber)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT FORMAT(SUM(CEILING((wg_net - ROUND((((97-wg_percent)*wg_net)/100))))),2) AS MINUSWATER FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' AND wg_product<>'0000'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        if (empty($sqlfet['MINUSWATER']))
            echo "ไม่มีข้อมูล";
        else
            return $sqlfet['MINUSWATER'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function calcWgWithBuyPrice($poNumber)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT SUM(ROUND(wg_buyprc*(CEILING(wg_net - ROUND((((97-wg_percent)*wg_net)/100)))),2)) AS BUYPRICE FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' AND wg_product<>'0000'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        if (empty($sqlfet['BUYPRICE']))
            echo "ไม่มีข้อมูล";
        else
            return $sqlfet['BUYPRICE'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function sumWg4PO($poNumber)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT SUM(wg_scalerd) AS SUMALL FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['SUMALL'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function sumWgNoCar($poNumber)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT SUM(wg_scalerd) AS SUMNOCAR FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' AND wg_product <> '0000'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['SUMNOCAR'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function sumWgBuyTypeProduct($date2calc, $buytype, $product)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT SUM(wg_net) AS WGSUM FROM tbl_wg4buy WHERE DATE(wg_createdAt)='" . $date2calc . "' AND wg_buytype='" . $buytype . "' AND wg_product='" . $product . "'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['WGSUM'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function sumWgByProductDate($date2calc, $product)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT SUM(wg_net) AS WGSUM FROM tbl_wg4buy WHERE DATE(wg_createdAt)='" . $date2calc . "' AND wg_product='" . $product . "' AND wg_product<>'0000'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['WGSUM'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function sumWgByBuyTypeDate($date2calc, $buytype)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT SUM(wg_net) AS WGSUM FROM tbl_wg4buy WHERE DATE(wg_createdAt)='" . $date2calc . "' AND wg_buytype='" . $buytype . "' AND wg_product<>'0000'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['WGSUM'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function sumWgAllDate($date2calc)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT SUM(wg_net) AS SUMALL4DATE FROM tbl_wg4buy WHERE DATE(wg_createdat)='" . $date2calc . "' AND wg_product<>'0000'";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet['SUMALL4DATE'];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

function getLastRecord($tblName, $condCol, $condVal, $orderCol, $retCol)
{
    $dbConn = dbConnect();

    $sqlcmd = "SELECT * FROM " . $tblName . " WHERE " . $condCol . "='" . $condVal . "' ORDER BY " . $orderCol . " DESC LIMIT 1";
    $sqlres = mysqli_query($dbConn, $sqlcmd);

    if ($sqlres) {
        $sqlfet = mysqli_fetch_assoc($sqlres);
        return $sqlfet[$retCol];
    } else {
        echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
    }
}

// Function only use for GoldRubber's project
/* --------------------------------------- */


function getMaxLogin()
{
    $baseDir = dirname(__FILE__) . DIRECTORY_SEPARATOR;
    if (file_exists($baseDir . "globalVariables.json")) {
        $gb_variable = file_get_contents($baseDir . "globalVariables.json");

        $gb_variable = json_decode($gb_variable);

        $gb_maxLogin = $gb_variable->gb_maxLogin;

        return $gb_maxLogin;
    } else {
        echo "No existing files plese create...<br>";
    }
}