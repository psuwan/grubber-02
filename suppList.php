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
    <link rel="stylesheet" href="./css/style4Paginator.css">
    <link rel="stylesheet" href="./css/jquery.dataTables.min.css">
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
            <h2 class="text-warning text-center">รายชื่อผู้ขายทั้งหมด</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลทั้งหมด </h5>
                            <h4 class="card-title"> ผู้ขายยาง </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="example">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>รหัส</th>
                                        <th>ชื่อ(ร้าน)-สกุล</th>
                                        <th>ประเภท</th>
                                        <th>การติดต่อ</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $suppCnt = 0;
                                    $sqlcmd_listSupp = "SELECT * FROM tbl_suppliers WHERE 1 ORDER BY supp_code ASC";
                                    $sqlres_listSupp = mysqli_query($dbConn, $sqlcmd_listSupp);

                                    if ($sqlres_listSupp) {

                                        // Paginator setup rows per page
                                        /*$Num_Rows = mysqli_num_rows($sqlres_listSupp);

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

                                        $sqlcmd_listSupp .= " LIMIT $Page_Start , $Per_Page";
                                        $sqlres_listSupp = mysqli_query($dbConn, $sqlcmd_listSupp);*/
                                        // Paginator setup rows per page
                                        while ($sqlfet_listSupp = mysqli_fetch_assoc($sqlres_listSupp)) {
                                            ?>
                                            <tr>
                                                <td><?= ++$suppCnt/* + (($Page - 1) * $Per_Page)*/
                                                    ; ?></td>
                                                <td><?= $sqlfet_listSupp['supp_code']; ?></td>
                                                <td><?= $sqlfet_listSupp['supp_name'] . " " . $sqlfet_listSupp['supp_surname']; ?></td>
                                                <td><?= getValue('tbl_supptypes', 'supptype_code', $sqlfet_listSupp['supp_category'], 2, 'supptype_name'); ?></td>
                                                <td><?= $sqlfet_listSupp['supp_phone']; ?></td>
                                                <td>
                                                    <a class="btn btn-round btn-outline-info btn-icon btn-sm"
                                                       href="./suppProfile.php?id2edit=<?= $sqlfet_listSupp['id']; ?>"
                                                       data-toggle="tooltip" data-placement="right" title="แก้ไข"><i
                                                                class="now-ui-icons ui-1_check"></i></a>
                                                    <a class="btn btn-round btn-outline-danger btn-icon btn-sm"
                                                       href="./act4Supp.php?id2delete=<?= $sqlfet_listSupp['id']; ?>"
                                                       onclick="return confirm('ต้องการลบข้อมูล');"
                                                       data-toggle="tooltip" data-placement="right" title=" ลบ "><i
                                                                class="now-ui-icons ui-1_simple-remove"></i></a>
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
            <!--รายชื่อผู้ขายยางทั้งหมด <strong><? /*= $Num_Rows; */ ?></strong> คน
            <br><br>
            <div class="row">
                <div class="col-md-auto">
                    <?php
            /*                    $value = $sqlcmd_listSupp;
                                $pages = new Paginator;
                                $pages->items_total = $Num_Rows;
                                $pages->mid_range = 7;
                                $pages->current_page = $Page;
                                $pages->default_ipp = $Per_Page;
                                // $pages->url_next = $_SERVER["PHP_SELF"] . "?QueryString=" . $value . "&Page=";
                                $pages->url_next = $_SERVER["PHP_SELF"] . "?QueryString=value&Page=";
                                $pages->paginate();

                                echo $pages->display_pages()
                                */ ?>
                </div>
            </div>-->
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
<script src="./js/jquery.dataTables.min.js"></script>

<!-- Hi-light active menu -->
<script>
    // $("#id4MenuAdmin").addClass("active");
    // $("#id4AlinkMenuAdmin").addClass("text-primary");
    // $("#id4IconMenuAdmin").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Backend").addClass("show");
    $("#id4SubMenuBackendSuppList").addClass("active");
</script><!-- Hi-light active menu -->

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    $(document).ready(function () {
        $('#example').DataTable({
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
                    "search": "ค้นหาในตาราง :  ",
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
</script>

</body>

</html>