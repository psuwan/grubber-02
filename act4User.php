<?php
session_start();

date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once "lib" . DIRECTORY_SEPARATOR . "apksFunctions.php";
$dbConn = dbConnect();

// Set how many device can login
// with the same user
// now this feature was not finished yet
$userCanLogin = intval(getMaxLogin());

$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_username = filter_input(INPUT_POST, 'name4User');
$varpost_password = filter_input(INPUT_POST, 'pass4User');
$varpost_userdept = filter_input(INPUT_POST, 'dept4User');

$userPass = password_hash(sha1($varpost_username) . $varpost_password, PASSWORD_BCRYPT);

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'userLogin':
            // function => countDB was return string so
            $chkUserLogin = intval(countDB("tbl_users", "username", $varpost_username, 2));
            if ($chkUserLogin === 0) {
                echo "<script>alert('ไม่มีข้อมูลของผู้ใช้นี้')</script>";
                echo "<script>window.history.go(-1)</script>";
            } else {
                $password2BeChk = getValue("tbl_users", "username", $varpost_username, 2, "userpass");
                $verifyPassword = password_verify(sha1($varpost_username) . $varpost_password, $password2BeChk);
                if (!$verifyPassword) {
                    echo "<script>alert('รหัสผ่านผิด')</script>";
                    echo "<script>window.history.go(-1)</script>";
                } else {
                    $chkUserEnable = getValue("tbl_users", "username", $varpost_username, 2, "userstatus");
                    if ($chkUserEnable === '0') {
                        echo "<script>alert('ผู้ใช้ไม่ได้รับอนุญาต')</script>";
                        echo "<script>window.history.go(-1)</script>";
                    } else {
                        $userLevel = getValue("tbl_users", "username", $varpost_username, 2, "userlevel");
                        // cntUserLogin return intval
                        $cntUserLogin = cntUserLogin('tbl_logintoken', $varpost_username);
                        if ($cntUserLogin < $userCanLogin) {
                            // Create login token and insert into tbl_logintoken
                            $token4User = getToken(50);
                            insertDB("tbl_logintoken", "login_user", $varpost_username, 2);
                            updateDB("tbl_logintoken", "login_user", $varpost_username, 2, "login_token", $token4User, 2);
                            updateDB("tbl_logintoken", "login_user", $varpost_username, 2, "login_time", $dateNow . " " . $timeNow, 2);
                            // Created login token and insert into tbl_logintoken

                            // Create session variable
                            $_SESSION["USERLOGINNAME"] = $varpost_username;
                            $_SESSION["USERLOGINTOKEN"] = $userLevel . "L" . $token4User;

                            // Write log for user login
                            writeLog("LOG4_LOGIN", "User \"" . $varpost_username . "\" login to system");

                            // Display message for login success
                            echo "<script>alert('เข้าสู่ระบบสำเร็จ...')</script>";
                            echo "<script>window.location.href='./index.php'</script>";
                        } else {
                            // Write log for user login
                            writeLog("LOG4_LOGIN", "User \"" . $varpost_username . "\" login to system from another place with no logout from last login");

                            // Create login token and update in tbl_logintoken
                            $token4User = getToken(50);
                            $sqlcmd_chkSingleSignOn = "UPDATE tbl_logintoken SET login_token='" . $token4User . "', login_time=NOW() WHERE login_user='" . $varpost_username . "' ORDER BY login_time ASC LIMIT 1";
                            $sqlres_chkSingleSignOn = mysqli_query($dbConn, $sqlcmd_chkSingleSignOn);

                            // Create session variable
                            $_SESSION["USERLOGINNAME"] = $varpost_username;
                            $_SESSION["USERLOGINTOKEN"] = $userLevel . "bXd" . $token4User;

                            // Display message for login success
                            echo "<script>alert('เข้าสู่ระบบสำเร็จ')</script>";
                            echo "<script>window.location.href='./index.php'</script>";
                        }
                    }
                }
            }
            break;

        case 'userRegister':
//            echo "<pre>";
//            var_dump($_POST);
//            echo "</pre>";
            $chkUser = countDB("tbl_users", "username", $varpost_username, 2);
            if ($chkUser != 0) {
                echo "<script>alert('ชื่อผู้ใช้ถูกลงทะเบียนแล้ว')</script>";
                echo "<script>window.history.go(-1)</script>";
            } else {
                $usercode = str_replace("-", "", $dateNow) . str_replace(":", "", $timeNow);
                insertDB("tbl_users", "usercode", $usercode, 2);
                updateDB("tbl_users", "usercode", $usercode, 2, "username", $varpost_username, 2);
                updateDB("tbl_users", "usercode", $usercode, 2, "userpass", $userPass, 2);
                updateDB("tbl_users", "usercode", $usercode, 2, "userdept", $varpost_userdept, 2);

                echo "<script>alert('ลงทะเบียนผู้ใช้แล้ว')</script>";
                echo "<script>window.history.go(-1)</script>";
            }
            break;
    }/* END OF SWITCH*/
}/* END OF IF */