<?php

include_once 'lib/apksFunctions.php';
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
            <h2 class="text-warning text-center">รายชื่อผู้ขายยางทั้งหมด</h2>
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
                                <table class="table">
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
                                        while ($sqlfet_listSupp = mysqli_fetch_assoc($sqlres_listSupp)) {
                                            ?>
                                            <tr>
                                                <td><?= ++$suppCnt; ?></td>
                                                <td><?= $sqlfet_listSupp['supp_code']; ?></td>
                                                <td><?= $sqlfet_listSupp['supp_name'] . " " . $sqlfet_listSupp['supp_surname']; ?></td>
                                                <td><?= getValue('tbl_supptypes', 'supptype_code', $sqlfet_listSupp['supp_category'], 2, 'supptype_name'); ?></td>
                                                <td><?= $sqlfet_listSupp['supp_phone']; ?></td>
                                                <td>
                                                    <a href="./suppProfile.php?id2edit=<?= $sqlfet_listSupp['id']; ?>"><i
                                                                class="fas fa-edit text-info"></i></a> &nbsp;
                                                    <a href="./act4Supp.php?id2delete=<?= $sqlfet_listSupp['id']; ?>"
                                                       onclick="return confirm('ต้องการลบข้อมูล');"><i
                                                                class="fas fa-trash text-danger"></i></a>
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
    $("#id4MenuAdmin").addClass("active");
    $("#id4AlinkMenuAdmin").addClass("text-primary");
    $("#id4IconMenuAdmin").addClass("text-primary");
</script><!-- Hi-light active menu -->

</body>

</html>