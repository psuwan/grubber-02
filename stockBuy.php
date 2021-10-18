<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");

$thisFile = basename(__FILE__, '.php');

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

    <style>
        #example_filter input {
            border-radius: 30px;
            width: 300px;
            height: 35px;
            margin-right: 18px;
        }

        /* Selects any <input> when focused */
        #example_filter input:focus {
            border: solid 1px orange;
            outline: none !important;
        }
    </style>
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
            <!--<div class="jumbotron ml-5 mr-5 display-1 text-center font-weight-bold text-warning bg-transparent d-none d-sm-block">
                บริษัท โกลด์รับเบอร์ จำกัด
            </div>
            <div class="jumbotron display-4 text-center d-block d-sm-none text-warning bg-transparent font-weight-bold">
                Gold Rubber
            </div>-->
            <h2 class="text-warning text-center font-weight-bold">รายการซื้อที่ยังไม่รับเข้าคลัง</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลทั้งหมด </h5>
                            <h4 class="card-title"> รายการซื้อที่ยังไม่รับเข้าคลัง </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example" class="table table-hover">
                                    <thead>
                                    <tr class="bg-secondary">
                                        <!--<th>#</th>-->
                                        <th>วัน-เวลา</th>
                                        <th>เลขอ้างอิงซื้อ</th>
                                        <th class="text-center">สินค้า</th>
                                        <th class="text-right">น้ำหนัก</th>
                                        <th class="text-center">รับเข้าคลัง</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cntPO = 0;
                                    $sqlcmd_listPO = "SELECT * FROM tbl_wg4buy WHERE wg_product<>'0000' AND wg_instock='0' ORDER BY wg_createdat DESC";
                                    $sqlres_listPO = mysqli_query($dbConn, $sqlcmd_listPO);

                                    if ($sqlres_listPO) {
                                        while ($sqlfet_listPO = mysqli_fetch_assoc($sqlres_listPO)) {
                                            ?>
                                            <tr>
                                                <!--<td><?/*= ++$cntPO; */ ?></td>-->
                                                <td><?= monthThai(dateBE(substr($sqlfet_listPO['wg_createdat'], 0, 10))) . " " . substr($sqlfet_listPO['wg_createdat'], 11, 26); ?></td>
                                                <td><?= $sqlfet_listPO['wg_ponum']; ?></td>
                                                <td class="text-center"><?= $sqlfet_listPO['wg_product']; ?></td>
                                                <td class="text-right"><?= number_format($sqlfet_listPO['wg_net'], 2, '.', ','); ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    if ($sqlfet_listPO['wg_instock'] === '0') {
                                                        ?>
                                                        <a class="btn btn-sm btn-round btn-icon btn-info pt-1" href="#"
                                                           data-toggle="tooltip" data-placement="top"
                                                           title="รับเข้าคลัง"
                                                           onclick="stockFromBuy('<?= $sqlfet_listPO['wg_ponum']; ?>', '<?= $sqlfet_listPO['wg_product']; ?>', <?= $sqlfet_listPO['wg_net']; ?>);"><i
                                                                    class="bi bi-box-arrow-in-right"></i></a>
                                                        <?php
                                                    } else {
                                                        ?>
                                                        <a class="btn btn-sm btn-round btn-icon btn-info pt-1"
                                                           href="#" data-toggle="tooltip" data-placement="top"
                                                           title="อยู่ในคลังแล้ว"><i class="bi bi-square"
                                                                                     style="font-size:12px"></i></a>
                                                        <?php
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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

<!-- Modal to show information (call iframe) -->
<div class="modal fade" id="modal4POInfo" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="xxxx.php" method="post">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold" id=""></h4>
                </div>

                <div class="modal-body" id="modalBody">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>

            </form>
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

<!-- Hi-light active menu -->
<script>
    // $("#id4MenuBuy").addClass("active");
    // $("#id4AlinkMenuBuy").addClass("text-primary");
    // $("#id4IconMenuBuy").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Stock").addClass("show");
    $("#id4SubMenuStockBuy").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Datatable Setup -->
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [[0, "desc"]],
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


<!-- Pass parameter to modal -->
<script>
    $('#modal4POInfo').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let poNumber = button.data('ponumber');

        let modal = $(this);

        modal.find('.modal-title').text('รายละเอียดของ PO : ' + poNumber)

        $.ajax({
            url: "poData.php",
            type: "POST",
            data: {poNumber: poNumber},
            success: function (response) {
                console.log(response.length);
                for (let i = 0; i < response.length; i++) {
                    modal.find('#modalBody').append('<button type="button" class="btn btn-primary">ปุ่มที่ ' + i + '</button>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        //modal.find('.modal-body').html('<iframe src="info4PO.php?ponumber=' + recipient + '" style="text-align:center;width: 100%;height:600px;border: 0px;font-size: smaller;">')
    })

    $('#modal4POInfo').on('hidden.bs.modal', function () {
        window.location.reload();
    })
</script>

<!-- TOOLTIP -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script><!-- TOOLTIP -->

<!-- STOCK BUY -->
<script>
    let stockFromBuy = function (poNumber, poProduct, poWeight) {
        console.log(poNumber);
        console.log(poProduct);
        console.log(poWeight);
        $.ajax({
            url: "act4Stock.php",
            type: "POST",
            data: {
                processName: "stockBuy",
                poNumberBuy: poNumber,
                poProductBuy: poProduct,
                poWeightBuy: poWeight
            },
            success: function (response) {
                // console.log(response);
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script><!-- STOCK BUY -->

</body>

</html>