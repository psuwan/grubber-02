<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");

// Initial parameter
$soNumber = filter_input(INPUT_GET, 'soNumber');
$thisFile = basename(__FILE__, '.php');
$enableCalcWgButton = 0;

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
    <link rel="stylesheet" href="./css/style4Project.css">
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
            <h2 class="text-warning text-center font-weight-bold">จัดการคำสั่งขาย</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header mx-3">
                            <div class="row mt-0">
                                <div class="col-md-8">
                                    <h5 class="card-category"> ข้อมูลรายการ SO </h5>
                                    <h4 class="card-title">SO Number: <?= $soNumber; ?></h4>
                                </div>
                                <div class="col-md-4 text-right">
                                    <h5 class="card-category">&nbsp;</h5>
                                    <h4 class="card-title">

                                        <!-- CALCULATION FOR WEIGHT -->
                                        <?php
                                        $sqlcmd_cntWg = "SELECT * FROM tbl_wg4sell WHERE wg_sonum='" . $soNumber . "'";
                                        $sqlres_cntWg = mysqli_query($dbConn, $sqlcmd_cntWg);
                                        if ($sqlres_cntWg) {
                                            $wgArr = array();
                                            $sqlnum_cntWg = mysqli_num_rows($sqlres_cntWg);
                                            if ($sqlnum_cntWg === 2) {
                                                foreach ($sqlres_cntWg as $key => $val) {
                                                    $wgArr[] = $val;
                                                }
                                                if (($wgArr[0]['wg_code4product'] === '0000') && ($wgArr[1]['wg_code4product'] === '0000')) {
                                                    $enableCalcWgButton = 1;
                                                    $wgNetCalc = $wgArr[1]['wg_net'] - $wgArr[0]['wg_net'];
                                                }
                                            }
                                        }

                                        if ($enableCalcWgButton === 1) {
                                            ?>
                                            <a href="./calc4SO.php?command=calc4Wg2Time&soNumber=<?= $soNumber; ?>&soVLpn=<?= $wgArr[0]['wg_vlpn']; ?>&soSuppLogisCode=<?= $wgArr[0]['wg_code4supplogis']; ?>&soWgNet=<?= $wgNetCalc; ?>&soCustomer=<?= $wgArr[0]['wg_code4customer']; ?>"
                                               class="btn btn-primary btn-sm">คำนวณน้ำหนัก</a>
                                            <?php
                                        } else {
                                            ?><!-- CALCULATION FOR WEIGHT -->

                                            <!-- <a href="./prnWgCardSO.php?soNumber=<?php //echo $soNumber; ?>"
                                               class="btn btn-primary btn-sm btn-round pt-2" style="height:38px">ดูบัตรชั่ง</a> -->
                                            <?php
                                        }
                                        ?>
                                    </h4>
                                </div>
                            </div>
                            <?php
                            $sqlcmd_soSummary = "SELECT DISTINCT(wg_sonum) AS SONUMBER, wg_code4supplogis, wg_code4customer, wg_vlpn, so_status, wg_labour FROM tbl_wg4sell WHERE wg_sonum='" . $soNumber . "'";
                            $sqlres_soSummary = mysqli_query($dbConn, $sqlcmd_soSummary);
                            if ($sqlres_soSummary)
                                $sqlfet_soSummary = mysqli_fetch_assoc($sqlres_soSummary);
                            ?>
                            <!-- SUPPLIER LOGISTICS DETAILS -->
                            <div class="row mt-2">
                                <!-- CUSTOMERS NAME -->
                                <!-- <div class="col-md-3">
                                    <h5 class="card-category"> ชื่อลูกค้า </h5>
                                    <h5 class="card-title"><? //= getValue('tbl_customers', 'customer_code', $sqlfet_soSummary['wg_code4customer'], 2, 'customer_name'); ?>
                                        &nbsp;<? //= getValue('tbl_customers', 'customer_code', $sqlfet_soSummary['wg_code4customer'], 2, 'customer_surname'); ?></h5>
                                </div>--><!-- CUSTOMERS NAME -->

                                <!-- SUPPLIER NAME -->
                                <div class="col-md-3">
                                    <h5 class="card-category"> เจ้าของรถขนส่ง </h5>
                                    <h5 class="card-title"><?= getValue('tbl_supplogis', 'supplogis_code', $sqlfet_soSummary['wg_code4supplogis'], 2, 'supplogis_name'); ?></h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="card-category"> รถขนส่ง </h5>
                                    <h5 class="card-title"><?= $sqlfet_soSummary['wg_vlpn']; ?></h5>
                                </div>
                                <div class="col-md-3">
                                    <h5 class="card-category"> สถานะการซื้อ </h5>
                                    <h5 class="card-title"><?php
                                        if ($sqlfet_soSummary['so_status'] === '1') {
                                            echo "เปิดอยู่";
                                            echo "&nbsp;";
                                            echo "&nbsp;";
                                            echo "<a href=\"./process4SO.php?command=toggleStatus&returnPage=" . $thisFile . ".php&soNumber=" . $soNumber . "\"><i class=\"now-ui-icons media-1_button-power text-success\"></i></a>";
                                        } else {
                                            echo "ปิดแล้ว";
                                            echo "&nbsp;";
                                            echo "&nbsp;";
                                            echo "<a href=\"./process4SO.php?command=toggleStatus&returnPage=" . $thisFile . ".php&soNumber=" . $soNumber . "\"><i class=\"now-ui-icons media-1_button-power text-danger\"></i></a>";
                                        }
                                        ?></h5>
                                </div>
                                <div class="col-md-2">
                                    <h5 class="card-category"> ค่าแรงลงยางปลายทาง (บาท)</h5>
                                    <h5 class="card-title">
                                        <input type="text" name="" id="id4WgLabour"
                                               class="form-control form-control-sm text-center text-primary"
                                               onblur="updateWgLabour(this.value, '<?= $soNumber; ?>')"
                                               onkeyup="chkKeyEnter4WgLabour(this.value, '<?= $soNumber; ?>')"
                                               placeholder="<?= number_format($sqlfet_soSummary['wg_labour'], 2, '.', ','); ?>">
                                    </h5>
                                </div>
                            </div><!-- SUPPLIER LOGISTICS DETAILS -->
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
                                            <th class="text-center" style="width: 100px;">เวลา</th>
                                            <th>สินค้า</th>
                                            <th class="text-center" style="width: 200px;">ลูกค้า</th>
                                            <th class="text-right" style="width: 150px;">นน.ต้นทาง</th>
                                            <th class="text-right" style="width: 150px;">นน.ปลายทาง</th>
                                            <th class="text-center" style="width: 120px;">คัดคืน</th>
                                            <th class="text-center" style="width: 120px;">DRC (%)</th>
                                            <!--<th class="text-center" style="width: 75px;">หักน้ำ</th>-->
                                            <th class="text-center" style="width: 175px;">น้ำหนักขายสุทธิ</th>
                                            </thead>
                                        </tr>
                                        <tbody>
                                        <?php
                                        $cntWg = 0;
                                        $sqlcmd_list4SO = "SELECT * FROM tbl_wg4sell WHERE wg_sonum='" . $soNumber . "' ORDER BY wg_created ASC";
                                        $sqlres_list4SO = mysqli_query($dbConn, $sqlcmd_list4SO);
                                        if ($sqlres_list4SO) {
                                            $cntRow = mysqli_num_rows($sqlres_list4SO);
                                            // echo $cntRow;
                                            while ($sqlfet_list4SO = mysqli_fetch_assoc($sqlres_list4SO)) {
                                                ?>
                                                <tr>
                                                    <td class="text-center0"><?= ++$cntWg; ?></td>

                                                    <!-- WEIGHTING TYPE -->
                                                    <!--<td>
                                                    <?php
                                                    /*
                                                    switch ($sqlfet_list4SO['wg_type']) {
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
                                                    */
                                                    ?>
                                                        </td>--><!-- WEIGHTING TYPE -->

                                                    <!-- WEIGHTING DATE -->
                                                    <td class="">
                                                        <div><?= monthThai(dateBE(substr($sqlfet_list4SO['wg_created'], 0, 10))); ?></div><?= substr($sqlfet_list4SO['wg_created'], 11, 17); ?>
                                                    </td>
                                                    <!-- WEIGHTING DATE -->

                                                    <!-- PRODUCT -->
                                                    <td><?php
                                                        if ($sqlfet_list4SO['wg_code4product'] == '0000') {
                                                            echo "ชั่งรถ";
                                                        } else {
                                                            $prdTWg = $sqlfet_list4SO['wg_code4product'];
                                                            $prdTWgName = getValue('tbl_products', 'product_code', $sqlfet_list4SO['wg_code4product'], 2, 'product_name');
                                                            //echo $prdTWgName;
                                                            ?>
                                                            <div class="selectWrapper1">
                                                                <select name="" id="id4PrdNameTWg"
                                                                        style="font-size:14px;"
                                                                        onchange="updateProduct(this.value, <?= $sqlfet_list4SO['id']; ?>)"
                                                                        class="form-control form-inline selectBox2">
                                                                    <?php
                                                                    $sqlcmd_listProducts = "SELECT * FROM tbl_products WHERE 1 ORDER BY product_order ASC";
                                                                    $sqlres_listProducts = mysqli_query($dbConn, $sqlcmd_listProducts);
                                                                    if ($sqlres_listProducts) {
                                                                        while ($sqlfet_listProducts = mysqli_fetch_assoc($sqlres_listProducts)) {
                                                                            ?>
                                                                            <option value="<?= $sqlfet_listProducts['product_code']; ?>" <?php if ($sqlfet_listProducts['product_code'] == $prdTWg) echo "selected"; ?>><?= $sqlfet_listProducts['product_name']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td><!-- PRODUCT -->

                                                    <!-- CUSTOMERS -->
                                                    <td class="text-left pl-3" style="font-size:16px">
                                                        <?php if ($sqlfet_list4SO['wg_code4product'] != '0000') { ?>
                                                            <div class="selectWrapper1">
                                                                <select name=""
                                                                        id="id4Location_<?= $sqlfet_list4SO['id']; ?>"
                                                                        class="form-control form-inline selectBox2"
                                                                        onchange="updateLocation(this.value, <?= $sqlfet_list4SO['id']; ?>)">
                                                                    <?php
                                                                    $sqlcmd_listCustomers = "SELECT * FROM tbl_customers WHERE 1";
                                                                    $sqlres_listCustomers = mysqli_query($dbConn, $sqlcmd_listCustomers);
                                                                    if ($sqlres_listCustomers) {
                                                                        while ($sqlfet_listCustomers = mysqli_fetch_assoc($sqlres_listCustomers)) {
                                                                            ?>
                                                                            <!--<option value="<?/*= $sqlfet_listCustomers['customer_code']; */ ?>" <?php /*if ($sqlfet_list4SO['wg_location'] == $sqlfet_listCustomers['loc_code']) echo "selected"; */ ?>><?/*= $sqlfet_listCustomers['loc_name']; */ ?></option>-->
                                                                            <option value="<?= $sqlfet_listCustomers['customer_code']; ?>"><?= $sqlfet_listCustomers['customer_name']; ?>
                                                                                &nbsp;<?= $sqlfet_listCustomers['customer_surname']; ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td><!-- CUSTOMERS -->

                                                    <!-- WEIGHT OF PRODUCT GOLD RUBBER -->
                                                    <td class="text-right px-0">
                                                        <?php
                                                        if ($sqlfet_list4SO['wg_code4product'] == '0000') {
                                                            ?>
                                                            <input class="form-control form-inline text-right"
                                                                   type="text" disabled
                                                                   style="font-size:14px;<?php if ($sqlfet_list4SO['wg_code4product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                                   placeholder="-"
                                                                   name="wgNet_<?= $sqlfet_list4SO['id']; ?>"
                                                                   id="id4WgNet_<?= $sqlfet_list4SO['id']; ?>"
                                                                   value="">
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <input class="form-control form-inline text-right <?php if ($sqlfet_list4SO['wg_code4product'] == '0000') echo "text-danger" ?>"
                                                                   type="text" disabled
                                                                   style="font-size:14px;<?php if ($sqlfet_list4SO['wg_code4product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                                   name="wgNet_<?= $sqlfet_list4SO['id']; ?>"
                                                                   id="id4WgNet_<?= $sqlfet_list4SO['id']; ?>"
                                                                   value="<?= number_format($sqlfet_list4SO['wg_net'], 2, '.', ','); ?>">
                                                            <?php
                                                        }
                                                        ?>
                                                    </td><!-- WEIGHT OF PRODUCT GOLD RUBBER -->

                                                    <!-- WEIGHT OF PRODUCT CUSTOMERS -->
                                                    <td class="text-right">
                                                        <?php if ($sqlfet_list4SO['wg_code4product'] == '0000') { ?>
                                                            <input type="text" name="" id="" disabled
                                                                   style="text-decoration: :line-through;"
                                                                   class="form-control form-inline text-right"
                                                                   value="-">
                                                        <?php } else { ?>
                                                            <input type="text" name="" id="id4_wgDestination"
                                                                   style="font-size:14px;"
                                                                   class="form-control form-inline text-right"
                                                                   onkeyup="chkKeyEnter4WgDestination(this.value, <?= $sqlfet_list4SO['id']; ?>)"
                                                                   onblur="updateWeightDestination(this.value, <?= $sqlfet_list4SO['id']; ?>)"
                                                                   value="<?= number_format($sqlfet_list4SO['wg_destination'], 2, '.', ','); ?>">
                                                            <?php
                                                            $wgDifference = $sqlfet_list4SO['wg_net'] - $sqlfet_list4SO['wg_destination'];
                                                            if ($wgDifference == $sqlfet_list4SO['wg_net'])
                                                                echo "<span class=\"text-info\">รอน้ำหนักปลายทาง</span>";
                                                            else {
                                                                if ($wgDifference < 0)
                                                                    echo "<span class=\"text-danger\">ขาด : " . number_format(($wgDifference * (-1)), 2, '.', ',') . " กก.</span>";
                                                                elseif ($wgDifference > 0)
                                                                    echo "<span class=\"text-success\">เกิน : " . number_format(($wgDifference * (1)), 2, '.', ',') . " กก.</span>";
                                                            }
                                                            ?>
                                                        <?php } ?>
                                                    </td><!-- WEIGHT OF PRODUCT CUSTOMERS -->

                                                    <!-- RETURN -->
                                                    <td>
                                                        <?php if ($sqlfet_list4SO['wg_code4product'] == '0000') { ?>
                                                            <input type="text" name="" id="" disabled
                                                                   style="text-decoration: line-through;"
                                                                   class="form-control form-inline text-right"
                                                                   value="-">
                                                        <?php } else { ?>
                                                            <input type="text" name="wgReturn" id="id4_wgReturn"
                                                                   style="font-size:14px;"
                                                                   onkeyup="chkKeyEnter4WgReturn(this.value, <?= $sqlfet_list4SO['id']; ?>)"
                                                                   onblur="updateWeightReturn(this.value, <?= $sqlfet_list4SO['id']; ?>)"
                                                                   class="form-control form-inline text-right"
                                                                   value="<?= number_format($sqlfet_list4SO['wg_return'], 2, '.', ','); ?>">
                                                        <?php } ?>
                                                    </td><!-- RETURN -->

                                                    <!-- DRC -->
                                                    <td class="text-right">
                                                        <!-- CHECK FOR PRODUCT 0000(VEHICLE) AND 0002(RUBBER-02) DISABLED -->
                                                        <?php
                                                        if (($sqlfet_list4SO['wg_code4product'] == '0002') || (($sqlfet_list4SO['wg_code4product'] == '0000'))) {
                                                            ?>
                                                            <input class="form-control form-inline text-primary text-right"
                                                                   type="text"
                                                                   style="font-size:14px;<?php if ($sqlfet_list4SO['wg_code4product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                                   disabled
                                                                   value="-">
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <input class="form-control form-inline text-primary text-right"
                                                                   type="text"
                                                                   onkeyup="chkKeyEnter4DRC(this.value, <?= $sqlfet_list4SO['id']; ?>)"
                                                                   onblur="updateDRC(this.value, <?= $sqlfet_list4SO['id']; ?>)"
                                                                   name="DRC_<?= $sqlfet_list4SO['id']; ?>"
                                                                   id="id4DRC_<?= $sqlfet_list4SO['id']; ?>"
                                                                   style="font-size:14px;<?php if ($sqlfet_list4SO['wg_code4product'] == '0000') echo "text-decoration: line-through;" ?>"
                                                                   value="<?= number_format($sqlfet_list4SO['wg_percent'], 2, '.', ','); ?>">
                                                            <span class="text-info">หักน้ำ : <?php
                                                                $wgWater = round((($sqlfet_list4SO['wg_destination'] - $sqlfet_list4SO['wg_return']) * (round((97 - $sqlfet_list4SO['wg_percent']), 2))) / 100);
                                                                echo number_format($wgWater, 2, '.', ',');
                                                                echo " กก.";
                                                                ?></span>
                                                            <?php
                                                        }
                                                        ?>
                                                    </td><!-- DRC -->

                                                    <!-- WEIGHT OF WATER -->
                                                    <!--<td>
                                                        <?php
                                                    /*                                                        if (($sqlfet_list4SO['wg_code4product'] == '0000') || ($sqlfet_list4SO['wg_code4product'] == '0002')) {
                                                                                                                */ ?>
                                                            <input class="form-control form-inline text-primary text-right"
                                                                   type="text" disabled
                                                                   name=""
                                                                   id=""
                                                                   style="font-size:14px;<?php /*if ($sqlfet_list4SO['wg_code4product'] == '0000') echo "text-decoration: line-through;" */ ?>"
                                                                   value="-">
                                                            <?php
                                                    /*                                                        } else {
                                                                                                                */ ?>
                                                            <input class="form-control form-inline text-primary text-right"
                                                                   type="text" disabled
                                                                   name=""
                                                                   id=""
                                                                   style="font-size:14px;<?php /*if ($sqlfet_list4SO['wg_code4product'] == '0000') echo "text-decoration: line-through;" */ ?>"
                                                                   value="<?/*= round(($sqlfet_list4SO['wg_net'] * (round((97 - $sqlfet_list4SO['wg_percent']), 2))) / 100); */ ?>">
                                                            <?php
                                                    /*                                                        }
                                                                                                            */ ?>
                                                    </td>--><!-- WEIGHT OF WATER -->

                                                    <!-- NET WEIGHT -->
                                                    <!-- wg_net-(wg_net*wg_percent) -->
                                                    <td>
                                                        <?php
                                                        // number_format($sqlfet_list4SO['wg_net'] - (round(($sqlfet_list4SO['wg_net'] * (round((97 - $sqlfet_list4SO['wg_percent']), 2))) / 100)), 2, '.', ',')
                                                        //$wgWater = round((($sqlfet_list4SO['wg_destination'] - $sqlfet_list4SO['wg_return']) * (round((97 - $sqlfet_list4SO['wg_percent']), 2))) / 100);
                                                        $wgNet4Sell = $sqlfet_list4SO['wg_destination'] - ($sqlfet_list4SO['wg_return'] + $wgWater);
                                                        if ($sqlfet_list4SO['wg_code4product'] == '0000') {// text-decoration: line-through;
                                                            ?><input
                                                                    class="form-control form-inline text-primary text-right"
                                                                    type="text" disabled name="" id=""
                                                                    style="font-size:14px;" value="-">
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <input class="form-control form-inline text-primary text-right"
                                                                   type="text" disabled name="" id=""
                                                                   style="font-size:14px;"
                                                                   value="<?= number_format($wgNet4Sell, 2, '.', ','); ?>">
                                                            <?php
                                                        }
                                                        ?>
                                                    </td><!-- NET WEIGHT -->

                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>

                                        <tr>
                                            <?php
                                            $sqlcmd_calcWg = "SELECT SUM(wg_net) AS SUMWG FROM tbl_wg4buy WHERE wg_ponum='" . $soNumber . "' AND wg_code4product <> '0000'";
                                            $sqlres_calcWg = mysqli_query($dbConn, $sqlcmd_calcWg);
                                            if ($sqlres_calcWg) {
                                                $sqlfet_calcWg = mysqli_fetch_assoc($sqlres_calcWg);
                                            }
                                            ?>
                                            <td class="text-right" colspan="4"></td>
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
                                            <td><!-- น้ำหนักปลายทาง --></td>
                                            <td><!-- DRC --></td>
                                            <!--<td>--><!-- หักน้ำ --><!--</td>-->
                                            <td><!-- คัดคืน --></td>
                                            <!-- น้ำหนักยางหัก % น้ำ -->
                                            <td class="text-right"><label for="id4MinusPercentWater"
                                                                          class="text-dark"
                                                                          style="font-size:14px;">น้ำหนักยางหัก %
                                                    น้ำ (กก.)</label><input type="text" name="minusPercentWater"
                                                                            id="id4MinusPercentWater" disabled
                                                                            style="font-size:14px;"
                                                                            class="form-control form-inline text-primary text-right font-weight-bold"
                                                                            value="<?= calcWgMinusWater4PO($soNumber); ?>">
                                            </td><!-- น้ำหนักยางหัก % น้ำ -->

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

<!-- Hi-light active menu -->
<script>
    // $("#sub4Sell").addClass("show");
    // $("#id4SubMenuSellSOList").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Bootstrap Tooltip -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script><!-- Bootstrap Tooltip -->

<!-- Calculation for PO -->
<script>
    let soNumber2Upd = '<?=$soNumber;?>';

    let updateDRC = function (DRC, ID) {
        $.ajax({
            url: "calc4SO.php",
            type: "POST",
            data: {
                // poNumber: soNumber2Upd,
                processName: "updateDRC",
                id: ID,
                valueDRC: DRC
            },
            success: function (response) {
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    let chkKeyEnter4DRC = function (DRC, ID) {
        let input = document.getElementById("id4DRC_" + ID);
// Execute a function when the user releases a key on the keyboard
        $("#id4DRC_" + ID).on("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                updateDRC(DRC, ID);
            } else {
                if (input.value > 97) {
                    input.value = 97;
                    updateDRC(97, ID);
                }
            }
        });
    }

    let updateBuyType = function (buyType, buyType_ID) {
        $.ajax({
            url: "calc4SO.php",
            type: "POST",
            data: {
                // poNumber: soNumber2Upd,
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
            url: "calc4SO.php",
            type: "POST",
            data: {
                // poNumber: soNumber2Upd,
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

    let updateProduct = function (PRD, PRD_ID) {
        //console.log(PRD + "xxx" + PRD_ID);
        $.ajax({
            url: "calc4SO.php",
            type: "POST",
            data: {
                // poNumber: soNumber2Upd,
                processName: "updateProduct",
                id: PRD_ID,
                valueProduct: PRD
            },
            success: function (response) {
                //console.log(response);
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    let updateWgLabour = function (WGLABOUR, SONUMBER) {
        $.ajax({
            url: "calc4SO.php",
            type: "POST",
            data: {
                soNumber: SONUMBER,
                processName: "updateWgLabour",
                // id: PRD_ID,
                valueWgLabour: WGLABOUR
            },
            success: function (response) {
                //console.log(response);
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    let chkKeyEnter4WgLabour = function (WGLABOUR, SONUMBER) {
// Execute a function when the user releases a key on the keyboard
        $("#id4WgLabour").on("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // console.log(event.keyCode);
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                updateWgLabour(WGLABOUR, SONUMBER);
            }
        });
    }

    let updateWeightDestination = function (WEIGHT, ID) {
        $.ajax({
            url: "calc4SO.php",
            type: "POST",
            data: {
                // soNumber: SONUMBER,
                processName: "updateWeightDestination",
                id: ID,
                valueWgDestination: WEIGHT
            },
            success: function (response) {
                console.log(response);
                //location.reload();
                // You will get response from your PHP page (what you echo or print)
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    let chkKeyEnter4WgDestination = function (WEIGHT, ID) {
// Execute a function when the user releases a key on the keyboard
        $("#id4_wgDestination").on("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // console.log(event.keyCode);
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                updateWeightDestination(WEIGHT, ID);
            }
        });
    }

    let updateWeightReturn = function (WEIGHT, ID) {
        $.ajax({
            url: "calc4SO.php",
            type: "POST",
            data: {
                processName: "updateWeightReturn",
                id: ID,
                valueWgReturn: WEIGHT
            },
            success: function (response) {
                //console.log(response);
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
    let chkKeyEnter4WgReturn = function (WEIGHT, ID) {
// Execute a function when the user releases a key on the keyboard
        $("#id4_wgReturn").on("keyup", function (event) {
            // Number 13 is the "Enter" key on the keyboard
            if (event.keyCode === 13) {
                // console.log(event.keyCode);
                // Cancel the default action, if needed
                event.preventDefault();
                // Trigger the button element with a click
                updateWeightReturn(WEIGHT, ID);
            }
        });
    }
</script><!-- Calculation for PO -->

</body>

</html>