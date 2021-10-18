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
    $txt2Display = "แผนขนส่ง";
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
            <h2 class="text-warning text-center"><?= $txt2Display; ?></h2>
        </div>
        <!-- Start of Content -->
        <div class="content" id="id4Content">
            <!-- Start of Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลทั้งหมด </h5>
                            <h4 class="card-title"> แผนขนส่ง </h4>
                        </div>

                        <!-- Card body -->
                        <div class="card-body table-responsive">
                            <table class="table table-striped" id="id4_soTable">
                                <thead class="bg-primary" style="font-size:14px">
                                <tr>
                                    <th>#</th>
                                    <th>เวลาที่สร้างแผน</th>
                                    <th>หมายเลขแผน</th>
                                    <th class="text-right">ปริมาณตามแผน</th>
                                    <th class="text-right">ปริมาณที่ชั่งแล้ว</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $cntPlan = 0;
                                mysqli_query($dbConn, "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
                                $sqlcmd_listPlan = "SELECT * FROM tbl_sellplan WHERE " . $queryString;
                                $sqlres_listPlan = mysqli_query($dbConn, $sqlcmd_listPlan);

                                if ($sqlres_listPlan) {
                                    while ($sqlfet_listPlan = mysqli_fetch_assoc($sqlres_listPlan)) {
                                        ?>
                                        <tr>
                                            <td><?= ++$cntPlan; ?></td>
                                            <td><?= $sqlfet_listPlan['plan_created']; ?></td>
                                            <td><?= $sqlfet_listPlan['plan_number']; ?></td>

                                            <!-- ปริมาณตามแผน -->
                                            <td class="text-right font-weight-bold"><?php
                                                //echo "wrong value: " . number_format($sqlfet_listPlan['plan_wg4sellorder'], 2, '.', ',');
                                                $sqlcmd_sumWg4Plan = "SELECT SUM(plan_wg4sellorder) AS PLANWG FROM tbl_sellplan WHERE plan_number='" . $sqlfet_listPlan['plan_number'] . "'";
                                                $sqlres_sumWg4Plan = mysqli_query($dbConn, $sqlcmd_sumWg4Plan);

                                                if ($sqlres_sumWg4Plan)
                                                    $sqlfet_sumWg4Plan = mysqli_fetch_assoc($sqlres_sumWg4Plan);
                                                echo number_format($sqlfet_sumWg4Plan['PLANWG'], 2, '.', ',');
                                                ?></td>

                                            <!-- ปริมาณที่ชั่งแล้ว -->
                                            <td class="text-right font-weight-bold"><?php
                                                $sqlcmd_wg4OpenPlan = "SELECT SUM(wg_net) AS WGNETOPENPLAN FROM tbl_wg4sell WHERE wg_sellplan='" . $sqlfet_listPlan['plan_number'] . "' AND wg_code4product<>'0000'";
                                                $sqlres_wg4OpenPlan = mysqli_query($dbConn, $sqlcmd_wg4OpenPlan);

                                                if ($sqlres_wg4OpenPlan) {
                                                    $sqlfet_wg4OpenPlan = mysqli_fetch_assoc($sqlres_wg4OpenPlan);
                                                    if (empty($sqlfet_wg4OpenPlan['WGNETOPENPLAN'])) {
                                                        echo "ยังไม่ได้ชั่ง";
                                                    } else {
                                                        echo number_format($sqlfet_wg4OpenPlan['WGNETOPENPLAN'], 2, '.', ',');
                                                    }
                                                }
                                                ?></td>

                                            <td class="text-center">

                                                <span data-toggle="modal" data-target="#exampleModal"
                                                      data-plan-number="<?= $sqlfet_listPlan['plan_number']; ?>">
                                                    <a href="#" class="btn btn-round btn-info btn-icon btn-sm"
                                                       data-toggle="tooltip" data-placement="right"
                                                       title=" ข้อมูลและจัดการ "><i
                                                                class="bi bi-clipboard-check"></i></a>
                                                </span>

                                                <a href="logisSellPlan.php?planNumber2edit=<?= $sqlfet_listPlan['plan_number']; ?>"
                                                   class="btn btn-round btn-warning btn-icon btn-sm"
                                                   data-toggle="tooltip" data-placement="right" title=" แก้ไข "><i
                                                            class="bi bi-pencil-fill"></i></a>

                                                <a href="./act4Plan.php?id2delete=<?= $sqlfet_listPlan['plan_number']; ?>"
                                                   class="btn btn-round btn-danger btn-icon btn-sm"
                                                   onclick="return confirm('ต้องการลบแผนการขนส่งนี้');"
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
    <div class="modal-dialog modal-dialog-centered modal-xl">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
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
    $("#id4SubMenuLogisSellPlanList").addClass("active");
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

        modal.find("#exampleModalLabel").text("ข้อมูลของแผนหมายเลข: " + planNumber);
        modal.find("#exampleModalContent").html("<iframe width=\"100%\" height=\"450px\" src=\"logisSellPlanDetails.php?planNumber=" + planNumber + "\" frameborder=\"0\"></iframe>");
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