<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_poNumber = filter_input(INPUT_GET, 'poNumber');
$varget_suppCode = filter_input(INPUT_GET, 'suppCode');
$varget_date2rep = filter_input(INPUT_GET, 'date2rep');

/*$sqlcmd_data = "SELECT * FROM tbl_wg4buy WHERE wg_suppcode = '" . $varget_suppCode . "' AND DATE(wg_createdat)='" . $varget_date2rep . "' GROUP BY wg_suppcode";
$sqlres_data = mysqli_query($dbConn, $sqlcmd_data);

if ($sqlres_data) {
    $sqlfet_data = mysqli_fetch_assoc($sqlres_data);
}*/

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

<div class="container">

    <!-- COLLAPSE -->
    <div class="row">
        <div class="col-md-12">

            <?php
            $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
            $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);

            $sqlcmd_data = "SELECT * FROM tbl_wg4buy WHERE wg_suppcode = '" . $varget_suppCode . "' AND DATE(wg_createdat)='" . $varget_date2rep . "' GROUP BY wg_ponum";
            $sqlres_data = mysqli_query($dbConn, $sqlcmd_data);

            if ($sqlres_data) {
                while ($sqlfet_data = mysqli_fetch_assoc($sqlres_data)) {
                    ?>
                    <div class="card">
                        <div class="card-header" id="heading_<?= $sqlfet_data['wg_ponum']; ?>">
                            <h2 class="mb-0">
                                <button class="btn btn-sm btn-block btn-outline-primary text-left text-dark"
                                        type="button"
                                        data-toggle="collapse"
                                        data-target="#collapse_<?= $sqlfet_data['wg_ponum']; ?>">
                                    ข้อมูลของ PO: <?= $sqlfet_data['wg_ponum']; ?>
                                </button>
                            </h2>
                        </div>
                        <div id="collapse_<?= $sqlfet_data['wg_ponum']; ?>" class="collapse">
                            <div class="card-body table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="bg-light">
                                        <th>ประเภทสินค้า</th>
                                        <th>ประเภทการซื้อ</th>
                                        <th class="text-right">น้ำหนักยาง</th>
                                        <th class="text-right">DRC</th>
                                        <th class="text-right">ราคาซื้อ</th>
                                    </tr>
                                    </thead>
                                    <?php
                                    $sqlcmd_infoPO = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $sqlfet_data['wg_ponum'] . "' AND wg_product<>'0000'";
                                    //$sqlcmd_infoPO = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $sqlfet_data['wg_ponum'] . "'";
                                    $sqlres_infoPO = mysqli_query($dbConn, $sqlcmd_infoPO);

                                    if ($sqlres_infoPO) {
                                        while ($sqlfet_infoPO = mysqli_fetch_assoc($sqlres_infoPO)) {
                                            ?>
                                            <tr>
                                                <td><?= getValue('tbl_products', 'product_code', $sqlfet_infoPO['wg_product'], 2, 'product_name'); ?></td>
                                                <td><?= getValue('tbl_buytype', 'buytype_code', $sqlfet_infoPO['wg_buytype'], 2, 'buytype_name'); ?></td>
                                                <td class="text-right"><?= number_format($sqlfet_infoPO['wg_net'], 2, '.', ','); ?></td>
                                                <td class="text-right"><?= number_format($sqlfet_infoPO['wg_percent'], 2, '.', ','); ?></td>
                                                <td class="text-right"><?= number_format($sqlfet_infoPO['wg_buyprc'], 2, '.', ','); ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div><!-- COLLAPSE -->

    <!---->

    <!--<div class="card">
        <div class="card-body">
            <button class="card-title" data-toggle="collapse" data-target="#collapse">
                Test
            </button>
            <div class="card-text collapse" id="collapse">
                Test
            </div>

            <div class="w-100"></div>

            <button class="card-title" data-toggle="collapse" data-target="#collapse1">
                Test2
            </button>
            <div class="card-text collapse" id="collapse1">
                Beta2
            </div>

        </div>
    </div>-->

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