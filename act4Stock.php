<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

/* AUTHORIZED CHECK FOR THIS PAGE */
/*
$pageLevel = 1;
$chkToken = 0;
if (empty($_SESSION["USERLOGINNAME"])) {
    echo "<script>alert(\"ยังไม่ได้เข้าระบบ\")</script>";
    echo "<script>window.location.href=\"./userLogin.php\"</script>";
} else {
    $cntLogin = countDB("tbl_logintoken", "login_user", $_SESSION["USERLOGINNAME"], 2);
    $maxLogin = intval(getMaxLogin());
    list($userLevel, $userToken) = explode("bXd", $_SESSION["USERLOGINTOKEN"]);
    if ($userLevel !== '999') {
        if (intval($userLevel) <= $pageLevel) {
            echo "<script>alert(\"ผู้ใช้ไม่มีสิทธิ์เข้าหน้านี้\")</script>";
            echo "<script>window.location.href=\"./index.php\"</script>";
        } else {
            $sqlcmd_chkLoginToken = "SELECT * FROM tbl_logintoken WHERE login_user='" . $_SESSION['USERLOGINNAME'] . "'  ORDER BY login_time DESC LIMIT " . $maxLogin;
            $sqlres_chkLoginToken = mysqli_query($dbConn, $sqlcmd_chkLoginToken);

            if ($sqlres_chkLoginToken) {
                while ($sqlfet_chkLoginToken = mysqli_fetch_assoc($sqlres_chkLoginToken)) {
                    if ($sqlfet_chkLoginToken['login_token'] === $userToken) {
                        $chkToken += 1;
                    }
                }
            } else {
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            if ($chkToken === 0) {
                session_unset();
                session_destroy();
                echo "<script>alert(\"รหัสผู้ใช้เข้าสู่ระบบจากเครื่องอื่นค้างอยู่\\nให้เข้าสู่ระบบใหม่\")</script>";
                echo "<script>window.location.href=\"./userLogin.php\"</script>";
            }
        }
    }
}
*//* AUTHORIZED CHECK FOR THIS PAGE */

$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_stockNumber = filter_input(INPUT_POST, 'stockNumber');
$varpost_productCode = filter_input(INPUT_POST, 'productCode');
$varpost_productWeight = filter_input(INPUT_POST, 'productWeight');

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'updateStock':
//            echo "<pre>";
//            var_dump($_POST);
//            echo "</pre>";
            $sqlcmd_updateStock = "INSERT INTO tbl_stocks (stock_product, stock_weight, stock_updated) VALUES ('$varpost_productCode', $varpost_productWeight, NOW())";
            $sqlres_updateStock = mysqli_query($dbConn, $sqlcmd_updateStock);

            if ($sqlres_updateStock) {
                echo "<script>alert('อัพเดตข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='stockChk.php'</script>";
            } else {
                echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;

        case 'lastCheckedProductInStock':
            $sqlcmd_lastChecked = "SELECT * FROM tbl_stocks WHERE stock_product='" . $varpost_productCode . "' ORDER BY DATE(stock_updated) DESC LIMIT 1";
            $sqlres_lastChecked = mysqli_query($dbConn, $sqlcmd_lastChecked);

            if ($sqlres_lastChecked) {
                $sqlfet_lastChecked = mysqli_fetch_assoc($sqlres_lastChecked);
                echo $sqlfet_lastChecked['updated'] . "_" . $sqlfet_lastChecked['stock_weight'];
            } else {
                echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;
    }
}