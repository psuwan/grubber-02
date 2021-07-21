<?php
require_once './lib/apksFunctions.php';

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
                                <!--                                <canvas id="lineChartExample"></canvas>-->
                                <canvas id="myChartLine" height="105px"></canvas>
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
                                <canvas id="myChart" height="105px"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="now-ui-icons loader_refresh"></i> Just Updated
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="col-lg-4 col-md-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category">ข้อมูลรายวัน</h5>
                            <h4 class="card-title">24 Hours Performance</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="barChartSimpleGradientsNumbers"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="now-ui-icons ui-2_time-alarm"></i> Last 7 days
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <div class="row">
                <!--<div class="col-md-6">
                    <div class="card  card-tasks">
                        <div class="card-header ">
                            <h5 class="card-category">ข้อมูลรายวัน</h5>
                            <h4 class="card-title">รายการซื้อ</h4>
                        </div>
                        <div class="card-body ">
                            <div class="table-full-width table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-left">Sign contract for "What are conference organizers afraid
                                            of?"
                                        </td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title=""
                                                    class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral"
                                                    data-original-title="Edit Task">
                                                <i class="now-ui-icons ui-2_settings-90"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title=""
                                                    class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral"
                                                    data-original-title="Remove">
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox">
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-left">Lines From Great Russian Literature? Or E-mails From My
                                            Boss?
                                        </td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title=""
                                                    class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral"
                                                    data-original-title="Edit Task">
                                                <i class="now-ui-icons ui-2_settings-90"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title=""
                                                    class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral"
                                                    data-original-title="Remove">
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" checked>
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="text-left">Flooded: One year later, assessing what was lost and what
                                            was found when a
                                            ravaging rain swept through metro Detroit
                                        </td>
                                        <td class="td-actions text-right">
                                            <button type="button" rel="tooltip" title=""
                                                    class="btn btn-info btn-round btn-icon btn-icon-mini btn-neutral"
                                                    data-original-title="Edit Task">
                                                <i class="now-ui-icons ui-2_settings-90"></i>
                                            </button>
                                            <button type="button" rel="tooltip" title=""
                                                    class="btn btn-danger btn-round btn-icon btn-icon-mini btn-neutral"
                                                    data-original-title="Remove">
                                                <i class="now-ui-icons ui-1_simple-remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                                <i class="now-ui-icons loader_refresh spin"></i> Updated 3 minutes ago 555
                            </div>
                        </div>
                    </div>
                </div>-->
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
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="คลิกดูบิล">PO20210721XXX</a>
                                        </td>
                                        <td>
                                            <?= monthThai(dateBE($dateNow)); ?> <?= date("H:m"); ?>
                                        </td>
                                        <td>
                                            Niger
                                        </td>
                                        <td>
                                            Oud-Turnhout
                                        </td>
                                        <td>
                                            09302312xx
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="คลิกดูบิล">PO20210721XXX</a>
                                        </td>
                                        <td>
                                            <?= monthThai(dateBE($dateNow)); ?> <?= date("H:m"); ?>
                                        </td>
                                        <td>
                                            Curaçao
                                        </td>
                                        <td>
                                            Sinaai-Waas
                                        </td>
                                        <td>
                                            09302312xx
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="คลิกดูบิล">PO20210721XXX</a>
                                        </td>
                                        <td>
                                            <?= monthThai(dateBE($dateNow)); ?> <?= date("H:m"); ?>
                                        </td>
                                        <td>
                                            Netherlands
                                        </td>
                                        <td>
                                            Baileux
                                        </td>
                                        <td>
                                            09302312xx
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="คลิกดูบิล">PO20210721XXX</a>
                                        </td>
                                        <td>
                                            <?= monthThai(dateBE($dateNow)); ?> <?= date("H:m"); ?>
                                        </td>
                                        <td>
                                            Malawi
                                        </td>
                                        <td>
                                            Feldkirchen in Kärnten
                                        </td>
                                        <td>
                                            09302312xx
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a href="#" data-toggle="tooltip" data-placement="bottom" title="คลิกดูบิล">PO20210721XXX</a>
                                        </td>
                                        <td>
                                            <?= monthThai(dateBE($dateNow)); ?> <?= date("H:m"); ?>
                                        </td>
                                        <td>
                                            Chile
                                        </td>
                                        <td>
                                            Gloucester
                                        </td>
                                        <td>
                                            09302312xx
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right">
                                <a href="#">ดูทั้งหมด</a>
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
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
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
    var ctx = document.getElementById("myChartLine");
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["-6", "-5", "-4", "-3", "-2", "-1", "วันนี้"],
            datasets: [{
                label: '# of Votes',
                data: [120, 190, 30, 50, 21, 119, 56],
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

</body>

</html>