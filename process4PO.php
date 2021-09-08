<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_command = filter_input(INPUT_GET, 'command');
$varget_poNumber = filter_input(INPUT_GET, 'poNumber');
$varget_returnpg = filter_input(INPUT_GET, 'returnPage');


if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'toggleStatus':
            // Toggle status for PO Number
            $sqlcmd = "SELECT DISTINCT(wg_ponum), po_status FROM tbl_wg4buy WHERE wg_ponum='" . $varget_poNumber . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                $sqlfet = mysqli_fetch_assoc($sqlres);
                $status2toggle = $sqlfet['po_status'];
            }

            if ($status2toggle == 0)
                $stt = 1;
            else
                $stt = 0;

            $sqlcmd = "UPDATE tbl_wg4buy SET po_status=" . $stt . " WHERE wg_ponum='" . $varget_poNumber . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);

            if ($varget_returnpg == 'poList.php')
                header('location:' . $varget_returnpg);
            else
                header('location:' . $varget_returnpg . '?poNumber=' . $varget_poNumber);
            break;

        case 'deletePO':
            $sqlcmd = "DELETE FROM tbl_wg4buy WHERE wg_ponum='" . $varget_poNumber . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres)
                header('location:' . $varget_returnpg);
            else
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            break;
    }
}
