<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$varget_id2edit = filter_input(INPUT_GET, 'id2edit');
if (empty($varget_id2edit)) {
    $processName = "addWgScale";
    $text2Show = "เพิ่มข้อมูลเครื่องชั่ง";
    $editAble = "";

    $sqlcmd_listWgScale = "SELECT * FROM tbl_wgscale WHERE 1";
    $sqlres_listWgScale = mysqli_query($dbConn, $sqlcmd_listWgScale);
    if ($sqlres_listWgScale) {
        $sqlnum_listWgScale = mysqli_num_rows($sqlres_listWgScale);
        $wgScaleCode = str_pad(($sqlnum_listWgScale + 1), 4, "0", STR_PAD_LEFT);
    }

    $wgScaleName = '';
    $wgScaleDetails = '';

} else {
    $processName = "editWgScale";
    $text2Show = "แก้ไขข้อมูลเครื่องชั่ง";
    $editAble = "readonly";

    // List suppliers
    $sqlcmd_listWgScale = "SELECT * FROM tbl_wgscale WHERE id=" . $varget_id2edit;
    $sqlres_listWgScale = mysqli_query($dbConn, $sqlcmd_listWgScale);
    if ($sqlres_listWgScale) {
        $sqlfet_listWgScale = mysqli_fetch_assoc($sqlres_listWgScale);

        $wgScaleCode = $sqlfet_listWgScale['wgscale_code'];
        $wgScaleName = $sqlfet_listWgScale['wgscale_name'];
        $wgScaleDetails = $sqlfet_listWgScale['wgscale_details'];
    }
}
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

        <!-- Header section -->
        <div class="panel-header h-auto d-flex justify-content-center">
            <h2 class="text-warning font-weight-bold">ข้อมูลเครื่องชั่ง</h2>
        </div><!-- Header section -->

        <!-- Main content -->
        <div class="content">
            <div class="row">

                <!-- Left side data -->
                <div class="col-md-8 order-1 order-md-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title"><?= $text2Show; ?></h5>
                        </div>
                        <div class="card-body">
                            <form action="./act4WgScale.php" method="post">
                                <div class="row">

                                    <!-- Product code -->
                                    <div class="col-md-6 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppCode">รหัสเครื่องชั่ง</label>
                                            <input type="text" class="form-control" placeholder="รหัสเครื่องชั่ง"
                                                   name="wgScaleCode" id="id4WgScaleCode"
                                                   value="<?= $wgScaleCode; ?>" <?= $editAble; ?>>
                                        </div>
                                    </div><!-- Product code -->

                                    <!-- Product name -->
                                    <div class="col-md-6 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppEmail">ชื่อเรียกเครื่องชั่ง</label>
                                            <input type="text" class="form-control" placeholder="ชื่อเรียกเครื่องชั่ง"
                                                   name="wgScaleName" id="id4WgScaleName"
                                                   value="<?= $wgScaleName; ?>" onkeyup="func2ShowName(this.value)">
                                        </div>
                                    </div><!-- Product name -->

                                </div>

                                <!-- About product -->
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id4SuppDetails">ข้อมูลเกี่ยวเครื่องชั่ง</label>
                                            <textarea rows="3" cols="80" class="form-control" name="wgScaleDetails"
                                                      id="id4WgScaleDetails"
                                                      placeholder="ข้อมูลเกี่ยวเครื่องชั่ง"><?= $wgScaleDetails; ?></textarea>
                                        </div>
                                    </div>
                                </div><!-- About product -->

                                <!-- Button "Reset" and "Submit" -->
                                <div class="row d-flex justify-content-center">
                                    <div class="button-container">
                                        <button type="reset" class="btn btn-outline-primary btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons loader_refresh spin"></i> ล้างข้อมูล
                                        </button>
                                        &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-outline-success btn-round"
                                                style="width: 120px" name="suppSubmitBtn">
                                            <i class="now-ui-icons arrows-1_cloud-upload-94"></i> บันทึก
                                        </button>
                                    </div>
                                </div><!-- Button "Reset" and "Submit" -->

                                <input type="hidden" name="processName" value="<?= $processName; ?>">
                                <input type="hidden" name="id2edit" value="<?= $varget_id2edit; ?>">

                            </form>
                        </div>
                    </div>
                </div><!-- Left side data -->

                <!-- Right side data -->
                <div class="col-md-4 order-0 order-md-1">
                    <div class="card card-user">
                        <div class="image">
                            <img src="assets/img/bgveh.jpg" alt="..." id="id4ImgBg">
                        </div>
                        <div class="card-body">
                            <div class="author">
                                <a href="#" style="text-decoration: none;">
                                    <!--<img class="avatar border-gray" src="assets/img/<? /*= $vehicleTypeCode; */ ?>avatarveh.png"
                                         alt="..."
                                         id="id4ImgAvatar">-->
                                    <img class="avatar border-gray" src="assets/img/avatarveh.png"
                                         alt="..."
                                         id="id4ImgAvatar">
                                    <h5 class="title"><span
                                                id="id4VehicleName2Show"><?php if (empty($wgScaleName)) echo "เครื่องชั่ง"; else echo $wgScaleName; ?></span>
                                    </h5>
                                </a>
                                <hr>
                                <p class="text-muted">
                                    ข้อมูลเกี่ยวกับเครื่องชั่ง
                                </p>
                            </div>
                        </div>
                    </div>
                </div><!-- Right side data -->

            </div>

            <!-- List of product -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category">ข้อมูลทั้งหมด</h5>
                            <h4 class="card-title"> ประเภทสินค้า </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>#</th>
                                        <th>รหัสเครื่อง</th>
                                        <th>ชื่อเรียกเครื่อง</th>
                                        <th>ข้อมูลเครื่องชั่ง</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cntWgScale = 0;
                                    $sqlcmd_listWgScale = "SELECT * FROM tbl_wgscale WHERE 1 ORDER BY wgscale_code ASC";
                                    $sqlres_listWgScale = mysqli_query($dbConn, $sqlcmd_listWgScale);

                                    if ($sqlres_listWgScale) {
                                        while ($sqlfet_listWgScale = mysqli_fetch_assoc($sqlres_listWgScale)) {
                                            ?>
                                            <tr>
                                                <td><?= ++$cntWgScale; ?></td>
                                                <td><?= $sqlfet_listWgScale['wgscale_code']; ?></td>
                                                <td><?= $sqlfet_listWgScale['wgscale_name']; ?></td>
                                                <td>
                                                    <a href="?id2edit=<?= $sqlfet_listWgScale['id']; ?>"
                                                       class="btn btn-round btn-outline-info btn-icon btn-sm"
                                                       data-toggle="tooltip" data-placement="right" title="แก้ไข"><i
                                                                class="now-ui-icons ui-1_check"></i></a>
                                                    <a href="./act4WgScale.php?id2delete=<?= $sqlfet_listWgScale['id']; ?>"
                                                       class="btn btn-round btn-outline-danger btn-icon btn-sm"
                                                       onclick="return confirm('ต้องการลบข้อมูลนี้');"
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
                            <!--<div class="text-right">
                                <a href="./poList.php">ดูทั้งหมด</a>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <!-- List of product -->

        </div><!-- Main content -->

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
    //$("#id4MenuAdmin").addClass("active");
    //$("#id4AlinkMenuAdmin").addClass("text-primary");
    //$("#id4IconMenuAdmin").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Backend").addClass("show");
    $("#id4SubMenuBackendWgScale").addClass("active");
</script><!-- Hi-light active menu -->

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    let func2ShowName = function (txtName) {
        let name2Show = document.getElementById('id4VehicleName2Show');
        name2Show.innerHTML = txtName;
    }

    let func2ChangeImg = function (typeCode) {
        let imgBg = document.getElementById('id4ImgBg');
        let imgAvatar = document.getElementById('id4ImgAvatar');

        // imgBg.src = './assets/img/' + typeCode + 'bg.jpg';
        // imgAvatar.src = './assets/img/' + typeCode + 'avatar.png';
    }
</script>

</body>

</html>