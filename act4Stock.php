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
$varpost_receivedReason = filter_input(INPUT_POST, 'receivedReason');
$varpost_loadedReason = filter_input(INPUT_POST, 'loadedReason');

//INPUT FROM BUY PROCESS
$varpost_poNumberBuy = filter_input(INPUT_POST, 'poNumberBuy');
$varpost_poProductBuy = filter_input(INPUT_POST, 'poProductBuy');
$varpost_poWeightBuy = filter_input(INPUT_POST, 'poWeightBuy');

//INPUT FROM SELL PROCESS
$varpost_soNumberSell = filter_input(INPUT_POST, 'soNumberSell');
$varpost_soProductSell = filter_input(INPUT_POST, 'soProductSell');
$varpost_soWeightSell = filter_input(INPUT_POST, 'soWeightSell');

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'updateStock':
            /*
             * UPDATE STOCK BY CHECKING
             */
            $chkProdInStock = countDB("tbl_stocks", "stock_product", $varpost_productCode, 2);
            if ($chkProdInStock == 0) {
                $sqlcmd_updateStock = "INSERT INTO tbl_stocks (stock_product, stock_type,stock_weight, stock_updated) VALUES ('$varpost_productCode', '0',$varpost_productWeight, NOW())";
            } else {
                $sqlcmd_updateStock = "UPDATE tbl_stocks SET stock_weight =" . $varpost_productWeight . ", stock_type='0' WHERE stock_product = '$varpost_productCode'";
            }
            $sqlres_updateStock = mysqli_query($dbConn, $sqlcmd_updateStock);

            if ($sqlres_updateStock) {
                writeLogStock("UPDATE STOCK, CHECKED", " PRODUCT: " . $varpost_productCode . ", WEIGHT: " . $varpost_productWeight . " KG");
                echo "<script>alert('อัพเดตข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='stockChk.php'</script>";
            } else {
                echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;

        case "stockReceived":
            $getLastWeight = getValue("tbl_stocks", "stock_product", $varpost_productCode, 2, "stock_weight");
            $totalWeight = $getLastWeight + $varpost_productWeight;

            $sqlcmd_updateStock = "UPDATE tbl_stocks SET stock_weight =" . $totalWeight . ", stock_type='0' WHERE stock_product = '$varpost_productCode'";
            $sqlres_updateStock = mysqli_query($dbConn, $sqlcmd_updateStock);

            if ($sqlres_updateStock) {
                writeLogStock("UPDATE STOCK, RECEIVED", " PRODUCT: " . $varpost_productCode . ", WEIGHT: " . $varpost_productWeight . " KG, REASON: " . $varpost_receivedReason);
                echo "<script>alert('อัพเดตข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='stockChk.php'</script>";
            } else {
                echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;

        case "stockLoaded":
            $getLastWeight = getValue("tbl_stocks", "stock_product", $varpost_productCode, 2, "stock_weight");
            $totalWeight = $getLastWeight - $varpost_productWeight;

            $sqlcmd_updateStock = "UPDATE tbl_stocks SET stock_weight =" . $totalWeight . ", stock_type='0' WHERE stock_product = '$varpost_productCode'";
            $sqlres_updateStock = mysqli_query($dbConn, $sqlcmd_updateStock);

            if ($sqlres_updateStock) {
                writeLogStock("UPDATE STOCK, LOADED", " PRODUCT: " . $varpost_productCode . ", WEIGHT: " . $varpost_productWeight . " KG, REASON: " . $varpost_loadedReason);
                echo "<script>alert('อัพเดตข้อมูลแล้ว')</script>";
                echo "<script>window.location.href='stockChk.php'</script>";
            } else {
                echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;

        case "stockBuy":
//            echo "<pre>";
//            var_dump($_POST);
//            echo "</pre>";
            $getLastWeight = getValue("tbl_stocks", "stock_product", $varpost_poProductBuy, 2, "stock_weight");
            $totalWeight = $getLastWeight + $varpost_poWeightBuy;

            $sqlcmd_updateStock = "UPDATE tbl_stocks SET stock_weight =" . $totalWeight . ", stock_type='0' WHERE stock_product = '$varpost_poProductBuy'";
            $sqlres_updateStock = mysqli_query($dbConn, $sqlcmd_updateStock);

            if ($sqlres_updateStock) {
                $sqlcmd_buy2Stock = "UPDATE tbl_wg4buy SET wg_instock='1' WHERE wg_ponum='" . $varpost_poNumberBuy . "' AND wg_product='" . $varpost_poProductBuy . "'";
                $sqlres_buy2Stock = mysqli_query($dbConn, $sqlcmd_buy2Stock);
                if ($sqlres_buy2Stock) {
                    logEvent("UPDATE STOCK, BUY PRODUCT: " . $varpost_poProductBuy . ", BUY WEIGHT: " . $varpost_poWeightBuy . " KG");
                    writeLogStock("UPDATE STOCK, BOUGHT", " PRODUCT: " . $varpost_poProductBuy . ", WEIGHT: " . $varpost_poWeightBuy . " KG");
//                    echo "<script>alert('อัพเดตข้อมูลแล้ว')</script>";
//                    echo "<script>window.location.href='stockChk.php'</script>";
                } else {
                    echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
                }
            } else {
                echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            break;

        case "stockSell":
            $getLastWeight = getValue("tbl_stocks", "stock_product", $varpost_soProductSell, 2, "stock_weight");
            $totalWeight = $getLastWeight - $varpost_soWeightSell;

            $sqlcmd_updateStock = "UPDATE tbl_stocks SET stock_weight =" . $totalWeight . ", stock_type='0' WHERE stock_product = '$varpost_soProductSell'";
            $sqlres_updateStock = mysqli_query($dbConn, $sqlcmd_updateStock);

            if ($sqlres_updateStock) {
                $sqlcmd_sell2Stock = "UPDATE tbl_wg4sell SET wg_outstock='1' WHERE wg_sonum='" . $varpost_soNumberSell . "' AND wg_code4product='" . $varpost_soProductSell . "'";
                $sqlres_sell2Stock = mysqli_query($dbConn, $sqlcmd_sell2Stock);
                if ($sqlres_sell2Stock) {
                    logEvent("UPDATE STOCK, SELL PRODUCT: " . $varpost_soProductSell . ", BUY WEIGHT: " . $varpost_soWeightSell . " KG");
                    writeLogStock("UPDATE STOCK, SALE", " PRODUCT: " . $varpost_soProductSell . ", WEIGHT: " . $varpost_soWeightSell . " KG");
//                    echo "<script>alert('อัพเดตข้อมูลแล้ว')</script>";
//                    echo "<script>window.location.href='stockChk.php'</script>";
                } else {
                    echo "ERROR!!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
                }
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