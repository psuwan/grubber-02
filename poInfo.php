<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_poNumber = filter_input(INPUT_GET, 'poNumber');


$sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
$sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);

$sqlcmd_data4PO = "SELECT * FROM tbl_wg4buy WHERE wg_ponum = '" . $varget_poNumber . "' GROUP BY wg_ponum";
$sqlres_data4PO = mysqli_query($dbConn, $sqlcmd_data4PO);

if ($sqlres_data4PO) {
    $sqlfet_data4PO = mysqli_fetch_assoc($sqlres_data4PO);
}
$suppName = getValue('tbl_suppliers', 'supp_code', $sqlfet_data4PO['wg_suppcode'], 2, 'supp_name');
$suppSurname = getValue('tbl_suppliers', 'supp_code', $sqlfet_data4PO['wg_suppcode'], 2, 'supp_surname');
$poVlpn = $sqlfet_data4PO['wg_vlpn'];

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
    <div class="row">
        <div class="col-12 h5 text-info">
            <?php
            echo $suppName . " " . $suppSurname;
            echo "<br>";
            echo $poVlpn;
            ?>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr class="bg-primary">
                    <th>ประเภทสินค้า</th>
                    <th>ประเภทการซื้อ</th>
                    <th class="text-right">น้ำหนักยาง</th>
                    <th class="text-right">DRC</th>
                    <th class="text-right">ราคาซื้อ</th>
                </tr>
                </thead>
                <?php
                $sqlcmd_infoPO = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='" . $varget_poNumber . "' AND wg_product<>'0000'";
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