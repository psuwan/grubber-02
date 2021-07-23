<?php

include_once './lib/apksFunctions.php';

date_default_timezone_set('Asia/Bangkok');
$dtNow = date("Y-m-d H:i:s");

$varget_id2delete = filter_input(INPUT_GET, 'id2delete');

$varpost_suppSubmitBtn = filter_input(INPUT_POST, 'suppSubmitBtn');
$varpost_processName = filter_input(INPUT_POST, 'processName');

$suppData = array(
    "suppCode" => filter_input(INPUT_POST, 'suppCode'),
    "suppEmail" => filter_input(INPUT_POST, 'suppEmail'),
    "suppPhone" => filter_input(INPUT_POST, 'suppPhone'),
    "suppName" => filter_input(INPUT_POST, 'suppName'),
    "suppSurname" => filter_input(INPUT_POST, 'suppSurname'),
    "suppCategory" => filter_input(INPUT_POST, 'suppCategory'),
    "suppAddress" => filter_input(INPUT_POST, 'suppAddress'),
    "suppAmphoe" => filter_input(INPUT_POST, 'suppAmphoe'),
    "suppProvince" => filter_input(INPUT_POST, 'suppProvince'),
    "suppZipcode" => filter_input(INPUT_POST, 'suppZipcode'),
    "suppDetails" => filter_input(INPUT_POST, 'suppDetails')
);
$suppCode = $suppData['suppCode'];
$suppEmail = $suppData['suppEmail'];
$suppPhone = $suppData['suppPhone'];
$suppName = $suppData['suppName'];
$suppSurname = $suppData['suppSurname'];
$suppCate = $suppData['suppCategory'];
$suppAddr = $suppData['suppAddress'];
$suppAmphoe = $suppData['suppAmphoe'];
$suppProvince = $suppData['suppProvince'];
$suppZipcode = $suppData['suppZipcode'];
$suppDetails = $suppData['suppDetails'];

if (isset($varpost_suppSubmitBtn)) {
    switch ($varpost_processName) {
        case 'addSupp':
            insertDB('tbl_suppliers', 'supp_code', $suppCode, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_createdat', $dtNow, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_name', $suppName, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_surname', $suppSurname, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_email', $suppEmail, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_phone', $suppPhone, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_category', $suppCate, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_address', $suppAddr, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_amphoe', $suppAmphoe, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_province', $suppProvince, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_zipcode', $suppZipcode, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_details', $suppDetails, 2);
            echo "<script>alert('เพิ่มข้อมูลผู้ขายเรียบร้อยแล้ว');</script>";
            echo "<script>window.location.href='./suppList.php';</script>";
            break;

        case 'editSupp':
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_name', $suppName, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_surname', $suppSurname, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_email', $suppEmail, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_phone', $suppPhone, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_category', $suppCate, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_address', $suppAddr, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_amphoe', $suppAmphoe, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_province', $suppProvince, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_zipcode', $suppZipcode, 2);
            updateDB('tbl_suppliers', 'supp_code', $suppCode, 2, 'supp_details', $suppDetails, 2);
            echo "<script>alert('แก้ไขข้อมูลผู้ขายเรียบร้อยแล้ว');</script>";
            echo "<script>window.location.href='./suppList.php';</script>";
            break;

        default:
            // Do nothing
            break;
    }
}

if (!empty($varget_id2delete)) {
    deleteDB('tbl_suppliers', 'id', $varget_id2delete, 1);
    echo "<script>alert('ลบข้อมูลผู้ขายเรียบร้อยแล้ว');</script>";
    echo "<script>window.location.href='./suppList.php';</script>";
}