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
            <h2 class="text-warning text-center font-weight-bold">พิมพ์บัตรชั่ง</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card px-3" id="tstPDF">

                        <div class="card-header">
                            <!-- Start of weighting card -->

                            <!-- Row of weighting card header -->
                            <div class="row mt-2">
                                <div class="col-md-2">&nbsp;</div>
                                <div class="col-md-2">
                                    <br>
                                    <img src="./assets/img/logoSm.png" alt="GoldRubber" width="175px">
                                    <br>
                                </div>
                                <div class="col-md-8">
                                    <h5><strong>บริษัท โกลด์ รับเบอร์ จำกัด</strong></h5>
                                    <h6>1/14 หมู่ 10 ตำบลดอนยาง อำเภอปะทิว จังหวัดชุมพร 86210 โทร. 093-779-8364,
                                        080-697-8799</h6>
                                    <h5><strong>Gold Rubber Co., Ltd.</strong></h5>
                                    <h6>1/14 Moo 10 Donyang, Pathiu, Chumphon 86210 Tel. 093-779-8364,
                                        080-697-8799</h6>
                                </div>
                            </div><!-- Row of weighting card header -->
                            <hr>
                            <!-- Row of weighting card details -->
                            <div class="row">
                                <div class="col-md-12 text-center h4" style="margin-top:5px!important;">
                                    <strong>บัตรชั่งน้ำหนัก</strong>
                                </div>
                            </div>

                            <!--<h4 class="card-title">PO Number: <? /*= $poNumber; */ ?> </h4>-->
                            <?php
                            $sqlcmd_1stPOData = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' ORDER BY wg_createdat ASC LIMIT 1";
                            $sqlres_1stPOData = mysqli_query($dbConn, $sqlcmd_1stPOData);
                            if ($sqlres_1stPOData)
                                $sqlfet_1stPOData = mysqli_fetch_assoc($sqlres_1stPOData);


                            //$sqlcmd_lastPOData = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' ORDER BY wg_createdat DESC LIMIT 1";
                            $sqlcmd_lastPOData = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' AND wg_type='0003' ORDER BY wg_createdat DESC LIMIT 1";
                            //echo $sqlcmd_lastPOData;
                            $sqlres_lastPOData = mysqli_query($dbConn, $sqlcmd_lastPOData);
                            if ($sqlres_lastPOData)
                                $sqlfet_lastPOData = mysqli_fetch_assoc($sqlres_lastPOData);
                            ?>

                            <div class="row font-weight-bold">
                                <div class="col-md-2" style="font-size:16px;">หมายเลขบัตรชั่ง</div>
                                <div class="col-md-2 text-primary" style="font-size:16px;"><?= $poNumber; ?></div>
                                <div class="col-md-2" style="font-size:16px;">หมายเลขทะเบียน</div>
                                <div class="col-md-2 text-primary"
                                     style="font-size:16px;"><?= $sqlfet_1stPOData['wg_vlpn']; ?></div>
                                <div class="col-md-2" style="font-size:16px;">ชื่อลูกค้า</div>
                                <div class="col-md-2 text-primary"
                                     style="font-size:16px;"><?= getValue('tbl_suppliers', 'supp_code', $sqlfet_1stPOData['wg_suppcode'], 2, 'supp_name'); ?> <?= getValue('tbl_suppliers', 'supp_code', $sqlfet_1stPOData['wg_suppcode'], 2, 'supp_surname'); ?></div>
                            </div>
                            <div class="row font-weight-bold">
                                <div class="col-md-2" style="font-size:16px;">วันที่เข้า</div>
                                <div class="col-md-2 text-primary"
                                     style="font-size:16px;"><?php
                                    list($yy, $mm, $dd) = explode("-", dateBE(substr($sqlfet_1stPOData['wg_createdat'], 0, 10)));
                                    echo number_format($dd) . "/" . number_format($mm) . "/" . $yy;
                                    ?>
                                </div>
                                <div class="col-md-2" style="font-size:16px;">เวลาเข้า</div>
                                <div class="col-md-2 text-primary"
                                     style="font-size:16px;"><?= substr($sqlfet_1stPOData['wg_createdat'], 11, 27); ?></div>
                                <div class="col-md-2" style="font-size:16px;">น้ำหนักรวม</div>
                                <div class="col-md-2 text-primary"
                                     style="font-size:16px;"><?php
                                    if ($sqlfet_1stPOData['wg_product'] != '0000')
                                        echo "-";
                                    else
                                        echo str_pad(number_format($sqlfet_1stPOData['wg_net'], 0, '.', ','), 8, " ", STR_PAD_LEFT) . " กก."; ?></div>
                            </div>
                            <div class="row font-weight-bold">
                                <div class="col-md-2" style="font-size:16px;">วันที่ออก</div>
                                <div class="col-md-2 text-primary"
                                     style="font-size:16px;"><?php
                                    list($yy, $mm, $dd) = explode("-", dateBE(substr($sqlfet_lastPOData['wg_createdat'], 0, 10)));
                                    echo number_format($dd) . "/" . number_format($mm) . "/" . $yy;
                                    ?>
                                </div>
                                <div class="col-md-2" style="font-size:16px;">เวลาออก</div>
                                <div class="col-md-2 text-primary"
                                     style="font-size:16px;"><?= substr($sqlfet_lastPOData['wg_createdat'], 11, 27); ?></div>
                                <div class="col-md-2" style="font-size:16px;">น้ำหนักรถ</div>
                                <div class="col-md-2 text-primary" style="font-size:16px;"><?php
                                    if ($sqlfet_1stPOData['wg_product'] != '0000') {
                                        echo "-";
                                    } else {
                                        echo str_pad(number_format($sqlfet_lastPOData['wg_net'], 0, '.', ','), 8, " ", STR_PAD_LEFT) . " กก.";
                                    }
                                    ?>
                                </div>
                            </div><!-- Row of weighting card details -->

                            <hr>
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
                                            <th class="text-center" style="width: 200px;">น้ำหนักสุทธิ</th>
                                            <th class="text-center" style="width: 100px;">DRC (%)</th>
                                            <!-- <th class="text-center" style="width: 100px;">หักน้ำ</th>-->
                                            <!-- <th class="text-center" style="width: 200px;">น้ำหนักสุทธิ</th>-->
                                            <th class="text-center" style="width: 150px;">ชั่งเวลา</th>
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
                                                        <!-- WEIGHT -->
                                                        <input class="form-control form-inline text-right <?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-danger" ?>"
                                                               type="text" disabled
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               name="wgNet_<?= $sqlfet_list4PO['id']; ?>"
                                                               id="id4WgNet_<?= $sqlfet_list4PO['id']; ?>"
                                                               value="<?= number_format($sqlfet_list4PO['wg_net'], 2, '.', ','); ?>">
                                                    </td>
                                                    <td class="text-right">
                                                        <!-- DRC -->
                                                        <input class="form-control form-inline text-primary text-right" <?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "disabled"; ?>
                                                               type="text" readonly
                                                               onkeyup="chkKeyEnter4DRC(this.value, <?= $sqlfet_list4PO['id']; ?>)"
                                                               onblur="updateDRC(this.value, <?= $sqlfet_list4PO['id']; ?>)"
                                                               name="DRC_<?= $sqlfet_list4PO['id']; ?>"
                                                               id="id4DRC_<?= $sqlfet_list4PO['id']; ?>"
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               value="<?php
                                                               if ($sqlfet_list4PO['wg_product'] == '0002')
                                                                   echo "-";
                                                               else
                                                                   echo number_format($sqlfet_list4PO['wg_percent'], 2, '.', ','); ?>">
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

                            <!-- WGCARD FOOTER -->
                            <div class="row">
                                <div class="col-md-12">&nbsp;</div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">ผู้ชั่ง _____________________________________</div>
                                <div class="col-md-3">ผู้รับของ __________________________________</div>
                                <div class="col-md-3">ผู้จ่ายเงิน _________________________________</div>
                                <div class="col-md-3">ผู้รับเงิน __________________________________</div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">&nbsp;</div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">WGCARD.REV.0.0.1</div>
                            </div><!-- WGCARD FOOTER -->

                        </div>
                        <!-- End of weighting card -->

                        <!--<div class="row mt-2 mb-5">
                            <div class="col-md-12 text-center">
                                <a href="wgcard_<? /*= $poNumber; */ ?>.pdf" class="btn btn-sm btn-success" target="_blank">พิมพ์บัตรชั่ง</a>
                            </div>
                        </div>-->
                    </div>

                    <!--<div class="row mt-2 mb-5">
                        <div class="col-md-12 text-center">
                            <a href="#" class="btn btn-info">
                                พิมพ์บัตรชั่ง
                            </a>
                        </div>
                    </div>-->

                </div>
            </div>

        </div>

        <!--        <div id="bypassme">--><? //= $html2PRN; ?><!--</div>-->

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
    $("#sub4Buy").addClass("show");
    $("#id4SubMenuBuyPoList").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Bootstrap Tooltip -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script><!-- Bootstrap Tooltip -->

<!-- Calculation for PO -->
<script>
    let poNumber2Upd = '<?=$poNumber;?>';

    let updateBuyPrice = function (wgBuyPrice, wgID) {
        $.ajax({
            url: "calc4PO.php",
            type: "POST",
            data: {
                // poNumber: poNumber2Upd,
                processName: "updatePrice",
                id: wgID,
                buyPrice: wgBuyPrice
            },
            success: function (response) {
                // console.log(response);
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })
        ;
    }

    let chkKeyEnter4BuyPrice = function (buyPrice, buyPrice_ID) {
// Execute a function when the user releases a key on the keyboard
        $("#id4BuyPrice_" + buyPrice_ID).on("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                console.log(event.keyCode);
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                updateBuyPrice(buyPrice, buyPrice_ID);
            }
        });
    }

    let updateDRC = function (wgDRC, wgID) {
        $.ajax({
            url: "calc4PO.php",
            type: "POST",
            data: {
                // poNumber: poNumber2Upd,
                processName: "updateDRC",
                id: wgID,
                valueDRC: wgDRC
            },
            success: function (response) {
                // console.log(response);
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        })
        ;
    }

    let chkKeyEnter4DRC = function (DRC, DRC_ID) {
        let input = document.getElementById("id4DRC_" + DRC_ID);
// Execute a function when the user releases a key on the keyboard
        $("#id4DRC_" + DRC_ID).on("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                updateDRC(DRC, DRC_ID);
            } else {
                if (input.value > 97) {
                    input.value = 97;
                    updateDRC(97, DRC_ID);
                }
            }
        });
    }
</script><!-- Calculation for PO -->

<script>
    // OK waiting to config page size
    /*
    html2canvas(document.getElementById('tstPDF'), {
        onrendered: function (canvas) {
            let data = canvas.toDataURL();
            let docDefinition = {
                content: [{
                    image: data,
                    width: 500
                }]
            };
            pdfMake.createPdf(docDefinition).download("test.pdf");
        }
    });
    */
    // OK waiting to config page size
    // pdfMake.createPdf(docDefinication).download();
</script>

</body>

</html>