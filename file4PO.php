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
}*//* AUTHORIZED CHECK FOR THIS PAGE */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <link rel="icon" type="image/png" href="./assets/img/faviconW.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>GOLD RUBBER : PURCHASE ORDER</title>

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

    <!-- DateTimePicker Thai -->
    <link rel="stylesheet" href="./css/thDateTimePicker.css">
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
            <h2 class="text-warning text-center">รับซื้อ</h2>
        </div>
        <!-- Start of Content -->
        <div class="content" id="id4Content">
            <!-- Start of Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลปัจจุบัน </h5>
                            <h4 class="card-title"> รับซื้อ </h4>
                        </div>

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form action="./act4PO.php" method="post">

                                <!-- Row #00 Select PO Type (new or existing) -->
                                <div class="row">
                                    <div class="col-md-12 pr-md-1">
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="chkNewPO"
                                                       id="id4ChkNewPO1" value="1">รับซื้อใหม่
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="chkNewPO"
                                                       id="id4ChkNewPO2" value="2">เปิดการซื้อแล้ว
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <!-- End of Row #00 -->

                                <!-- Row #01 -->
                                <div class="row">
                                    <div class="col-md-3 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4PONumber">เลขอ้างอิงการซื้อ</label>
                                            <input type="text" class="form-control" placeholder="เลขอ้างอิงการซื้อ"
                                                   name="poNumber" id="id4PONumber" readonly list="id4ListOpenPO"
                                                   required value="">
                                        </div>
                                    </div>

                                    <div class="col-md-3 px-md-1">
                                        <div class="form-group">
                                            <label for="id4VlpnNumber">เลขทะเบียนรถ</label>&nbsp;<span
                                                    id="VLPNCheckResult"></span>&nbsp;
                                            <input type="text" class="form-control" placeholder="เลขทะเบียนรถ"
                                                   name="vlpnNumber" id="id4VlpnNumber" required
                                                   onkeyup="chkAvailableVLPN(this.value);">
                                        </div>
                                    </div>

                                    <div class="col-md-3 px-md-1">
                                        <div class="form-group">
                                            <label for="id4POSuppName">ผู้ขาย</label>
                                            <input type="text" name="POSuppName" id="id4POSuppName" class="form-control"
                                                   placeholder="ชื่อผู้ขาย (ถ้ามาใหม่ให้ไปลงทะเบียนผู้ขายก่อน)" required
                                                   value="">
                                        </div>
                                    </div>

                                    <div class="col-md-3 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4BillPODate">บิลลงวันที่</label>
                                            <input type="text"
                                                   class="form-control text-center font-weight-bold text-primary"
                                                   placeholder="วันที่ออกบิล" name="billPODate" id="id4BillPODate">
                                        </div>
                                    </div>

                                </div> <!-- End of Row #01 -->

                                <!-- Row #02 -->
                                <div class="row">
                                    <div class="col-md-3 pr-md-1">
                                        <label for="id4POBuyType">ประเภทการซื้อ</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="POBuyType"
                                                        id="id4POBuyType" style="border: none!important;">
                                                    <option value="">เลือกประเภทการซื้อ</option>
                                                    <?php
                                                    $sqlcmd_listBuyType = "SELECT * FROM tbl_buytype WHERE 1 ORDER BY buytype_code ASC";
                                                    $sqlres_listBuyType = mysqli_query($dbConn, $sqlcmd_listBuyType);
                                                    if ($sqlres_listBuyType) {
                                                        while ($sqlfet_listBuyType = mysqli_fetch_assoc($sqlres_listBuyType)) {
                                                            ?>
                                                            <option value="<?= $sqlfet_listBuyType['buytype_code']; ?>"><?= $sqlfet_listBuyType['buytype_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 px-md-1">
                                        <label for="id4POWgType">ประเภทการชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="POWgType" id="id4POWgType"
                                                        style="border: none!important;" required>
                                                    <option value="">เลือกประเภทการชั่ง</option>
                                                    <option value="0001">ชั่งเข้า (รถพร้อมสินค้า)</option>
                                                    <option value="0002">ชั่งแยก (สินค้าและพาเลท)</option>
                                                    <option value="0003">ชั่งออก (รถเปล่า)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 px-md-1">
                                        <label for="id4POWgScale">เครื่องชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="POWgScale"
                                                        id="id4POWgScale" required style="border: none!important;">
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
                                    </div>

                                    <div class="col-md-3 pl-md-1">
                                        <label for="id4POProduct">สินค้าที่ชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="POProduct"
                                                        id="id4POProduct" style="border: none!important;">
                                                    <option value="">เลือกสินค้า</option>
                                                    <option value="0000">ชั่งรถ</option>
                                                    <?php
                                                    $sqlcmd_listWgScale = "SELECT * FROM tbl_products WHERE 1 ORDER BY product_order";
                                                    $sqlres_listWgScale = mysqli_query($dbConn, $sqlcmd_listWgScale);
                                                    if ($sqlres_listWgScale) {
                                                        while ($sqlfet_listWgScale = mysqli_fetch_assoc($sqlres_listWgScale)) {
                                                            ?>
                                                            <option value="<?= $sqlfet_listWgScale['product_code']; ?>"><?= $sqlfet_listWgScale['product_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- End of Row #02 -->

                                <!-- Row for pallet weight -->
                                <div class="row mt-5 h4 font-weight-bold text-muted" id="div4WgPallet">
                                    <div class="col-md-5 pr-md-1 my-2" id="div4Txt">
                                        <div class="form-group text-right">
                                            จำนวนพาเลท
                                        </div>
                                    </div>
                                    <div class="col-md-1 px-md-1" id="div4WgShow">
                                        <div class="form-group">
                                            <!-- <label for="id4SuppAmphoe" style="text-decoration: none;">น้ำหนักที่ชั่งได้</label>-->
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
                                            <!-- <label for="id4SuppAmphoe" style="text-decoration: none;">น้ำหนักที่ชั่งได้</label>-->
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

                                <!-- Row #03 -->
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
                                </div><!-- End of Row #03 -->

                                <!-- Row for net weight -->
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
                                </div><!-- End of row for net weight -->

                                <hr>
                                <!-- Button "Reset" and "Submit" -->
                                <div class="row d-flex justify-content-center">
                                    <div class="button-container">
                                        <button type="reset" class="btn btn-outline-primary btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons loader_refresh spin"></i> ล้างข้อมูล
                                        </button>
                                        &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-outline-success btn-round"
                                                style="width: 120px" name="suppSubmitBtn"
                                                onsubmit="return confirm('ข้อมูลถูกต้อง\nต้องการบันทึกข้อมูล')">
                                            <i class="now-ui-icons arrows-1_cloud-upload-94"></i> บันทึก
                                        </button>
                                    </div>
                                </div><!-- Button "Reset" and "Submit" -->

                                <!-- Hidden -->
                                <input type="hidden" name="processName" value="AddWg">

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

<!-- Datalist -->
<!-- datalist for PO -->
<datalist id="id4ListOpenPO">
    <?php
    //    $sqlcmd_listOpenPO = "SELECT * FROM tbl_purchaseorder WHERE po_status=1";
    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
    $sqlcmd_listOpenPO = "SELECT * FROM tbl_wg4buy WHERE po_status=1 GROUP BY wg_ponum";
    $sqlres_listOpenPO = mysqli_query($dbConn, $sqlcmd_listOpenPO);
    if ($sqlres_listOpenPO) {
        while ($sqlfet_listOpenPO = mysqli_fetch_assoc($sqlres_listOpenPO)) {
            ?>
            <option value="<?= $sqlfet_listOpenPO['wg_ponum']; ?>"></option>
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
    $sqlcmd_listOpenVLPN = "SELECT * FROM tbl_wg4buy WHERE po_status=1 GROUP BY wg_ponum";
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

<!-- Datalist for all supplier -->
<datalist id="id4ListAllSupp">
    <?php
    $sqlcmd_listAllSupp = "SELECT * FROM tbl_suppliers WHERE 1 ORDER BY supp_code ASC";
    $sqlres_listAllSupp = mysqli_query($dbConn, $sqlcmd_listAllSupp);
    if ($sqlres_listAllSupp) {
        while ($sqlfet_listAllSupp = mysqli_fetch_assoc($sqlres_listAllSupp)) {
            ?>
            <option value="<?= $sqlfet_listAllSupp['supp_name'] . " " . $sqlfet_listAllSupp['supp_surname']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- Datalist for all supplier -->

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
<script src="./js/script4PO.js"></script>

<!-- DateTimePicker Thai -->
<script src="./js/thDateTimePicker.js"></script>

<!-- Hi-light active menu -->
<script>
    // Try to still open submenu
    $("#sub4Buy").addClass("show");
    $("#id4SubMenuBuyPO").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Check New PO or Existing PO -->
<script>
    let poNumber = document.getElementById("id4PONumber");
    let poSuppName = document.getElementById("id4POSuppName");
    let poVlpn = document.getElementById("id4VlpnNumber");
    let vlpnRes = document.getElementById("VLPNCheckResult");

    let radChk = document.getElementsByName("chkNewPO");

    let radVal = 0;

    $(document).ready(function () {
        // Check radio button #01 checked
        $('#id4ChkNewPO1').change(function () {
            vlpnRes.innerHTML = "";
            $("#id4PONumber").attr("readonly", true);
            $("#VLPNCheckResult").removeClass("d-none");
            poSuppName.setAttribute("list", "id4ListAllSupp");
            radVal = 1;
            // Get new PO-Number
            $.ajax({
                type: "POST",
                url: "php4PO.php",
                data: {processName: 'genPONumber'},
                success: function (response) {
                    poNumber.value = response;
                }
            });
            poSuppName.value = "";
            poVlpn.value = "";

            // Enable and Disable Select Option
            $("#id4POWgType option[value='0001']").prop("disabled", false);
            $("#id4POWgType option[value='0002']").prop("disabled", false);
            $("#id4POWgType option[value='0003']").prop("disabled", true);

            // Enable keyboard input
            $("#id4PONumber").keydown(function () {
                return true;
            });
            $("#id4VlpnNumber").keydown(function () {
                return true;
            });
            $("#id4POSuppName").keydown(function () {
                return true;
            });
        });
        // Check radio button #02 checked
        $('#id4ChkNewPO2').change(function () {
            $("#id4PONumber").attr("readonly", false);
            $("#VLPNCheckResult").addClass("d-none");
            poSuppName.setAttribute("list", "id4ListOpenSupp");
            poVlpn.setAttribute("list", "id4ListVLPN");
            radVal = 2;
            poNumber.value = "";
            poSuppName.value = "";
            poVlpn.value = "";

            // Enable and Disable Select Option
            $("#id4POWgType option[value='0001']").prop("disabled", true);
            $("#id4POWgType option[value='0002']").prop("disabled", false);
            $("#id4POWgType option[value='0003']").prop("disabled", false);

            // Disable keyboard input
            $("#id4PONumber").keydown(function () {
                return false;
            });
            $("#id4VlpnNumber").keydown(function () {
                return false;
            });
            $("#id4POSuppName").keydown(function () {
                return false;
            });
        });

        // Check weight type selected
        $('#id4POWgType').change(function () {
            let wgType = $('#id4POWgType :selected').val();
            let cntWgScale = "<?= countAllRow('tbl_wgscale');?>";

            // console.log(wgType);
            if (wgType === '0002') {
                for (let i = 1; i <= cntWgScale; i++) {
                    if (i === 1)
                        $("#id4POWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", true);
                    else
                        $("#id4POWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                }
            } else {
                for (let i = 1; i <= cntWgScale; i++) {
                    if (i === 1)
                        $("#id4POWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                    else
                        $("#id4POWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", true);
                }
            }

            // Enable keyboard input
            $("#id4PONumber").keydown(function () {
                return true;
            });
            $("#id4VlpnNumber").keydown(function () {
                return true;
            });
            $("#id4POSuppName").keydown(function () {
                return true;
            });
        });

        // Check weight scale if with pallet type show pallet weight input
        $('#id4POWgScale').change(function () {
            let wgScale = $('#id4POWgScale :selected').val();
            let chkWgLevel = queryData("php4PO.php?command=checkWgScaleLevel&wgSCaleCode=" + wgScale);
            let cntPrdlist = '<?=countAllRow('tbl_products');?>';

            if (chkWgLevel === '1') {
                // Disable wgscale level 0 and enable wgscale level 1
                $("#id4POProduct option[value=0000]").prop("disabled", true);
                for (let i = 1; i <= cntPrdlist; i++) {
                    $("#id4POProduct option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                }   // Disable wgscale level 0 and enable wgscale level 1

                // Enable pallet weight section
                document.getElementById("id4CntPallet").value = 0;
                document.getElementById("id4Wg4Pallet").value = 0;
                $("#div4WgPallet :input").attr("readonly", false);// change from disabled to readonly
            } else if (chkWgLevel === '0') {
                // Check weight scale level to the big one for vehicle weighting
                // Enable wgscale level 0 and disable wgscale level 1
                $("#id4POProduct option[value=0000]").prop("disabled", false);
                for (let i = 1; i <= cntPrdlist; i++) {
                    $("#id4POProduct option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", true);
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

    $("#id4POSuppName").on("change", function () {
        // list4PO(radVal, poSuppName.value, 'POSuppName', 'po_suppcode');
        list4PO(radVal, poSuppName.value, 'POSuppName', 'wg_suppcode');
    });
    $("#id4PONumber").on("change", function () {
        // list4PO(radVal, poNumber.value, 'PONumber', 'po_number');
        list4PO(radVal, poNumber.value, 'PONumber', 'wg_ponum');
    });
    $("#id4VlpnNumber").on("change", function () {
        // list4PO(radVal, poVlpn.value, 'VlpnNumber', 'po_vlpn');
        list4PO(radVal, poVlpn.value, 'VlpnNumber', 'wg_vlpn');
    });
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

<script>
    // $("#id4WgScaleRd").on("keyup", function () {
    //     this.value = this.value.replace(/,/g, '');
    //     let value = this.value;
    //     this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // });
</script>

<!-- 2 Decimal not test yet -->
<!-- <input name="my_field" pattern="^\d*(\.\d{0,2})?$" /> -->
<script>
    /*    $(document).on('keydown', 'input[pattern]', function(e){
            var input = $(this);
            var oldVal = input.val();
            var regex = new RegExp(input.attr('pattern'), 'g');

            setTimeout(function(){
                var newVal = input.val();
                if(!regex.test(newVal)){
                    input.val(oldVal);
                }
            }, 1);
        });*/
</script>


<!-- DATETIME PICKER -->
<script type="text/javascript">
    $(function () {

        $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

        // กรณีใช้แบบ inline
        /*  $("#testdate4").datetimepicker({
              timepicker:false,
              format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
              lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
              inline:true
          });    */


        // กรณีใช้แบบ input
        $("#id4BillPODate").datetimepicker({
            timepicker: false,
            format: 'd-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
            lang: 'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
            onSelectDate: function (dp, $input) {
                var yearT = new Date(dp).getFullYear();
                var yearTH = yearT + 543;
                var fulldate = $input.val();
                var fulldateTH = fulldate.replace(yearT, yearTH);
                $input.val(fulldateTH);
            },
        });
        // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
        $("#id4BillPODate").on("mouseenter mouseleave", function (e) {
            var dateValue = $(this).val();
            if (dateValue != "") {
                var arr_date = dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0
                if (e.type == "mouseenter") {
                    var yearT = arr_date[2] - 543;
                }
                if (e.type == "mouseleave") {
                    var yearT = parseInt(arr_date[2]) + 543;
                }
                dateValue = dateValue.replace(arr_date[2], yearT);
                $(this).val(dateValue);
            }
        });


    });
</script><!-- DATETIME PICKER -->

</body>

</html>