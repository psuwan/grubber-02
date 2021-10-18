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
    $queryString = " 1 GROUP BY plan_number ORDER BY plan_created";
} else {
    $queryString = " DATE(so_created)='" . $varpost_date2Display . "' ORDER BY so_created";
}

$varget_planNumber2edit = filter_input(INPUT_GET, 'planNumber2edit');
if (empty($varget_planNumber2edit)) {
    $processName = "openPlan";
    $txt2Display = "สร้างแผนขนส่ง";
    $txtButton = "สร้างแผน";

    $sqlcmd_cntTodayPlan = "SELECT * FROM tbl_sellplan WHERE DATE(plan_created)='" . $dateNow . "'";
    $sqlres_cntTodayPlan = mysqli_query($dbConn, $sqlcmd_cntTodayPlan);
    if ($sqlres_cntTodayPlan)
        $cntTodayPlan = mysqli_num_rows($sqlres_cntTodayPlan);

    $planNumber = str_replace("-", "", $dateNow) . str_pad(($cntTodayPlan + 1), 3, "0", STR_PAD_LEFT) . str_replace(":", "", $timeNow);
} else {
    $processName = "editPlan";
    $txt2Display = "แก้ไขแผนขนส่ง";
    $txtButton = "แก้ไขแผน";

    $sqlcmd_editPlan = "SELECT * FROM tbl_sellplan where plan_number='" . $varget_planNumber2edit . "'";
    $sqlres_editPlan = mysqli_query($dbConn, $sqlcmd_editPlan);

    $planNumber = $varget_planNumber2edit;

    $planID = array();
    $planSO = array();
    $planSuppLogis = array();
    $planSOProduct = array();
    $planWgProduct = array();
    if ($sqlres_editPlan) {
        $sqlnum_editPlan = mysqli_num_rows($sqlres_editPlan);
        while ($sqlfet_editPlan = mysqli_fetch_assoc($sqlres_editPlan)) {
            $planID[] = $sqlfet_editPlan['id'];
            $planSO[] = $sqlfet_editPlan['plan_code4sellorder'];
            $planSuppLogis[] = $sqlfet_editPlan['plan_code4supplogis'];
            $planSOProduct[] = $sqlfet_editPlan['plan_code4product'];
            $planWgSellOrder[] = $sqlfet_editPlan['plan_wg4sellorder'];
        }
    }
}/* END OF IF */

function listOpenSellOrder()
{
    $dbConn = dbConnect();

    $sqlcmd_listSellOrder = "SELECT * FROM tbl_sellorder WHERE 1";
    $sqlres_listSellOrder = mysqli_query($dbConn, $sqlcmd_listSellOrder);
    if ($sqlres_listSellOrder) {
        while ($sqlfet_listSellOrder = mysqli_fetch_assoc($sqlres_listSellOrder)) {
            echo "<option value=\"" . $sqlfet_listSellOrder['so_number'] . "\">" . $sqlfet_listSellOrder['so_number'] . "</option>";
        }
    }

}

function listProducts()
{
    $dbConn = dbConnect();

    $sqlcmd_listProducts = "SELECT * FROM tbl_products WHERE 1";
    $sqlres_listProducts = mysqli_query($dbConn, $sqlcmd_listProducts);
    if ($sqlres_listProducts) {
        while ($sqlfet_listProducts = mysqli_fetch_assoc($sqlres_listProducts)) {

            echo "<option value=\"" . $sqlfet_listProducts['product_code'] . "\">" . $sqlfet_listProducts['product_name'] . "</option>";

        }
    }
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
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
                            <form action="./act4Plan.php" method="post">

                                <!-- Row #01 -->
                                <div class="row">

                                    <div class="col-md-3 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4_planNumber">เลขอ้างอิงแผน</label>
                                            <input type="text" class="form-control" placeholder="เลขอ้างอิงแผน"
                                                   name="planNumber" id="id4_planNumber" readonly
                                                   required value="<?= $planNumber; ?>">
                                        </div>
                                    </div>

                                    <!-- SUPP_LOGIS -->
                                    <div class="col-md-3 px-md-1">
                                        <label for="id4_planSuppLogis">รถขนส่ง</label>
                                        <div class="form-group text-center">
                                            <div class="selectWrapper1" style="width: 100%;">
                                                <select class="form-control selectBox1" name="planSuppLogis"
                                                        id="id4_planSuppLogis"
                                                        required <?php if (!empty($varget_planNumber2edit)) echo "disabled"; ?>>
                                                    <option value="">เลือกรถ</option>
                                                    <?php
                                                    $sqlcmd_listSuppLogis = "SELECT * FROM tbl_supplogis WHERE 1";
                                                    $sqlres_listSuppLogis = mysqli_query($dbConn, $sqlcmd_listSuppLogis);
                                                    if ($sqlres_listSuppLogis) {
                                                        while ($sqlfet_listSuppLogis = mysqli_fetch_assoc($sqlres_listSuppLogis)) {
                                                            ?>
                                                            <option value="<?= $sqlfet_listSuppLogis['supplogis_code']; ?>" <?php if ($sqlfet_listSuppLogis['supplogis_code'] == $planSuppLogis[0]) echo "selected"; ?>><?= $sqlfet_listSuppLogis['supplogis_vlpn']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- SUPP_LOGIS -->

                                    <!-- ADD_BUTTON -->
                                    <div class="col-md-3 pl-md-1">
                                        <label for="id4_addButton">จัดของเพิ่ม</label>
                                        <div class="form-group">
                                            <a class="btn btn-round btn-success mt-0" id="id4_addButton"
                                               data-toggle="tooltip" data-placement="right" title="เพิ่ม"><i
                                                        class="now-ui-icons ui-1_simple-add"></i></a>
                                        </div>
                                    </div><!-- ADD_BUTTON -->

                                    <!-- PRODUCT PRICE -->
                                    <div class="col-md-3 pl-md-1">
                                        <!-- EMPTY SECTION -->
                                    </div><!-- PRODUCT PRICE -->

                                </div> <!-- End of Row #01 -->

                                <!-- SET PLAN -->
                                <div id="id4_addPlan">
                                    <div class="row" id="">
                                        <?php
                                        if (!empty($varget_planNumber2edit)) {
                                            // EDIT_LOGISTIC_PLAN
                                            // OLD_DATA_FROM_EXISTING_PLAN
                                            for ($iPlan = 0; $iPlan < count($planID); ++$iPlan) {
                                                ?>
                                                <div class="col-md-3 pr-md-1">
                                                    <label for=""><?= "id: " . $planID[$iPlan]; ?></label>
                                                    <div class="form-group text-center">
                                                        <div class="selectWrapper1" style="width: 100%;">
                                                            <select class="form-control selectBox1" name="soNumber[]"
                                                                    id="id4_soNumber_<?= $iPlan; ?>" required
                                                                    onchange="updatePlanNumberByID(this.value,<?= $planID[$iPlan]; ?>)">
                                                                <option value="">เลือก sell order</option>
                                                                <?php
                                                                $sqlcmd_listSellOrder = "SELECT * FROM tbl_sellorder WHERE 1";
                                                                $sqlres_listSellOrder = mysqli_query($dbConn, $sqlcmd_listSellOrder);
                                                                if ($sqlres_listSellOrder) {
                                                                    while ($sqlfet_listSellOrder = mysqli_fetch_assoc($sqlres_listSellOrder)) {
                                                                        ?>
                                                                        <option value="<?= $sqlfet_listSellOrder['so_number']; ?>" <?php if ($sqlfet_listSellOrder['so_number'] == $planSO[$iPlan]) echo "selected"; ?>><?= $sqlfet_listSellOrder['so_number']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- PRODUCT -->
                                                <div class="col-md-3 px-md-1">
                                                    <label for="id4_product_0">เลือกสินค้า</label>
                                                    <div class="form-group text-center">
                                                        <div class="selectWrapper1" style="width: 100%;">
                                                            <select class="form-control selectBox1" name="soProduct[]"
                                                                    id="id4_product_<?= $iPlan; ?>" required
                                                                    onchange="updatePlanProductByID(this.value, <?= $planID[$iPlan]; ?>)">
                                                                <option value="">เลือกสินค้า</option>
                                                                <?php
                                                                $sqlcmd_listProducts = "SELECT * FROM tbl_products WHERE product_code<>'0000' ORDER BY product_order ASC";
                                                                $sqlres_listProducts = mysqli_query($dbConn, $sqlcmd_listProducts);
                                                                if ($sqlres_listProducts) {
                                                                    while ($sqlfet_listProducts = mysqli_fetch_assoc($sqlres_listProducts)) {
                                                                        ?>
                                                                        <option value="<?= $sqlfet_listProducts['product_code']; ?>" <?php if ($sqlfet_listProducts['product_code'] == $planSOProduct[$iPlan]) echo "selected"; ?>><?= $sqlfet_listProducts['product_name']; ?></option>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div><!-- PRODUCT -->

                                                      <!-- PRODUCT_WEIGHT -->
                                                <div class="col-md-3 px-md-1">
                                                    <label for="id4_wgProduct_0">น้ำหนักสินค้า (กก.)</label>
                                                    <div class="form-group">
                                                        <input class="form-control text-right" type="text"
                                                               name="wgProduct[]"
                                                               id="id4_wgProduct_<?= $iPlan; ?>"
                                                               style="font-size:14px;font-weight:bold;"
                                                               onblur="updatePlanWgProductByID(this.value, <?= $planID[$iPlan]; ?>)"
                                                               value="<?= number_format($planWgSellOrder[$iPlan], 2, ".", ","); ?>">
                                                    </div>
                                                </div><!-- PRODUCT_WEIGHT -->

                                                      <!-- UPDATE_BUTTON -->
                                                <div class="col-md-3 pl-md-1 mt-3">
                                                    <!--<a class="btn btn-round btn-warning" href="#" data-toggle="tooltip"
                                                       data-placement="top" title=" อัพเดท "><i
                                                                class="now-ui-icons loader_refresh"></i></a>-->
                                                    <a class="btn btn-danger btn-round"
                                                       href="#"
                                                       onclick="return confirm(deleteFromPlan(<?= $planID[$iPlan]; ?>))"
                                                       data-toggle="tooltip"
                                                       data-placement="top" title=" ลบ "><i
                                                                class="now-ui-icons ui-1_simple-delete"></i></a>
                                                </div><!-- UPDATE_BUTTON -->
                                                <?php
                                            }// OLD_DATA_FROM_EXISTING_PLAN
                                        }
                                        ?>
                                    </div>
                                    <div class="mb-3"
                                         style="width: 100%; height: 12px; border-bottom: 1px solid orange; text-align: center">
                                        <span style="font-size: 12px; background-color: #FFFFFF; padding: 0 15px;">
                                            แผนเพิ่มเติม <!--Padding is optional-->
                                        </span>
                                    </div>
                                </div><!-- SET PLAN -->

                                <!-- Button "Reset" and "Submit" -->
                                <div class="row d-flex justify-content-center">
                                    <div class="button-container">
                                        <button type="reset" class="btn btn-outline-primary btn-round"
                                                style="width: 120px"><i class="bi bi-file-earmark-excel"></i> ล้างข้อมูล
                                        </button>
                                        &nbsp;&nbsp;
                                        <button type="submit" class="btn btn-outline-success btn-round"
                                                style="width: 120px"><i
                                                    class="bi bi-file-earmark-check"></i> <?= $txtButton; ?>
                                        </button>
                                    </div>
                                </div><!-- Button "Reset" and "Submit" -->

                                <!-- Hidden -->
                                <input type="hidden" name="processName" value="<?= $processName; ?>">
                                <?php
                                if (!empty($varget_planNumber2edit)) {
                                    ?>
                                    <input type="hidden" name="planSuppLogis" value="<?= $planSuppLogis[0]; ?>">
                                    <input type="hidden" name="qtyOfSOInPlan" value="<?= $sqlnum_editPlan; ?>">
                                    <?php
                                }
                                ?>

                            </form><!-- End of form -->
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


<!-- MODAL_PLAN_DETAILS -->
<div class="modal fade" id="exampleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="exampleModalContent">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- MODAL_PLAN_DETAILS -->

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
    $("#sub4LogisSell").addClass("show");
    $("#id4SubMenuLogisSellPlan").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Datatable Setup -->
<script>
    $(document).ready(function () {
        $('#id4_soTable').DataTable({
            "order": [[1, "desc"]],
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

<!-- ADD_PRODUCT -->
<script type="text/javascript">
    $(document).ready(function () {
        let max_fields = 20;
        let wrapper = $("#id4_addPlan");
        let add_button = $("#id4_addButton");

        let x = '<?=($sqlnum_editPlan - 1);?>';
        let selectSO = '<?=listOpenSellOrder();?>';
        let selectPrd = '<?=listProducts();?>';

        $(add_button).click(function (e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                $(wrapper).append('<div class="row mt-1">' +

                    // column sellorder
                    '<div class="col-md-3 pr-md-1">' +
                    '<label for="id4_soNumber_' + x + '">Sell Order [' + x + ']</label>' +
                    '<div class="form-group text-center">' +
                    '<div class="selectWrapper1" style="width: 100%;">' +
                    '<select class="form-control selectBox1" name="soNumber[' + x + ']" id="id4_soNumber_' + x + '" required>' +
                    '<option value="">เลือก sell order</option>' +
                    selectSO +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>' + // column sellorder

                    '<div class="col-md-3 px-md-1">' +
                    '<label for="id4_product_' + x + '">เลือกสินค้า [' + x + ']</label>' +
                    '<div class="form-group text-center">' +
                    '<div class="selectWrapper1" style="width: 100%;">' +
                    '<select class="form-control selectBox1" name="soProduct[' + x + ']" id="id4_soProduct_' + x + '" required>' +
                    '<option value="">เลือกสินค้า</option>' +
                    selectPrd +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +

                    // WEIGHT_PRODUCT
                    '<div class="col-md-3 px-md-1">' +
                    '<label for="id4_wgProduct_' + x + '">น้ำหนักสินค้า [' + x + ']</label>' +
                    '<div class="form-group">' +
                    '<input class="form-control text-right" type="text" name="wgProduct[' + x + ']" id="id4_wgProduct_' + x + '" required style="font-size: 14px;font-weight: bold;">' +
                    '</div>' +
                    '</div>' +// WEIGHT_PRODUCT

                    // delete button
                    '<div class="col-md-3 pl-md-1 mt-3">' +
                    '<div class="form-group">' +
                    '<a class="btn btn-danger btn-round delete" href="#" data-toggle="tooltip" data-placement="top" title=" ลบ "><i class="now-ui-icons ui-1_simple-delete"></i></a>' +
                    '</div>' +
                    '</div>' +// delete button
                    '</div>'
                );
            } else {
                alert('ไม่สามารถเพิ่มข้อมูลได้อีก');
            }
        });

        $(wrapper).on("mouseover", ".delete", function (e) {
            e.preventDefault();
            $(".delete").tooltip();
        })

        $(wrapper).on("click", ".delete", function (e) {
            e.preventDefault();
            // $(this).parent('div').remove();
            $(this).parents(':eq(2)').remove();
            x--;
        })
    });
</script>

<script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
</script>

<!-- PASS_DATA_TO_MODAL -->
<script type="text/javascript">
    $('#exampleModal').on('show.bs.modal', function (event) {
        let refTarget = $(event.relatedTarget);
        let planNumber = refTarget.data('plan-number');

        let modal = $(this);

        modal.find("#exampleModalLabel").text("ข้อมูลของ: " + planNumber);
        modal.find("#exampleModalContent").html("<iframe width=\"100%\" height=\"450px\" src=" + planNumber + "\"logisSellPlanDetails.php?planNumber=\" frameborder=\"0\"></iframe>");
        // modal.find('#deleteForm').attr("action", "{{ url('/companies') }}" + "/" + companyId)
        // modal.find('#deleteForm input').val(companyId)
    })
</script><!-- PASS_DATA_TO_MODAL -->

<!-- TOOLTIP -->
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
</script><!-- TOOLTIP -->

<!-- UPDATE_PLAN_NUMBER_BY_ID -->
<script>
    let updatePlanNumberByID = function (PLANNUMBER, ID) {
        $.ajax({
            url: "act4Plan.php",
            type: "POST",
            data: {
                processName: "updatePlanNumberByID",
                id: ID,
                planNumberByID: PLANNUMBER
            },
            success: function (response) {
                //console.log(response);
                //location.reload();
                // You will get response from your PHP page (what you echo or print)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script><!-- UPDATE_PLAN_NUMBER_BY_ID -->

<!-- UPDATE_PRODUCT_BY_ID -->
<script>
    let updatePlanProductByID = function (PRODUCTCODE, ID) {
        $.ajax({
            url: "act4Plan.php",
            type: "POST",
            data: {
                processName: "updateProductByID",
                id: ID,
                productCodeByID: PRODUCTCODE
            },
            success: function (response) {
                //console.log(response);
                //location.reload();
                // You will get response from your PHP page (what you echo or print)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script><!-- UPDATE_PRODUCT_BY_ID -->

<!-- UPDATE_PRODUCT_WEIGHT_BY_ID -->
<script>
    let updatePlanWgProductByID = function (WGPRODUCT, ID) {
        $.ajax({
            url: "act4Plan.php",
            type: "POST",
            data: {
                processName: "updateWgProductByID",
                id: ID,
                wgProductByID: WGPRODUCT
            },
            success: function (response) {
                //console.log(response);
                //location.reload();
                // You will get response from your PHP page (what you echo or print)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script><!-- UPDATE_PRODUCT_WEIGHT_BY_ID -->

<!-- DELETE_FROM_PLAN -->
<script>
    let deleteFromPlan = function (ID) {
        $.ajax({
            url: "act4Plan.php",
            type: "POST",
            data: {
                processName: "deleteFromPlan",
                id: ID
            },
            success: function (response) {
                //console.log(response);
                location.reload();
                // You will get response from your PHP page (what you echo or print)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script><!-- DELETE_FROM_PLAN -->

</body>

</html>