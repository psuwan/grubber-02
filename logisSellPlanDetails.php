<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_planNumber = filter_input(INPUT_GET, 'planNumber');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="./css/style4Project.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/jquery.dataTables.min.css">

    <style>
        #id4_soTable_filter input {
            border-radius: 30px;
            width: 300px;
            height: 35px;
            margin-right: 18px;
        }

        /* Selects any <input> when focused */
        #id4_soTable_filter input:focus {
            border: solid 1px orange;
            outline: none !important;
        }
    </style>

</head>

<body>


<div class="container-fluid">
    <div class="col-12 table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>SO</th>
                <th>ลูกค้า</th>
                <th>สินค้า</th>
                <th class="text-center">ปริมาณขาย</th>
                <th class="text-center">ชั่งแล้ว</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <!-- Check for weighting empty vehicle -->
            <?php
            /* check for vehicle weighting */
            $sqlnum_chkVehicleWg = 0;
            $sqlcmd_chkVehicleWg = "SELECT * FROM tbl_wg4sell WHERE wg_sellplan='" . $varget_planNumber . "' AND wg_code4wgtype='0001'";
            $sqlres_chkVehicleWg = mysqli_query($dbConn, $sqlcmd_chkVehicleWg);

            if ($sqlres_chkVehicleWg) {
            $sqlnum_chkVehicleWg = mysqli_num_rows($sqlres_chkVehicleWg);
            if ($sqlnum_chkVehicleWg === 1) {
                $sqlfet_chkVehicleWg = mysqli_fetch_assoc($sqlres_chkVehicleWg);
                ?>
                <tr>
                    <td>-</td>
                    <td class="text-muted">น้ำหนักรถเปล่า</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right"><?= number_format($sqlfet_chkVehicleWg['wg_net'], 2, '.', ','); ?> กก.
                    </td>
                    <td></td>
                </tr>
                <?php
            } elseif ($sqlnum_chkVehicleWg > 1) {
                echo "something went wrong. duplicated data maybe testing process";
            }
            elseif ($sqlnum_chkVehicleWg === 0) {
            ?>
                <tr>
                    <td>-</td>
                    <td>
                        <a href="./wg4PlanLogis.php?planNumber=<?= $varget_planNumber; ?>&productCode=0000&wgType=0001"
                           data-dismiss="modal" target="_top">ชั่งรถเปล่าก่อน</a></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">0.00 กก.</td>
                    <td></td>
                </tr>
            <?php
            }
            } else {
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
            }
            ?><!-- Check for weighting empty vehicle -->

            <!-- ############################### -->
            <?php
            if ($sqlnum_chkVehicleWg === 1) {
                $cntSO = 0;
                $sqlcmd_listPlan = "SELECT * FROM tbl_sellplan WHERE plan_number='" . $varget_planNumber . "'";
                $sqlres_listPlan = mysqli_query($dbConn, $sqlcmd_listPlan);

                if ($sqlres_listPlan) {
                    while ($sqlfet_listPlan = mysqli_fetch_assoc($sqlres_listPlan)) {
                        ?>
                        <tr>
                            <td><?= ++$cntSO; ?></td>
                            <td>
                                <a href="./wg4PlanLogis.php?soNumber=<?= $sqlfet_listPlan['plan_code4sellorder']; ?>&planNumber=<?= $varget_planNumber; ?>&productCode=<?= $sqlfet_listPlan['plan_code4product']; ?>&wgType=0002"
                                   data-dismiss="modal"
                                   target="_top"><?= $sqlfet_listPlan['plan_code4sellorder']; ?></a>
                            </td>
                            <td><?php
                                $code4Customer = getValue("tbl_sellorder", "so_number", $sqlfet_listPlan['plan_code4sellorder'], 2, "so_customer");
                                $name4Customer = getValue("tbl_customers", "customer_code", $code4Customer, 2, "customer_name");
                                $surName4Customer = getValue("tbl_customers", "customer_code", $code4Customer, 2, "customer_surname");
                                echo $name4Customer . " " . $surName4Customer;
                                ?>
                            </td>
                            <td><?php
                                $name4Product = getValue("tbl_products", "product_code", $sqlfet_listPlan['plan_code4product'], 2, "product_name");
                                echo $name4Product;
                                ?>
                            </td>
                            <td class="text-right"><?php
                                echo number_format($sqlfet_listPlan['plan_wg4sellorder'], 2, '.', ',') . " กก.";
                                ?>
                            </td>
                            <td class="text-right"><?php
                                $sqlcmd_cntRow4Cond = "SELECT * FROM tbl_wg4sell WHERE wg_sonum='" . $sqlfet_listPlan['plan_code4sellorder'] . "' AND wg_code4product='" . $sqlfet_listPlan['plan_code4product'] . "'";
                                $sqlres_cntRow4Cond = mysqli_query($dbConn, $sqlcmd_cntRow4Cond);

                                $sqlfet_cntRow4Cond = mysqli_fetch_assoc($sqlres_cntRow4Cond);
                                $sqlnum_cntRow4Cond = mysqli_num_rows($sqlres_cntRow4Cond);
                                if ($sqlnum_cntRow4Cond === 0) {
                                    echo "ยังไม่ได้ทำการชั่งสินค้านี้";
                                } elseif ($sqlnum_cntRow4Cond === 1) {
                                    echo number_format($sqlfet_cntRow4Cond['wg_net'], 2, '.', ',') . " กก.";
                                } elseif ($sqlnum_cntRow4Cond > 1) {
                                    echo "มีข้อมูลผิดพลาด (more than 1 data found here...)";
                                }
                                ?></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                    ?>

                    <!-- Check for weighting full vehicle -->
                    <?php
                    /* check for vehicle weighting */
                    $sqlnum_chkVehicleWgPrd = 0;
                    $sqlcmd_chkVehicleWgPrd = "SELECT * FROM tbl_wg4sell WHERE wg_sellplan='" . $varget_planNumber . "' AND wg_code4wgtype='0003'";
                    $sqlres_chkVehicleWgPrd = mysqli_query($dbConn, $sqlcmd_chkVehicleWgPrd);

                    if ($sqlres_chkVehicleWgPrd) {
                        $sqlnum_chkVehicleWgPrd = mysqli_num_rows($sqlres_chkVehicleWgPrd);
                        if ($sqlnum_chkVehicleWgPrd === 1) {
                            $sqlfet_chkVehicleWgPrd = mysqli_fetch_assoc($sqlres_chkVehicleWgPrd);
                            ?>
                            <tr>
                                <td>-</td>
                                <td class="text-muted">น้ำหนักรถและสินค้า</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right"><?= number_format($sqlfet_chkVehicleWgPrd['wg_net'], 2, '.', ','); ?>
                                    กก.
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        } elseif ($sqlnum_chkVehicleWgPrd > 1) {
                            echo "something went wrong. duplicated data maybe testing process";
                        } elseif ($sqlnum_chkVehicleWgPrd === 0) {
                            ?>
                            <tr>
                                <td>-</td>
                                <td>
                                    <a href="./wg4PlanLogis.php?planNumber=<?= $varget_planNumber; ?>&productCode=0000&wgType=0003"
                                       data-dismiss="modal" target="_top">ชั่งรถพร้อมสินค้า</a></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right">0.00 กก.</td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "ERROR !!! [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
                    }
                    ?><!-- Check for weighting full vehicle -->

                    <?php
                }
            } else {
                echo "count of vehicle weighting: " . $sqlnum_chkVehicleWg;
            }
            ?>
            <!-- ############################### -->

            <!--<tr>
                <td></td>
                <td><a href="./wg4PlanLogis.php">ชั่งรถเต็ม</a></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>-->
            </tbody>
        </table>
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
<script src="./js/script4SO.js"></script>

<!-- DATATABLES -->
<script src="./js/jquery.dataTables.min.js"></script>

<!-- Hi-light active menu -->
<script>
    // Try to still open submenu
    $("#sub4Sell").addClass("show");
    $("#id4SubMenuSellPlan").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Datatable Setup -->
<script>
    $(document).ready(function () {
        $('#id4_soTable').DataTable({
            "order": [[1, "desc"]],
            language:
                {
                    "decimal": "",
                    "emptyTable": "ไม่มีข้อมูล",
                    "info": "แสดงผล _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล",
                    "infoEmpty": "แสดงผล 0 ถึง 0 จากทั้งหมด 0 ข้อมูล",
                    "infoFiltered": "(กรองจากทั้งหมด _MAX_ ข้อมูล)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "แสดง _MENU_ ข้อมูลต่อหน้า",
                    "loadingRecords": "กำลังโหลดข้อมูล...",
                    "processing": "กำลังประมวลผล...",
                    "search": "",
                    "searchPlaceholder": "   ค้นหาในตาราง",
                    "zeroRecords": "ไม่มีข้อมูลตรงกับที่ค้นหา",
                    "paginate": {
                        "first": "หน้าแรก",
                        "last": "หน้าสุดท้าย",
                        "next": "ถัดไป",
                        "previous": "ก่อนหน้า"
                    },
                    "aria": {
                        "sortAscending": ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
        });
    });
</script><!-- Datatable Setup -->

</body>

</html>