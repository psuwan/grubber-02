<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");

$poNumber = filter_input(INPUT_GET, 'poNumber');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <link rel="icon" type="image/png" href="./assets/img/faviconW.ico">
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/jquery.dataTables.min.css">

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

        <div class="panel-header h-auto">
            <h2 class="text-warning text-center font-weight-bold">รายงานซื้อ</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card px-3">

                        <div class="card-header">
                            <!-- Start of weighting card -->

                            <!-- Row of weighting card details -->
                            <div class="row">
                                <div class="col-md-3 h4" style="margin-top:5px!important;">
                                    <strong>เลือกวันที่ต้องการ</strong>
                                </div>
                                <div class="col-md-3 h4" style="margin-top:5px!important;">
                                    <input type="text" name="" id="id4Date2Report">
                                </div>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <thead class="font-weight-bold bg-primary">
                                            <th class="text-center">#</th>
                                            <!--<th>ประเภทการชั่ง</th>-->
                                            <th>สินค้า</th>
                                            <th class="text-center">น้ำหนักสุทธิ</th>
                                            <th class="text-center">DRC (%)</th>
                                            <!-- <th class="text-center" style="width: 100px;">หักน้ำ</th>-->
                                            <!-- <th class="text-center" style="width: 200px;">น้ำหนักสุทธิ</th>-->
                                            <th class="text-center">ชั่งเวลา</th>
                                            </thead>
                                        </tr>
                                        <tbody>
                                        <?php
                                        $cntWg = 0;
                                        $sqlcmd_list4PO = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' AND wg_product<>'0000' ORDER BY wg_createdat ASC";
                                        $sqlres_list4PO = mysqli_query($dbConn, $sqlcmd_list4PO);
                                        if ($sqlres_list4PO) {
                                            $cntRow = mysqli_num_rows($sqlres_list4PO);
                                            // echo $cntRow;
                                            while ($sqlfet_list4PO = mysqli_fetch_assoc($sqlres_list4PO)) {
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= ++$cntWg; ?></td>
                                                    <!--<td><?php
                                                    switch ($sqlfet_list4PO['wg_type']) {
                                                        case '0001':
                                                            echo "ชั่งเข้า (รถและสินค้า)";
                                                            break;

                                                        case '0002':
                                                            echo "ชั่งแยกประเภทสินค้า";
                                                            break;

                                                        case '0003':
                                                            echo "ชั่งออก (รถเปล่า)";
                                                            break;

                                                        default:
                                                            break;
                                                    }
                                                    ?>
                                                        </td>-->
                                                    <td style="font-size:16px;"><?php
                                                        if ($sqlfet_list4PO['wg_product'] == '0000') {
                                                            echo "ชั่งรถ";
                                                        } else {
                                                            echo getValue('tbl_products', 'product_code', $sqlfet_list4PO['wg_product'], 2, 'product_name');
                                                        }
                                                        ?></td>
                                                    <td class="text-right">
                                                        <input class="form-control form-inline text-right <?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-danger" ?>"
                                                               type="text" disabled
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               name="wgNet_<?= $sqlfet_list4PO['id']; ?>"
                                                               id="id4WgNet_<?= $sqlfet_list4PO['id']; ?>"
                                                               value="<?= number_format($sqlfet_list4PO['wg_net'], 2, '.', ','); ?>">
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-inline text-primary text-right" <?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "disabled"; ?>
                                                               type="text"
                                                               onkeyup="chkKeyEnter4DRC(this.value, <?= $sqlfet_list4PO['id']; ?>)"
                                                               onblur="updateDRC(this.value, <?= $sqlfet_list4PO['id']; ?>)"
                                                               name="DRC_<?= $sqlfet_list4PO['id']; ?>"
                                                               id="id4DRC_<?= $sqlfet_list4PO['id']; ?>"
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               value="<?= number_format($sqlfet_list4PO['wg_percent'], 2, '.', ','); ?>">
                                                    </td>
                                                    <!--<td>
                                                        <input class="form-control form-inline text-primary text-right"
                                                               type="text" disabled
                                                               name=""
                                                               id=""
                                                               style="font-size:14px;<?php /*if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" */ ?>"
                                                               value="<?/*= round(($sqlfet_list4PO['wg_net'] * (round((97 - $sqlfet_list4PO['wg_percent']), 2))) / 100); */ ?>">
                                                    </td>-->
                                                    <!--<td>
                                                        <input class="form-control form-inline text-primary text-right"
                                                               type="text" disabled
                                                               name=""
                                                               id=""
                                                               style="font-size:14px;<?php /*if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" */ ?>"
                                                               value="<?/*= number_format($sqlfet_list4PO['wg_net'] - (round(($sqlfet_list4PO['wg_net'] * (round((97 - $sqlfet_list4PO['wg_percent']), 2))) / 100)), 2, '.', ','); */ ?>">

                                                    </td>-->
                                                    <td class="text-center"><?= substr($sqlfet_list4PO['wg_createdat'], 11, 12); ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        <tr>
                                            <?php
                                            $sqlcmd_calcWg = "SELECT SUM(wg_net) AS SUMWG FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' AND wg_product <> '0000'";
                                            $sqlres_calcWg = mysqli_query($dbConn, $sqlcmd_calcWg);
                                            if ($sqlres_calcWg) {
                                                $sqlfet_calcWg = mysqli_fetch_assoc($sqlres_calcWg);
                                            }
                                            ?>
                                            <td class="text-right"></td>
                                            <td class="text-right font-weight-bold"> รวม</td>
                                            <!-- น้ำหนักยางไม่รวมรถ -->
                                            <td class="text-right"><!--<label for="id4NoVehWg" class="text-dark"
                                                                          style="font-size:14px;">น้ำหนักยางไม่รวมรถ
                                                    (กก.)</label>-->
                                                <input type="text" name="noVehWg" id="id4NoVehWg" disabled
                                                       style="font-size:14px;"
                                                       pattern="^\d*(\.\d{0,2})?$"
                                                       class="form-control form-inline text-right text-primary font-weight-bold"
                                                       value="<?= number_format($sqlfet_calcWg['SUMWG'], 2, '.', ','); ?>">
                                            </td><!-- น้ำหนักยางไม่รวมรถ -->
                                            <!--<td></td>-->
                                            <!-- น้ำหนักยางหัก % น้ำ -->
                                            <!--<td class="text-right"><label for="id4MinusPercentWater"
                                                                          class="text-dark"
                                                                          style="font-size:14px;">น้ำหนักยางหัก
                                                    %
                                                    น้ำ (กก.)</label><input type="text" name="minusPercentWater"
                                                                            id="id4MinusPercentWater" disabled
                                                                            style="font-size:14px;"
                                                                            class="form-control form-inline text-primary text-right font-weight-bold"
                                                                            value="<? /*= calcWgMinusWater4PO($poNumber); */ ?>">
                                            </td>--><!-- น้ำหนักยางหัก % น้ำ -->
                                            <!-- Empty column -->
                                            <td></td><!-- Empty column -->
                                            <td></td><!-- Empty column -->
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- End of weighting card -->

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

<!--   Core JS Files   -->
<script src="./js/core/jquery.min.js"></script>
<script src="./js/core/popper.min.js"></script>
<script src="./js/core/bootstrap.min.js"></script>
<script src="./js/plugins/perfect-scrollbar.jquery.min.js"></script>

<!--  Notifications Plugin    -->
<script src="./js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>
<script src="./js/jquery.dataTables.min.js"></script>


<!--<script src="./js/jspdf.min.js"></script>-->
<!--<script src="./js/THSarabun-normal.js" type="module"></script>-->
<!--<script src="./js/jspdf.customfonts.min.js"></script>-->
<!--<script src="./js/default_vfs.js"></script>-->
<!--<script src="./js/html2pdf.bundle.min.js"></script>-->
<!--<script src="./js/xepOnline.jqPlugin.js"></script>-->
<script src="./js/html2canvas.js"></script>
<script src="./js/pdfmake.min.js"></script>
<script src="./js/vfs_fonts.js"></script>
<!-- Hi-light active menu -->
<script>
    // $("#id4MenuBuy").addClass("active");
    // $("#id4AlinkMenuBuy").addClass("text-primary");
    // $("#id4IconMenuBuy").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Report").addClass("show");
    $("#id4SubMenuReportBuy").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Bootstrap Tooltip -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script><!-- Bootstrap Tooltip -->


</body>

</html>