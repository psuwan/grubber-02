<?php
//session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <link rel="icon" type="image/png" href="./assets/img/faviconW.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>GOLD RUBBER : USER LOGIN</title>

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
    <link rel="stylesheet" href="./css/style4Project.css">
    <style>
        body {
            background-image: url('./assets/img/bigBG3.jpg');
        }
    </style>
</head>

<body>
<div class="mt-5 mb-5 d-none d-md-block">
    &nbsp;
</div>
<div class="container mt-5">
    <div class="col-10 col-md-6 col-lg-4 ml-auto mr-auto">

        <form class="form" method="POST" action="./act4User.php">

            <div class="card card-login card-plain"
                 style="background-color: rgba(80,80,80,0.75);border-radius: 5px">

                <div class="card-header ">
                    <div class="logo-container">
                        <img src="./assets/img/logo_shadow.png" alt="">
                    </div>
                </div>

                <div class="card-body ">

                    <div class="input-group no-border form-control-lg mb-3">
                                <span class="input-group-prepend">
                                  <div class="input-group-text">
                                    <i class="now-ui-icons users_circle-08"></i>
                                  </div>
                                </span>
                        <input type="text" class="form-control" placeholder="ผู้ใช้งาน" name="name4User"
                               style="font-size: 14px;" data-toggle="tooltip" data-placement="top" title="ผู้ใช้งาน">
                    </div>

                    <div class="input-group no-border form-control-lg mt-3">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="now-ui-icons text_caps-small"></i>
                            </div>
                        </div>
                        <input type="password" placeholder="รหัสผ่าน" class="form-control" name="pass4User"
                               style="font-size: 14px;" data-toggle="tooltip" data-placement="top" title="รหัสผ่าน">
                    </div>


                </div>


                <div class="card-footer ">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">เข้าสู่ระบบ
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 text-center">
                            <h6><a href="./userRegister.php" class="link footer-link">สร้างรหัสผู้ใช้งาน</a></h6>
                        </div>

                        <div class="col-12 col-md-6 text-center">
                            <h6><a href="#" class="link footer-link">ความช่วยเหลือ</a></h6>
                        </div>
                    </div>


                </div>

                <input type="hidden" name="processName" value="userLogin">

        </form>
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

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

</body>

</html>
