<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

/* AUTHORIZED CHECK FOR THIS PAGE */
/*$pageLevel = 1;
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
}*//* AUTHORIZED CHECK FOR THIS PAGE */

$queryString = "";
$varpost_date2Display = filter_input(INPUT_POST, 'date2Display');
if (empty($varpost_date2Display)) {
    $queryString = " 1 ORDER BY so_created";
} else {
    $queryString = " DATE(so_created)='" . $varpost_date2Display . "' ORDER BY so_created";
}

$varget_id2edit = filter_input(INPUT_GET, 'id2edit');
if (empty($varget_id2edit)) {
    $processName = "openSO";
    $txt2Display = "เปิดการขายออก";

    $sqlcmd_cntTodaySO = "SELECT * FROM tbl_sellorder WHERE DATE(so_created)='" . $dateNow . "'";
    $sqlres_cntTodaySO = mysqli_query($dbConn, $sqlcmd_cntTodaySO);
    if ($sqlres_cntTodaySO)
        $cntTodaySO = mysqli_num_rows($sqlres_cntTodaySO);

    $soNumber = str_replace("-", "", $dateNow) . str_pad(($cntTodaySO + 1), 3, "0", STR_PAD_LEFT) . str_replace(":", "", $timeNow);
} else {
    $processName = "editSO";
    $txt2Display = "แก้ไขการขายออก";
    echo "edit";
}
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

        <div class="panel-header h-auto" id="id4Header">
            <!--<div class="jumbotron ml-5 mr-5 display-1 text-center font-weight-bold text-warning bg-transparent d-none d-sm-block">
                บริษัท โกลด์รับเบอร์ จำกัด
            </div>
            <div class="jumbotron display-4 text-center d-block d-sm-none text-warning bg-transparent font-weight-bold">
                Gold Rubber
            </div>-->
            <h2 class="text-warning text-center"><?= $txt2Display; ?></h2>
        </div>
        <!-- Start of Content -->
        <div class="content" id="id4Content">
            <!-- Start of Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลปัจจุบัน </h5>
                            <h4 class="card-title"> <?= $txt2Display; ?> </h4>
                        </div>

                        <!-- Card body -->
                        <div class="card-body">
                            <!-- Form -->
                            <form action="./act4SO.php" method="post">

                                <!-- Row #01 -->
                                <div class="row">
                                    <div class="col-md-3 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4_PONumber">เลขอ้างอิงการขาย</label>
                                            <input type="text" class="form-control" placeholder="เลขอ้างอิงการขาย"
                                                   name="soNumber" id="id4_soNumber" readonly
                                                   required value="<?= $soNumber; ?>">
                                        </div>
                                    </div>

                                    <!-- CUSTOMERS -->
                                    <div class="col-md-3 px-md-1">
                                        <label for="id4_SOCustomer">ลูกค้า</label>
                                        <div class="form-group text-center">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="soCustomer"
                                                        id="id4_soCustomer" required>
                                                    <option value="">เลือกลูกค้า</option>
                                                    <?php
                                                    $sqlcmd_listCusts = "SELECT * FROM tbl_customers WHERE 1";
                                                    $sqlres_listCusts = mysqli_query($dbConn, $sqlcmd_listCusts);
                                                    if ($sqlres_listCusts) {
                                                        while ($sqlfet_listCusts = mysqli_fetch_assoc($sqlres_listCusts)) {
                                                            ?>
                                                            <option value="<?= $sqlfet_listCusts['customer_code']; ?>"><?= $sqlfet_listCusts['customer_name']; ?>
                                                                &nbsp;<?= $sqlfet_listCusts['customer_surname']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- CUSTOMERS -->

                                    <!-- PRODUCT QUANTITY -->
                                    <div class="col-md-3 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_PONumber">น้ำหนักที่ขาย</label>
                                            <input type="text" class="form-control" placeholder="ปริมาณขาย"
                                                   name="soWeight" id="id4_soWeight"
                                                   required value="">
                                        </div>
                                    </div>
                                    <!-- PRODUCT QUANTITY -->


                                    <!-- PRODUCT PRICE -->
                                    <div class="col-md-3 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_PONumber">ราคาขาย</label>
                                            <input type="text" class="form-control" placeholder="ราคาขาย"
                                                   name="soPrice" id="id4_soPrice"
                                                   required value="">
                                        </div>
                                    </div><!-- PRODUCT PRICE -->

                                </div> <!-- End of Row #01 -->

                                <br>
                                <!-- Button "Reset" and "Submit" -->
                                <div class="row d-flex justify-content-center">
                                    <div class="button-container">
                                        <button type="reset" class="btn btn-outline-primary btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons loader_refresh spin"></i> ล้างข้อมูล
                                        </button>
                                        &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-outline-success btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons arrows-1_cloud-upload-94"></i> บันทึก
                                        </button>
                                    </div>
                                </div><!-- Button "Reset" and "Submit" -->

                                <!-- Hidden -->
                                <input type="hidden" name="processName" value="<?= $processName; ?>">

                            </form><!-- End of form -->
                        </div><!-- Card body -->
                    </div>
                </div>
            </div><!-- End of Row -->

            <!-- Start of Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลทั้งหมด </h5>
                            <h4 class="card-title"> รายการขาย </h4>
                        </div>

                        <!-- Card body -->
                        <div class="card-body table-responsive">
                            <table class="table table-striped" id="id4_soTable">
                                <thead class="bg-primary" style="font-size:14px">
                                <tr>
                                    <th>#</th>
                                    <th>soNumber</th>
                                    <th>soCutomer</th>
                                    <th>soProduct</th>
                                    <th>soQuantites</th>
                                    <th>soPrice</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $cntSO = 0;
                                $sqlcmd_listSO = "SELECT * FROM tbl_sellorder WHERE " . $queryString;
                                $sqlres_listSO = mysqli_query($dbConn, $sqlcmd_listSO);

                                if ($sqlres_listSO) {
                                    while ($sqlfet_listSO = mysqli_fetch_assoc($sqlres_listSO)) {

                                        ?>
                                        <tr>
                                            <td><?= ++$cntSO; ?></td>
                                            <td><?= $sqlfet_listSO['so_number']; ?></td>
                                            <td><?= getValue("tbl_customers", "customer_code", $sqlfet_listSO['so_customer'], 2, "customer_name"); ?> <?= getValue("tbl_customers", "customer_code", $sqlfet_listSO['so_customer'], 2, "customer_surname"); ?></td>
                                            <td><?= "ยางแผ่น"/*$sqlfet_listSO['so_product']*/; ?></td>
                                            <td><?= number_format($sqlfet_listSO['so_weight'], 2, '.', ','); ?></td>
                                            <td><?= number_format($sqlfet_listSO['so_price'], 2, '.', ','); ?></td>
                                            <td></td>
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


        </div><!-- End of Content -->

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
<script src="./js/script4SO.js"></script>

<!-- DATATABLES -->
<script src="./js/jquery.dataTables.min.js"></script>

<!-- Hi-light active menu -->
<script>
    // Try to still open submenu
    $("#sub4Sell").addClass("show");
    $("#id4SubMenuSellOrder").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Datatable Setup -->
<script>
    $(document).ready(function () {
        $('#id4_soTable').DataTable({
            "order": [[0, "asc"]],
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

<!-- TOOLTIP -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script><!-- TOOLTIP -->

</body>

</html>