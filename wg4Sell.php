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

$varget_id2edit = filter_input(INPUT_GET, 'id2edit');
if (empty($varget_id2edit)) {
    $txt2Display = "จัดสินค้าขึ้นรถ";
    $processName = "newLogis";
} else {
    $txt2Display = "แก้ไขข้อมูลการจัดสินค้าขึ้นรถ";
    $processName = "editLogis";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <link rel="icon" type="image/png" href="./assets/img/faviconW.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>GOLD RUBBER : SELL ORDER</title>

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
            <h2 class="text-warning text-center"> จัดสินค้าขึ้นรถ </h2>
        </div>
        <!-- Start of Content -->
        <div class="content" id="id4Content">
            <!-- Start of Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลปัจจุบัน </h5>
                            <h4 class="card-title"> <?= $txt2Display; ?> </h4>
                        </div>

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form action="./act4SO.php" method="post">

                                <!-- Row #00 Select PO Type (new or existing) -->
                                <div class="row">
                                    <div class="col-md-12 pr-md-1">
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="chkNewSO"
                                                       id="id4_chkNewSO1" value="1">ขายใหม่
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                        <div class="form-check form-check-radio form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="chkNewSO"
                                                       id="id4_chkNewSO2" value="2" checked>เปิดการขายแล้ว
                                                <span class="form-check-sign"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Row #00 -->

                                <!-- Row #01 -->
                                <div class="row">
                                    <!-- VEHICLE AND OWNER -->
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4_soNumber">เลขอ้างอิงการขาย</label>
                                            <input type="text" class="form-control" placeholder="เลขอ้างอิงการขาย"
                                                   name="soNumber" id="id4_soNumber" list="id4_listOpenSO"
                                                   required value="">
                                        </div>
                                    </div><!-- VEHICLE AND OWNER -->

                                    <!-- SELL ORDER -->
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_soSuppLogis">รถขนส่ง/เจ้าของ</label>
                                            <!--<div class="selectWrapper1" style="width: 100%">
                                                <select class="form-control selectBox1" name="SOSuppLogis"
                                                        id="id4_SOSuppLogis" required>
                                                    <option value="">เลือกรถขนส่ง (ถ้ามาใหม่ให้ลงทะเบียนก่อน)</option>

                                                </select>
                                            </div>-->
                                            <input class="form-control" type="text" name="soSuppLogis"
                                                   list="id4_listFreeSuppLogis"
                                                   id="id4_soSuppLogis" required>
                                        </div>
                                    </div><!-- SELL ORDER -->

                                    <!-- CUSTOMERS -->
                                    <!--
                                    <div class="col-md-4 pl-md-1">
                                        <label for="soCustomer">ลูกค้า</label>
                                        <div class="form-group text-center">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="soCustomer"
                                                        id="id4_soCustomer" required>
                                                    <option value="">เลือกลูกค้า</option>
                                                    <?php
                                    $sqlcmd_listCusts = "SELECT * FROM tbl_customers WHERE 1";
                                    $sqlres_listCusts = mysqli_query($dbConn, $sqlcmd_listCusts);
                                    if ($sqlres_listCusts) {
                                        while ($sqlfet_listCusts = mysqli_fetch_assoc($sqlres_listCusts)) {
                                            ?>
                                                            <option value="<?= $sqlfet_listCusts['customer_code']; ?>"><?= $sqlfet_listCusts['customer_name']; ?>
                                                                &nbsp;<?= $sqlfet_listCusts['customer_surname']; ?></option>
                                                            <?php
                                        }
                                    }
                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>--><!-- CUSTOMERS -->

                                    <!--<div class="col-md-4 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_SOSuppLogis">เจ้าของรถขนส่ง</label>
                                            <input type="text" name="SOSuppLogis" id="id4_SOSuppLogis"
                                                   class="form-control" placeholder="ถ้ามาใหม่ให้ไปลงทะเบียนก่อน"
                                                   required value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_vLpnNumber">เลขทะเบียนรถ</label>&nbsp;<span
                                                    id="id4_vLpnCheckResult"></span>&nbsp;
                                            <input type="text" class="form-control" placeholder="เลขทะเบียนรถ"
                                                   name="vLpnNumber" id="id4_vLpnNumber" list="id4_dataList4SuppLogis"
                                                   disabled required
                                                   onkeyup="chkAvailableVLPN(this.value);">
                                        </div>
                                    </div>-->
                                </div> <!-- End of Row #01 -->

                                <!-- Row #02 -->
                                <div class="row">
                                    <!-- WEIGHT TYPE -->
                                    <div class="col-md-3 pr-md-2">
                                        <label for="id4_soWgType">ประเภทการชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="soWgType"
                                                        id="id4_soWgType" required>
                                                    <option value="">เลือกประเภทการชั่ง</option>
                                                    <option value="0001">ชั่งเข้า (รถเปล่า)</option>
                                                    <option value="0002">ชั่งแยก (สินค้าและพาเลท)</option>
                                                    <option value="0003">ชั่งออก (รถพร้อมสินค้า)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- WEIGHT TYPE -->

                                    <!-- WEIGHT SCALE -->
                                    <div class="col-md-3 px-md-2">
                                        <label for="id4_soWgScale">เครื่องชั่ง</label>
                                        <div class="form-group">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="soWgScale"
                                                        id="id4_soWgScale" required>
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

<!-- DATALIST -->
<!-- LIST FOR OPEN SO -->
<datalist id="id4_listOpenSO">
    <?php
    $sqlcmd_listOpenSO = "SELECT * FROM tbl_sellorder WHERE so_status=1";
    $sqlres_listOpenSO = mysqli_query($dbConn, $sqlcmd_listOpenSO);
    if ($sqlres_listOpenSO) {
        while ($sqlfet_listOpenSO = mysqli_fetch_assoc($sqlres_listOpenSO)) {
            $custName = getValue("tbl_customers", "customer_code", $sqlfet_listOpenSO['so_customer'], 2, "customer_name");
            $custSurname = getValue("tbl_customers", "customer_code", $sqlfet_listOpenSO['so_customer'], 2, "customer_surname");
            ?>
            <option value="<?= $sqlfet_listOpenSO['so_number'] . " / " . $custName . " " . $custSurname; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- LIST FOR OPEN SO -->

<!-- LIST FOR VACANT SUPPLOGIS -->
<datalist id="id4_listFreeSuppLogis">
    <?php
    $sqlcmd_listFreeSuppLogis = "SELECT * FROM tbl_supplogis WHERE supplogis_status=0";
    $sqlres_listFreeSuppLogis = mysqli_query($dbConn, $sqlcmd_listFreeSuppLogis);
    if ($sqlres_listFreeSuppLogis) {
        while ($sqlfet_listFreeSuppLogis = mysqli_fetch_assoc($sqlres_listFreeSuppLogis)) {
            ?>
            <option value="<?= $sqlfet_listFreeSuppLogis['supplogis_vlpn'] . "/" . $sqlfet_listFreeSuppLogis['supplogis_name']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- LIST FOR VACANT SUPPLOGIS -->
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
    $("#sub4Sell").addClass("show");
    $("#id4SubMenuSellSO").addClass("active");
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
            // vlpnRes.innerHTML = "";
            // $("#id4_SONumber").attr("readonly", true);
            // $("#id4_vLpnCheckResult").removeClass("d-none");
            soSuppLogis.setAttribute("list", "id4_CloseSOSuppLogist");
            radVal = 1;
            // Get new SO-Number
            $.ajax({
                type: "POST",
                url: "php4SO.php",
                data: {processName: 'genSONumber'},
                success: function (response) {
                    soNumber.value = response;
                }
            });
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
            $("#id4_SONumber").attr("readonly", false);
            $("#id4_SOCustomer").attr("readonly", true);
            // $("#id4_vLpnCheckResult").addClass("d-none");

            soNumber.setAttribute("list", "id4_OpenSONumber");
            // soSuppLogis.setAttribute("list", "id4ListOpenSupp");
            // poVlpn.setAttribute("list", "id4ListVLPN");
            radVal = 2;
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

    $("#id4_SOSuppLogis").on("change", function () {
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


    $("#id4_SONumber").on("change", function () {
        // list4PO(radVal, poNumber.value, 'PONumber', 'po_number');
        // console.log(typeof radVal + "][" + radVal);
        // console.log(soNumber.value);
        list4SO(radVal, soNumber.value, 'SONumber', 'wg_sonum');
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

</body>

</html>