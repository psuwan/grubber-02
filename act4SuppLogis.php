<?php

include_once "./lib/apksFunctions.php";
$dbConn = dbConnect();

$varpost_processName = filter_input(INPUT_POST, "processName");
$varpost_id2edit = filter_input(INPUT_POST, "id2edit");

$suppLogisData = array(
    "suppLogisCode" => filter_input(INPUT_POST, "suppLogisCode"),
    "suppLogisVlpn" => filter_input(INPUT_POST, "suppLogisVlpn"),
    "suppLogisName" => filter_input(INPUT_POST, "suppLogisName"),
    "suppLogisDetails" => filter_input(INPUT_POST, "suppLogisDetails")
);

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case 'addSuppLogis':
            insertDB("tbl_suppLogis", "supplogis_code", $suppLogisData["suppLogisCode"], 2);
            updateDB("tbl_suppLogis", "supplogis_code", $suppLogisData["suppLogisCode"], 2, "supplogis_name", $suppLogisData["suppLogisName"], 2);
            updateDB("tbl_suppLogis", "supplogis_code", $suppLogisData["suppLogisCode"], 2, "supplogis_vlpn", $suppLogisData["suppLogisVlpn"], 2);
            updateDB("tbl_suppLogis", "supplogis_code", $suppLogisData["suppLogisCode"], 2, "supplogis_details", $suppLogisData["suppLogisDetails"], 2);

            echo "<script>alert(\"เพิ่มข้อมูลรถขนส่งแล้ว\")</script>";
            echo "<script>window.location.href=\"suppLogis.php\"</script>";
            break;

        case 'editSuppLogis':
            updateDB("tbl_suppLogis", "supplogis_code", $suppLogisData["suppLogisCode"], 2, "supplogis_name", $suppLogisData["suppLogisName"], 2);
            updateDB("tbl_suppLogis", "supplogis_code", $suppLogisData["suppLogisCode"], 2, "supplogis_vlpn", $suppLogisData["suppLogisVlpn"], 2);
            updateDB("tbl_suppLogis", "supplogis_code", $suppLogisData["suppLogisCode"], 2, "supplogis_details", $suppLogisData["suppLogisDetails"], 2);

            echo "<script>alert(\"แก้ไขข้อมูลรถขนส่งแล้ว\")</script>";
            echo "<script>window.location.href=\"suppLogis.php\"</script>";
            break;
    }
}