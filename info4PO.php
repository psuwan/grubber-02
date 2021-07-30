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
    <div class="col-12 table-responsive">
        <table class="table table-striped">
            <tr>
                <thead>
                <th>#</th>
                <th>ประเภทการชั่ง</th>
                <th>น้ำหนักสุทธิ</th>
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
                                    echo "ชั่งเข้า (รถพร้อมสินค้า)";
                                    break;

                                case '0002':
                                    echo "ชั่งแยกประเภทสินค้าเข้าโกดัง";
                                    break;

                                case '0003':
                                    echo "ชั่งออก (รถเปล่า)";
                                    break;

                                default:
                                    break;
                            }
                            ?>
                        </td>
                        <td><?= number_format($sqlfet_list4PO['wg_net'], 2, '.', ','); ?></td>
                        <td><?= substr($sqlfet_list4PO['wg_createdat'], 11, 5); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
