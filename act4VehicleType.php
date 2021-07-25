<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varpost_processName = filter_input(INPUT_POST, 'processName');

$vehicleTypeData = array(
    "vehicleTypeCode" => filter_input(INPUT_POST, 'vehicleTypeCode'),
    "vehicleTypeName" => filter_input(INPUT_POST, 'vehicleTypeName'),
    "vehicleTypeDetails" => filter_input(INPUT_POST, 'vehicleTypeDetails')
);

$vehicleTypeCode = $vehicleTypeData['vehicleTypeCode'];
$vehicleTypeName = $vehicleTypeData['vehicleTypeName'];
$vehicleTypeDetails = $vehicleTypeData['vehicleTypeDetails'];

// Add and edit database
if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addVehicleType':
            insertDB('tbl_vehicletype', 'vehicletype_code', $vehicleTypeCode, 2);
            updateDB('tbl_vehicletype', 'vehicletype_code', $vehicleTypeCode, 2, 'vehicletype_name', $vehicleTypeName, 2);
            updateDB('tbl_vehicletype', 'vehicletype_code', $vehicleTypeCode, 2, 'vehicletype_details', $vehicleTypeDetails, 2);

            echo "<script>alert('เพิ่มข้อมูลประเภทรถแล้ว');</script>";
            echo "<script>window.location.href='./vehicleType.php';</script>";
            break;

        case 'editVehicleType':
            updateDB('tbl_vehicletype', 'vehicletype_code', $vehicleTypeCode, 2, 'vehicletype_name', $vehicleTypeName, 2);
            updateDB('tbl_vehicletype', 'vehicletype_code', $vehicleTypeCode, 2, 'vehicletype_details', $vehicleTypeDetails, 2);

            echo "<script>alert('แก้ไขข้อมูลประเภทรถแล้ว');</script>";
            echo "<script>window.location.href='./vehicleType.php';</script>";
            break;

        default:
            echo "<script>alert('ไม่มีการจัดการที่ถูกเลือก');</script>";
            echo "<script>window.history.go(-1);</script>";
            break;
    }
}

// Delete data from database
if (!empty($varget_id2delete)) {
    deleteDB('tbl_vehicletype', 'id', $varget_id2delete, 1);
    echo "<script>alert('ลบข้อมูลประเภทรถแล้ว');</script>";
    echo "<script>window.location.href='./vehicleType.php';</script>";
}