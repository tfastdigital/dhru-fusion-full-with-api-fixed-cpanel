<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if ($save_token != sha1(session_id() . $_SESSION["adminid"] . ":SaveMe123122sds2")) {
    exit("error:invalid token");
}
if ($DEMOMODE) {
    echo "error: This function not enabled in demo mode .";
    exit;
}
if (!$wid) {
    echo "error: Warehouse required compulsory";
    exit;
}
if ($stock || $serial || $from && $to) {
    if ($from && $to) {
        if ($from < $to) {
            $stock = 0;
            while ($from <= $to) {
                if (!mysqli_num_rows(dquery("select id from tbl_serial_list \nwhere serial='" . $from . "' and status=0 and pid!='" . $pid . "'"))) {
                    $stock++;
                    $data["serial"] = trim($from);
                    $data["pid"] = $pid;
                    $data["status"] = 0;
                    $data["aid"] = $_SESSION["adminid"];
                    $data["date"] = date("Y-m-d");
                    $db->insert("tbl_serial_list", $data);
                    $data = NULL;
                    $from++;
                }
            }
        } else {
            echo "error: Wrong range for serial number ";
        }
    }
    if ($serial) {
        $stock = 0;
        $scode = explode("\n", $serial);
        foreach ($scode as $s) {
            $s = trim($s);
            if (!mysqli_num_rows(dquery("select id from tbl_serial_list \nwhere serial='" . $s . "' and status=0 and pid!='" . $pid . "'"))) {
                $to = $qnt;
                for ($j = 1; $j <= $to; $j++) {
                    if (trim($s)) {
                        $stock++;
                        $data["serial"] = trim($s);
                        $data["pid"] = $pid;
                        $data["wid"] = $wid;
                        $data["status"] = 0;
                        $data["aid"] = $_SESSION["adminid"];
                        $data["date"] = date("Y-m-d");
                        $db->insert("tbl_serial_list", $data);
                        $data = NULL;
                    }
                }
            }
        }
    }
    if ($stock) {
        $data["qnt"] = $stock;
        $data["wid"] = $wid;
        $data["pid"] = $pid;
        $data["date"] = $date;
        $data["time"] = time();
        $data["sid"] = $sid;
        $data["note"] = $note;
        $data["bill_date"] = $bill_date;
        $data["bill_no"] = $bill_no;
        $data["status"] = "IN";
        $data["aid"] = $_SESSION["adminid"];
        if ($db->insert("tbl_stock_history", $data)) {
            $ins["wid"] = $wid;
            $ins["pid"] = $pid;
            $ins["stockin"] = $stock;
            $db->insert("tbl_warehousestock", $ins);
            dquery("update tbl_products set stock=stock+" . $stock . " \n            where id='" . $pid . "'");
            echo "success:  " . $LNG["savesuccessfully"] . " ";
        } else {
            echo "error: " . $LNG["datanotsave"] . " ";
        }
    }
    if ($stock == 0) {
        echo "error: Serial number already exist";
    }
    $data = NULL;
} else {
    echo "error: " . $LNG["fieldblank"];
}

?>