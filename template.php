<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <!--    <link rel="icon" type="image/png" href="../assets/img/favicon.png">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>Gold Rubber : Template</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no'
          name='viewport'/>

    <!-- Fonts and icons -->
    <!-- <link rel="stylesheet" href="./css/font.css">-->
    <link rel="stylesheet" href="./css/all.css"/>

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
            <canvas id="bigDashboardChart"></canvas>
        </div>
        <div class="content">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category">Global Sales</h5>
                            <h4 class="card-title">Shipped Products</h4>
                            <div class="dropdown">
                                <button type="button"
                                        class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret"
                                        data-toggle="dropdown">
                                    <i class="fas fa-cogs"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <a class="dropdown-item text-danger" href="#">Remove Data</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="lineChartExample"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fas fa-sync"></i> Just Updated
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category">2018 Sales</h5>
                            <h4 class="card-title">All products</h4>
                            <div class="dropdown">
                                <button type="button"
                                        class="btn btn-round btn-outline-default dropdown-toggle btn-simple btn-icon no-caret"
                                        data-toggle="dropdown">
                                    <i class="fas fa-cogs"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                    <a class="dropdown-item text-danger" href="#">Remove Data</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="lineChartExampleWithNumbersAndGrid"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="fas fa-sync"></i> Just Updated
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card card-chart">
                        <div class="card-header">
                            <h5 class="card-category">Email Statistics</h5>
                            <h4 class="card-title">24 Hours Performance</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-area">
                                <canvas id="barChartSimpleGradientsNumbers"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="far fa-bell"></i> Last 7 days
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card  card-tasks">
                        <div class="card-header ">
                            <h5 class="card-category">Backend development</h5>
                            <h4 class="card-title">Tasks</h4>
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
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-category">All Persons List</h5>
                            <h4 class="card-title"> Employees Stats</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Country
                                        </th>
                                        <th>
                                            City
                                        </th>
                                        <th class="text-right">
                                            Salary
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            Dakota Rice
                                        </td>
                                        <td>
                                            Niger
                                        </td>
                                        <td>
                                            Oud-Turnhout
                                        </td>
                                        <td class="text-right">
                                            $36,738
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Minerva Hooper
                                        </td>
                                        <td>
                                            Curaçao
                                        </td>
                                        <td>
                                            Sinaai-Waas
                                        </td>
                                        <td class="text-right">
                                            $23,789
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Sage Rodriguez
                                        </td>
                                        <td>
                                            Netherlands
                                        </td>
                                        <td>
                                            Baileux
                                        </td>
                                        <td class="text-right">
                                            $56,142
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Doris Greene
                                        </td>
                                        <td>
                                            Malawi
                                        </td>
                                        <td>
                                            Feldkirchen in Kärnten
                                        </td>
                                        <td class="text-right">
                                            $63,542
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Mason Porter
                                        </td>
                                        <td>
                                            Chile
                                        </td>
                                        <td>
                                            Gloucester
                                        </td>
                                        <td class="text-right">
                                            $78,615
                                        </td>
                                    </tr>
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
<!--   Core JS Files   -->
<script src="./js/core/jquery.min.js"></script>
<script src="./js/core/popper.min.js"></script>
<script src="./js/core/bootstrap.min.js"></script>
<script src="./js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin    -->
<!--<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>-->
<!-- Chart JS -->
<script src="./js/plugins/chartjs.min.js"></script>
<!--  Notifications Plugin    -->
<script src="./js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
<script src="./js/now-ui-dashboard.min.js?v=1.5.0" type="text/javascript"></script>

</body>

</html>