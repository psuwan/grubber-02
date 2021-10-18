<?php

include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_command = filter_input(INPUT_GET, 'command');
$varpost_processName = filter_input(INPUT_POST, 'processName');

// VARIABLE_FROM_POST
$varpost_planNumber = filter_input(INPUT_POST, 'planNumber');
$varpost_planSuppLogis = filter_input(INPUT_POST, 'planSuppLogis');
$varpost_planNumberByID = filter_input(INPUT_POST, 'planNumberByID');
$varpost_planProductByID = filter_input(INPUT_POST, 'productCodeByID');

// FOR_EDIT_PLAN
$varpost_qtyOfSOInPlan = filter_input(INPUT_POST, 'qtyOfSOInPlan');

// remote , if have
$varpost_planWgProductByID = filter_input(INPUT_POST, 'wgProductByID');
$varpost_planWgProductByID = str_replace(',', '', $varpost_planWgProductByID);

$varpost_id2Update = filter_input(INPUT_POST, 'id');
$varpost_id2delete = filter_input(INPUT_POST,'id');

// VARIABLE_ARRAY_FROM_POST
$varpost_soNumber = filter_input(INPUT_POST, 'soNumber', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$varpost_soProduct = filter_input(INPUT_POST, 'soProduct', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$varpost_wgProduct = filter_input(INPUT_POST, 'wgProduct', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

if (!empty($varpost_processName)) {
    switch ($varpost_processName) {
        case "openPlan":
            for ($cntArr = 0; $cntArr < count($varpost_wgProduct); ++$cntArr) {
                $varpost_wgProduct[$cntArr] = str_replace(',', '', $varpost_wgProduct[$cntArr]);
                $sqlcmd_openPlan = "INSERT INTO tbl_sellplan (plan_number, plan_code4supplogis, plan_code4sellorder, plan_code4product, plan_wg4sellorder, plan_created)";
                $sqlcmd_openPlan .= " VALUES ('$varpost_planNumber','$varpost_planSuppLogis','$varpost_soNumber[$cntArr]','$varpost_soProduct[$cntArr]','$varpost_wgProduct[$cntArr]', NOW())";
                //echo $sqlcmd_openPlan;
                $sqlres_openPlan = mysqli_query($dbConn, $sqlcmd_openPlan);

                if (!$sqlres_openPlan) {
                    echo "ERROR [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
                }
            }

            echo "<script>alert(\"สร้างแผนขนส่งใหม่เสร็จแล้ว\")</script>";
            echo "<script>window.location.href=\"./logisSellPlan.php\"</script>";
            break;

        case "editPlan":
            for ($cntArr = $varpost_qtyOfSOInPlan; $cntArr < count($varpost_wgProduct); ++$cntArr) {
                $varpost_wgProduct[$cntArr] = str_replace(',', '', $varpost_wgProduct[$cntArr]);
                $sqlcmd_openPlan = "INSERT INTO tbl_sellplan (plan_number, plan_code4supplogis, plan_code4sellorder, plan_code4product, plan_wg4sellorder, plan_created)";
                $sqlcmd_openPlan .= " VALUES ('$varpost_planNumber','$varpost_planSuppLogis','$varpost_soNumber[$cntArr]','$varpost_soProduct[$cntArr]','$varpost_wgProduct[$cntArr]', NOW())";
//                echo $sqlcmd_openPlan;
//                echo "<br>";
                $sqlres_openPlan = mysqli_query($dbConn, $sqlcmd_openPlan);

                if (!$sqlres_openPlan) {
                    echo "ERROR [" . mysqli_errno($dbConn) . "] [" . mysqli_error($dbConn) . "]";
                }
            }

            echo "<script>alert(\"แก้ไขแผนขนส่งเสร็จแล้ว\")</script>";
            echo "<script>window.location.href=\"./logisSellPlan.php\"</script>";
            break;

        case "updatePlanNumberByID":
            updateDB("tbl_sellplan", "id", $varpost_id2Update, 1, "plan_code4sellorder", $varpost_planNumberByID, 2);
            break;

        case "updateProductByID":
            updateDB("tbl_sellplan", "id", $varpost_id2Update, 1, "plan_code4product", $varpost_planProductByID, 2);
            break;

        case "updateWgProductByID":
            updateDB("tbl_sellplan", "id", $varpost_id2Update, 1, "plan_wg4sellorder", $varpost_planWgProductByID, 1);
            break;

        case "deleteFromPlan":
            deleteDB("tbl_sellplan", "id", $varpost_id2delete,1);
            break;
    }
}