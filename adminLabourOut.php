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
    $processName = "updateStock";
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

    <title>GOLD RUBBER : LABOUR OUT</title>

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
            <h2 class="text-warning font-weight-bold">ค่าแรงขึ้นยาง</h2>
        </div><!-- Header section -->

        <!-- Main content -->
        <div class="content">
            <div class="row">

                <!-- Left side data -->
                <div class="col-md-8 order-1 order-md-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title"> บันทึกค่าแรงขึ้นยาง </h5>
                        </div>
                        <div class="card-body">
                            <form action="./act4Stock.php" method="post">
                                <div class="row">

                                    <!-- PRODUCT -->
                                    <div class="col-md-6 pr-md-1">
                                        <label for="">สินค้า</label>
                                        <div class="form-group selectWrapper" style="width: 100%;">
                                            <select name="productCode" id="id4ProductCode"
                                                    class="form-control selectBox">
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

                                    <!-- PRODUCT QUANTITY -->
                                    <div class="col-md-6 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4SuppEmail">ปริมาณที่ตรวจสอบได้</label>
                                            <input type="text" class="form-control" placeholder=""
                                                   name="productWeight" id="" value="">
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
                                        <th>สินค้า</th>
                                        <th class="text-right">ปริมาณ</th>
                                        <th class="text-center">วันที่ตรวจสอบ</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $cntChk = 0;
                                    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
                                    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);

                                    $sqlcmd_chkStock = "SELECT * FROM tbl_stocks WHERE 1 GROUP BY stock_product";
                                    $sqlres_chkStock = mysqli_query($dbConn, $sqlcmd_chkStock);

                                    if ($sqlres_chkStock) {
                                        while ($sqlfet_chkStock = mysqli_fetch_assoc($sqlres_chkStock)) {
                                            ?>
                                            <tr>
                                                <td><?= ++$cntChk; ?></td>
                                                <td><?= getValue("tbl_products", "product_code", $sqlfet_chkStock['stock_product'], 2, "product_name"); ?></td>
                                                <td class="text-right font-weight-bold"><?php
                                                    $prdStock = getLastRecord("tbl_stocks", "stock_product", $sqlfet_chkStock['stock_product'], "stock_updated", "stock_weight");
                                                    echo number_format($prdStock, 2, '.', ',');
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= getLastRecord("tbl_stocks", "stock_product", $sqlfet_chkStock['stock_product'], "stock_updated", "stock_updated"); ?>
                                                </td>
                                                <td>
                                                    <!--<a href="?id2edit=<?/*= $sqlfet_chkStock['stock_number']; */?>"
                                                       class="btn btn-round btn-info btn-icon btn-sm"
                                                       data-toggle="tooltip" data-placement="right" title="แก้ไข"><i
                                                                class="bi bi-pencil-fill"></i></i></a>-->

                                                    <!--<a href="./act4VehicleType.php?id2delete=<?/*= $sqlfet_chkStock['stock_number']; */?>"
                                                       class="btn btn-round btn-outline-danger btn-icon btn-sm"
                                                       onclick="return confirm('ต้องการลบข้อมูลนี้');"
                                                       data-toggle="tooltip" data-placement="right" title=" ลบ "><i
                                                                class="now-ui-icons ui-1_simple-remove"></i></a>-->
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
    $("#id4SubMenuBackendLabourPriceOut").addClass("active");
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

<!--<script>-->
<!--    let returnText = '';-->
<!--    let lastChecked = function (productCode) {-->
<!--        $.ajax({-->
<!--            url: "act4Stock.php",-->
<!--            type: "POST",-->
<!--            data: {-->
<!--                processName: "lastCheckedProductInStock",-->
<!--                productCode: productCode-->
<!--            },-->
<!--            success: function (response) {-->
<!--                console.log(response);-->
<!--                // location.reload();-->
<!--                // You will get response from your PHP page (what you echo or print)-->
<!--                returnText = response.split("_");-->
<!--                let dateLastUpdated = returnText[0];-->
<!--                let weightLastUpdated = returnText[1];-->
<!--                console.log(dateLastUpdated);-->
<!--                console.log(weightLastUpdated);-->
<!--                if (dateLastUpdated === '') {-->
<!--                    document.getElementById("lastDateUpdated").value = "ไม่มีข้อมูล";-->
<!--                } else {-->
<!--                    document.getElementById("lastDateUpdated").value = dateLastUpdated;-->
<!--                }-->
<!--                if (weightLastUpdated === '') {-->
<!--                    document.getElementById("lastQtysUpdated").value = "ไม่มีข้อมูล";-->
<!--                } else {-->
<!--                    document.getElementById("lastQtysUpdated").value = weightLastUpdated;-->
<!--                }-->
<!--            }-->
<!--            ,-->
<!--            error: function (jqXHR, textStatus, errorThrown) {-->
<!--                console.log(textStatus, errorThrown);-->
<!--            }-->
<!--        });-->
<!--    }-->
<!--</script>-->

</body>

</html>