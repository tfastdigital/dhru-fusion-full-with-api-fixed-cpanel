<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
require ROOTDIR . "/includes/fun.inc.php";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$file = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $file);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
$invid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $invid);
if ($action == "downloads" && $type == "file") {
    $id = descape($id);
    $sql = mysqli_fetch_assoc(dquery("select * from tbl_download where md5(id)='" . $id . "'"));
    if (isset($_SESSION["uid"])) {
        $log["username"] = $_SESSION["username"];
    }
    dquery("insert into tbl_download_log (username,ip,time,did)\n    values ('" . $_SESSION["username"] . "','" . $_SERVER["REMOTE_ADDR"] . "','" . $time . "','" . $sql["id"] . "')");
    $log = NULL;
    if ($sql["reqlogin"] && !$_SESSION["uid"]) {
        $_SESSION["afterloginredirect"] = "download.php?action=downloads&type=file&id=" . $id;
        header("Location: login.php");
    }
    if ($sql["forproduct"]) {
        $invid = descape($invid);
        $inv = mysqli_fetch_assoc(dquery("select status from tbl_invoices where md5(id)='" . $invid . "'"));
        if ($inv["status"] != "Paid") {
            header("Location: index.php");
        }
    }
    echo $donloaddirpath . "/" . $sql["file"];
    if (file_exists($donloaddirpath . "/" . $sql["file"])) {
        dquery("update tbl_download set counter=counter+1 where md5(id)='" . $id . "'");
        $fh = fopen($donloaddirpath . "/" . $sql["file"], "r");
        $data = fread($fh, filesize($donloaddirpath . "/" . $sql["file"]));
        fclose($fh);
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"" . $sql["filename"] . "\"");
        echo $data;
    } else {
        echo "Error : File Not Found";
    }
} else {
    if ($_SESSION["uid"] || $_SESSION["adminid"]) {
        if ($action && $id) {
            if (!$_SESSION["adminid"]) {
                $append = " AND `user_id`=" . $_SESSION["uid"];
            } else {
                $append = "";
            }
            switch ($action) {
                case "replyfile":
                    $orderid = descape($id);
                    $sql = mysqli_fetch_assoc(dquery("select `reply`,`reply_enc` from tbl_order_file where md5(order_id)='" . $orderid . "' " . $append));
                    if (file_exists($donloaddirpath . "/" . $sql["reply_enc"])) {
                        $fh = fopen($donloaddirpath . "/" . $sql["reply_enc"], "r");
                        $data = fread($fh, filesize($donloaddirpath . "/" . $sql["reply_enc"]));
                        fclose($fh);
                        header("Content-type: application/octet-stream");
                        header("Content-Disposition: attachment; filename=\"" . $sql["reply"] . "\"");
                        echo $data;
                    } else {
                        echo "Error : File Not Found";
                    }
                    break;
                case "requestfile":
                    $orderid = descape($id);
                    $sql = mysqli_fetch_assoc(dquery("select `file`,`file_enc` from tbl_order_file where md5(order_id)='" . $orderid . "' " . $append));
                    if (file_exists($donloaddirpath . "/" . $sql["file_enc"])) {
                        $fh = fopen($donloaddirpath . "/" . $sql["file_enc"], "r");
                        $data = fread($fh, filesize($donloaddirpath . "/" . $sql["file_enc"]));
                        fclose($fh);
                        header("Content-type: application/octet-stream");
                        header("Content-Disposition: attachment; filename=\"" . $sql["file"] . "\"");
                        echo $data;
                    } else {
                        echo "Error : File Not Found";
                    }
                    break;
                case "exportstatement":
                    $query = "SELECT * FROM\n                        `tbl_statement_user` WHERE `uid`='" . $_SESSION["uid"] . "' ORDER BY `id`";
                    $result = dquery($query);
                    $buf = "Date,Description,Type,Amount,RID,Details\n";
                    while ($row = mysqli_fetch_assoc($result)) {
                        $details = "";
                        if ($row["stype"] == "imei") {
                            $s = mysqli_fetch_assoc(dquery("select imei ,encnum,\n                        (SELECT service_name from tbl_services_imei where id=service_id) as service \n                        from tbl_order_imei where order_id='" . $row["relid"] . "'"));
                            if ($s["encnum"]) {
                                $row["relid"] = $s["encnum"];
                            }
                            $details .= $s["service"] . " - " . $s["imei"];
                        }
                        if ($row["stype"] == "file") {
                            $s = mysqli_fetch_assoc(dquery("select file ,\n\t                        (SELECT service_name from tbl_services_file where id=service_id) as service \n\t                        from tbl_order_file where order_id='" . $row["relid"] . "'"));
                            $details .= $s["service"] . " - " . $s["file"];
                        }
                        if ($row["stype"] == "server") {
                            $s = mysqli_fetch_assoc(dquery("select server ,\n                        (SELECT service_name from tbl_server_log where id=service_id) as service \n                        from tbl_order_server where order_id='" . $row["relid"] . "'"));
                            $details .= $s["service"] . " - " . $s["server"];
                        }
                        if ($row["stype"] == "Product") {
                            $s = mysqli_fetch_assoc(dquery("select \n                            (SELECT service_name from tbl_products where id=service_id) as service \n                            from tbl_order_product where order_id='" . $row["relid"] . "'"));
                            $details .= (string) $s["service"];
                        }
                        $buf .= $row["date"] . "," . $row["description"] . "," . $row["type"] . "," . $row["amount"] . "," . $row["relid"] . "," . $details . "\n";
                    }
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"my-statement.csv\"");
                    echo $buf;
                    break;
                case "exportfilter":
                    $buf = "";
                    $oids = implode(",", $orderid);
                    $sql = dquery("select date,(select service_name from tbl_services_imei where id=service_id) as service,\n                            imei, reply, (credit-discount) as credit,\n                            CONCAT(IF(tbl_order_imei.user_can_c='1','Pending',IF(tbl_order_imei.user_can_c='3','Rejected',IF(tbl_order_imei.user_can_c='4','Available','New')))) AS status,\n                            CONCAT(IF(model_id='','',(SELECT Name FROM tbl_model_brand where tbl_model_brand.ID=model_id)),' ',\n                            IF(provider_id='','',(SELECT Name FROM tbl_provider where tbl_provider.ID=provider_id)),' ',\n                            IF(PIN='','',PIN),' ',\n                            IF(KBH='','',KBH),' ',\n                            IF(PRD='','',PRD),' ',\n                            IF(Type='','',Type),' ',\n                            IF(Reference='','',Reference) ) as field \n                        \tfrom tbl_order_imei where user_id='" . $_SESSION["uid"] . "'  and `server`=0 and order_id in (" . $oids . ")");
                    $buf .= "Date,Service,Status,IMEI,Code,Credit,Fields\n";
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $row["service"] = str_replace(",", "_", $row["service"]);
                        $row["reply"] = str_replace(",", "_", $row["reply"]);
                        $buf .= $row["date"] . "," . $row["service"] . "," . $row["status"] . ",=\"" . $row["imei"] . "\",=\"" . $row["reply"] . "\"," . $row["credit"] . "," . $row["field"] . "\n";
                    }
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"my-data.csv\"");
                    echo $buf;
                    exit;
                    break;
                case "exports":
                    if ($type) {
                        $type = preg_replace("/[^0-9]/i", "", $type);
                        $from = preg_replace("/[^0-9\\-\\/]/i", "", $from);
                        $to = preg_replace("/[^0-9\\-\\/]/i", "", $to);
                        if (!stripos($from, "-") !== false && $from) {
                            $from = date("Y-m-d", strtotime($from));
                            $to = date("Y-m-d", strtotime($to));
                        }
                        $where = "";
                        if ($status != "") {
                            if ($status == 0) {
                                $where .= " AND ( user_can_c='0' or user_can_c='1' )";
                            } else {
                                $where .= " AND user_can_c='" . $status . "'";
                            }
                        }
                        if ($from != "" && $to != "") {
                            $where .= " AND ( date between '" . $from . "' and '" . $to . "' )";
                        }
                        if ($type == 1) {
                            $sid = descape($imei);
                            $sid = preg_replace("/[^0-9a-zA-Z]/i", "", $sid);
                            if ($sid != "") {
                                $where .= " AND md5(service_id)='" . $sid . "'";
                            }
                            $sql = dquery("select date,(select service_name from tbl_services_imei where id=service_id) as service,\n                            imei, reply, (credit-discount) as credit,\n                            CONCAT(IF(tbl_order_imei.user_can_c='1','Pending',IF(tbl_order_imei.user_can_c='3','Rejected',IF(tbl_order_imei.user_can_c='4','Available','New')))) AS status,\n                            CONCAT(IF(model_id='','',(SELECT Name FROM tbl_model_brand where tbl_model_brand.ID=model_id)),' ',\n                            IF(provider_id='','',(SELECT Name FROM tbl_provider where tbl_provider.ID=provider_id)),' ',\n                            IF(PIN='','',PIN),' ',\n                            IF(KBH='','',KBH),' ',\n                            IF(PRD='','',PRD),' ',\n                            IF(Type='','',Type),' ',\n                            IF(Reference='','',Reference) ) as field \n                        \tfrom tbl_order_imei where user_id='" . $_SESSION["uid"] . "' " . $where . " and `server`=0");
                            if ($from && $to) {
                                $buf .= $from . " - " . $to . ",,,,,,\n";
                            }
                            $buf .= "Date,Service,Status,IMEI,Code,Credit,Fields\n";
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $row["service"] = str_replace(",", "_", $row["service"]);
                                $row["reply"] = str_replace(",", "_", $row["reply"]);
                                $buf .= $row["date"] . "," . $row["service"] . "," . $row["status"] . ",=\"" . $row["imei"] . "\",=\"" . $row["reply"] . "\"," . $row["credit"] . "," . $row["field"] . "\n";
                            }
                        } else {
                            if ($type == 2) {
                                $sid = descape($file);
                                $sid = preg_replace("/[^0-9a-zA-Z]/i", "", $sid);
                                if ($sid != "") {
                                    $where .= " AND md5(service_id)='" . $sid . "'";
                                }
                                $sql = dquery("select date,(select service_name from tbl_services_file where id=service_id) as service,\n                                    file, reply, (credit-discount) as credit,\n                                    CONCAT(IF(tbl_order_file.user_can_c='1','Pending',IF(tbl_order_file.user_can_c='3','Rejected',IF(tbl_order_file.user_can_c='4','Available','New')))) AS status\n                                    from tbl_order_file where user_id='" . $_SESSION["uid"] . "' " . $where);
                                $buf .= "Date,Service,Status,File,Reply,Credit\n";
                                while ($row = mysqli_fetch_assoc($sql)) {
                                    $row["service"] = str_replace(",", "_", $row["service"]);
                                    $row["reply"] = str_replace(",", "_", $row["reply"]);
                                    $buf .= $row["date"] . "," . $row["service"] . "," . $row["status"] . "," . $row["file"] . "," . $row["reply"] . "," . $row["credit"] . "\n";
                                }
                            } else {
                                if ($type == 3) {
                                    $sid = descape($server);
                                    $sid = preg_replace("/[^0-9a-zA-Z]/i", "", $sid);
                                    if ($sid != "") {
                                        $where .= " AND md5(service_id)='" . $sid . "'";
                                    }
                                    $sql = dquery("select date,(select service_name from tbl_services_imei where id=service_id) as service,\n                                               server, reply, (credit-discount) as credit,\n                                               CONCAT(IF(tbl_order_imei.user_can_c='1','Pending',IF(tbl_order_imei.user_can_c='3','Rejected',IF(tbl_order_imei.user_can_c='4','Available','New')))) AS status\n                                               from tbl_order_imei where user_id='" . $_SESSION["uid"] . "' " . $where . " and `server`=1");
                                    $buf .= "Date,Service,Status,Server,Reply,Credit\n";
                                    while ($row = mysqli_fetch_assoc($sql)) {
                                        $row["service"] = str_replace(",", "_", $row["service"]);
                                        $row["reply"] = str_replace(",", "_", $row["reply"]);
                                        $buf .= $row["date"] . "," . $row["service"] . "," . $row["status"] . "," . $row["server"] . "," . $row["reply"] . "," . $row["credit"] . "\n";
                                    }
                                }
                            }
                        }
                        header("Content-type: application/octet-stream");
                        header("Content-Disposition: attachment; filename=\"my-data.csv\"");
                        echo $buf;
                        exit;
                    }
                    echo "                            <script>history.back();</script>\n                        ";
                    exit;
                    break;
                case "invoice":
                    exit;
                    break;
            }
        } else {
            header("Location: index.php");
        }
    }
}
chkMd5sumsubpage();

?>