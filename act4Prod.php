<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');
$varpost_processName = filter_input(INPUT_POST, 'processName');

$prodData = array(
    "prodCode" => filter_input(INPUT_POST, 'prodCode'),
    "prodName" => filter_input(INPUT_POST, 'prodName'),
    "prodGroup" => filter_input(INPUT_POST, 'prodGroup'),
    "prodDetails" => filter_input(INPUT_POST, 'prodDetails')
);

$prodCode = $prodData['prodCode'];
$prodName = $prodData['prodName'];
$prodGroup = $prodData['prodGroup'];
$prodDetails = $prodData['prodDetails'];

// Add adn edit database
if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addProd':
            insertDB('tbl_products', 'product_code', $prodCode, 2,);
            updateDB('tbl_products', 'product_code', $prodCode, 2, 'product_name', $prodName, 2);
            updateDB('tbl_products', 'product_code', $prodCode, 2, 'product_group', $prodGroup, 2);
            updateDB('tbl_products', 'product_code', $prodCode, 2, 'product_details', $prodDetails, 2);

            echo "<script>alert('เพิ่มข้อมูลสินค้าแล้ว');</script>";
            echo "<script>window.location.href='./prodList.php';</script>";
            break;

        case 'editProd':
            updateDB('tbl_products', 'product_code', $prodCode, 2, 'product_name', $prodName, 2);
            updateDB('tbl_products', 'product_code', $prodCode, 2, 'product_group', $prodGroup, 2);
            updateDB('tbl_products', 'product_code', $prodCode, 2, 'product_details', $prodDetails, 2);

            echo "<script>alert('แก้ไขข้อมูลสินค้าแล้ว');</script>";
            echo "<script>window.location.href='./prodList.php';</script>";
            break;

        default:
            echo "<script>alert('ไม่มีการจัดการที่ถูกเลือก');</script>";
            echo "<script>window.history.go(-1);</script>";
            break;
    }
}

// Delete data from database
if(!empty($varget_id2delete)){
    deleteDB('tbl_products', 'id', $varget_id2delete, 1);
    echo "<script>alert('ลบข้อมูลสินค้าแล้ว');</script>";
    echo "<script>window.location.href='./prodList.php';</script>";
}