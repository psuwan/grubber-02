<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");

$thisFile = basename(__FILE__, '.php');

?>
<!DOCTYPE html>
<html lang="en">

<!-- HTML HEADER SECTION -->
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
</head><!-- HTML HEADER SECTION -->

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
                ?????????????????? ??????????????????????????????????????? ???????????????
            </div>
            <div class="jumbotron display-4 text-center d-block d-sm-none text-warning bg-transparent font-weight-bold">
                Gold Rubber
            </div>-->
            <h2 class="text-warning text-center font-weight-bold">?????????????????????????????????????????????????????????</h2>
        </div>
        <div class="content">
            <!-- Start of Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ??????????????????????????????????????? </h5>
                            <h4 class="card-title"> ??????????????????????????? </h4>
                        </div>

                        <!-- Card body -->
                        <div class="card-body table-responsive">
                            <table class="table table-striped" id="id4_soTable">
                                <thead class="bg-primary" style="font-size:14px">
                                <tr>
                                    <th>#</th>
                                    <th>????????????????????????????????????????????????</th>
                                    <th>??????????????????????????????????????????</th>
                                    <th style="width: 150px;">??????????????????</th>
                                    <th style="width: 75px;">??????????????????</th>
                                    <th style="width: 95px;">??????????????????</th>
                                    <th>?????????????????????</th>
                                    <th>????????????????????????</th>
                                    <th>???????????????</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $cntSO = 0;
                                $sqlcmd_listSO = "SELECT * FROM tbl_sellorder WHERE 1 ORDER BY so_created";
                                $sqlres_listSO = mysqli_query($dbConn, $sqlcmd_listSO);

                                if ($sqlres_listSO) {
                                    while ($sqlfet_listSO = mysqli_fetch_assoc($sqlres_listSO)) {
                                        ?>
                                        <tr>
                                            <td><?= ++$cntSO; ?></td>
                                            <td><?= $sqlfet_listSO['so_created']; ?></td>
                                            <td><?= $sqlfet_listSO['so_number']; ?></td>
                                            <td><?= getValue("tbl_customers", "customer_code", $sqlfet_listSO['so_customer'], 2, "customer_name"); ?> <?= getValue("tbl_customers", "customer_code", $sqlfet_listSO['so_customer'], 2, "customer_surname"); ?></td>
                                            <td><?= "?????????????????????";/*$sqlfet_listSO['so_product']*/ ?></td>
                                            <td><?= number_format($sqlfet_listSO['so_wgordered'], 2, '.', ','); ?></td>
                                            <td class="text-right"><?= number_format($sqlfet_listSO['so_price'], 2, '.', ','); ?></td>
                                            <td><?php
                                                $sqlcmd_getSumWg4SONow = "SELECT SUM(wg_net) AS WGNOW FROM tbl_wg4sell WHERE wg_sonum='" . $sqlfet_listSO['so_number'] . "' AND wg_code4product <> '0000'";
                                                $sqlres_getSumWg4SONow = mysqli_query($dbConn, $sqlcmd_getSumWg4SONow);
                                                if ($sqlres_getSumWg4SONow) {
                                                    $sqlfet_getSumWg4SONow = mysqli_fetch_assoc($sqlres_getSumWg4SONow);
                                                    echo number_format($sqlfet_getSumWg4SONow['WGNOW'], 2, '.', ',');
                                                }
                                                ?></td>
                                            <td>
                                                <?php
                                                //echo $sqlfet_listSO['so_status'];
                                                echo "&nbsp;";
                                                if ($sqlfet_listSO['so_status'] == 1)
                                                    echo "[Y]";
                                                else
                                                    echo "[X]";
                                                ?>
                                            </td>

                                            <!-- update stock by weighting -->
                                            <td>
                                                <a href="#" class="btn btn-sm btn-round btn-icon btn-warning"
                                                   data-toggle="tooltip" data-placement="top" title="?????????????????????"><i
                                                            class="now-ui-icons shopping_delivery-fast"></i></a>
                                            </td><!-- update stock by weighting -->
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>

                        </div><!-- Card body -->
                    </div>
                </div>
            </div><!-- End of Row -->
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">?????????</button>
                    <button type="submit" class="btn btn-primary">??????????????????</button>
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
    $("#sub4Sell").addClass("show");
    $("#id4SubMenuSellSOList").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Datatable Setup -->
<script>
    $(document).ready(function () {
        $('#id4_soTable').DataTable({
            "order": [[3, "desc"]],
            language:
                {
                    "decimal": "",
                    "emptyTable": "?????????????????????????????????",
                    "info": "?????????????????? _START_ ????????? _END_ ?????????????????????????????? _TOTAL_ ??????????????????",
                    "infoEmpty": "?????????????????? 0 ????????? 0 ?????????????????????????????? 0 ??????????????????",
                    "infoFiltered": "(?????????????????????????????????????????? _MAX_ ??????????????????)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "???????????? _MENU_ ???????????????????????????????????????",
                    "loadingRecords": "?????????????????????????????????????????????...",
                    "processing": "???????????????????????????????????????...",
                    "search": "",
                    "searchPlaceholder": "   ????????????????????????????????????",
                    "zeroRecords": "???????????????????????????????????????????????????????????????????????????",
                    "paginate": {
                        "first": "?????????????????????",
                        "last": "?????????????????????????????????",
                        "next": "???????????????",
                        "previous": "????????????????????????"
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

        modal.find('.modal-title').text('??????????????????????????????????????? PO : ' + poNumber)

        $.ajax({
            url: "poData.php",
            type: "POST",
            data: {poNumber: poNumber},
            success: function (response) {
                console.log(response.length);
                for (let i = 0; i < response.length; i++) {
                    modal.find('#modalBody').append('<button type="button" class="btn btn-primary">????????????????????? ' + i + '</button>');
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

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

</body>

</html>