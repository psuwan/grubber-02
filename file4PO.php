<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <!--    <link rel="icon" type="image/png" href="../assets/img/favicon.png">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>Gold Rubber : Template</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>

    <!-- Fonts and icons -->
    <!-- <link rel="stylesheet" href="./css/font.css">-->
    <link rel="stylesheet" href="./css/all.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap" rel="stylesheet">

    <!-- CSS Files -->
    <link href="./css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet"/>
    <link href="./css/style4Paginator.css" rel="stylesheet">
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
        <div class="content" id="id4Content">

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
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppAmphoe">เลขอ้างอิงการซื้อ</label>
                                            <input type="text" class="form-control" placeholder="เลขอ้างอิงการซื้อ"
                                                   name="poNumber" id="id4PONumber" readonly list="id4ListOpenPO"
                                                   required value="">
                                        </div>
                                    </div>
                                    <div class="col-md-4 px-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppAmphoe">เลขทะเบียนรถ</label>&nbsp;<span
                                                    id="VLPNCheckResult"></span>&nbsp;
                                            <input type="text" class="form-control" placeholder="เลขทะเบียนรถ"
                                                   name="vlpnNumber" id="id4VlpnNumber" required
                                                   onkeyup="chkAvailableVLPN(this.value);">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppProvince">ผู้ขาย</label>
                                            <input type="text" name="POSuppName" id="id4POSuppName" class="form-control"
                                                   required placeholder="ชื่อผู้ขาย (ถ้ามาใหม่ให้ไปลงทะเบียนผู้ขายก่อน)"
                                                   value="">
                                        </div>
                                    </div>
                                </div> <!-- End of Row #01 -->

                                <!-- Row #02 -->
                                <div class="row">
                                    <div class="col-md-3 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppZipcode">ประเภทการซื้อ</label>
                                            <select class="form-control" name="POBuyType" id="id4POBuyType" required>
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

                                    <div class="col-md-3 px-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppZipcode">ประเภทการชั่ง</label>
                                            <select class="form-control" name="POWgType" id="id4POWgType" required>
                                                <option value="">เลือกประเภทการชั่ง</option>
                                                <option value="0001">ชั่งเข้า</option>
                                                <option value="0002">ชั่งแยก</option>
                                                <option value="0003">ชั่งออก</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3 px-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppProvince">เครื่องชั่ง</label>
                                            <select class="form-control" name="POWgScale" id="id4POWgScale" required>
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

                                    <div class="col-md-3 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppProvince">สินค้าที่ชั่ง</label>
                                            <select class="form-control" name="POWgScale" id="id4POWgScale" required>
                                                <option value="">เลือกสินค้า</option>
                                                <option value="">ชั่งรถ</option>
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
                                                   name="wg4Pallet" id="id4Wg4Pallet"
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
                                            <input type="text" class="form-control font-weight-bold text-primary h3"
                                                   placeholder="0"
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
                                                   placeholder="0"
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

                        </div><!-- Card body -->
                        </form><!-- End of form -->
                    </div>
                </div>
            </div>

        </div>

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
    $sqlcmd_listOpenPO = "SELECT * FROM tbl_purchaseorder WHERE po_status=1";
    $sqlres_listOpenPO = mysqli_query($dbConn, $sqlcmd_listOpenPO);
    if ($sqlres_listOpenPO) {
        while ($sqlfet_listOpenPO = mysqli_fetch_assoc($sqlres_listOpenPO)) {
            ?>
            <option value="<?= $sqlfet_listOpenPO['po_number']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist><!-- datalist for PO -->

<!-- Datalist for LPN -->
<datalist id="id4ListVLPN">
    <?php
    $sqlcmd_listOpenVLPN = "SELECT * FROM tbl_purchaseorder WHERE po_status=1";
    $sqlres_listOpneVLPN = mysqli_query($dbConn, $sqlcmd_listOpenVLPN);
    if ($sqlres_listOpneVLPN) {
        while ($sqlfet_listOpenVLPN = mysqli_fetch_assoc($sqlres_listOpneVLPN)) {
            ?>
            <option value="<?= $sqlfet_listOpenVLPN['po_vlpn']; ?>"></option>
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
    $sqlcmd_listOpenSupp = "SELECT * FROM tbl_purchaseorder WHERE po_status=1 ORDER BY po_suppcode ASC";
    $sqlres_listOpenSuup = mysqli_query($dbConn, $sqlcmd_listOpenSupp);
    if ($sqlres_listOpenSuup) {
        while ($sqlfet_listOpenSupp = mysqli_fetch_assoc($sqlres_listOpenSuup)) {
            ?>
            <option value="<?= getValue('tbl_suppliers', 'supp_code', $sqlfet_listOpenSupp['po_suppcode'], 2, 'supp_name') . " " . getValue('tbl_suppliers', 'supp_code', $sqlfet_listOpenSupp['po_suppcode'], 2, 'supp_surname'); ?>"></option>
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
    let radChk = document.getElementsByName("chkNewPO");
    let vlpnRes = document.getElementById("VLPNCheckResult");

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
        });
        // Check radio button #02 checked
        $('#id4ChkNewPO2').change(function () {
            $("#id4PONumber").attr("readonly", false);
            $("#VLPNCheckResult").addClass("d-none");
            poSuppName.setAttribute("list", "id4ListOpenSupp");
            radVal = 2;
            poNumber.value = "";
            poSuppName.value = "";
            poVlpn.value = "";

            // Enable and Disable Select Option
            $("#id4POWgType option[value='0001']").prop("disabled", true);
            $("#id4POWgType option[value='0002']").prop("disabled", false);
            $("#id4POWgType option[value='0003']").prop("disabled", false);
        });

        // Check weight type selected
        $('#id4POWgType').change(function () {
            let wgType = $('#id4POWgType :selected').val();
            let cntWgScale = "<?= countAllRow('tbl_wgscale');?>";
            let i = 0;
            if (wgType === '0002')
                for (i = 1; i <= cntWgScale; i++) {
                    if (i === 1)
                        $("#id4POWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", true);
                    else
                        $("#id4POWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                }
            else {
                for (i = 1; i <= cntWgScale; i++) {
                    $("#id4POWgScale option[value=" + i.toString().padStart(4, '0') + "]").prop("disabled", false);
                }
            }
        });

        // Check weight scale if with pallet type show pallet weight input
        $('#id4POWgScale').change(function () {
            let wgScale = $('#id4POWgScale :selected').val();
            let chkLevel = queryData("php4PO.php?command=checkWgScaleLevel&wgSCaleCode=" + wgScale);
            if (chkLevel === '1') {
                //$("#div4WgPallet").removeClass("d-none");
            } else if (chkLevel === '0') {
                console.log(chkLevel);
                //$("#div4WgPallet").addClass("d-none");
                document.getElementById("id4CntPallet").value = 0;
                document.getElementById("id4Wg4Pallet").value = 0;
                $("#div4WgPallet :input").attr("disabled", true);
            }
            calcWgNet();
        });

        $("#id4POWgNet").on("keyup", function () {
            console.log(document.getElementById("id4CntPallet").value);
        });
    });

    $("#id4POSuppName").on("change", function () {
        list4PO(radVal, poSuppName.value, 'POSuppName', 'po_suppcode');
    });
    $("#id4PONumber").on("change", function () {
        list4PO(radVal, poNumber.value, 'PONumber', 'po_number');
    });
    $("#id4VlpnNumber").on("change", function () {
        list4PO(radVal, poVlpn.value, 'VlpnNumber', 'po_vlpn');
    });
</script>

<script>
    let calcWgNet = function () {
        let cntPallet = document.getElementById("id4CntPallet");
        let wg4Pallet = document.getElementById("id4Wg4Pallet");
        let wgScaleRD = document.getElementById("id4WgScaleRd");
        let wgScaleNet = document.getElementById("id4WgScaleNet");
        // console.log('wgscalerd :' + wgScaleRD.value);

        let A = 0;
        let B = 0;
        let C = 0;
        let D = 0;

        if (cntPallet.value === '')
            cntPallet.value = '0';
        if (wg4Pallet.value === '')
            wg4Pallet.value = '0';
        if (wgScaleRD.value === '')
            wgScaleRD.value = '0';
        if (wgScaleNet.value === '')
            wgScaleNet.value = '0';

        A = parseInt(cntPallet.value);
        B = parseFloat(wg4Pallet.value);
        C = parseFloat(wgScaleRD.value.replace(/,/g, ''));
        // console.log('C =' + C);

        D = C - (A * B);

        wgScaleNet.value = D.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<script>
    $("#id4WgScaleRd").on("keyup", function () {
        this.value = this.value.replace(/,/g, '');
        let value = this.value;
        this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    });
</script>

</body>

</html>