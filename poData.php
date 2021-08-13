<?php

// This file will return opened PO data in JSON format

header('Content-Type: application/json');

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_poNumber = filter_input(INPUT_POST, 'poNumber');

$sqlcmd = "SELECT * FROM tbl_wg4buy WHERE wg_ponum='".$varpost_poNumber."' AND po_status=1";
$sqlres = mysqli_query($dbConn, $sqlcmd);

$retData = array();

foreach($sqlres as $result){
    $retData[] = $result;
}

mysqli_close($dbConn);

echo json_encode($retData, JSON_PRETTY_PRINT);