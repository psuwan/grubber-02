<?php
date_default_timezone_set('Asia/Bangkok');
$dateNow = date("Y-m-d");
$timeNow = date("H:i:s");

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_custCode = filter_input(INPUT_POST, 'custCode');
$varpost_custName = filter_input(INPUT_POST, 'custName');
$varpost_custSurName = filter_input(INPUT_POST, 'custSurName');
$varpost_custPhone = filter_input(INPUT_POST, 'custPhone');
$varpost_custAddress = filter_input(INPUT_POST, 'custAddress');
$varpost_custDetails = filter_input(INPUT_POST, 'custDetails');

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case "addCustomer":
            insertDB("tbl_customers", "customer_code", $varpost_custCode, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_name", $varpost_custName, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_surname", $varpost_custSurName, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_phone", $varpost_custPhone, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_address", $varpost_custAddress, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_details", $varpost_custDetails, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_created", $dateNow . " " . $timeNow, 2);

            echo "<script>alert(\"เพิ่มข้อมูลลูกค้าแล้ว\")</script>";
            echo "<script>window.logcation.href=\"./customerห.php\"</script>";
            break;

        case "editCustomer":
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_name", $varpost_custName, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_surname", $varpost_custSurName, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_phone", $varpost_custPhone, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_address", $varpost_custAddress, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_details", $varpost_custDetails, 2);
            updateDB("tbl_customers", "customer_code", $varpost_custCode, 2, "customer_created", $dateNow . " " . $timeNow, 2);

            echo "<script>alert(\"แก้ไขข้อมูลลูกค้าแล้ว\")</script>";
            echo "<script>window.logcation.href=\"./customerห.php\"</script>";
            break;
    }
}