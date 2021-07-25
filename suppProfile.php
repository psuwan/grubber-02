<?php

include_once 'lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$varget_id2edit = filter_input(INPUT_GET, 'id2edit');
if (empty($varget_id2edit)) {
    $processName = "addSupp";
    $text2Show = "เพิ่มข้อมูลผู้ขายยาง";
    $editAble = "";

    // Count today created user
    $sqlcmd_listSupp = "SELECT * FROM tbl_suppliers WHERE DATE(supp_createdat)='" . $dateNow . "'";
    $sqlres_listSupp = mysqli_query($dbConn, $sqlcmd_listSupp);
    if ($sqlres_listSupp) {
        $sqlnum_listSupp = mysqli_num_rows($sqlres_listSupp);
        $suppCode = str_replace("-", "", $dateNow);
        $suppCode .= str_pad(($sqlnum_listSupp + 1), 3, '0', STR_PAD_LEFT);
        $suppCode .= str_replace(":", "", $timeNow);
    }// Count today created user

    $suppPhone = '';
    $suppName = '';
    $suppSurname = '';
    $suppAddress = '';
    $suppAmphoe = '';
    $suppProvince = '';
    $suppZipcode = '';
    $suppDetails = '';
    $suppCategory = '';
    $suppEmail = '';

} else {
    $processName = "editSupp";
    $text2Show = "แก้ไขข้อมูลผู้ขายยาง";
    $editAble = "readonly";

    // List suppliers
    $sqlcmd_listSupp = "SELECT * FROM tbl_suppliers WHERE id=" . $varget_id2edit;
    $sqlres_listSupp = mysqli_query($dbConn, $sqlcmd_listSupp);
    if ($sqlres_listSupp) {
        $sqlfet_listSupp = mysqli_fetch_assoc($sqlres_listSupp);

        $suppCode = $sqlfet_listSupp['supp_code'];
        $suppPhone = $sqlfet_listSupp['supp_phone'];
        $suppName = $sqlfet_listSupp['supp_name'];
        $suppSurname = $sqlfet_listSupp['supp_surname'];
        $suppAddress = $sqlfet_listSupp['supp_address'];
        $suppAmphoe = $sqlfet_listSupp['supp_amphoe'];
        $suppProvince = $sqlfet_listSupp['supp_province'];
        $suppZipcode = $sqlfet_listSupp['supp_zipcode'];
        $suppDetails = $sqlfet_listSupp['supp_details'];
        $suppCategory = $sqlfet_listSupp['supp_category'];
        $suppEmail = $sqlfet_listSupp['supp_email'];
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
            <h2 class="text-warning">ข้อมูลผู้ขายยาง</h2>
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
                            <form action="./act4Supp.php" method="post">
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppCode">รหัสผู้ใช้งาน</label>
                                            <input type="text" class="form-control" placeholder="รหัสผู้ขาย"
                                                   name="suppCode" id="id4SuppCode"
                                                   value="<?= $suppCode; ?>" <?= "readonly"; ?>>
                                        </div>
                                    </div>
                                    <div class="col-md-4 px-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppEmail">อีเมลล์</label>
                                            <input type="email" class="form-control" placeholder="Email"
                                                   name="suppEmail" id="id4SuppEmail"
                                                   value="<?= $suppEmail; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppPhone">เบอร์โทรศัพท์</label>
                                            <input type="text" class="form-control" placeholder="เบอร์โทรศัพท์"
                                                   name="suppPhone" id="id4SuppPhone" value="<?= $suppPhone; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppName">ชื่อ (ชื่อร้าน)</label>
                                            <input type="text" class="form-control" placeholder="ชื่อ" name="suppName"
                                                   id="id4SuppName"
                                                   value="<?= $suppName; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 px-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppSurname">นามสกุล</label>
                                            <input type="text" class="form-control" placeholder="นามสกุล"
                                                   name="suppSurname" id="id4SuppSurname"
                                                   value="<?= $suppSurname; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppCategory">ประเภทผู้ขาย</label>
                                            <select class="form-control" name="suppCategory" id="id4SuppCategory"
                                                    required>
                                                <option value="">เลือกประเภท</option>
                                                <?php
                                                $sqlcmd_suppCate = "SELECT * FROM tbl_supptypes WHERE 1 ORDER BY supptype_code ASC";
                                                $sqlres_suppCate = mysqli_query($dbConn, $sqlcmd_suppCate);
                                                if ($sqlres_suppCate) {
                                                    while ($sqlfet_suppCate = mysqli_fetch_assoc($sqlres_suppCate)) {
                                                        ?>
                                                        <option value="<?= $sqlfet_suppCate['supptype_code']; ?>" <?php if ($sqlfet_suppCate['supptype_code'] == $suppCategory) echo "selected"; ?>><?= $sqlfet_suppCate['supptype_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id4SuppAddress">ที่อยู่</label>
                                            <input type="text" class="form-control" placeholder="เลขที่"
                                                   name="suppAddress" id="id4SuppAddress"
                                                   value="<?= $suppAddress; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppAmphoe">อำเภอ</label>
                                            <input type="text" class="form-control" placeholder="อำเภอ"
                                                   name="suppAmphoe" id="id4SuppAmphoe"
                                                   value="<?= $suppAmphoe; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 px-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppProvince">จังหวัด</label>
                                            <input type="text" class="form-control" placeholder="จังหวัด"
                                                   name="suppProvince" id="id4SuppProvince"
                                                   value="<?= $suppProvince; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppZipcode">รหัสไปรษณีย์</label>
                                            <input type="text" class="form-control" placeholder="รหัสไปรษณีย์"
                                                   name="suppZipcode" id="id4SuppZipcode"
                                                   pattern="[0-9]+" maxlength="5" value="<?= $suppZipcode; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id4SuppDetails">เกี่ยวกับผู้ใช้</label>
                                            <textarea rows="3" cols="80" class="form-control" name="suppDetails"
                                                      id="id4SuppDetails"
                                                      placeholder="ข้อมูลอื่นๆ"><?= $suppDetails; ?></textarea>
                                        </div>
                                    </div>
                                </div>

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
                            <img src="./assets/img/xbg.jpg" alt="...">
                        </div>
                        <div class="card-body">
                            <div class="author">
                                <a href="#" style="text-decoration: none;">
                                    <img class="avatar border-gray" src="./assets/img/xavatar.png" alt="...">
                                    <h5 class="title"><?= $suppName . " " . $suppSurname; ?></h5>
                                </a>
                            </div>
                            <hr>
                            <p class="description text-center text-muted">
                                <i class="now-ui-icons business_badge text-primary"></i>&nbsp;<?= $suppCode; ?>
                                <br>
                                <i class="now-ui-icons tech_mobile text-primary"></i>&nbsp;<a
                                        href="tel:+66<?= $suppPhone; ?>"
                                        style="text-decoration: none;"><?= $suppPhone; ?></a>
                            </p>
                        </div>
                        <!--<hr>
                        <div class="button-container">
                            <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button href="#" class="btn btn-neutral btn-icon btn-round btn-lg">
                                <i class="fab fa-google-plus-g"></i>
                            </button>
                        </div>-->
                    </div>
                </div><!-- Right side data -->

            </div>
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
    // $("#id4MenuAdmin").addClass("active");
    // $("#id4AlinkMenuAdmin").addClass("text-primary");
    // $("#id4IconMenuAdmin").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Backend").addClass("show");
    $("#id4SubMenuBackendSuppProfile").addClass("active");
</script><!-- Hi-light active menu -->

</body>

</html>