<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!--    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
    <!--    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">-->
    <link rel="icon" type="image/png" href="./assets/img/faviconW.ico">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>

    <title>GOLD RUBBER : USER REGISTER</title>

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
<div class="container mt-5">
    <div class="col-10 col-md-6 col-lg-4 ml-auto mr-auto">

        <form class="form" method="POST" action="./act4User.php">

            <div class="card card-login card-plain"
                 style="background-color: rgba(80,80,80,0.75);border-radius: 5px">

                <div class="card-header ">
                    <div class="logo-container">
                        <img src="./assets/img/logo_shadow.png" alt="Gold-Rubber Co., Ltd.">
                    </div>
                </div>

                <div class="card-body ">
                    <div class="row">
                        <div class="col-12 px-4">
                            <div class="selectWrapper1" style="width: 100%;font-size: 14px">
                                <select class="form-control selectBox1" name="dept4User" id="id4_userDept"
                                        style="font-size:14px">
                                    <?php
                                    $sqlcmd_listDepartments = "SELECT * FROM tbl_departments WHERE dept_code<>'99'";
                                    $sqlres_listDepartments = mysqli_query($dbConn, $sqlcmd_listDepartments);

                                    if ($sqlres_listDepartments) {
                                        while ($sqlfet_listDepartments = mysqli_fetch_assoc($sqlres_listDepartments)) {
                                            ?>
                                            <option value="<?= $sqlfet_listDepartments['dept_code']; ?>"><?= $sqlfet_listDepartments['dept_name']; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 px-4">
                            <input type="text" class="form-control no-border text-dark" placeholder="ผู้ใช้งาน"
                                   name="name4User" id="id4_username"
                                   style="height:30px;font-size:14px" data-toggle="tooltip" data-placement="top"
                                   title="ผู้ใช้งาน">
                            <div class="ml-5 text-danger" id="id4_chkNameLang">* ชื่อผู้ใช้ต้องเป็นภาษาอังกฤษหรือตัวเลข
                            </div>
                            <div class="ml-5 text-danger" id="id4_chkNameLength">* ชื่อผู้ใช้ต้องมากกว่า 6 อักษร</div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12 px-4">
                            <input type="password" placeholder="รหัสผ่าน" class="form-control" name="pass4User"
                                   id="id4_password"
                                   style="height:30px;font-size:14px" data-toggle="tooltip" data-placement="top"
                                   title="รหัสผ่าน">
                        </div>
                    </div>
                    <div class="ml-5 text-danger" id="id4_chkPwdCapEngLang">* รหัสผ่านต้องมีภาษาอังกฤษตัวใหญ่</div>
                    <div class="ml-5 text-danger" id="id4_chkPwdSmallEngLang">* รหัสผ่านต้องมีภาษาอังกฤษตัวเล็ก</div>
                    <div class="ml-5 text-danger" id="id4_chkPwdSpecialChar">* รหัสผ่านต้องมีอักษรพิเศษ</div>
                    <div class="ml-5 text-danger" id="id4_chkPwdLength">* รหัสผ่านต้องมากกว่า 6 อักษร</div>

                    <div class="row mt-3">
                        <div class="col-12 px-4">
                            <input type="password" placeholder="รหัสผ่านอีกครั้ง"
                                   class="form-control" name="passRe4User"
                                   id="id4_rePassword"
                                   style="height:30px;font-size:14px" data-toggle="tooltip"
                                   data-placement="top"
                                   title="รหัสผ่านอีกครั้ง">
                        </div>
                    </div>
                    <div class="ml-5 text-danger" id="id4_chkPwdMatch">* รหัสผ่านต้องเหมือนกัน</div>

                </div>

                <div class="card-footer ">
                    <div class="row">
                        <div class="col-12">
                            <button id="id4_btnRegister" type="submit" style="border:solid 1px white"
                                    class="btn btn-primary btn-round btn-block btn-sm disabled mb-3">
                                ลงทะเบียน
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-md-6 text-center">
                            <h6><a href="./userLogin.php" class="link footer-link">เข้าสู่ระบบ</a></h6>
                        </div>

                        <div class="col-12 col-md-6 text-center">
                            <h6><a href="#" class="link footer-link">ความช่วยเหลือ</a></h6>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="processName" value="userRegister">

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

<script>
    let btnChk1 = 0;
    let btnChk2 = 0;
    let btnChk3 = 0;
    let btnChk4 = 0;
    let btnChk5 = 0;
    let btnChk6 = 0;
    let btnChk7 = 0;

    let letters = /^[A-Za-z0-9]+$/;
    let capitalletters = /^[A-Z]+$/;
    let smallletters = /^[a-z]+$/;
    let numbers = /^[0-9]+$/;
    let specialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;

    let userName = document.getElementById("id4_username");
    let pwd1st = document.getElementById("id4_password");
    let pwd2nd = document.getElementById("id4_rePassword");

    $("#id4_username").on("keyup change", function () {
        // CHECK USERNAME LENGTH
        if (userName.value.length < 6) {
            $("#id4_chkNameLength").removeClass("text-success");
            $("#id4_chkNameLength").addClass("text-danger");
            $("#id4_chkNameLength").css("text-decoration", "none");
            // $("#id4BtnSave").attr("disabled", true);
            btnChk1 = 0;
        } else {
            $("#id4_chkNameLength").removeClass("text-danger");
            $("#id4_chkNameLength").addClass("text-success");
            $("#id4_chkNameLength").css("text-decoration", "line-through");
            // $("#id4BtnSave").attr("disabled", false);
            btnChk1 = 1;
        }
        // CHECK USERNAME LANGUAGE
        if (userName.value.match(letters)) {
            $("#id4_chkNameLang").removeClass("text-danger");
            $("#id4_chkNameLang").addClass("text-success");
            $("#id4_chkNameLang").css("text-decoration", "line-through");
            btnChk2 = 1;
        } else {
            $("#id4_chkNameLang").removeClass("text-success");
            $("#id4_chkNameLang").addClass("text-danger");
            $("#id4_chkNameLang").css("text-decoration", "none");
            btnChk2 = 0;
        }
    });

    $("#id4_password").on("keyup change", function () {
        if (pwd1st.value.length < 6) {
            $("#id4_chkPwdLength").removeClass("text-success");
            $("#id4_chkPwdLength").addClass("text-danger");
            $("#id4_chkPwdLength").css("text-decoration", "none");
            btnChk3 = 0;
        } else {
            $("#id4_chkPwdLength").removeClass("text-danger");
            $("#id4_chkPwdLength").addClass("text-success");
            $("#id4_chkPwdLength").css("text-decoration", "line-through");
            btnChk3 = 1;
        }

        if (pwd1st.value.toLowerCase() != pwd1st.value) {
            $("#id4_chkPwdCapEngLang").removeClass("text-danger");
            $("#id4_chkPwdCapEngLang").addClass("text-success");
            $("#id4_chkPwdCapEngLang").css("text-decoration", "line-through");
            btnChk4 = 1;
        } else {
            $("#id4_chkPwdCapEngLang").removeClass("text-success");
            $("#id4_chkPwdCapEngLang").addClass("text-danger");
            $("#id4_chkPwdCapEngLang").css("text-decoration", "none");
            btnChk4 = 0;
        }

        if (pwd1st.value.toUpperCase() != pwd1st.value) {
            $("#id4_chkPwdSmallEngLang").removeClass("text-danger");
            $("#id4_chkPwdSmallEngLang").addClass("text-success");
            $("#id4_chkPwdSmallEngLang").css("text-decoration", "line-through");
            btnChk5 = 1;
        } else {
            $("#id4_chkPwdSmallEngLang").removeClass("text-success");
            $("#id4_chkPwdSmallEngLang").addClass("text-danger");
            $("#id4_chkPwdSmallEngLang").css("text-decoration", "none");
            btnChk5 = 0;
        }

        if (specialChar.test(pwd1st.value)) {
            $("#id4_chkPwdSpecialChar").removeClass("text-danger");
            $("#id4_chkPwdSpecialChar").addClass("text-success");
            $("#id4_chkPwdSpecialChar").css("text-decoration", "line-through");
            btnChk6 = 1;
        } else {
            $("#id4_chkPwdSpecialChar").removeClass("text-success");
            $("#id4_chkPwdSpecialChar").addClass("text-danger");
            $("#id4_chkPwdSpecialChar").css("text-decoration", "none");
            btnChk6 = 0;
        }
    });

    $("#id4_rePassword").on("keyup change", function () {
        if (pwd2nd.value === pwd1st.value) {
            $("#id4_chkPwdMatch").removeClass("text-danger");
            $("#id4_chkPwdMatch").addClass("text-success");
            $("#id4_chkPwdMatch").css("text-decoration", "line-through");
            if ((btnChk1) && (btnChk2) && (btnChk3) && (btnChk4) && (btnChk5) && (btnChk6)) {
                $("#id4_btnRegister").removeClass("disabled");
            }
        } else {
            $("#id4_chkPwdMatch").removeClass("text-success");
            $("#id4_chkPwdMatch").addClass("text-danger");
            $("#id4_chkPwdMatch").css("text-decoration", "none");
            $("#id4_btnRegister").addClass("disabled");
        }
    });
</script>

</body>

</html>
