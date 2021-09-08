<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

$varget_id2edit = filter_input(INPUT_GET, 'id2edit');
if (empty($varget_id2edit)) {
    $processName = "addCustomer";
    $text2Show = "เพิ่มข้อมูลลูกค้า";

    $custCode = str_replace("-", "", $dateNow) . str_replace(":", "", $timeNow);
    $custName = '';
    $custSurName = '';
    $custPhone = '';
    $custAddress = '';
    $custDetails = '';


} else {
    $processName = "editCustomer";
    $text2Show = "แก้ไขข้อมูลลูกค้า";

    // List suppliers
    $sqlcmd_listCustomer = "SELECT * FROM tbl_customers WHERE id=" . $varget_id2edit;
    $sqlres_listCustomer = mysqli_query($dbConn, $sqlcmd_listCustomer);
    if ($sqlres_listCustomer) {
        $sqlfet_listCustomer = mysqli_fetch_assoc($sqlres_listCustomer);

        $custCode = $sqlfet_listCustomer['customer_code'];
        $custName = $sqlfet_listCustomer['customer_name'];
        $custSurName = $sqlfet_listCustomer['customer_surname'];
        $custPhone = $sqlfet_listCustomer['customer_phone'];
        $custAddress = $sqlfet_listCustomer['customer_address'];
        $custDetails = $sqlfet_listCustomer['customer_details'];
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
    <link rel="stylesheet" href="./css/style4Project.css">
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
            <h2 class="text-warning font-weight-bold"> ข้อมูลลูกค้า </h2>
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
                            <form action="./act4Cust.php" method="post">

                                <!-- 1st ROW -->
                                <div class="row">
                                    <!-- Product code -->
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4_custCode">รหัสลูกค้า</label>
                                            <input type="text" class="form-control" placeholder="รหัสลูกค้า"
                                                   name="custCode" id="id4_custCode" readonly
                                                   value="<?= $custCode; ?>">
                                        </div>
                                    </div><!-- Product code -->

                                    <!-- Product name -->
                                    <div class="col-md-4 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_custName">ชื่อลูกค้า</label>
                                            <input type="text" class="form-control" placeholder="ชื่อลูกค้า"
                                                   name="custName" id="id4_custName"
                                                   value="<?= $custName; ?>" onkeyup="func2ShowName(this.value)">
                                        </div>
                                    </div><!-- Product name -->

                                    <!-- Product name -->
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_custName">นามสกุลลูกค้า (ถ้ามี)</label>
                                            <input type="text" class="form-control" placeholder="นามสกุลลูกค้า"
                                                   name="custSurName" id="id4_custSurName"
                                                   value="<?= $custSurName; ?>" onkeyup="func2ShowName(this.value)">
                                        </div>
                                    </div><!-- Product name -->
                                </div><!-- 1st ROW -->

                                <!-- 2nd ROW -->
                                <div class="row">
                                    <div class="col-md-4 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4_custCode">โทรศัพท์</label>
                                            <input type="text" class="form-control" placeholder="โทรศัพท์"
                                                   name="custPhone" id="id4_custPhone"
                                                   value="<?= $custPhone; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-8 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_custCode">ที่อยู่ลูกค้า</label>
                                            <input type="text" class="form-control" placeholder="ที่อยู่ลูกค้า"
                                                   name="custAddress" id="id4_custAddress"
                                                   value="<?= $custAddress; ?>">
                                        </div>
                                    </div>
                                </div>
                                <!-- 2nd ROW -->

                                <!-- ABOUT CUSTOMER -->
                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="id4SuppDetails">เกี่ยวกับลูกค้า</label>
                                            <textarea rows="3" cols="80" class="form-control" name="custDetails"
                                                      id="id4_custDetails"
                                                      placeholder="ข้อมูลอื่นๆ"><?= $custDetails; ?></textarea>
                                        </div>
                                    </div>
                                </div><!-- ABOUT CUSTOMER -->

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
                            <img src="assets/img/<?= $prodTypeCode; ?>bg.jpg" alt="..." id="id4ImgBg">
                        </div>
                        <div class="card-body">
                            <div class="author">
                                <a href="#" style="text-decoration: none;">
                                    <img class="avatar border-gray" src="assets/img/<?= $prodTypeCode; ?>avatar.png"
                                         alt="..."
                                         id="id4ImgAvatar">
                                    <h5 class="title"><span
                                                id="id4ProdTypeName2Show"><?php if (empty($prodTypeName)) echo "ประเภทสินค้า"; else echo $prodTypeName; ?></span>
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
                                        <th>รหัสลูกค้า</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>โทรศัพท์</th>
                                        <th>ที่อยู่</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cntCust = 0;
                                    $sqlcmd_listCustomers = "SELECT * FROM tbl_customers WHERE 1";
                                    $sqlres_listCustomers = mysqli_query($dbConn, $sqlcmd_listCustomers);

                                    if ($sqlres_listCustomers) {
                                        while ($sqlfet_listCustomers = mysqli_fetch_assoc($sqlres_listCustomers)) {
                                            ?>
                                            <tr>
                                                <td><?= ++$cntCust; ?></td>
                                                <td><?= $sqlfet_listCustomers['customer_code']; ?></td>
                                                <td><?= $sqlfet_listCustomers['customer_name']; ?> <?= $sqlfet_listCustomers['customer_surname']; ?></td>
                                                <td><?= $sqlfet_listCustomers['customer_phone']; ?></td>
                                                <td><?= mb_substr($sqlfet_listCustomers['customer_address'], 0, 30) . "..."; ?></td>
                                                <td>
                                                    <a href="?id2edit=<?= $sqlfet_listCustomers['id']; ?>"
                                                       class="btn btn-round btn-outline-info btn-icon btn-sm"
                                                       data-toggle="tooltip" data-placement="right" title="แก้ไข"><i
                                                                class="bi bi-pencil"></i></a>
                                                    <a href="#" class="btn btn-round btn-outline-danger btn-icon btn-sm"
                                                       onclick="return confirm('ต้องการลบข้อมูลนี้');"
                                                       data-toggle="tooltip" data-placement="right" title=" ลบ "><i
                                                                class="bi bi-trash2"></i></a>
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
    // $("#id4MenuAdmin").addClass("active");
    // $("#id4AlinkMenuAdmin").addClass("text-primary");
    // $("#id4IconMenuAdmin").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Backend").addClass("show");
    $("#id4SubMenuBackendCustomerProfile").addClass("active");
</script><!-- Hi-light active menu -->

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script>
    let func2ShowName = function (txtName) {
        let name2Show = document.getElementById('id4ProdTypeName2Show');
        name2Show.innerHTML = txtName;
    }

    let func2ChangeImg = function (typeCode) {
        let imgBg = document.getElementById('id4ImgBg');
        let imgAvatar = document.getElementById('id4ImgAvatar');

        imgBg.src = './assets/img/' + typeCode + 'bg.jpg';
        imgAvatar.src = './assets/img/' + typeCode + 'avatar.png';
    }
</script>

</body>

</html>