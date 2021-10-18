<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$yearNow = date("Y");

$thisFile = basename(__FILE__, '.php');

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
    <link rel="stylesheet" href="./css/thDateTimePicker.css">

    <!-- CSS Files -->
    <link href="./css/bootstrap.min.css" rel="stylesheet"/>
    <link href="./css/now-ui-dashboard.css?v=1.5.0" rel="stylesheet"/>
    <link href="./css/style4Paginator.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/jquery.dataTables.min.css">

    <style>
        #example_filter input {
            border-radius: 30px;
            width: 300px;
            height: 35px;
            margin-right: 18px;
        }

        /* Selects any <input> when focused */
        #example_filter input:focus {
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
            <!--<div class="jumbotron ml-5 mr-5 display-1 text-center font-weight-bold text-warning bg-transparent d-none d-sm-block">
                บริษัท โกลด์รับเบอร์ จำกัด
            </div>
            <div class="jumbotron display-4 text-center d-block d-sm-none text-warning bg-transparent font-weight-bold">
                Gold Rubber
            </div>-->
            <h2 class="text-warning text-center font-weight-bold">รายการซื้อยางประจำวัน</h2>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <!-- CARD HEADER -->
                        <div class="card-header">
                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h5 class="card-category"> ข้อมูลรายวัน </h5>
                                        <h4 class="card-title"> รายการซื้อวันที่
                                            : <?= monthThai(dateBE($varpost_date2Report)); ?> </h4>

                                    </div>
                                    <div class="col-md-3 text-right input-group mr-0" style="font-size:14px">
                                        <input type="text" class="form-control" name="date2Report"
                                               id="id4Date2List"
                                               style="margin:10px 0px 10px 0px!important"
                                               placeholder="คลิกเลือกวันที่">
                                        <div class="input-group-append mr-3">
                                            <button class="btn btn-primary btn-round" type="submit" id="button-addon2">
                                                แสดงรายงาน
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div><!-- CARD HEADER -->

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="example">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th class="text-center">สถานะ</th>
                                        <th>เลขอ้างอิง</th>
                                        <th>วัน-เวลา</th>
                                        <th>ผู้ขาย</th>
                                        <th>ทะเบียนรถ</th>
                                        <th>โทรศัพท์</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sqlcmd_SetMode = "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))";
                                    $sqlres_setMode = mysqli_query($dbConn, $sqlcmd_SetMode);

                                    $sqlcmd_listPO = "SELECT * FROM tbl_wg4buy WHERE DATE(wg_createdat)='" . $varpost_date2Report . "' GROUP BY wg_ponum ORDER BY wg_ponum DESC";
                                    $sqlres_listPO = mysqli_query($dbConn, $sqlcmd_listPO);

                                    if ($sqlres_listPO) {
                                        while ($sqlfet_listPO = mysqli_fetch_assoc($sqlres_listPO)) {
                                            ?>
                                            <tr>
                                                <td class="text-center"><?php
                                                    if ($sqlfet_listPO['po_status'] == 0)
                                                        echo "<a href=\"./process4PO.php?command=toggleStatus&returnPage=" . $thisFile . ".php&poNumber=" . $sqlfet_listPO['wg_ponum'] . "\"><i class=\"now-ui-icons media-1_button-power text-danger\"></i></a>";
                                                    else
                                                        echo "<a href=\"./process4PO.php?command=toggleStatus&returnPage=" . $thisFile . ".php&poNumber=" . $sqlfet_listPO['wg_ponum'] . "\"><i class=\"now-ui-icons media-1_button-power text-success\"></i></a>";
                                                    ?>
                                                </td>
                                                <td><?= $sqlfet_listPO['wg_ponum']; ?></td>
                                                <td><?= monthThai(dateBE(substr($sqlfet_listPO['wg_createdat'], 0, 10)));
                                                    ?>&nbsp;
                                                    <?= substr($sqlfet_listPO['wg_createdat'], 11, -3) . " น."; ?></td>
                                                <td><?= getValue('tbl_suppliers', 'supp_code', $sqlfet_listPO['wg_suppcode'], 2, 'supp_name') . " " . getValue('tbl_suppliers', 'supp_code', $sqlfet_listPO['wg_suppcode'], 2, 'supp_surname'); ?></td>
                                                <td><?= $sqlfet_listPO['wg_vlpn']; ?></td>
                                                <td><?= getValue('tbl_suppliers', 'supp_code', $sqlfet_listPO['wg_suppcode'], 2, 'supp_phone'); ?></td>
                                                <td>
                                                    <!-- CALCULATION FOR WEIGHT 2 TIME poMgr -> poMgrAll-->
                                                    <a href="./poMgrAll.php?poNumber=<?= $sqlfet_listPO['wg_ponum']; ?>"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="จัดการ PO"><i
                                                            class="now-ui-icons design-2_ruler-pencil"></i></a>

                                                    <a href="./prnWgCard.php?poNumber=<?= $sqlfet_listPO['wg_ponum']; ?>"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="พิมพ์บัตรชั่ง"><i class="now-ui-icons files_box"></i></a>

                                                    <span data-toggle="modal" data-target="#modal4POInfo"
                                                          data-ponumber="<?= $sqlfet_listPO['wg_ponum']; ?>">
                                                        <a href="#" data-toggle="tooltip" data-placement="top"
                                                           title="ข้อมูล PO"><i
                                                                class="now-ui-icons travel_info"></i></a></span>

                                                    <a href="./process4PO.php?command=deletePO&returnPage=<?= $thisFile; ?>.php&poNumber=<?= $sqlfet_listPO['wg_ponum']; ?>"
                                                       data-toggle="tooltip" data-placement="top"
                                                       title="ลบข้อมูล PO"
                                                       onclick="return confirm('ต้องการลบ PO นี้')"><i
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php
        require_once './fileFooter.php';
        ?><!-- End Footer -->
    </div>
</div>

<!-- Modal to show information (call iframe) -->
<div class="modal fade" id="modal4POInfo" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="xxxx.php" method="post">
                <div class="modal-header">
                    <h4 class="modal-title font-weight-bold" id=""></h4>
                </div>

                <div class="modal-body" id="modalBody">

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>

            </form>
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

<!-- DATETIME PICKER -->
<script src="./js/thDateTimePicker.js"></script>

<!-- Hi-light active menu -->
<script>
    // $("#id4MenuBuy").addClass("active");
    // $("#id4AlinkMenuBuy").addClass("text-primary");
    // $("#id4IconMenuBuy").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Buy").addClass("show");
    $("#id4SubMenuBuyPoListDate").addClass("active");
</script><!-- Hi-light active menu -->

<!-- Datatable Setup -->
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "order": [[0, "desc"]],
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


<!-- Pass parameter to modal -->
<script>
    $('#modal4POInfo').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let poNumber = button.data('ponumber');

        let modal = $(this);

        modal.find('.modal-title').text('รายละเอียดของ PO : ' + poNumber)

        $.ajax({
            url: "poData.php",
            type: "POST",
            data: {poNumber: poNumber},
            success: function (response) {
                console.log(response.length);
                for (let i = 0; i < response.length; i++) {
                    modal.find('#modalBody').append('<button type="button" class="btn btn-primary">ปุ่มที่ ' + i + '</button>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });

        //modal.find('.modal-body').html('<iframe src="info4PO.php?ponumber=' + recipient + '" style="text-align:center;width: 100%;height:600px;border: 0px;font-size: smaller;">')
    })

    $('#modal4POInfo').on('hidden.bs.modal', function () {
        window.location.reload();
    })
</script>

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
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
        $("#id4Date2List").datetimepicker({
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
        $("#id4Date2List").on("mouseenter mouseleave", function (e) {
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

</body>

</html>