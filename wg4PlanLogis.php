<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

/* AUTHORIZED CHECK FOR THIS PAGE */
/*$pageLevel = 1;
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
}*//* AUTHORIZED CHECK FOR THIS PAGE */

// PARAMETER_FROM_SELL_PLAN
$varget_planNumber = filter_input(INPUT_GET, "planNumber");
$planSuppLogis = getValue("tbl_sellplan", "plan_number", $varget_planNumber, 2, "plan_code4supplogis");
$planSuppLogisVlpn = getValue("tbl_supplogis", "supplogis_code", $planSuppLogis, 2, "supplogis_vlpn");
$planSuppLogisOwner = getValue("tbl_supplogis", "supplogis_code", $planSuppLogis, 2, "supplogis_name");

$wgCode4WgType = filter_input(INPUT_GET, "wgType");
$wgCode4Product = filter_input(INPUT_GET, "productCode");

$varget_soNumber = filter_input(INPUT_GET, 'soNumber');
$varget_productCode = filter_input(INPUT_GET, 'productCode');
$customer_SO = getValue("tbl_sellorder", "so_number", $varget_soNumber, 2, "so_customer");
$customer_name = getValue("tbl_customers", "customer_code", $customer_SO, 2, "customer_name");
$customer_surname = getValue("tbl_customers", "customer_code", $customer_SO, 2, "customer_surname");

$wg4GetSONumber = getValue("tbl_sellorder", "so_number", $varget_soNumber, 2, "so_wgordered");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <link rel="icon" type="image/png" href="./assets/img/faviconW.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>GOLD RUBBER : WG PLAN LOGIS</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>

    <!-- Fonts and icons -->
    <!-- <link rel="stylesheet" href="./css/font.css">-->
    <link rel="stylesheet" href="./css/all.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="./css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet"/>
    <link href="./css/style4Project.css" rel="stylesheet">
</head>

<body>
<div class="wrapper ">
    <!-- Sidebar -->
    <div class="sidebar" data-color="orange">
        <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
        -->
        <?php
        require_once './fileSidebar.php';
        ?>
    </div><!-- End Sidebar -->

    <div class="main-panel" id="main-panel">
        <!-- Navbar -->
        <?php
        require_once './fileNavbar.php';
        ?>
        <!-- End Navbar -->

        <div class="panel-header h-auto" id="id4Header">
            <!--<div class="jumbotron ml-5 mr-5 display-1 text-center font-weight-bold text-warning bg-transparent d-none d-sm-block">
                บริษัท โกลด์รับเบอร์ จำกัด
            </div>
            <div class="jumbotron display-4 text-center d-block d-sm-none text-warning bg-transparent font-weight-bold">
                Gold Rubber
            </div>-->
            <h2 class="text-warning text-center"> ชั่งขึ้นรถ </h2>
        </div>
        <!-- Start of Content -->
        <div class="content" id="id4Content">
            <!-- Start of Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลปัจจุบัน </h5>
                            <h4 class="card-title"> ชั่งขึ้นรถ [ตามแผน: <?= $varget_planNumber; ?>]
                                <!--; SO
                                Number: <? /*= $varget_soNumber; */ ?>; Wg2Sell: <? /*= $wg4GetSONumber; */ ?>;
                                Product: --><? /*= $varget_productCode; */ ?></h4>
                        </div>

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form action="./act4SO.php" method="post">

                                <!-- Row #01 -->
                                <div class="row">
                                    <div class="col-md-3 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4_PONumber">เลขอ้างอิงการขาย / ลูกค้า</label>
                                            <input type="text" class="form-control"
                                                   name="SONumber" id="id4_SONumber"
                                                <?php if ($wgCode4Product == '0000') {
                                                    echo "placeholder=\"ชั่งรถไม่ต้องกรอก\" ";
                                                    echo "value=\"\" ";
                                                    echo "disabled";
                                                } else {
                                                    echo "required ";
                                                    echo "value=\"" . $varget_soNumber . " / " . $customer_name . " " . $customer_surname . "\"";
                                                }
                                                ?>
                                                   style="font-size:14px;font-weight:bold;">
                                        </div>
                                    </div>

                                    <!-- VEHICLE AND OWNER -->
                                    <div class="col-md-3 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_SOSuppLogis">รถขนส่ง / เจ้าของ</label>
                                            <input class="form-control" type="text" placeholder="รถขนส่ง / เจ้าของ"
                                                   name="SOSuppLogis" id="id4_SOSuppLogis" required readonly
                                                   style="font-size:14px;font-weight:bold;"
                                                   value="<?= $planSuppLogisVlpn . " / " . $planSuppLogisOwner; ?>">
                                        </div>
                                    </div><!-- VEHICLE AND OWNER -->

                                    <div class="col-md-2 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_PONumber">น้ำหนักตามคำสั่งขาย</label>
                                            <input type="text" class="form-control text-right text-primary"
                                                   placeholder="น้ำหนักตามคำสั่งขาย"
                                                   name="" id="id4_wgInSOPlan" disabled
                                                   value="<?= number_format($wg4GetSONumber, 2, '.', ','); ?>"
                                                   style="font-size:14px;font-weight:bold;">
                                        </div>
                                    </div>

                                    <div class="col-md-2 px-md-1">
                                        <?php
                                        $sqlcmd_wgInSellPlan4SO = "SELECT * FROM tbl_sellplan WHERE plan_number='" . $varget_planNumber . "' AND plan_code4sellorder='" . $varget_soNumber . "' AND plan_code4product='" . $varget_productCode . "'";
                                        $sqlres_wgInSellPlan4SO = mysqli_query($dbConn, $sqlcmd_wgInSellPlan4SO);
                                        if ($sqlres_wgInSellPlan4SO)
                                            $sqlfet_wgInSellPlan4SO = mysqli_fetch_assoc($sqlres_wgInSellPlan4SO);
                                        ?>
                                        <div class="form-group">
                                            <label for="id4_PONumber">น้ำหนักตามแผน</label>
                                            <input type="text" class="form-control text-right text-primary"
                                                   placeholder="น้ำหนักตามแผน"
                                                   name="" id="id4_wgInSO" disabled
                                                   value="<?= number_format($sqlfet_wgInSellPlan4SO['plan_wg4sellorder'], 2, '.', ','); ?>"
                                                   style="font-size:14px;font-weight:bold;">
                                        </div>
                                    </div>

                                    <div class="col-md-2 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_PONumber">ชั่งเพื่อส่งแล้ว</label>
                                            <input type="text" class="form-control text-right text-primary"
                                                   placeholder="ชั่งแล้ว" name="" id="" disabled value=""
                                                   style="font-size:14px;font-weight:bold;">
                                        </div>
                                    </div>

                                </div> <!-- End of Row #01 -->

                                <!-- Row #02 -->
                                <div class="row">
                                    <!-- WEIGHT TYPE -->
                                    <div class="col-md-3 pr-md-2">
                                        <label for="id4_SOWgType">ประเภทการชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="SOWgType"
                                                        id="id4_SOWgType" required>
                                                    <option value="">เลือกประเภทการชั่ง</option>
                                                    <?php
                                                    if ($wgCode4WgType === '0001') {
                                                        ?>
                                                        <option value="0001">ชั่งเข้า (รถเปล่า)</option>
                                                        <?php
                                                    } elseif ($wgCode4WgType === '0002') {
                                                        ?>
                                                        <option value="0002">ชั่งแยก (สินค้าและพาเลท)</option>
                                                        <?php
                                                    } elseif ($wgCode4WgType === '0003') {
                                                        ?>
                                                        <option value="0003">ชั่งออก (รถพร้อมสินค้า)</option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- WEIGHT TYPE -->

                                    <!-- WEIGHT SCALE -->
                                    <div class="col-md-3 px-md-2">
                                        <label for="id4_SOWgScale">เครื่องชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="SOWgScale"
                                                        id="id4_SOWgScale" required>
                                                    <option value="">เลือกเครื่องชั่ง</option>
                                                    <?php
                                                    $sqlcmd_listWgScale = "SELECT * FROM tbl_wgscale WHERE 1 ORDER BY wgscale_code";
                                                    $sqlres_listWgScale = mysqli_query($dbConn, $sqlcmd_listWgScale);
                                                    if ($sqlres_listWgScale) {
                                                        while ($sqlfet_listWgScale = mysqli_fetch_assoc($sqlres_listWgScale)) {
                                                            ?>
                                                            <option value="<?= $sqlfet_listWgScale['wgscale_code']; ?>"><?= $sqlfet_listWgScale['wgscale_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- WEIGHT SCALE -->

                                    <!-- IN THE FUTURE IF NEED TO SEPARATED PRODUCT TO SELL -->
                                    <div class="col-md-3 px-md-1">
                                        <label for="id4POProduct">สินค้าที่ชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="SOProduct"
                                                        id="id4_SOProduct">
                                                    <option value="">เลือกสินค้า</option>
                                                    <!--<option value="0000">ชั่งรถ</option>-->
                                                    <?php
                                                    $sqlcmd_listWgScale = "SELECT * FROM tbl_products WHERE 1 ORDER BY product_order";
                                                    $sqlres_listWgScale = mysqli_query($dbConn, $sqlcmd_listWgScale);
                                                    if ($sqlres_listWgScale) {
                                                        while ($sqlfet_listWgScale = mysqli_fetch_assoc($sqlres_listWgScale)) {
                                                            ?>
                                                            <option value="<?= $sqlfet_listWgScale['product_code']; ?>" <?php if ($sqlfet_listWgScale['product_code'] == $varget_productCode) echo "selected"; ?>><?= $sqlfet_listWgScale['product_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- IN THE FUTURE IF NEED TO SEPARATED PRODUCT TO SELL -->

                                </div><!-- End of Row #02 -->

                                <!-- IN THE FUTURE IF NEED TO SEPARATED PRODUCT TO SELL -->
                                <!-- Row for pallet weight -->
                                <div class="row mt-5 h4 font-weight-bold text-muted" id="div4WgPallet">
                                    <div class="col-md-5 pr-md-1 my-2" id="div4Txt">
                                        <div class="form-group text-right">
                                            จำนวนพาเลท
                                        </div>
                                    </div>
                                    <div class="col-md-1 px-md-1" id="div4WgShow">
                                        <div class="form-group">
                                            <input type="number" class="form-control" placeholder="0"
                                                   name="cntPallet" id="id4CntPallet" required
                                                   value="" style="text-align: right;" onchange="calcWgNet();"
                                                   onkeyup="calcWgNet();">
                                        </div>
                                    </div>
                                    <div class="col-md-1 px-md-1 text-md-left my-2" id="div4Unit1">
                                        <div class="form-group">
                                            แผง
                                        </div>
                                    </div>

                                    <div class="col-md-2 px-md-1 my-2" id="div4Txt">
                                        <div class="form-group text-right">
                                            น้ำหนักพาเลท (ต่อแผง)
                                        </div>
                                    </div>
                                    <div class="col-md-2 px-md-1" id="div4WgShow">
                                        <div class="form-group">
                                            <input type="text" class="form-control" placeholder="0"
                                                   name="wg4Pallet" id="id4Wg4Pallet" pattern="^\d*(\.\d{0,2})?$"
                                                   value="" style="text-align: right;" onchange="calcWgNet();"
                                                   onkeyup="calcWgNet();">
                                        </div>
                                    </div>
                                    <div class="col-md-1 pl-md-1 my-2" id="div4Unit1">
                                        <div class="form-group">
                                            กก.
                                        </div>
                                    </div>
                                </div><!-- End of row for pallet weight -->
                                <!-- IN THE FUTURE IF NEED TO SEPARATED PRODUCT TO SELL -->

                                <!-- Row #03 --><!-- WEIGHTING -->
                                <div class="row h4 mt-5 font-weight-bold text-muted" style="vertical-align: center;"
                                     id="div4Wg">
                                    <div class="col-md-7 pr-md-1 my-4" id="div4Txt">
                                        <div class="form-group text-right">
                                            น้ำหนักที่ชั่งได้
                                        </div>
                                    </div>
                                    <div class="col-md-4 px-md-1" id="div4WgShow">
                                        <div class="form-group">
                                            <!-- <label for="id4SuppAmphoe" style="text-decoration: none;">น้ำหนักที่ชั่งได้</label>-->
                                            <!-- 2 Decmial tested --><!--  pattern="^\d*(\.\d{0,2})?$" -->
                                            <input type="text" class="form-control font-weight-bold text-primary h3"
                                                   placeholder="0.00"
                                                   name="wgScaleRd" id="id4WgScaleRd" required
                                                   value="" style="text-align: right;" onchange="calcWgNet();"
                                                   onkeyup="calcWgNet();">
                                        </div>
                                    </div>
                                    <div class="col-md-1 pl-md-1 text-left my-4" id="div4Unit1">
                                        <div class="form-group">
                                            กก.
                                        </div>
                                    </div>
                                </div><!-- WEIGHTING --><!-- End of Row #03 -->

                                <!-- Row for net weight --><!-- WEIGHTING -->
                                <div class="row h4 mt-5 font-weight-bold text-muted" id="div4Wg">
                                    <div class="col-md-7 pr-md-1 my-4" id="div4Txt">
                                        <div class="form-group text-right">
                                            น้ำหนักสุทธิ
                                        </div>
                                    </div>
                                    <div class="col-md-4 px-md-1" id="div4WgShow">
                                        <div class="form-group">
                                            <!-- <label for="id4SuppAmphoe" style="text-decoration: none;">น้ำหนักที่ชั่งได้</label>-->
                                            <input type="text" class="form-control font-weight-bold text-primary h3"
                                                   placeholder="0.00"
                                                   name="wgScaleNet" id="id4WgScaleNet" required
                                                   value="" style="text-align: right;">
                                        </div>
                                    </div>
                                    <div class="col-md-1 pl-md-1 text-left my-4" id="div4Unit1">
                                        <div class="form-group">
                                            กก.
                                        </div>
                                    </div>
                                </div><!-- WEIGHTING --><!-- End of row for net weight -->

                                <br>
                                <!-- Button "Reset" and "Submit" -->
                                <div class="row d-flex justify-content-center">
                                    <div class="button-container">
                                        <button type="reset" class="btn btn-outline-primary btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons loader_refresh spin"></i> ล้างข้อมูล
                                        </button>
                                        &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-outline-success btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons arrows-1_cloud-upload-94"></i> บันทึก
                                        </button>
                                    </div>
                                </div><!-- Button "Reset" and "Submit" -->

                                <!-- Hidden -->
                                <input type="hidden" name="wgPlanNumber" value="<?= $varget_planNumber; ?>">
                                <input type="hidden" name="processName" value="addWg4SOInPlan">

                            </form><!-- End of form -->
                        </div><!-- Card body -->
                    </div>
                </div>
            </div><!-- End of Row -->

        </div><!-- End of Content -->

        <!-- Footer -->
        <?php
        require_once './fileFooter.php';
        ?><!-- End Footer -->
    </div>
</div>

<!-- DATALIST -->
<!-- 20210908063800 DATALIST NEW SELL ORDER (OK) -->
<datalist id="id4_newOpenSO">
    <?php
    /*$sqlcmd_listNewOpenSO = "SELECT * FROM tbl_sellorder WHERE so_number NOT IN (SELECT wg_sonum FROM tbl_wg4sell)";*/
    $sqlcmd_listNewOpenSO = "SELECT * FROM tbl_sellorder WHERE so_status=1";
    $sqlres_listNewOpenSO = mysqli_query($dbConn, $sqlcmd_listNewOpenSO);

    if ($sqlres_listNewOpenSO) {
        while ($sqlfet_listNewOpenSO = mysqli_fetch_assoc($sqlres_listNewOpenSO)) {
            $custName = getValue("tbl_customers", "customer_code", $sqlfet_listNewOpenSO['so_customer'], 2, "customer_name");
            $custSurname = getValue("tbl_customers", "customer_code", $sqlfet_listNewOpenSO['so_customer'], 2, "customer_surname");
            ?>
            <option value="<?= $sqlfet_listNewOpenSO['so_number'] . " / " . $custName . " " . $custSurname; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- 20210908063800 DATALIST NEW SELL ORDER (OK) -->

<datalist id="id4_OpenSONoWorking">
    <?php
    /*$sqlcmd_listNewOpenSO = "SELECT * FROM tbl_sellorder WHERE so_number NOT IN (SELECT wg_sonum FROM tbl_wg4sell)";*/
    $sqlcmd_listNewOpenSO = "SELECT * FROM tbl_sellorder WHERE so_number NOT IN (select wg.wg_sonum from tbl_wg4sell wg left join tbl_supplogis su on wg.wg_code4supplogis=su.supplogis_code where su.supplogis_status<>0)";
    echo $sqlcmd_listNewOpenSO;
    $sqlres_listNewOpenSO = mysqli_query($dbConn, $sqlcmd_listNewOpenSO);

    if ($sqlres_listNewOpenSO) {
        while ($sqlfet_listNewOpenSO = mysqli_fetch_assoc($sqlres_listNewOpenSO)) {
            $custName = getValue("tbl_customers", "customer_code", $sqlfet_listNewOpenSO['so_customer'], 2, "customer_name");
            $custSurname = getValue("tbl_customers", "customer_code", $sqlfet_listNewOpenSO['so_customer'], 2, "customer_surname");
            ?>
            <option value="<?= $sqlfet_listNewOpenSO['so_number'] . " / " . $custName . " " . $custSurname; ?>"></option>
            <?php
        }
    }
    ?>
</datalist>

<!-- 20210908065400 DATALIST FREE SUPPLIER LOGISTICS (OK) -->
<datalist id="id4_freeSuppLogis">
    <?php
    $sqlcmd_listFreeSuppLogis = "SELECT * FROM tbl_supplogis WHERE supplogis_status=0";
    $sqlres_listFreeSuppLogis = mysqli_query($dbConn, $sqlcmd_listFreeSuppLogis);
    if ($sqlres_listFreeSuppLogis) {
        while ($sqlfet_listFreeSuppLogis = mysqli_fetch_assoc($sqlres_listFreeSuppLogis)) {
            ?>
            <option value="<?= $sqlfet_listFreeSuppLogis['supplogis_vlpn'] . " / " . $sqlfet_listFreeSuppLogis['supplogis_name']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- 20210908065400 DATALIST FREE SUPPLIER LOGISTICS (OK) -->

<!-- 20210908155200 DATALIST EXISTING SELL ORDER -->
<datalist id="id_existOpenSO">
    <?php
    $sqlcmd_listExistOpenSO = "SELECT * FROM tbl_sellorder WHERE so_number IN (SELECT wg_sonum FROM tbl_wg4sell)";
    $sqlres_listExistOpenSO = mysqli_query($dbConn, $sqlcmd_listExistOpenSO);

    if ($sqlres_listExistOpenSO) {
        while ($sqlfet_listExistOpenSO = mysqli_fetch_assoc($sqlres_listExistOpenSO)) {
            $custName = getValue("tbl_customers", "customer_code", $sqlfet_listExistOpenSO['so_customer'], 2, "customer_name");
            $custSurname = getValue("tbl_customers", "customer_code", $sqlfet_listExistOpenSO['so_customer'], 2, "customer_surname");
            ?>
            <option value="<?= $sqlfet_listExistOpenSO['so_number'] . " / " . $custName . " " . $custSurname; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- 20210908155200 DATALIST EXISTING SELL ORDER -->

<!-- 20210908161300 DATALIST WORKING SUPPLIER LOGISTICS -->
<datalist id="id4_workingSuppLogis">
    <?php
    $sqlcmd_listWorkingSuppLogis = "SELECT * FROM tbl_supplogis WHERE supplogis_status=1";
    $sqlres_listWorkingSuppLogis = mysqli_query($dbConn, $sqlcmd_listWorkingSuppLogis);
    if ($sqlres_listWorkingSuppLogis) {
        while ($sqlfet_listWorkingSuppLogis = mysqli_fetch_assoc($sqlres_listWorkingSuppLogis)) {
            ?>
            <option value="<?= $sqlfet_listWorkingSuppLogis['supplogis_vlpn'] . " / " . $sqlfet_listWorkingSuppLogis['supplogis_name']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- 20210908161300 DATALIST WORKING SUPPLIER LOGISTICS -->

<!-- datalist for SO -->
<datalist id="id4_OpenSONumber">
    <?php
    //    $sqlcmd_listOpenPO = "SELECT * FROM tbl_purchaseorder WHERE po_status=1";
    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
    $sqlcmd_listOpenSO = "SELECT * FROM tbl_wg4sell WHERE so_status=1 GROUP BY wg_sonum";
    $sqlres_listOpenSO = mysqli_query($dbConn, $sqlcmd_listOpenSO);
    if ($sqlres_listOpenSO) {
        while ($sqlfet_listOpenSO = mysqli_fetch_assoc($sqlres_listOpenSO)) {
            ?>
            <option value="<?= $sqlfet_listOpenSO['wg_sonum']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- datalist for PO -->

<!-- Datalist for LPN -->
<datalist id="id4ListVLPN">
    <?php
    //    $sqlcmd_listOpenVLPN = "SELECT * FROM tbl_purchaseorder WHERE po_status=1";
    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
    $sqlcmd_listOpenVLPN = "SELECT * FROM tbl_wg4sell WHERE so_status=1 GROUP BY wg_sonum";
    $sqlres_listOpneVLPN = mysqli_query($dbConn, $sqlcmd_listOpenVLPN);
    if ($sqlres_listOpneVLPN) {
        while ($sqlfet_listOpenVLPN = mysqli_fetch_assoc($sqlres_listOpneVLPN)) {
            ?>
            <option value="<?= $sqlfet_listOpenVLPN['wg_vlpn']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist>
<!-- Datalist for LPN -->

<!-- Datalist for all supplier logistic -->
<datalist id="id4_listAllSuppLogis">
    <?php
    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
    $sqlcmd_listAllSuppLogis = "SELECT * FROM tbl_supplogis WHERE 1 GROUP BY supplogis_name";
    $sqlres_listAllSuppLogis = mysqli_query($dbConn, $sqlcmd_listAllSuppLogis);
    if ($sqlres_listAllSuppLogis) {
        while ($sqlfet_listAllSuppLogis = mysqli_fetch_assoc($sqlres_listAllSuppLogis)) {
            ?>
            <option value="<?= $sqlfet_listAllSuppLogis['supplogis_name']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- Datalist for all supplier logistic -->

<!-- Datalist for open supplier -->
<datalist id="id4ListOpenSupp">
    <?php
    //    $sqlcmd_listOpenSupp = "SELECT * FROM tbl_purchaseorder WHERE po_status=1 ORDER BY po_suppcode ASC";
    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
    $sqlcmd_listOpenSupp = "SELECT * FROM tbl_wg4buy WHERE po_status=1 GROUP BY wg_ponum ORDER BY wg_suppcode ASC";
    $sqlres_listOpenSuup = mysqli_query($dbConn, $sqlcmd_listOpenSupp);
    if ($sqlres_listOpenSuup) {
        while ($sqlfet_listOpenSupp = mysqli_fetch_assoc($sqlres_listOpenSuup)) {
            ?>
            <option value="<?= getValue('tbl_suppliers', 'supp_code', $sqlfet_listOpenSupp['wg_suppcode'], 2, 'supp_name') . " " . getValue('tbl_suppliers', 'supp_code', $sqlfet_listOpenSupp['wg_suppcode'], 2, 'supp_surname'); ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- Datalist for open supplier -->

<datalist id="id4_CloseSOSuppLogist">
    <?php
    $sqlcmd_listVehicle = "SELECT * FROM tbl_supplogis WHERE 1 ORDER BY supplogis_name ASC, supplogis_vlpn ASC";
    $sqlres_listVehicle = mysqli_query($dbConn, $sqlcmd_listVehicle);

    if ($sqlres_listVehicle) {
        while ($sqlfet_listVehicle = mysqli_fetch_assoc($sqlres_listVehicle)) {
            ?>
            <option value="<?= $sqlfet_listVehicle['supplogis_vlpn'] . "/" . $sqlfet_listVehicle['supplogis_name']; ?>" <?php
            $vehicleStatus = getValue("tbl_wg4sell", "wg_vlpn", $sqlfet_listVehicle['supplogis_vlpn'], 2, "so_status");
            if ($vehicleStatus == '1')
                echo "disabled";
            ?>></option>
            <?php
        }
    }
    ?>
</datalist>

<!-- Datalist -->

<!--   Core JS Files   -->
<script src="./js/core/jquery.min.js"></script>
<script src="./js/core/popper.min.js"></script>
<script src="./js/core/bootstrap.min.js"></script>
<script src="./js/plugins/perfect-scrollbar.jquery.min.js"></script>

<!--  Notifications Plugin    -->
<script src="./js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
<script src="./js/script4SO.js"></script>

<!-- Hi-light active menu -->
<script>
    // Try to still open submenu
    // $("#sub4Sell").addClass("show");
    // $("#id4SubMenuSellSO").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Check New PO or Existing PO -->
<script>
    let radChk = document.getElementsByName("chkNewSO");

    let soNumber = document.getElementById("id4_SONumber");
    let soSuppLogis = document.getElementById("id4_SOSuppLogis");
    // let soVlpn = document.getElementById("id4_vLpnNumber");
    // let vlpnRes = document.getElementById("id4_vLpnCheckResult");
    let radVal = 0;

    $(document).ready(function () {
        // Check radio button #01 checked
        $('#id4_chkNewSO1').change(function () {
            radVal = 1;
            soNumber.value = '';
            soSuppLogis.value = '';
            $("#id4_SONumber").attr("readonly", false);
            // $("#id4_vLpnCheckResult").removeClass("d-none");
            soNumber.setAttribute("list", "id4_OpenSONoWorking");
            soSuppLogis.setAttribute("list", "id4_freeSuppLogis");//OLD id4_CloseSOSuppLogist
            // Get new SO-Number
            /*$.ajax({
                type: "POST",
                url: "php4SO.php",
                data: {processName: 'genSONumber'},
                success: function (response) {
                    soNumber.value = response;
                }
            });*/
            // soSuppLogis.value = "";
            // soVlpn.value = "";

            // Enable and Disable Select Option
            $("#id4_SOWgType option[value='0001']").prop("disabled", false);
            $("#id4_SOWgType option[value='0002']").prop("disabled", false);
            $("#id4_SOWgType option[value='0003']").prop("disabled", true);

            // Enable keyboard input
            /*$("#id4PONumber").keydown(function () {
                return true;
            });
            $("#id4VlpnNumber").keydown(function () {
                return true;
            });
            $("#id4_SOSuppLogis").keydown(function () {
                return true;
            });*/
        });

        // Check radio button #02 checked
        $('#id4_chkNewSO2').change(function () {
            radVal = 2;
            soNumber.value = '';
            soSuppLogis.value = '';
            // $("#id4_SONumber").attr("readonly", false);
            // $("#id4_SOCustomer").attr("readonly", true);
            // $("#id4_vLpnCheckResult").addClass("d-none");
            $("#id4_SONumber").attr("readonly", true);

            // soNumber.setAttribute("list", "id_existOpenSO");
            soSuppLogis.setAttribute("list", "id4_workingSuppLogis");
            // poVlpn.setAttribute("list", "id4ListVLPN");
            // poNumber.value = "";
            // poSuppName.value = "";
            // poVlpn.value = "";

            // Enable and Disable Select Option
            $("#id4_SOWgType option[value='0001']").prop("disabled", true);
            $("#id4_SOWgType option[value='0002']").prop("disabled", false);
            $("#id4_SOWgType option[value='0003']").prop("disabled", false);

            // Disable keyboard input
            /*
            $("#id4PONumber").keydown(function () {
                return false;
            });
            $("#id4VlpnNumber").keydown(function () {
                return false;
            });
            $("#id4POSuppName").keydown(function () {
                return false;
            });
            */
        });

        // Check weight type selected
        $('#id4_SOWgType').change(function () {
            let wgType = $('#id4_SOWgType :selected').val();
            let cntWgScale = "<?= countAllRow('tbl_wgscale');?>";

            // console.log(wgType);
            if (wgType === '0002') {
                for (let i = 1; i <= cntWgScale; i++) {
                    if (i === 1)
                        $("#id4_SOWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", true);
                    else
                        $("#id4_SOWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                }
            } else {
                for (let i = 1; i <= cntWgScale; i++) {
                    if (i === 1)
                        $("#id4_SOWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                    else
                        $("#id4_SOWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", true);
                }
            }

            // Enable keyboard input
            /*$("#id4PONumber").keydown(function () {
                return true;
            });
            $("#id4VlpnNumber").keydown(function () {
                return true;
            });
            $("#id4POSuppName").keydown(function () {
                return true;
            });*/
        });

        // Check weight scale if with pallet type show pallet weight input
        $('#id4_SOWgScale').change(function () {
            let wgScale = $('#id4_SOWgScale :selected').val();
            let chkWgLevel = queryData("php4SO.php?command=checkWgScaleLevel&wgSCaleCode=" + wgScale);
            let cntPrdlist = '<?=countAllRow('tbl_products');?>';

            if (chkWgLevel === '1') {
                // Disable wgscale level 0 and enable wgscale level 1
                $("#id4_SOProduct option[value=0000]").prop("disabled", true);
                for (let i = 1; i <= cntPrdlist; i++) {
                    $("#id4_SOProduct option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                }   // Disable wgscale level 0 and enable wgscale level 1

                // Enable pallet weight section
                document.getElementById("id4CntPallet").value = 0;
                document.getElementById("id4Wg4Pallet").value = 0;
                $("#div4WgPallet :input").attr("readonly", false);// change from disabled to readonly
            } else if (chkWgLevel === '0') {
                // Check weight scale level to the big one for vehicle weighting
                // Enable wgscale level 0 and disable wgscale level 1
                $("#id4_SOProduct option[value=0000]").prop("disabled", false);
                for (let i = 1; i <= cntPrdlist; i++) {
                    $("#id4_SOProduct option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", true);
                }   // Enable wgscale level 0 and disable wgscale level 1

                // Disable pallet weight section
                document.getElementById("id4CntPallet").value = 0;
                document.getElementById("id4Wg4Pallet").value = 0;
                $("#div4WgPallet :input").attr("readonly", true);// change from disabled to readonly
            }
            calcWgNet();
        });

        /*$("#id4POWgNet").on("keyup", function () {
            console.log(document.getElementById("id4CntPallet").value);
        });*/
    });

    $("#id4_SOSuppLogisXXXXXX").on("change", function () {
        $("#id4_vLpnNumber").attr("disabled", false);
        $.ajax({
            type: "POST",
            url: "php4SO.php",
            data: {
                processName: "listVlpn4SuppLogis",
                vehicleOwner: this.value
            },
            success: function (response) {
                const arrayVlpn = JSON.parse(response);
                createDataList(arrayVlpn, "id4_vLpnNumber");
            }
        });

        function createDataList(optionList, inputTextID) {
            let container = document.getElementById(inputTextID);
            let i = 0;
            let len = optionList.length;
            let datLst = document.createElement('datalist');

            datLst.id = 'id4_dataList4SuppLogis';
            for (; i < len; i += 1) {
                let option = document.createElement('option');
                option.value = optionList[i]["supplogis_vlpn"];
                datLst.appendChild(option);
            }
            container.appendChild(datLst);
        }
    });

    // LISTEN TO #id4_SONumber WAS CHANGE
    $("#id4_SONumber").on("change", function () {
        // list4SO(radVal, soNumber.value, 'SONumber', 'wg_sonum');
        getWg4SO(soNumber.value, "id4_wgInSO");
    });
    $("#id4_SOSuppLogis").on("change", function () {
        if (radVal === 2) {
            getSONumber4SuppLogis(soSuppLogis.value, "id4_SONumber");
            getWg4SO(soNumber.value, "id4_wgInSO");
        }
    });
    /*
    $("#id4VlpnNumber").on("change", function () {
        // list4PO(radVal, poVlpn.value, 'VlpnNumber', 'po_vlpn');
        list4PO(radVal, poVlpn.value, 'VlpnNumber', 'wg_vlpn');
    });*/
</script>

<script>
    let calcWgNet = function () {
        let cntPallet = document.getElementById("id4CntPallet");
        let wg4Pallet = document.getElementById("id4Wg4Pallet");
        let wgScaleRD = document.getElementById("id4WgScaleRd");
        let wgScaleNet = document.getElementById("id4WgScaleNet");

        if (cntPallet.value === '')
            cntPallet.value = '0';
        if (wg4Pallet.value === '')
            wg4Pallet.value = '0';
        if (wgScaleRD.value === '')
            wgScaleRD.value = '0';
        if (wgScaleNet.value === '')
            wgScaleNet.value = '0';

        let A = parseInt(cntPallet.value);
        let B = parseFloat(wg4Pallet.value);
        let C = parseFloat(wgScaleRD.value.replace(/,/g, ''));
        // console.log('C =' + C);

        let D = C - (A * B);

        //wgScaleNet.value = D.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        wgScaleNet.value = D.toFixed(2);//.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

</body>

</html>