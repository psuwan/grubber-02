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
    <!--    <link rel="icon" type="image/png" href="../assets/img/favicon.png">-->
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
            <h2 class="text-warning text-center">รายการซื้อยางทั้งหมด</h2>
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
                                    $sqlcmd_listPO = "SELECT * FROM tbl_purchaseorder WHERE 1 ORDER BY po_createdat DESC";
                                    $sqlres_listPO = mysqli_query($dbConn, $sqlcmd_listPO);

                                    if ($sqlres_listPO) {
                                        // Paginator setup rows per page
                                        $Num_Rows = mysqli_num_rows($sqlres_listPO);

                                        $Per_Page = 2;   // Per Page

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
                                                <td><?= $sqlfet_listPO['po_number']; ?></td>
                                                <td><?= substr($sqlfet_listPO['po_createdat'], 0, -3); ?></td>
                                                <td><?= getValue('tbl_suppliers', 'old_code', $sqlfet_listPO['po_suppcode'], 2, 'supp_name') . " " . getValue('tbl_suppliers', 'old_code', $sqlfet_listPO['po_suppcode'], 2, 'supp_surname'); ?></td>
                                                <td><?= $sqlfet_listPO['po_vlpn']; ?></td>
                                                <td><?= getValue('tbl_suppliers', 'old_code', $sqlfet_listPO['po_suppcode'], 2, 'supp_phone'); ?></td>
                                                <td>
                                                    <?php
                                                    if ($sqlfet_listPO['po_status'] == 1) {
                                                        echo "ยังไม่สรุปบิล";
                                                    } else {
                                                        echo "สรุปบิลแล้ว";
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
    $("#id4MenuBuy").addClass("active");
    $("#id4AlinkMenuBuy").addClass("text-primary");
    $("#id4IconMenuBuy").addClass("text-primary");
</script><!-- Hi-light active menu -->

</body>

</html>