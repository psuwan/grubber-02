<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varpost_processName = filter_input(INPUT_POST, 'processName');

$prodTypeData = array(
    "prodTypeCode" => filter_input(INPUT_POST, 'prodTypeCode'),
    "prodTypeName" => filter_input(INPUT_POST, 'prodTypeName'),
    "prodTypeDetails" => filter_input(INPUT_POST, 'prodTypeDetails')
);

$prodTypeCode = $prodTypeData['prodTypeCode'];
$prodTypeName = $prodTypeData['prodTypeName'];
$prodTypeDetails = $prodTypeData['prodTypeDetails'];

// Add and edit database
if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addProdType':
            insertDB('tbl_prdtypes', 'prdtype_code', $prodTypeCode, 2);
            updateDB('tbl_prdtypes', 'prdtype_code', $prodTypeCode, 2, 'prdtype_name', $prodTypeName, 2);
            updateDB('tbl_prdtypes', 'prdtype_code', $prodTypeCode, 2, 'prdtype_details', $prodTypeDetails, 2);

            echo "<script>alert('เพิ่มข้อมูลสินค้าแล้ว');</script>";
            echo "<script>window.location.href='./prodList.php';</script>";
            break;

        case 'editProdType':
            updateDB('tbl_prdtypes', 'prdtype_code', $prodTypeCode, 2, 'prdtype_name', $prodTypeName, 2);
            updateDB('tbl_prdtypes', 'prdtype_code', $prodTypeCode, 2, 'prdtype_details', $prodTypeDetails, 2);

            echo "<script>alert('แก้ไขข้อมูลประเภทสินค้าแล้ว');</script>";
            echo "<script>window.location.href='./prodType.php';</script>";
            break;

        default:
            echo "<script>alert('ไม่มีการจัดการที่ถูกเลือก');</script>";
            echo "<script>window.history.go(-1);</script>";
            break;
    }
}


// Delete data from database
if(!empty($varget_id2delete)){
    deleteDB('tbl_prdtypes','id', $varget_id2delete,1);
    echo "<script>alert('ลบข้อมูลประเภทสินค้าแล้ว');</script>";
    echo "<script>window.location.href='./prodType.php';</script>";
}