<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_PONumber = filter_input(INPUT_GET, 'ponumber');
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
</head>

<body>
<div class="row">
    <div class="col-12 h4">
        ข้อมูลของ PO หมายเลข : <?= $varget_PONumber; ?>
    </div>
</div>
<div class="row">
    <div class="col-12 table-responsive">
        <form action="xxxx.php" method="post">
            <table class="table table-striped">
                <tr>
                    <thead class="text-center">
                    <th></th>
                    <th>ประเภทการชั่ง</th>
                    <th>สินค้า</th>
                    <th>น้ำหนักสุทธิ</th>
                    <th style="width: 125px;">% น้ำ</th>
                    <th style="width: 125px;">ราคารับซื้อ</th>
                    <th>ชั่งเวลา</th>
                    </thead>
                </tr>
                <tbody>
                <?php
                $cntWg = 0;
                $sqlcmd_list4PO = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $varget_PONumber . "' ORDER BY wg_createdat ASC";
                $sqlres_list4PO = mysqli_query($dbConn, $sqlcmd_list4PO);
                if ($sqlres_list4PO) {
                    while ($sqlfet_list4PO = mysqli_fetch_assoc($sqlres_list4PO)) {
                        ?>
                        <tr>
                            <td><?= ++$cntWg; ?></td>
                            <td><?php
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
                            </td>
                            <td><?php
                                if ($sqlfet_list4PO['wg_product'] == '0000') {
                                    echo "ชั่งรถ";
                                } else {
                                    echo getValue('tbl_products', 'product_code', $sqlfet_list4PO['wg_product'], 2, 'product_name');
                                }
                                ?></td>
                            <td><?= number_format($sqlfet_list4PO['wg_net'], 2, '.', ','); ?></td>
                            <th>
                                <input class="form-control form-inline" <?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "disabled"; ?>
                                       type="text" name="" id=""></th>
                            <th>
                                <input class="form-control form-inline" <?php if ($sqlfet_list4PO['wg_product'] == '0000') echo "disabled"; ?>
                                       type="text" name="" id=""></th>
                            <td class="text-center"><?= substr($sqlfet_list4PO['wg_createdat'], 11, 5); ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                </tbody>
            </table>
            <hr>
            <div class="row mt-3">
                <div class="col-6">
                    <label for="id4WgProd">น้ำหนักรวม (กิโลกรัม)</label>
                    <input type="text" name="" id="" class="form-control text-right" placeholder="0.00 กิโลกรัม">
                </div>
                <div class="col-6">
                    <label for="id4WgPrice">ราคารับซื้อ (บาท)</label>
                    <input type="text" name="" id="" class="form-control text-right" placeholder="0.00 บาท">
                </div>
            </div>

            <div class="row mt-3 d-flex justify-content-center fixed-bottom">
                <div class="col-12r">
                    <button id="id4CloseBtn" type="button" class="btn btn-round btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-round btn-primary">บันทึก</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>
</html>
