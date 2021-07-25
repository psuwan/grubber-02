<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varpost_processName = filter_input(INPUT_POST, 'processName');

$buyTypeData = array(
    "buyTypeCode" => filter_input(INPUT_POST, 'buyTypeCode'),
    "buyTypeName" => filter_input(INPUT_POST, 'buyTypeName'),
    "buyTypeDetails" => filter_input(INPUT_POST, 'buyTypeDetails')
);

$buyTypeCode = $buyTypeData['buyTypeCode'];
$buyTypeName = $buyTypeData['buyTypeName'];
$buyTypeDetails = $buyTypeData['buyTypeDetails'];

// Add and edit database
if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addBuyType':
            insertDB('tbl_buytype', 'buytype_code', $buyTypeCode, 2);
            updateDB('tbl_buytype', 'buytype_code', $buyTypeCode, 2, 'buytype_name', $buyTypeName, 2);
            updateDB('tbl_buytype', 'buytype_code', $buyTypeCode, 2, 'buytype_details', $buyTypeDetails, 2);

            echo "<script>alert('เพิ่มข้อมูลประเภทการซื้อแล้ว');</script>";
            echo "<script>window.location.href='./buyType.php';</script>";
            break;

        case 'editBuyType':
            updateDB('tbl_buytype', 'buytype_code', $buyTypeCode, 2, 'buytype_name', $buyTypeName, 2);
            updateDB('tbl_buytype', 'buytype_code', $buyTypeCode, 2, 'buytype_details', $buyTypeDetails, 2);

            echo "<script>alert('แก้ไขข้อมูลประเภทการซื้อแล้ว');</script>";
            echo "<script>window.location.href='./buyType.php';</script>";
            break;

        default:
            echo "<script>alert('ไม่มีการจัดการที่ถูกเลือก');</script>";
            echo "<script>window.history.go(-1);</script>";
            break;
    }
}

// Delete data from database
if (!empty($varget_id2delete)) {
    deleteDB('tbl_buytype', 'id', $varget_id2delete, 1);
    echo "<script>alert('ลบข้อมูลประเภทการซื้อแล้ว');</script>";
    echo "<script>window.location.href='./buyType.php';</script>";
}