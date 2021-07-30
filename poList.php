<?php

include_once './lib/apksPagination.php';
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");

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
            <h2 class="text-warning text-center font-weight-bold">รายการซื้อยางทั้งหมด</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลทั้งหมด </h5>
                            <h4 class="card-title"> รายการซื้อ </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>เลขอ้างอิง</th>
                                        <th>วัน-เวลา</th>
                                        <th>ผู้ขาย</th>
                                        <th>ทะเบียนรถ</th>
                                        <th>หมายเลขติดต่อ</th>
                                        <th>สถานะ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
                                    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
                                    $sqlcmd_listPO = "SELECT * FROM tbl_wg4buy WHERE 1 GROUP BY wg_ponum ORDER BY wg_createdat DESC";
                                    $sqlres_listPO = mysqli_query($dbConn, $sqlcmd_listPO);

                                    if ($sqlres_listPO) {
                                        // Paginator setup rows per page
                                        $Num_Rows = mysqli_num_rows($sqlres_listPO);

                                        $Per_Page = 10;   // Per Page

                                        $Page = $_GET["Page"];
                                        if (!$_GET["Page"]) {
                                            $Page = 1;
                                        }

                                        $Prev_Page = $Page - 1;
                                        $Next_Page = $Page + 1;

                                        $Page_Start = (($Per_Page * $Page) - $Per_Page);
                                        if ($Num_Rows <= $Per_Page) {
                                            $Num_Pages = 1;
                                        } else if (($Num_Rows % $Per_Page) == 0) {
                                            $Num_Pages = ($Num_Rows / $Per_Page);
                                        } else {
                                            $Num_Pages = ($Num_Rows / $Per_Page) + 1;
                                            $Num_Pages = (int)$Num_Pages;
                                        }

                                        $sqlcmd_listPO .= " LIMIT $Page_Start , $Per_Page";
                                        $sqlres_listPO = mysqli_query($dbConn, $sqlcmd_listPO);
                                        // Paginator setup rows per page

                                        while ($sqlfet_listPO = mysqli_fetch_assoc($sqlres_listPO)) {
                                            ?>
                                            <tr>
                                                <td><?= $sqlfet_listPO['wg_ponum']; ?></td>
                                                <td><?= substr($sqlfet_listPO['wg_createdat'], 0, -3); ?></td>
                                                <td><?= getValue('tbl_suppliers', 'supp_code', $sqlfet_listPO['wg_suppcode'], 2, 'supp_name') . " " . getValue('tbl_suppliers', 'supp_code', $sqlfet_listPO['wg_suppcode'], 2, 'supp_surname'); ?></td>
                                                <td><?= $sqlfet_listPO['wg_vlpn']; ?></td>
                                                <td><?= getValue('tbl_suppliers', 'supp_code', $sqlfet_listPO['wg_suppcode'], 2, 'supp_phone'); ?></td>
                                                <td>
                                                    <a href="#" data-toggle="modal"
                                                       data-target="#modal4POInfo"
                                                       data-cardid="<?= $sqlfet_listPO['wg_ponum']; ?>"><i class="now-ui-icons travel_info"></i></a>
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

            <!--
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category"> ข้อมูลทั้งหมด </h5>
                    <h4 class="card-title"> รายการซื้อ </h4>
                </div>
                <div class="card-body">

                    <div class="accordion" id="accordionExample">
                        <?php
            /*                        $cntList = 0;
                                    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
                                    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);
                                    $sqlcmd_listPOx = "SELECT * FROM tbl_wg4buy WHERE 1 GROUP BY wg_ponum ORDER BY wg_createdat DESC";
                                    $sqlres_listPOx = mysqli_query($dbConn, $sqlcmd_listPOx);

                                    if ($sqlres_listPOx) {
                                        while ($sqlfet_listPOx = mysqli_fetch_assoc($sqlres_listPOx)) {
                                            */ ?>
                                <div class="card">
                                    <div class="card-header" id="heading<? /*= ++$cntList; */ ?>">
                                        <h2 class="mb-0">
                                            <a class="btn btn-sm btn-round w-100 text-left <?php /*if ($sqlfet_listPOx['po_status'] == 0) echo "btn-success"; else echo "btn-primary"; */ ?>"
                                               type="button"
                                               data-toggle="collapse" href="#"
                                               data-target="#collapse<? /*= $cntList; */ ?>">
                                                <? /*= $sqlfet_listPOx['wg_ponum']; */ ?>
                                                &nbsp;<? /*= getValue('tbl_suppliers', 'supp_code', $sqlfet_listPOx['wg_suppcode'], 2, 'supp_name') . " " . getValue('tbl_suppliers', 'supp_code', $sqlfet_listPOx['wg_suppcode'], 2, 'supp_surname'); */ ?>
                                            </a>
                                        </h2>
                                    </div>

                                    <div id="collapse<? /*= $cntList; */ ?>" class="collapse" data-parent="#accordionExample">
                                        <div class="card-body">
                                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry
                                            richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard
                                            dolor
                                            brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon
                                            tempor, sunt
                                            aliqua put a bird on it squid single-origin coffee nulla assumenda
                                            shoreditch et.
                                            Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt
                                            sapiente
                                            ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft
                                            beer
                                            farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                                            of them
                                            accusamus labore sustainable VHS.
                                        </div>
                                    </div>
                                </div>
                                <?php
            /*                            }
                                    }
                                    */ ?>

                    </div>
                </div>
            </div>
-->
            <!-- Paginator -->
            มีรายการซื้อทั้งหมด <strong><?= $Num_Rows; ?></strong> รายการ
            <br><br>
            <div class="row">
                <div class="col-md-auto">
                    <?php
                    $pages = new Paginator;
                    $pages->items_total = $Num_Rows;
                    $pages->mid_range = 10;
                    $pages->current_page = $Page;
                    $pages->default_ipp = $Per_Page;
                    $pages->url_next = $_SERVER["PHP_SELF"] . "?QueryString=value&Page=";

                    $pages->paginate();

                    echo $pages->display_pages()
                    ?>
                </div>
            </div>
            <!-- Paginator -->
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
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Card ID</h4>
            </div>
            <div class="modal-body"></div>
            <!--            <div class="modal-footer">-->
            <!--                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">ปิด</button>-->
            <!--            </div>-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <button type="button" class="btn btn-primary">บันทึก</button>
            </div>
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

<!-- Hi-light active menu -->
<script>
    // $("#id4MenuBuy").addClass("active");
    // $("#id4AlinkMenuBuy").addClass("text-primary");
    // $("#id4IconMenuBuy").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Buy").addClass("show");
    $("#id4SubMenuBuyPoList").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Pass parameter to modal -->

<script>
    $('#modal4POInfo').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget)
        let recipient = button.data('cardid')
        let modal = $(this)
        modal.find('.modal-title').text('รายละเอียดของ PO : ' + recipient)
        modal.find('.modal-body').html('<iframe src="info4PO.php?ponumber=' + recipient + '" style="text-align:center;width: 100%;height:400px;border: 0px;font-size: smaller;">')
    })

    $('#modal4POInfo').on('hidden.bs.modal', function () {
        window.location.reload();
    })

</script>

</body>

</html>