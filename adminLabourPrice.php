<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

// DATE TO REPORT
$varpost_date2Report = filter_input(INPUT_POST, 'date2Report');
if (empty($varpost_date2Report)) {
    $varpost_date2Report = $dateNow;
} else {
    list($dd, $mm, $yy) = explode("-", $varpost_date2Report);
    $varpost_date2Report = ($yy - 543) . "-" . $mm . "-" . $dd;
}

list($ddd, $mmm, $yyy) = explode("-", date("d-m-Y"));
$dateNowPicker = $ddd . "-" . $mmm . "-" . ($yyy + 543);

/* GET VARIABLE SECTION */
$varget_id2edit = filter_input(INPUT_GET, "id2edit");

if (!empty($varget_id2edit)) {
    $processName = "editLabourPriceIn";

    $sqlcmd_labourInEdit = "SELECT * FROM tbl_labourprice WHERE id=" . $varget_id2edit;
    $sqlres_labourInEdit = mysqli_query($dbConn, $sqlcmd_labourInEdit);

    if ($sqlres_labourInEdit) {
        $sqlfet_labourInEdit = mysqli_fetch_assoc($sqlres_labourInEdit);

        $lbCode = $sqlfet_labourInEdit['lb_code'];

        $lbDate = $sqlfet_labourInEdit['lb_date'];
        list($yyy, $mmm, $ddd) = explode("-", $lbDate);
        $lbDate = $ddd . "-" . $mmm . "-" . ($yyy + 543);

        $lbSupp = $sqlfet_labourInEdit['lb_supplier'];
        $lbVLpn = $sqlfet_labourInEdit['lb_vlpn'];
        $lbWeight = $sqlfet_labourInEdit['lb_weight'];
        $lbPrice = $sqlfet_labourInEdit['lb_price'];
    }
} else {
    $processName = "addLabourPriceIn";

    $lbDate = $dateNowPicker;
    $lbSupp = '';
    $lbVLpn = '';
    $lbWeight = '';
    $lbPrice = '';
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

    <title>GOLD RUBBER : LABOUR IN</title>

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
    <link rel="stylesheet" href="./css/thDateTimePicker.css">

    <!-- DATATABLES -->
    <link rel="stylesheet" href="./css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <style>
        #labourIn_filter input {
            border-radius: 30px;
            width: 300px;
            height: 35px;
            margin-right: 18px;
        }

        .dataTables_length select {
            -webkit-border-radius: 30px !important;
        }

        .dt-button {
            border-radius: 30px !important;
        }

        /* Selects any <input> when focused */
        #labourIn_filter input:focus {
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

        <!-- Header section -->
        <div class="panel-header h-auto d-flex justify-content-center">
            <h2 class="text-warning font-weight-bold">ค่าแรงลงยาง</h2>
        </div><!-- Header section -->

        <!-- Main content -->
        <div class="content">
            <div class="row">

                <!-- Left side data -->
                <div class="col-md-12 order-1 order-md-0">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="title"> บันทึกค่าแรงลงยาง </h5>
                        </div>
                        <div class="card-body">
                            <form action="./act4LabourPrice.php" method="post">
                                <div class="row">

                                    <!-- PRODUCT -->
                                    <div class="col-md-3 pr-md-1">
                                        <div class="form-group">
                                            <label for="id4_dateLabourIn">วันที่</label>
                                            <input type="text"
                                                   class="form-control form-control-sm text-primary font-weight-bold"
                                                   placeholder=""
                                                   name="dateLabourIn" id="id4_dateLabourIn" style="font-size:14px;"
                                                   value="<?= $lbDate; ?>">
                                        </div>
                                    </div><!-- PRODUCT -->

                                    <!-- CUSTOMER -->
                                    <div class="col-md-3 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_supplier">ชื่อผู้ขาย</label>
                                            <input type="text" class="form-control form-control-sm font-weight-bold"
                                                   placeholder="ชื่อผู้ขาย" name="supplier" id="id4_supplier"
                                                   style="font-size:14px" value="<?= $lbSupp; ?>" required
                                                   list="supplierList">
                                        </div>
                                    </div><!-- CUSTOMER -->

                                    <!-- VLPN -->
                                    <div class="col-md-2 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_vLpn">ทะเบียนรถ</label>
                                            <input type="text" class="form-control form-control-sm font-weight-bold"
                                                   placeholder="ทะเบียนรถ" style="font-size:14px"
                                                   name="vLpn" id="id4_vLpn" value="<?= $lbVLpn; ?>" required>
                                        </div>
                                    </div><!-- VLPN -->

                                    <!-- PRODUCT -->
                                    <div class="col-md-2 px-md-1">
                                        <div class="form-group">
                                            <label for="id4_weight">น้ำหนักยางที่ลง</label>
                                            <input type="text"
                                                   class="form-control form-control-sm font-weight-bold float"
                                                   placeholder="น้ำหนักยาง (กก.)" style="font-size:14px"
                                                   name="weight" id="id4_weight" value="<?= $lbWeight; ?>" required>
                                        </div>
                                    </div><!-- PRODUCT -->

                                    <!-- PRICE -->
                                    <div class="col-md-2 pl-md-1">
                                        <div class="form-group">
                                            <label for="id4_price">ค่าลงยาง</label>
                                            <input type="text"
                                                   class="form-control form-control-sm font-weight-bold float"
                                                   placeholder="ค่าลงยาง (บาท)" style="font-size:14px"
                                                   name="price" id="id4_price" value="<?= $lbPrice; ?>" required>
                                        </div>
                                    </div><!-- PRICE -->

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
                                <input type="hidden" name="labourCode2Edit" value="<?= $lbCode; ?>">

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

                            <form action="" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <!--<h5 class="card-category">ข้อมูลทั้งหมด</h5>-->
                                        <h5 class="card-title"> ค่าแรงลงยางวันที่
                                            : <?= monthThai(dateBE($varpost_date2Report)); ?> </h5>
                                    </div>
                                    <div class="col-md-4 text-right input-group" style="font-size:14px">
                                        <input type="text" class="form-control" name="date2Report"
                                               id="id4_date2Report" style="margin:10px 0px 10px 105px!important;"
                                               placeholder="คลิกเลือกวันที่">
                                        <div class="input-group-append mr-md-3">
                                            <button class="btn btn-primary btn-round" type="submit" id="button-addon2">
                                                แสดงรายงาน
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="labourIn">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>วันที่</th>
                                        <th>ผู้ขาย</th>
                                        <th>ทะเบียนรถ</th>
                                        <th class="text-right">ปริมาณ</th>
                                        <th class="text-right">ค่าลง</th>
                                        <th class="text-right">รวมเป็นเงิน</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sqlcmd_listLabourPirceIn = "SELECT * FROM tbl_labourprice WHERE DATE(lb_date)='" . $varpost_date2Report . "'";
                                    $sqlres_listLabourPirceIn = mysqli_query($dbConn, $sqlcmd_listLabourPirceIn);

                                    if ($sqlres_listLabourPirceIn) {
                                        while ($sqlfet_listLabourPirceIn = mysqli_fetch_assoc($sqlres_listLabourPirceIn)) {
                                            ?>
                                            <tr>
                                                <td><?= monthThai(dateBE($sqlfet_listLabourPirceIn['lb_date'])); ?></td>
                                                <td><?= $sqlfet_listLabourPirceIn['lb_supplier']; ?></td>
                                                <td><?= $sqlfet_listLabourPirceIn['lb_vlpn']; ?></td>
                                                <td class="text-right"><?= number_format($sqlfet_listLabourPirceIn['lb_weight'], 2, '.', ','); ?>
                                                    กก.
                                                </td>
                                                <td class="text-right"><?= $sqlfet_listLabourPirceIn['lb_price']; ?>
                                                    บาท/กก.
                                                </td>
                                                <td class="text-right"><?= number_format(($sqlfet_listLabourPirceIn['lb_weight'] * $sqlfet_listLabourPirceIn['lb_price']), 2, '.', ',') ?>
                                                    บาท
                                                </td>
                                                <td>
                                                    <a href="adminLabourIn.php?id2edit=<?= $sqlfet_listLabourPirceIn['id']; ?>"
                                                       class="btn btn-round btn-warning btn-icon btn-sm"
                                                       data-toggle="tooltip" data-placement="right" title=" แก้ไข "><i
                                                                class="bi bi-pencil-fill"></i></a>
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

<!-- SUPPLIER LIST -->
<datalist id="supplierList">
    <?php
    $sqlcmd_listSuppliers = "SELECT * FROM tbl_suppliers WHERE 1";
    $sqlres_listSuppliers = mysqli_query($dbConn, $sqlcmd_listSuppliers);

    if ($sqlres_listSuppliers) {
        while ($sqlfet_listSuppliers = mysqli_fetch_assoc($sqlres_listSuppliers)) {
            ?>
            <option value="<?= $sqlfet_listSuppliers['supp_name']; ?>&nbsp;<?= $sqlfet_listSuppliers['supp_surname']; ?>"></option>
            <?php
        }
    }
    ?>
</datalist>
<!-- SUPPLIER LIST -->

<!--   Core JS Files   -->
<script src="./js/core/jquery.min.js"></script>
<script src="./js/core/popper.min.js"></script>
<script src="./js/core/bootstrap.min.js"></script>
<script src="./js/plugins/perfect-scrollbar.jquery.min.js"></script>

<!--  Notifications Plugin    -->
<script src="./js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>

<!-- PICKER DATE -->
<script src="./js/picker_date.js"></script>
<script src="./js/thDateTimePicker.js"></script>

<!-- DATATABLES -->
<script src="./js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

<!-- Hi-light active menu -->
<script>
    //$("#id4MenuAdmin").addClass("active");
    //$("#id4AlinkMenuAdmin").addClass("text-primary");
    //$("#id4IconMenuAdmin").addClass("text-primary");
    // Try to still open submenu
    $("#sub4Backend").addClass("show");
    $("#id4SubMenuBackendLabourPriceIn").addClass("active");
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
        $("#id4_dateLabourIn").datetimepicker({
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
        $("#id4_dateLabourIn").on("mouseenter mouseleave", function (e) {
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

        // id4_date2Report
        // กรณีใช้แบบ input
        $("#id4_date2Report").datetimepicker({
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
        $("#id4_date2Report").on("mouseenter mouseleave", function (e) {
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

<!-- INPUT FLOAT -->
<script>
    $('input.float').on('input', function () {
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
    });
</script><!-- INPUT FLOAT -->

<!-- Datatable Setup -->
<script>
    $(document).ready(function () {
        $('#labourIn').DataTable({
            dom: 'Blfrtip',
            buttons: ['copy', 'excel', {
                extend: "print",
                title: function () {
                    var printTitle = 'ค่าแรงลงยาง';
                    return printTitle
                },
                text: "พิมพ์",
                customize: function (win) {
                    var last = null;
                    var current = null;
                    var bod = [];

                    var css = '@page { size: landscape; }',
                        head = win.document.head || win.document.getElementsByTagName('head')[0],
                        style = win.document.createElement('style');

                    style.type = 'text/css';
                    style.media = 'print';

                    if (style.styleSheet) {
                        style.styleSheet.cssText = css;
                    } else {
                        style.appendChild(win.document.createTextNode(css));
                    }

                    head.appendChild(style);
                }
            }/*, {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'A4'
            }*/],
            "order": [
                [0, "desc"]
            ],
            language: {
                "decimal": "",
                "emptyTable": "ไม่มีข้อมูล",
                "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ ข้อมูล",
                "infoEmpty": "แสดง 0 ถึง 0 จาก 0 ข้อมูล",
                "infoFiltered": "(กรองจากทั้งหมด _MAX_ ข้อมูล)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "แสดง _MENU_ ข้อมูลต่อหน้า",
                "loadingRecords": "กำลังโหลด...",
                "processing": "กำลังประมวลผล...",
                "search": "ค้นหาในตาราง:  ",
                "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
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

</body>

</html>