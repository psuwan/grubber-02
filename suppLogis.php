<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

/* AUTHORIZED CHECK FOR THIS PAGE */
/*
$pageLevel = 1;
$chkToken = 0;
if (empty($_SESSION["USERLOGINNAME"])) {
    echo "<script>alert(\"ยังไม่ได้เข้าระบบ\")</script>";
    echo "<script>window.location.href=\"./userLogin.php\"</script>";
} else {
    $cntLogin = countDB("tbl_logintoken", "login_user", $_SESSION["USERLOGINNAME"], 2);
    $maxLogin = intval(getMaxLogin());
    list($userLevel, $userToken) = explode("bXd", $_SESSION["USERLOGINTOKEN"]);
    if ($userLevel !== '999') {
        if (intval($userLevel) <= $pageLevel) {
            echo "<script>alert(\"ผู้ใช้ไม่มีสิทธิ์เข้าหน้านี้\")</script>";
            echo "<script>window.location.href=\"./index.php\"</script>";
        } else {
            $sqlcmd_chkLoginToken = "SELECT * FROM tbl_logintoken WHERE login_user='" . $_SESSION['USERLOGINNAME'] . "'  ORDER BY login_time DESC LIMIT " . $maxLogin;
            $sqlres_chkLoginToken = mysqli_query($dbConn, $sqlcmd_chkLoginToken);

            if ($sqlres_chkLoginToken) {
                while ($sqlfet_chkLoginToken = mysqli_fetch_assoc($sqlres_chkLoginToken)) {
                    if ($sqlfet_chkLoginToken['login_token'] === $userToken) {
                        $chkToken += 1;
                    }
                }
            } else {
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            }
            if ($chkToken === 0) {
                session_unset();
                session_destroy();
                echo "<script>alert(\"รหัสผู้ใช้เข้าสู่ระบบจากเครื่องอื่นค้างอยู่\\nให้เข้าสู่ระบบใหม่\")</script>";
                echo "<script>window.location.href=\"./userLogin.php\"</script>";
            }
        }
    }
}
*//* AUTHORIZED CHECK FOR THIS PAGE */

$varget_id2edit = filter_input(INPUT_GET, 'id2edit');
if (empty($varget_id2edit)) {
    $processName = "addSuppLogis";
    $text2Show = "เพิ่มข้อมูลรถขนส่ง";
    $editAble = "";

    $suppLogisCode = str_replace("-", "", $dateNow) . str_replace(":", "", $timeNow);

    $suppLogisName = '';
    $suppLogisVlpn = '';
    $suppLogisDetails = '';

} else {
    $processName = "editSuppLogis";
    $text2Show = "แก้ไขข้อมูลรถขนส่ง";
    $editAble = "readonly";

    // List suppliers
    $sqlcmd_listSuppLogis = "SELECT * FROM tbl_supplogis WHERE id=" . $varget_id2edit;
    $sqlres_listSuppLogis = mysqli_query($dbConn, $sqlcmd_listSuppLogis);
    if ($sqlres_listSuppLogis) {
        $sqlfet_listSuppLogis = mysqli_fetch_assoc($sqlres_listSuppLogis);

        $suppLogisCode = $sqlfet_listSuppLogis['supplogis_code'];
        $suppLogisName = $sqlfet_listSuppLogis['supplogis_name'];
        $suppLogisVlpn = $sqlfet_listSuppLogis['supplogis_vlpn'];
        $suppLogisDetails = $sqlfet_listSuppLogis['supplogis_details'];
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

    <title>GOLD RUBBER : LOGISTICS</title>

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
            <h2 class="text-warning font-weight-bold"> ข้อมูลรถขนส่ง </h2>
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
                            <form action="./act4SuppLogis.php" method="post">
                                <div class="row">

                                    <!-- Product code -->
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppCode"> รหัสรถขนส่ง </label>
                                            <input type="text" class="form-control" placeholder="รหัสรถขนส่ง"
                                                   name="suppLogisCode" id="id4_suppLogisCode"
                                                   value="<?= $suppLogisCode; ?>" <?= $editAble; ?>>
                                        </div>
                                    </div><!-- Product code -->

                                    <!-- Product name -->
                                    <div class="col-md-4 px-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppEmail"> ทะเบียนรถ </label>
                                            <input type="text" class="form-control" placeholder="ทะเบียนรถ"
                                                   name="suppLogisVlpn" id="id4_suppLogisVlpn"
                                                   value="<?= $suppLogisVlpn; ?>" onkeyup="func2ShowName(this.value)">
                                        </div>
                                    </div><!-- Product name -->

                                    <!-- Product name -->
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppEmail"> เจ้าของ </label>
                                            <input type="text" class="form-control" placeholder="เจ้าของรถขนส่ง"
                                                   name="suppLogisName" id="id4_suppLogisName" list="id4_allSuppLogis"
                                                   value="<?= $suppLogisName; ?>" onkeyup="func2ShowName(this.value)">
                                        </div>
                                    </div><!-- Product name -->

                                </div>

                                <!-- ABOUT SUPPLIER LOGISTICS -->
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id4SuppDetails">เกี่ยวกับรถขนส่ง</label>
                                            <textarea rows="3" cols="80" class="form-control" name="suppLogisDetails"
                                                      id="id4_suppLogisDetails"
                                                      placeholder="ข้อมูลอื่นๆ"><?= $suppLogisDetails; ?></textarea>
                                        </div>
                                    </div>
                                </div><!-- ABOUT SUPPLIER LOGISTICS -->

                                <!-- Button "Reset" and "Submit" -->
                                <div class="row d-flex justify-content-center">
                                    <div class="button-container">
                                        <button type="reset" class="btn btn-outline-primary btn-round pr-md-1"
                                                style="width: 120px">
                                            <i class="now-ui-icons loader_refresh spin"></i> ล้างข้อมูล
                                        </button>
                                        <button type="submit" class="btn btn-outline-success btn-round pl-md-1"
                                                style="width: 120px">
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
                                                id="id4VehicleName2Show"><?php if (empty($vehicleTypeName)) echo "ประเภทสินค้า"; else echo $vehicleTypeName; ?></span>
                                    </h5>
                                </a>
                                <hr>
                                <p class="text-muted">
                                    ข้อมูลประเภทสินค้า
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
                                        <th>รหัสรถขนส่ง</th>
                                        <th>เลขทะเบียน</th>
                                        <th>ชื่อเจ้าของ</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cntSuppLogis = 0;
                                    $sqlcmd_listSuppLogis = "SELECT * FROM tbl_supplogis WHERE 1 ORDER BY supplogis_name ASC, supplogis_vlpn ASC";
                                    $sqlres_listSuppLogis = mysqli_query($dbConn, $sqlcmd_listSuppLogis);

                                    if ($sqlres_listSuppLogis) {
                                        while ($sqlfet_listSuppLogis = mysqli_fetch_assoc($sqlres_listSuppLogis)) {
                                            ?>
                                            <tr>
                                                <td><?= ++$cntSuppLogis; ?></td>
                                                <td><?= $sqlfet_listSuppLogis['supplogis_code']; ?></td>
                                                <td><?= $sqlfet_listSuppLogis['supplogis_vlpn']; ?></td>
                                                <td><?= $sqlfet_listSuppLogis['supplogis_name']; ?></td>
                                                <td>
                                                    <!-- STATUS FOR SUPPLIER LOGISTICS -->
                                                    <a href="./act4VehicleType.php?command=toggleStatus&id2edit=<?= $sqlfet_listSuppLogis['id']; ?>"
                                                       class="btn btn-round btn-icon btn-sm <?php if ($sqlfet_listSuppLogis['supplogis_status'] == 0) echo "btn-info"; ?>"
                                                       onclick="return confirm('ต้องการเปลี่ยนสถานะข้อมูลนี้');"
                                                       data-toggle="tooltip" data-placement="right"
                                                       title=" เปลี่ยนสถานะ "><i
                                                                class="bi bi-lightbulb-fill"></i><?= $sqlfet_listSuppLogis['supplogis_status']; ?>
                                                    </a>

                                                    <a href="?id2edit=<?= $sqlfet_listSuppLogis['id']; ?>"
                                                       class="btn btn-round btn-warning btn-icon btn-sm"
                                                       data-toggle="tooltip" data-placement="right" title="แก้ไข"><i
                                                                class="bi bi-pencil-fill"></i></a>

                                                    <a href="./act4VehicleType.php?id2delete=<?= $sqlfet_listSuppLogis['id']; ?>"
                                                       class="btn btn-round btn-danger btn-icon btn-sm"
                                                       onclick="return confirm('ต้องการลบข้อมูลนี้');"
                                                       data-toggle="tooltip" data-placement="right" title=" ลบ "><i
                                                                class="bi bi-trash2-fill"></i></a>
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

<!-- DATALIST FOR ALL SUPPLIER LOGISTICS -->
<datalist id="id4_allSuppLogis">
    <?php
    $sqlcmd_listAllSuppLogis = "SELECT * FROM tbl_supplogis WHERE 1 ORDER BY supplogis_code ASC";
    $sqlres_listAllSuppLogis = mysqli_query($dbConn, $sqlcmd_listAllSuppLogis);

    if ($sqlres_listAllSuppLogis) {
        while ($sqlfet_listAllSuppLogis = mysqli_fetch_assoc($sqlres_listAllSuppLogis)) {
            ?>
            <option value="<?= $sqlfet_listAllSuppLogis['supplogis_name']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist>

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
    $("#id4SubMenuBackendLogistics").addClass("active");
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