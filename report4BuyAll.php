<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$yearNow = date("Y");

//$poNumber = filter_input(INPUT_GET, 'poNumber');
$varpost_date2Report = filter_input(INPUT_POST, 'date2Report');
if (empty($varpost_date2Report)) {
    $varpost_date2Report = $dateNow;
} else {
    list($dd, $mm, $yy) = explode("-", $varpost_date2Report);
    $varpost_date2Report = ($yy - 543) . "-" . $mm . "-" . $dd;
}

list($yChk, $mChk, $dChk) = explode("-", $varpost_date2Report);
if ($yChk > ($yearNow + 400))
    $varpost_date2Report = ($yChk - 543) . "-" . $mChk . "-" . $dChk;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <link rel="icon" type="image/png" href="./assets/img/faviconW.ico">
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
    <link href="./css/style4Paginator.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="./css/thDateTimePicker.css">

    <style>
        #id4DailyReport_filter input {
            border-radius: 30px;
            width: 300px;
            height: 35px;
            margin-right: 18px;
        }

        /* Selects any <input> when focused */
        #id4DailyReport_filter input:focus {
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

        <div class="panel-header h-auto">
            <h2 class="text-warning text-center font-weight-bold">รายงานซื้อ</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card px-3">

                        <!-- CARD HEADER -->
                        <div class="card-header">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h5 class="card-category"> ข้อมูลสรุป </h5>
                                        <h4 class="card-title"> รายงานซื้อวันที่
                                            : <?= monthThai(dateBE($varpost_date2Report)); ?> </h4>
                                    </div>
                                    <div class="col-md-3 text-right input-group" style="font-size:14px">
                                        <input type="text" class="form-control" name="date2Report"
                                               id="id4Date2Report"
                                               style="margin:10px 0px 10px 0px!important"
                                               placeholder="คลิกเลือกวันที่">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-round" type="submit" id="button-addon2">
                                                แสดงรายงาน
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div><!-- CARD HEADER -->

                        <div class="card-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="id4DailyReport">
                                        <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center" style="width: 25px;">#</th>
                                            <th>ผู้ขาย</th>
                                            <th class="text-center" style="width: 100px;">สถานที่ลง</th>
                                            <th class="text-center" style="width: 125px;">สินค้า</th>
                                            <th class="text-center" style="width: 100px;">น้ำหนัก</th>
                                            <th class="text-center" style="width: 100px;">ราคาซื้อ</th>
                                            <th class="text-center" style="width: 100px;">เป็นเงิน</th>
                                            <th class="text-center" style="width: 100px;">ประเภทซื้อ</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $cntWg = 0;

                                        $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
                                        $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);

                                        $sqlcmd_listWg = "SELECT * FROM tbl_wg4buy WHERE wg_product<>'0000' AND DATE(wg_createdat)='" . $varpost_date2Report . "' GROUP BY wg_suppcode ORDER BY wg_ponum ASC, wg_product ASC, wg_createdat DESC";
                                        $sqlres_listWg = mysqli_query($dbConn, $sqlcmd_listWg);
                                        if ($sqlres_listWg) {
                                            // echo $cntRow;
                                            while ($sqlfet_listWg = mysqli_fetch_assoc($sqlres_listWg)) {
                                                $supplier = getValue('tbl_suppliers', 'supp_code', $sqlfet_listWg['wg_suppcode'], 2, 'supp_name') . " " . getValue('tbl_suppliers', 'supp_code', $sqlfet_listWg['wg_suppcode'], 2, 'supp_surname');
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?= ++$cntWg; ?></td>
                                                    <td><a href=""
                                                           data-toggle="modal"
                                                           data-target="#modal4PO"
                                                           data-ponumber="<?= $sqlfet_listWg['wg_ponum']; ?>"
                                                           data-suppcode="<?= $sqlfet_listWg['wg_suppcode']; ?>"
                                                           data-supplier="<?= $supplier; ?>"
                                                           data-date2rep="<?= $varpost_date2Report; ?>">
                                                            <?= $supplier; ?>
                                                        </a>
                                                    </td>
                                                    <td><?= getValue('tbl_locations', 'loc_code', $sqlfet_listWg['wg_location'], 2, 'loc_name'); ?></td>
                                                    <td><?= getValue('tbl_products', 'product_code', $sqlfet_listWg['wg_product'], 2, 'product_name'); ?></td>
                                                    <td class="text-right"><?= number_format($sqlfet_listWg['wg_net'] - round(($sqlfet_listWg['wg_net'] * round(97 - $sqlfet_listWg['wg_percent'])) / 100), 2, '.', ','); ?></td>
                                                    <td class="text-right"><?= number_format($sqlfet_listWg['wg_buyprc'], 2, '.', ','); ?></td>
                                                    <td class="text-right"><?= number_format(($sqlfet_listWg['wg_buyprc'] * ($sqlfet_listWg['wg_net'] - round(($sqlfet_listWg['wg_net'] * round(97 - $sqlfet_listWg['wg_percent'])) / 100))), 2, '.', ','); ?></td>
                                                    <td class="text-left"><?= getValue('tbl_buytype', 'buytype_code', $sqlfet_listWg['wg_buytype'], 2, 'buytype_name'); ?></td>
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
                        <!-- End of weighting card -->

                    </div>

                </div>
            </div>

            <!-- DATA SUMMARY -->
            <div class="row">
                <div class="col-md-12">

                    <div class="card px-3">

                        <div class="card-header">
                            <h5 class="card-category"> ข้อมูลสรุป </h5>
                            <h4 class="card-title">
                                สรุปรายงานซื้อวันที่ <?= monthThai(dateBE($varpost_date2Report)); ?></h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">

                                        <!-- CALCULATION FOR REPORT -->
                                        <?php
                                        $prdArr = array();
                                        $sqlcmd_products = "SELECT * FROM tbl_products WHERE 1 ORDER BY product_order ASC";
                                        $sqlres_products = mysqli_query($dbConn, $sqlcmd_products);
                                        if ($sqlres_products) {
                                            $sqlnum_products = mysqli_num_rows($sqlres_products);
                                            foreach ($sqlres_products as $col => $val) {
                                                $prdArr[] = $val;
                                            }
                                        }

                                        $buyArr = array();
                                        $sqlcmd_buytype = "SELECT * FROM tbl_buytype WHERE 1 ORDER BY buytype_code ASC";
                                        $sqlres_buytype = mysqli_query($dbConn, $sqlcmd_buytype);
                                        if ($sqlres_buytype) {
                                            $sqlnum_buytype = mysqli_num_rows($sqlres_buytype);
                                            foreach ($sqlres_buytype as $col => $val) {
                                                $buyArr[] = $val;
                                            }
                                        }
                                        echo "<table class=\"table\">";
                                        for ($iRow = 0; $iRow <= ($sqlnum_buytype + 1); ++$iRow) {
                                            echo "<tr>";
                                            for ($iCol = 0; $iCol <= ($sqlnum_products + 1); ++$iCol) {
                                                if (($iRow === 0) && ($iCol === 0)) {
                                                    echo "<td>";
                                                } else {
                                                    echo "<td class=\"text-right\">";
                                                }
                                                if ($iRow === 0 && $iCol === 0) {
                                                    echo "&nbsp;";
                                                } elseif ($iRow === 0) {
                                                    if ($iCol === ($sqlnum_products + 1)) {
                                                        echo "<strong>แยกตามการซื้อ</strong>";
                                                    }
                                                    echo "<strong>" . $prdArr[($iCol - 1)]['product_name'] . "</strong>";
                                                } elseif ($iCol === 0) {
                                                    if ($iRow === ($sqlnum_buytype + 1)) {
                                                        echo "<strong>แยกตามชนิดยาง</strong>";
                                                    }
                                                    echo "<strong>" . $buyArr[($iRow - 1)]['buytype_name'] . "</strong>";
                                                } else {
                                                    // echo "[" . $iRow . ", " . $iCol . "]";
                                                    if ($iCol === ($sqlnum_products + 1)) {
                                                        if ($iRow === ($sqlnum_buytype + 1))
                                                            echo "&nbsp;";
                                                        else
                                                            if (empty(sumWgByBuyTypeDate($varpost_date2Report, $buyArr[($iRow - 1)]['buytype_code'])))
                                                                echo "&nbsp;";
                                                            else {
                                                                echo "<strong class=\"text-danger\">";
                                                                echo number_format(sumWgByBuyTypeDate($varpost_date2Report, $buyArr[($iRow - 1)]['buytype_code']), 2, '.', ',');
                                                                echo " กก.</strong>";
                                                            }
                                                    } elseif ($iRow === ($sqlnum_buytype + 1)) {
                                                        if ($iCol === ($sqlnum_products + 1))
                                                            echo "&nbsp;";
                                                        else
                                                            if (empty(sumWgByProductDate($varpost_date2Report, $prdArr[($iCol - 1)]['product_code'])))
                                                                echo "&nbsp;";
                                                            else {
                                                                echo "<strong class=\"text-danger\">";
                                                                echo number_format(sumWgByProductDate($varpost_date2Report, $prdArr[($iCol - 1)]['product_code']), 2, '.', ',');
                                                                echo " กก.</strong>";
                                                            }
                                                    } elseif ((($iRow > 0) && ($iRow <= $sqlnum_buytype)) && (($iCol > 0) && ($iCol <= $sqlnum_products))) {
                                                        $wg2Show = sumWgBuyTypeProduct($varpost_date2Report, $buyArr[($iRow - 1)]['buytype_code'], $prdArr[($iCol - 1)]['product_code']);
                                                        if (empty($wg2Show))
                                                            echo "-";
                                                        else
                                                            echo number_format($wg2Show, 2, '.', ',') . " กก.";
                                                        //echo "</td>";
                                                    }
                                                    if (($iRow === ($sqlnum_buytype + 1)) && ($iCol === $sqlnum_products + 1)) {
                                                        echo "<strong class=\"\" style=\"font-size:14pt;font-weight:bold;color:darkblue;text-decoration-line: underline;
  text-decoration-style: double;\">";
                                                        echo number_format(sumWgAllDate($varpost_date2Report), 2, '.', ',');
                                                        echo "</strong>";
                                                        echo " กก.";
                                                    }
                                                    echo "</td>";
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                        echo "</table>";
                                        ?>
                                        <!-- CALCULATION FOR REPORT -->

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div><!-- DATA SUMMARY -->

            <!-- Footer -->
            <?php
            require_once './fileFooter.php';
            ?><!-- End Footer -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal4PO" tabindex="-1">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ข้อมูลของ PO: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>
            </div>
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
    <script src="./js/jquery.dataTables.min.js"></script>

    <!-- PICKER DATE -->
    <script src="./js/picker_date.js"></script>
    <script src="./js/thDateTimePicker.js"></script>


    <!--<script src="./js/jspdf.min.js"></script>-->
    <!--<script src="./js/THSarabun-normal.js" type="module"></script>-->
    <!--<script src="./js/jspdf.customfonts.min.js"></script>-->
    <!--<script src="./js/default_vfs.js"></script>-->
    <!--<script src="./js/html2pdf.bundle.min.js"></script>-->
    <!--<script src="./js/xepOnline.jqPlugin.js"></script>-->
    <script src="./js/html2canvas.js"></script>
    <script src="./js/pdfmake.min.js"></script>
    <script src="./js/vfs_fonts.js"></script>
    <!-- Hi-light active menu -->
    <script>
        // $("#id4MenuBuy").addClass("active");
        // $("#id4AlinkMenuBuy").addClass("text-primary");
        // $("#id4IconMenuBuy").addClass("text-primary");
        // Try to still open submenu
        $("#sub4Report").addClass("show");
        $("#id4SubMenuReportBuyAll").addClass("active");
    </script><!-- Hi-light active menu -->

    <!-- Bootstrap Tooltip -->
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script><!-- Bootstrap Tooltip -->

    <!-- DATETIME PICKER -->
    <script>
        // picker_date(document.getElementById("id4Date2Report"), {year_range: "-3:+1"});
        /*{year_range:"-12:+10"} คือ กำหนดตัวเลือกปฎิทินให้ แสดงปี ย้อนหลัง 12 ปี และ ไปข้างหน้า 10 ปี*/
    </script>

    <!-- DATETIME PICKER -->
    <script type="text/javascript">
        $(function () {

            $.datetimepicker.setLocale('th'); // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.

            // กรณีใช้แบบ inline
            /*  $("#testdate4").datetimepicker({
                  timepicker:false,
                  format:'d-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                  lang:'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                  inline:true
              });    */


            // กรณีใช้แบบ input
            $("#id4Date2Report").datetimepicker({
                timepicker: false,
                format: 'd-m-Y',  // กำหนดรูปแบบวันที่ ที่ใช้ เป็น 00-00-0000
                lang: 'th',  // ต้องกำหนดเสมอถ้าใช้ภาษาไทย และ เป็นปี พ.ศ.
                onSelectDate: function (dp, $input) {
                    var yearT = new Date(dp).getFullYear();
                    var yearTH = yearT + 543;
                    var fulldate = $input.val();
                    var fulldateTH = fulldate.replace(yearT, yearTH);
                    $input.val(fulldateTH);
                },
            });
            // กรณีใช้กับ input ต้องกำหนดส่วนนี้ด้วยเสมอ เพื่อปรับปีให้เป็น ค.ศ. ก่อนแสดงปฏิทิน
            $("#id4Date2Report").on("mouseenter mouseleave", function (e) {
                var dateValue = $(this).val();
                if (dateValue != "") {
                    var arr_date = dateValue.split("-"); // ถ้าใช้ตัวแบ่งรูปแบบอื่น ให้เปลี่ยนเป็นตามรูปแบบนั้น
                    // ในที่นี้อยู่ในรูปแบบ 00-00-0000 เป็น d-m-Y  แบ่งด่วย - ดังนั้น ตัวแปรที่เป็นปี จะอยู่ใน array
                    //  ตัวที่สอง arr_date[2] โดยเริ่มนับจาก 0
                    if (e.type == "mouseenter") {
                        var yearT = arr_date[2] - 543;
                    }
                    if (e.type == "mouseleave") {
                        var yearT = parseInt(arr_date[2]) + 543;
                    }
                    dateValue = dateValue.replace(arr_date[2], yearT);
                    $(this).val(dateValue);
                }
            });


        });
    </script><!-- DATETIME PICKER -->

    <!-- Datatable Setup -->
    <script>
        $(document).ready(function () {
            $('#id4DailyReport').DataTable({
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


    <!-- Show PO's info -->
    <script>
        $('#modal4PO').on('show.bs.modal', function (event) {
            let refev = $(event.relatedTarget);

            // let poNumber = refev.data('ponumber');
            let suppCode = refev.data('suppcode');
            let supplier = refev.data('supplier');
            let date2rep = refev.data('date2rep');

            let modal = $(this);

            modal.find(".modal-title").text("ข้อมูลของ: " + supplier);
            modal.find(".modal-body").html("<iframe src=\"poInfoAll.php?date2rep=" + date2rep + "&suppCode=" + suppCode + "\" frameborder=\"0\" width=\"100%\" height=\"500px\"></iframe>");
        })

        $('#modal4PO').on('hidden.bs.modal', function () {
            // window.location.reload();
        })
    </script><!-- Show PO's info -->

</body>

</html>