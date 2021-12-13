<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

/* GET VARIABLE SECTION */
$varget_stockNumber = filter_input(INPUT_GET, "stockNumber");

if (!empty($varget_stockNumber)) {
    $processName = "editStock";
} else {
    $processName = "stockLoaded";
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

    <title>GOLD RUBBER : UPDATE STOCK</title>

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
    <link rel="stylesheet" href="./css/style4Project.css">
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
            <h2 class="text-warning font-weight-bold">จ่ายสินค้าออกจากคลัง</h2>
        </div><!-- Header section -->

        <!-- Main content -->
        <div class="content">
            <div class="row">

                <!-- Left side data -->
                <div class="col-md-12 order-1 order-md-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title"> จ่ายสินค้า </h5>
                        </div>
                        <div class="card-body">
                            <form action="./act4Stock.php" method="post">
                                <div class="row">

                                    <!-- PRODUCT -->
                                    <div class="col-md-4 pr-md-1">
                                        <label for="">สินค้า</label>
                                        <div class="form-group selectWrapper" style="width: 100%;">
                                            <select name="productCode" id="id4ProductCode"
                                                    class="form-control form-control-sm selectBox">
                                                <?php
                                                $sqlcmd_listProducts = "SELECT * FROM tbl_products WHERE product_code<>'0000' ORDER BY product_order ASC";
                                                $sqlres_listProducts = mysqli_query($dbConn, $sqlcmd_listProducts);
                                                if ($sqlres_listProducts) {
                                                    while ($sqlfet_listProducts = mysqli_fetch_assoc($sqlres_listProducts)) {
                                                        ?>
                                                        <option value="<?= $sqlfet_listProducts['product_code']; ?>"><?= $sqlfet_listProducts['product_name']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div><!-- PRODUCT -->


                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_productWeight">ปริมาณ</label>
                                            <input type="text" class="form-control" placeholder="น้ำหนักจ่ายออก"
                                                   name="productWeight" id="id4_productWeight" value="">
                                        </div>
                                    </div>

                                    <!-- PRODUCT QUANTITY -->
                                    <div class="col-md-4 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_loadedReason">จ่ายออก</label>
                                            <input type="text" class="form-control" placeholder="เหตุผล"
                                                   name="loadedReason" id="id4_loadedReason" value="">
                                        </div>
                                    </div><!-- PRODUCT QUANTITY -->
                                </div>


                                <!-- Button "Reset" and "Submit" -->
                                <div class="row d-flex justify-content-center">
                                    <div class="button-container">
                                        <button type="reset" class="btn btn-outline-primary btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons loader_refresh spin"></i> ล้างข้อมูล
                                        </button>
                                        <button type="submit" class="btn btn-outline-success btn-round"
                                                style="width: 120px">
                                            <i class="now-ui-icons arrows-1_cloud-upload-94"></i> บันทึก
                                        </button>
                                    </div>
                                </div><!-- Button "Reset" and "Submit" -->

                                <input type="hidden" name="processName" value="<?= $processName; ?>">
                                <input type="hidden" name="stock2edit" value="<?= $varget_stockNumber; ?>">

                            </form>
                        </div>
                    </div>
                </div><!-- Left side data -->

                <!-- Right side data -->
                <!--<div class="col-md-4 order-0 order-md-1">
                    <div class="card card-user">
                        <div class="image">
                            <img src="assets/img/bg.jpg" alt="..." id="id4ImgBg">
                        </div>
                        <div class="card-body">
                            <div class="author">
                                <a href="#" style="text-decoration: none;">
                                    <img class="avatar border-gray" src="assets/img/avatar.png"
                                         alt="..."
                                         id="id4ImgAvatar">
                                    <h5 class="title"><span
                                            id="id4VehicleName2Show"><?php /*if (empty($vehicleTypeName)) echo "ประเภทสินค้า"; else echo $vehicleTypeName; */ ?></span>
                                    </h5>
                                </a>
                                <hr>
                                <p class="text-muted">
                                    ข้อมูลประเภทสินค้า
                                </p>
                            </div>
                        </div>
                    </div>
                </div>--><!-- Right side data -->

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
    //$("#id4MenuAdmin").addClass("active");
    //$("#id4AlinkMenuAdmin").addClass("text-primary");
    //$("#id4IconMenuAdmin").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Stock").addClass("show");
    $("#id4SubMenuStockLoaded").addClass("active");
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