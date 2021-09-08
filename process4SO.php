<?php
include_once './lib/apksFunctions.php';
$dbConn = dbConnect();

$varget_command = filter_input(INPUT_GET, 'command');
$varget_soNumber = filter_input(INPUT_GET, 'soNumber');
$varget_returnpg = filter_input(INPUT_GET, 'returnPage');


if (!empty($varget_command)) {
    switch ($varget_command) {
        case 'toggleStatus':
            // Toggle status for SO Number
            $sqlcmd = "SELECT DISTINCT(wg_sonum), so_status FROM tbl_wg4sell WHERE wg_sonum='" . $varget_soNumber . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres) {
                $sqlfet = mysqli_fetch_assoc($sqlres);
                $status2toggle = $sqlfet['so_status'];
            }

            if ($status2toggle == 0)
                $stt = 1;
            else
                $stt = 0;

            $sqlcmd = "UPDATE tbl_wg4sell SET so_status=" . $stt . " WHERE wg_sonum='" . $varget_soNumber . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);

            if ($varget_returnpg == 'soList.php')
                header('location:' . $varget_returnpg);
            else
                header('location:' . $varget_returnpg . '?soNumber=' . $varget_soNumber);
            break;

        case 'deletePO':
            $sqlcmd = "DELETE FROM tbl_wg4sell WHERE wg_sonum='" . $varget_soNumber . "'";
            $sqlres = mysqli_query($dbConn, $sqlcmd);
            if ($sqlres)
                header('location:' . $varget_returnpg);
            else
                echo "ERROR !!! [" . mysqli_errno($dbConn) . "]--[" . mysqli_error($dbConn) . "]";
            break;
    }
}
