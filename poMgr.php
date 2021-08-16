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
            <h2 class="text-warning text-center font-weight-bold">จัดการคำสั่งซื้อ</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header mx-3">
                            <div class="row mt-0">
                                <div class="col-md-10">
                                    <h5 class="card-category"> ข้อมูลรายการ PO </h5>
                                    <h4 class="card-title">PO Number: <?= $poNumber; ?> </h4>
                                </div>
                                <div class="col-md-2 text-right">
                                    <h5 class="card-category">&nbsp;</h5>
                                    <h4 class="card-title">
                                        <a href="./prnWgCard.php?poNumber=<?php echo $poNumber; ?>"
                                           class="btn btn-primary btn-sm">ดูบัตรชั่ง</a>
                                    </h4>
                                </div>
                            </div>
                            <?php
                            $sqlcmd_poSummary = "SELECT DISTINCT(wg_ponum) AS PONUMBER, wg_suppcode, wg_vlpn, po_status FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "'";
                            $sqlres_poSummary = mysqli_query($dbConn, $sqlcmd_poSummary);
                            if ($sqlres_poSummary)
                                $sqlfet_poSummary = mysqli_fetch_assoc($sqlres_poSummary);
                            ?>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <h5 class="card-category"> ชื่อผู้ขาย </h5>
                                    <h5 class="card-title"><?= getValue('tbl_suppliers', 'supp_code', $sqlfet_poSummary['wg_suppcode'], 2, 'supp_name'); ?>
                                        &nbsp;<?= getValue('tbl_suppliers', 'supp_code', $sqlfet_poSummary['wg_suppcode'], 2, 'supp_surname'); ?></h5>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="card-category"> ทะเบียนรถ </h5>
                                    <h5 class="card-title"><?= $sqlfet_poSummary['wg_vlpn']; ?></h5>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="card-category"> สถานะการซื้อ </h5>
                                    <h5 class="card-title"><?php
                                        if ($sqlfet_poSummary['po_status'] === '1')
                                            echo "เปิดอยู่";
                                        else
                                            echo "ปิดแล้ว";
                                        ?></h5>
                                </div>
                            </div>
                        </div>

                        <!-- Begin of FORM -->
                        <!--<form action="" method="post">-->
                        <div class="card-body mx-4">
                            <div class="row mt-3">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <thead class="font-weight-bold bg-primary">
                                            <th class="text-center" style="width: 25px;">#</th>
                                            <!--<th>ประเภทการชั่ง</th>-->
                                            <th class="text-center" style="width: 75px;">เวลา</th>
                                            <th>สินค้า</th>
                                            <th class="text-right" style="width: 150px;">น้ำหนักยาง</th>
                                            <th class="text-center" style="width: 100px;">DRC (%)</th>
                                            <th class="text-center" style="width: 75px;">หักน้ำ</th>
                                            <th class="text-center" style="width: 150px;">น้ำหนักสุทธิ</th>
                                            <th class="text-center" style="width: 100px;">ราคาซื้อ</th>
                                            <th class="text-center" style="width: 150px;">เป็นเงิน</th>
                                            <th class="text-center" style="width: 125px;">ประเภทซื้อ</th>
                                            <th class="text-center" style="width: 125px;">สถานที่ลง</th>
                                            </thead>
                                        </tr>
                                        <tbody>
                                        <?php
                                        $cntWg = 0;
                                        $sqlcmd_list4PO = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $poNumber . "' ORDER BY wg_createdat ASC";
                                        $sqlres_list4PO = mysqli_query($dbConn, $sqlcmd_list4PO);
                                        if ($sqlres_list4PO) {
                                            $cntRow = mysqli_num_rows($sqlres_list4PO);
                                            // echo $cntRow;
                                            while ($sqlfet_list4PO = mysqli_fetch_assoc($sqlres_list4PO)) {
                                                ?>
                                                <tr>
                                                    <td class="text-center0"><?= ++$cntWg; ?></td>
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
                                                    <td class="text-center"><?= substr($sqlfet_list4PO['wg_createdat'], 11, 17); ?></td>
                                                    <td><?php
                                                        if ($sqlfet_list4PO['wg_product'] == '0000') {
                                                            echo "ชั่งรถ";
                                                        } else {
                                                            echo getValue('tbl_products', 'product_code', $sqlfet_list4PO['wg_product'], 2, 'product_name');
                                                        }
                                                        ?></td>
                                                    <td class="text-right px-0">
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
                                                    <td>
                                                        <input class="form-control form-inline text-primary text-right"
                                                               type="text" disabled
                                                               name=""
                                                               id=""
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               value="<?= round(($sqlfet_list4PO['wg_net'] * (round((97 - $sqlfet_list4PO['wg_percent']), 2))) / 100); ?>">
                                                    </td>
                                                    <td>
                                                        <!-- wg_net-(wg_net*wg_percent) -->
                                                        <input class="form-control form-inline text-primary text-right"
                                                               type="text" disabled
                                                               name=""
                                                               id=""
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               value="<?= number_format($sqlfet_list4PO['wg_net'] - (round(($sqlfet_list4PO['wg_net'] * (round((97 - $sqlfet_list4PO['wg_percent']), 2))) / 100)), 2, '.', ','); ?>">

                                                    </td>
                                                    <td>
                                                        <input class="form-control form-inline text-primary text-right" <?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "disabled"; ?>
                                                               type="text"
                                                               onkeyup="chkKeyEnter4BuyPrice(this.value, <?= $sqlfet_list4PO['id']; ?>)"
                                                               onblur="updateBuyPrice(this.value, <?= $sqlfet_list4PO['id']; ?>)"
                                                               name="buyPrice_<?= $sqlfet_list4PO['id']; ?>"
                                                               id="id4BuyPrice_<?= $sqlfet_list4PO['id']; ?>"
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               value="<?= number_format($sqlfet_list4PO['wg_buyprc'], 2, '.', ','); ?>">
                                                    </td>
                                                    <td><!-- รวมเป็นเงิน -->
                                                        <input class="form-control form-inline text-primary text-right"
                                                               type="text" disabled
                                                               name="sumBuyPrice_<?= $sqlfet_list4PO['id']; ?>"
                                                               id="id4SumBuyPrice_<?= $sqlfet_list4PO['id']; ?>"
                                                               style="font-size:14px;<?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                               value="<?php
                                                               $wgMinus = round(($sqlfet_list4PO['wg_net'] * (round((97 - $sqlfet_list4PO['wg_percent']), 2))) / 100);
                                                               $wg2Calc = $sqlfet_list4PO['wg_net'] - $wgMinus;
                                                               echo number_format(($sqlfet_list4PO['wg_buyprc'] * $wg2Calc), 2, '.', ',');
                                                               ?>">
                                                    </td>
                                                    <td class="text-left pl-3" style="font-size:16px">
                                                        <?//= getValue('tbl_buytype', 'buytype_code', $sqlfet_list4PO['wg_buytype'], 2, 'buytype_name'); ?>
                                                        <?php if ($sqlfet_list4PO['wg_product'] != '0000') { ?>
                                                            <select name=""
                                                                    id="id4BuyType_<?= $sqlfet_list4PO['id']; ?>"
                                                                    class="form-control form-inline"
                                                                    onchange="updateBuyType(this.value, <?= $sqlfet_list4PO['id']; ?>)">
                                                                <?php
                                                                $sqlcmd_listBuyType = "SELECT * FROM tbl_buytype WHERE 1 ORDER BY buytype_code ASC";
                                                                $sqlres_listBuyType = mysqli_query($dbConn, $sqlcmd_listBuyType);
                                                                if ($sqlres_listBuyType) {
                                                                    while ($sqlfet_listBuyType = mysqli_fetch_assoc($sqlres_listBuyType)) {
                                                                        ?>
                                                                        <option value="<?= $sqlfet_listBuyType['buytype_code']; ?>" <?php if ($sqlfet_list4PO['wg_buytype'] == $sqlfet_listBuyType['buytype_code']) echo "selected"; ?>><?= $sqlfet_listBuyType['buytype_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="text-left pl-3" style="font-size:16px">
                                                        <?php if ($sqlfet_list4PO['wg_product'] != '0000') { ?>
                                                            <select name=""
                                                                    id="id4Location_<?= $sqlfet_list4PO['id']; ?>"
                                                                    class="form-control form-inline"
                                                                    onchange="updateLocation(this.value, <?= $sqlfet_list4PO['id']; ?>)">
                                                                <?php
                                                                $sqlcmd_listLocation = "SELECT * FROM tbl_locations WHERE 1 ORDER BY loc_code ASC";
                                                                $sqlres_listLocation = mysqli_query($dbConn, $sqlcmd_listLocation);
                                                                if ($sqlres_listLocation) {
                                                                    while ($sqlfet_listLocation = mysqli_fetch_assoc($sqlres_listLocation)) {
                                                                        ?>
                                                                        <option value="<?= $sqlfet_listLocation['loc_code']; ?>" <?php if ($sqlfet_list4PO['wg_location'] == $sqlfet_listLocation['loc_code']) echo "selected"; ?>><?= $sqlfet_listLocation['loc_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
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
                                            <td class="text-right" colspan="3"></td>
                                            <!-- น้ำหนักยางไม่รวมรถ -->
                                            <td class="text-right"><label for="id4NoVehWg" class="text-dark"
                                                                          style="font-size:14px;">น้ำหนักยางไม่รวมรถ
                                                    (กก.)</label>
                                                <input type="text" name="noVehWg" id="id4NoVehWg" disabled
                                                       style="font-size:14px;"
                                                       pattern="^\d*(\.\d{0,2})?$"
                                                       class="form-control form-inline text-right text-primary font-weight-bold"
                                                       value="<?= number_format($sqlfet_calcWg['SUMWG'], 2, '.', ','); ?>">
                                            </td><!-- น้ำหนักยางไม่รวมรถ -->
                                            <td></td>
                                            <td></td>
                                            <!-- น้ำหนักยางหัก % น้ำ -->
                                            <td class="text-right"><label for="id4MinusPercentWater"
                                                                          class="text-dark"
                                                                          style="font-size:14px;">น้ำหนักยางหัก %
                                                    น้ำ (กก.)</label><input type="text" name="minusPercentWater"
                                                                            id="id4MinusPercentWater" disabled
                                                                            style="font-size:14px;"
                                                                            class="form-control form-inline text-primary text-right font-weight-bold"
                                                                            value="<?= calcWgMinusWater4PO($poNumber); ?>">
                                            </td><!-- น้ำหนักยางหัก % น้ำ -->
                                            <td>&nbsp;</td>
                                            <!-- ราคารับซื้อ -->
                                            <td class="text-right"><label for="id4BuyPrice"
                                                                          class="text-dark"
                                                                          style="font-size:14px;">รวมซื้อยาง
                                                    <div>(บาท)</div>
                                                </label><input
                                                        type="text" name="sumBuyPrice" id="id4SumBuyPrice"
                                                        style="font-size:14px;" disabled
                                                        class="form-control form-inline text-primary text-right font-weight-bold"
                                                        value="<?= calcWgWithBuyPrice($poNumber); ?>">
                                            </td><!-- ราคารับซื้อ -->
                                            <!-- Empty column -->
                                            <td></td><!-- Empty column -->
                                            <td></td><!-- Empty column -->
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!--</form>--><!-- End of FORM -->

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
        });
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

    let updateBuyType = function (buyType, buyType_ID) {
        $.ajax({
            url: "calc4PO.php",
            type: "POST",
            data: {
                // poNumber: poNumber2Upd,
                processName: "updateBuyType",
                id: buyType_ID,
                valueBuyType: buyType
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
        });
    }

    let updateLocation = function (LOC, LOC_ID) {
        $.ajax({
            url: "calc4PO.php",
            type: "POST",
            data: {
                // poNumber: poNumber2Upd,
                processName: "updateLocation",
                id: LOC_ID,
                valueLocation: LOC
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
        });
    }
</script><!-- Calculation for PO -->

</body>

</html>