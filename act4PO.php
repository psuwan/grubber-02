<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varpost_processName = filter_input(INPUT_POST, 'processName');

$POData = array(
    "POIsNew" => filter_input(INPUT_POST, 'chkNewPO'),
    "PONumber" => filter_input(INPUT_POST, 'poNumber'),
    "POVLPN" => filter_input(INPUT_POST, 'vlpnNumber'),
    "POSupp" => filter_input(INPUT_POST, 'POSuppName'),
    "POBuyType" => filter_input(INPUT_POST, 'POBuyType'),
    "POWgType" => filter_input(INPUT_POST, 'POWgType'),
    "POWgScale" => filter_input(INPUT_POST, 'POWgScale'),
    "QtyPallet" => filter_input(INPUT_POST, 'cntPallet'),
    "Wg4Pallet" => filter_input(INPUT_POST, 'wg4Pallet'),
    "WgScaleRd" => filter_input(INPUT_POST, 'wgScaleRd'),
    "WgNetValue" => filter_input(INPUT_POST, 'wgScaleNet'),
    "POProduct" => filter_input(INPUT_POST, 'POProduct')
);
$PO_New = $POData['POIsNew'];
$PO_Number = $POData['PONumber'];
$PO_LPN = $POData['POVLPN'];
//
$PO_SuppCode = '';
list($suppNameF, $suppNameL) = explode(" ", $POData['POSupp']);
$PO_SuppCode = getValue('tbl_suppliers', 'supp_name', $suppNameF, 2, 'supp_code');
//
$PO_BuyType = $POData['POBuyType'];
$PO_WgType = $POData['POWgType'];
$PO_WgScale = $POData['POWgScale'];
$PO_Product = $POData['POProduct'];
$PO_PalletQty = $POData['QtyPallet'];
$PO_PalletWG = $POData['Wg4Pallet'];
$PO_ScaleRd = $POData['WgScaleRd'];
$PO_WgNet = $POData['WgNetValue'];
// echo "<pre>";
// var_dump($POData);
// echo "</pre>";

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'AddPO':
            if ($PO_New == 1) {
                insertDB('tbl_purchaseorder', 'po_number', $PO_Number, 2);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_vlpn', $PO_LPN, 2);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_suppcode', $PO_SuppCode, 2);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_buytype', $PO_BuyType, 2);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_wgtype', $PO_WgType, 2);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_wgscale', $PO_WgScale, 2);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_product', $PO_Product, 2);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_palletqty', $PO_PalletQty, 1);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_palletwg', $PO_PalletWG, 1);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_scalerd', $PO_ScaleRd, 1);
                updateDB('tbl_purchaseorder', 'po_number', $PO_Number, 2, 'po_netwg', $PO_WgNet, 1);
//                updateDB('tbl_purchaseorder', 'po_number', $PO_Num, 2, '', , );
//                updateDB('tbl_purchaseorder', 'po_number', $PO_Num, 2, '', , );
//                updateDB('tbl_purchaseorder', 'po_number', $PO_Num, 2, '', , );

                echo "<script>alert('บันทึก PO แล้ว');</script>";
                echo "<script>window.location.href='./poList.php';</script>";
            } else {
                //
            }
            break;

        default:
            break;
    }
}