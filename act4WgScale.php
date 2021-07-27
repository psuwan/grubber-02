<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varpost_processName = filter_input(INPUT_POST, 'processName');

$wgScaleData = array(
    "wgScaleCode" => filter_input(INPUT_POST, 'wgScaleCode'),
    "wgScaleName" => filter_input(INPUT_POST, 'wgScaleName'),
    "wgScaleDetails" => filter_input(INPUT_POST, 'wgScaleDetails')
);

$wgScaleCode = $wgScaleData['wgScaleCode'];
$wgScaleName = $wgScaleData['wgScaleName'];
$wgScaleDetails = $wgScaleData['wgScaleDetails'];

// Add and edit database
if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addWgScale':
            insertDB('tbl_wgscale', 'wgscale_code', $wgScaleCode, 2);
            updateDB('tbl_wgscale', 'wgscale_code', $wgScaleCode, 2, 'wgscale_name', $wgScaleName, 2);
            updateDB('tbl_wgscale', 'wgscale_code', $wgScaleCode, 2, 'wgscale_details', $wgScaleDetails, 2);

            echo "<script>alert('เพิ่มข้อมูลเครื่องชั่งแล้ว');</script>";
            echo "<script>window.location.href='./vehicleType.php';</script>";
            break;

        case 'editWgScale':
            updateDB('tbl_wgscale', 'wgscale_code', $wgScaleCode, 2, 'wgscale_name', $wgScaleName, 2);
            updateDB('tbl_wgscale', 'wgscale_code', $wgScaleCode, 2, 'wgscale_details', $wgScaleDetails, 2);

            echo "<script>alert('แก้ไขข้อมูลเครื่องแล้ว');</script>";
            echo "<script>window.location.href='./wgScale.php';</script>";
            break;

        default:
            echo "<script>alert('ไม่มีการจัดการที่ถูกเลือก');</script>";
            echo "<script>window.history.go(-1);</script>";
            break;
    }
}

// Delete data from database
if (!empty($varget_id2delete)) {
    deleteDB('tbl_wgscale', 'id', $varget_id2delete, 1);
    echo "<script>alert('ลบข้อมูลเครื่องชั่งแล้ว');</script>";
    echo "<script>window.location.href='./wgScale.php';</script>";
}