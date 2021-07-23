<?php

include_once 'lib/apksFunctions.php';
$dbConn = dbConnect();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");

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

        <div class="panel-header panel-header-lg">
            <div class="jumbotron ml-5 mr-5 display-1 text-center font-weight-bold text-warning bg-transparent d-none d-sm-block">
                บริษัท โกลด์รับเบอร์ จำกัด
            </div>
            <div class="jumbotron display-4 text-center d-block d-sm-none text-warning bg-transparent font-weight-bold">
                Gold Rubber
            </div>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category">ข้อมูลรายสัปดาห์</h5>
                            <h4 class="card-title">ข้อมูลการซื้อวันที่ <?= (date("d") - 7); ?>
                                - <?= monthThai(dateBE($dateNow)); ?></h4>
                            <!--<div class="dropdown">
                                <button type="button"
                                        class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret"
                                        data-toggle="dropdown">
                                    <i class="now-ui-icons loader_gear"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <a class="dropdown-item text-danger" href="#">Remove Data</a>
                                </div>
                            </div>-->
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <!-- <canvas id="lineChartExample"></canvas>-->
                                <canvas id="myChartLine" class="w-100 h-100"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="now-ui-icons loader_refresh"></i> Just Updated
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category">ข้อมูลรายวัน</h5>
                            <h4 class="card-title">ประเภทยางที่ซื้อวันที่ <?= monthThai(dateBE($dateNow)); ?></h4>
                            <!--<div class="dropdown">
                                <button type="button"
                                        class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret"
                                        data-toggle="dropdown">
                                    <i class="now-ui-icons loader_gear"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <a class="dropdown-item text-danger" href="#">Remove Data</a>
                                </div>
                            </div>-->
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <!-- <canvas id="lineChartExampleWithNumbersAndGrid"></canvas>-->
                                <canvas id="myChart" class="w-100 h-100"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="now-ui-icons loader_refresh"></i> Just Updated
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category">ข้อมูลรายวัน</h5>
                            <h4 class="card-title"> รายการซื้อ </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>เลขอ้างอิง</th>
                                        <th>วัน-เวลา</th>
                                        <th>ผู้ขาย</th>
                                        <th>ทะเบียนรถ</th>
                                        <th>หมายเลขติดต่อ</th>
                                        <th>สถานะ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sqlcmd_listPO = "SELECT * FROM tbl_purchaseorder WHERE 1 ORDER BY po_createdat DESC LIMIT 5";
                                    $sqlres_listPO = mysqli_query($dbConn, $sqlcmd_listPO);

                                    if ($sqlres_listPO) {
                                        while ($sqlfet_listPO = mysqli_fetch_assoc($sqlres_listPO)) {
                                            ?>
                                            <tr>
                                                <td>
                                                    <a href="#" data-toggle="modal" data-target="#exampleModal">
                                                        <?= $sqlfet_listPO['po_number']; ?>
                                                    </a>
                                                </td>
                                                <td><?= $sqlfet_listPO['po_createdat']; ?></td>
                                                <td><?= $sqlfet_listPO['po_suppcode']; ?></td>
                                                <td><?= $sqlfet_listPO['po_vlpn']; ?></td>
                                                <td><?= getValue('tbl_suppliers', 'supp_code', $sqlfet_listPO['po_suppcode'], 2, 'supp_phone'); ?></td>
                                                <td>
                                                    <?php
                                                    if ($sqlfet_listPO['po_status'] == 1) {
                                                        echo "ยังไม่สรุปบิล";
                                                    } else {
                                                        echo "สรุปบิลแล้ว";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <a href="./poList.php">ดูทั้งหมด</a>
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

<!-- Modal show PO details -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- Modal show PO details -->

<!--   Core JS Files   -->
<script src="./js/core/jquery.min.js"></script>
<script src="./js/core/popper.min.js"></script>
<script src="./js/core/bootstrap.min.js"></script>
<script src="./js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin    -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
<!-- Chart JS -->
<script src="./js/plugins/chartjs.min.js"></script>
<!-- Demo Chart to show -->
<script>
    let ctx = document.getElementById("myChart");
    let myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["แผ่นสวย", "แผ่นคละ", "แผ่นหนา", "บล๊อก_1", "บล๊อก_2", "ยางฟอง", "เศษยาง"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3, 7],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(25, 230, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(25, 230, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>

<script>
    let ctxA = document.getElementById("myChartLine");
    let myChartLine = new Chart(ctxA, {
        type: 'pie',
        data: {
            labels: ["แผ่นสวย", "แผ่นคละ", "แผ่นหนา", "บล๊อก_1", "บล๊อก_2", "ยางฟอง", "เศษยาง"],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3, 7],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(25, 230, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(25, 230, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script><!-- Demo chart to show -->

<!--  Notifications Plugin    -->
<script src="./js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>

<script>
    $("#id4MenuDB").addClass("active");
</script>

</body>

</html>