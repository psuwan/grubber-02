<?php

include_once './lib/apksFunctions.php';

//$poNumber = filter_input(INPUT_POST, 'poNumber');
$varpost_processName = filter_input(INPUT_POST, 'processName');
$varpost_id2Update = filter_input(INPUT_POST, 'id');
$varpost_buyPrice = filter_input(INPUT_POST, 'buyPrice');
$varpost_valueDRC = filter_input(INPUT_POST, 'valueDRC');
$varpost_valueBuyType = filter_input(INPUT_POST, 'valueBuyType');
$varpost_valueLocation = filter_input(INPUT_POST, 'valueLocation');

switch ($varpost_processName) {
    case 'updatePrice':
        updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_buyprc', $varpost_buyPrice, 1);
//        header('refresh:0;url=poMgr.php?poNumber=' . $poNumber);
        break;

    case 'updateDRC':
        updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_percent', $varpost_valueDRC, 1);
//        header('refresh:0;url=poMgr.php?poNumber=' . $poNumber);
        break;

    case 'updateBuyType':
        updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_buytype', $varpost_valueBuyType, 2);
        break;

    case 'updateLocation':
        updateDB('tbl_wg4buy', 'id', $varpost_id2Update, 1, 'wg_location', $varpost_valueLocation, 2);
        break;
}