<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("ADMIN", true);
require "../../comm.php";
require "fun.inc.php";
$action = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $action);
$id = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $id);
if ($_SESSION["adminid"]) {
    if ($ihistory) {
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"IMEI.txt\"");
        echo str_replace("__", "\t\n", $_SESSION["ihistory"]);
        exit;
    }
    if ($exportclient) {
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"Client.csv\"");
        $iresult = dquery("SELECT id,username,phonenumber,email,credit_left \n        from tblUsers where userstatus=0");
        $data = "ID,Username,Phone,Country,Email,Credit Left\n";
        while ($row = mysqli_fetch_assoc($iresult)) {
            $data .= $row["id"] . "," . $row["username"] . "," . $row["contact"] . "," . $row["country"] . "," . $row["email"] . "," . $row["credit_left"] . "\n";
        }
        echo $data;
        exit;
    }
    if ($exportstatement) {
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"Statement.csv\"");
        $iresult = dquery("SELECT id,(select username from tblUsers where id=uid) as user,\n        date,stype,description,\n        amount,balance FROM `tbl_statement_user` WHERE 1");
        $data = "ID,User,Date,Type,Info,Amount,Balance\n";
        while ($row = mysqli_fetch_assoc($iresult)) {
            $data .= $row["id"] . "," . $row["user"] . "," . $row["date"] . "," . $row["stype"] . "," . $row["description"] . "," . $row["amount"] . "," . $row["balance"] . "\n";
        }
        echo $data;
        exit;
    }
    if ($exportcsv) {
        require_once ROOTDIR . "/includes/products.fun.php";
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"stock.csv\"");
        $iresult = dquery("SELECT id,service_name,stock,stock_allow \n        from tbl_products where active=1");
        $data = "";
        while ($row = mysqli_fetch_assoc($iresult)) {
            $stock = getWarehouseStock($wars, $row["id"]);
            $data .= $row["service_name"] . "," . $stock . "\n";
        }
        echo $data;
    }
    if ($export) {
        if (file_exists("../../language/" . $language)) {
            $fh = fopen("../../language/" . $language, "r");
            $data = fread($fh, filesize("../../language/" . $language));
            fclose($fh);
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . $language . "\"");
            echo $data;
        }
        exit;
    }
    if ($exporte) {
        if (file_exists("../language/" . $language)) {
            $fh = fopen("../language/" . $language, "r");
            $data = fread($fh, filesize("../language/" . $language));
            fclose($fh);
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"" . $language . "\"");
            echo $data;
        }
        exit;
    }
    if ($action && $id) {
        switch ($action) {
            case "idverifacation":
                $file = mysqli_fetch_assoc(dquery("select * from tbl_document\n                where id='" . $id . "'"));
                $names = $file["document"];
                if (file_exists("../../" . $donloaddirpath . "/" . $file["document"])) {
                    $fh = fopen("../../" . $donloaddirpath . "/" . $file["document"], "r");
                    $data = fread($fh, filesize("../../" . $donloaddirpath . "/" . $file["document"]));
                    fclose($fh);
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"" . $names . "\"");
                    echo $data;
                } else {
                    echo "Error : File Not Found";
                }
                break;
            case "idstatement":
                $file = mysqli_fetch_assoc(dquery("select * from tbl_document\n                where id='" . $id . "'"));
                $ext = pathinfo($file["statement"], PATHINFO_EXTENSION);
                $names = "Statement." . $ext;
                if (file_exists("../../" . $donloaddirpath . "/" . $file["statement"])) {
                    $fh = fopen("../../" . $donloaddirpath . "/" . $file["statement"], "r");
                    $data = fread($fh, filesize("../../" . $donloaddirpath . "/" . $file["statement"]));
                    fclose($fh);
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"" . $names . "\"");
                    echo $data;
                } else {
                    echo "Error : File Not Found";
                }
                break;
            case "screensht":
                $orderid = md5($id);
                $file = mysqli_fetch_assoc(dquery("select userid,id from tbl_invoices\n                where id='" . $id . "'"));
                $files = md5($id . $file["userid"]);
                $name = end(explode(".", $names));
                if (file_exists("../../" . $donloaddirpath . "/" . $files . "." . $name)) {
                    $fh = fopen("../../" . $donloaddirpath . "/" . $files . "." . $name, "r");
                    $data = fread($fh, filesize("../../" . $donloaddirpath . "/" . $files . "." . $name));
                    fclose($fh);
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"" . $names . "\"");
                    echo $data;
                } else {
                    echo "Error : File Not Found";
                }
                break;
            case "replyfile":
                $orderid = descape($id);
                $sql = mysqli_fetch_assoc(dquery("select `reply`,`reply_enc` from tbl_order_file where md5(order_id)='" . $orderid . "'"));
                if (file_exists("../../" . $donloaddirpath . "/" . $sql["reply_enc"])) {
                    $fh = fopen("../../" . $donloaddirpath . "/" . $sql["reply_enc"], "r");
                    $data = fread($fh, filesize("../../" . $donloaddirpath . "/" . $sql["reply_enc"]));
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
                $sql = mysqli_fetch_assoc(dquery("select `file`,`file_enc`\n                 from tbl_order_file where md5(order_id)='" . $orderid . "' " . $append));
                if (file_exists("../../" . $donloaddirpath . "/" . $sql["file_enc"])) {
                    $fh = fopen("../../" . $donloaddirpath . "/" . $sql["file_enc"], "r");
                    $data = fread($fh, filesize("../../" . $donloaddirpath . "/" . $sql["file_enc"]));
                    fclose($fh);
                    header("Content-type: application/octet-stream");
                    header("Content-Disposition: attachment; filename=\"" . $sql["file"] . "\"");
                    echo $data;
                } else {
                    echo "Error : File Not Found";
                }
                break;
            case "exports":
                $type = preg_replace("/[^0-9]/i", "", $type);
                $from = preg_replace("/[^0-9\\-]/i", "", $from);
                $to = preg_replace("/[^0-9\\-]/i", "", $to);
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
                        $where = " AND md5(service_id)='" . $sid . "'";
                    }
                    $sql = dquery("select date,(select service_name from tbl_services_imei where id=service_id) as service,\n                                                   imei, reply, (credit-discount) as credit,\n                                                   CONCAT(IF(tbl_order_imei.user_can_c='1','Pending',IF(tbl_order_imei.user_can_c='3','Rejected',IF(tbl_order_imei.user_can_c='4','Available','New')))) AS status,\n                                                   CONCAT(IF(model_id='','',(SELECT Name FROM tbl_model_brand where tbl_model_brand.ID=model_id)),' ',\n                                                    IF(provider_id='','',(SELECT Name FROM tbl_provider where tbl_provider.ID=provider_id)),' ',\n                                                    IF(PIN='','',PIN),' ',\n                                                    IF(KBH='','',KBH),' ',\n                                                    IF(PRD='','',PRD),' ',\n                                                    IF(Type='','',Type),' ',\n                                                    IF(Reference='','',Reference)\n                                                    ) as field \n                        from tbl_order_imei where user_id='" . $_SESSION["uid"] . "' " . $where);
                    $buf .= "Date,Service,Status,IMEI,Code,Credit,Fields\n";
                    while ($row = mysqli_fetch_assoc($sql)) {
                        $buf .= $row["date"] . "," . $row["service"] . "," . $row["status"] . "," . $row["imei"] . "," . $row["reply"] . "," . $row["credit"] . "," . $row["field"] . "\n";
                    }
                } else {
                    if ($type == 2) {
                        $sid = descape($file);
                        $sid = preg_replace("/[^0-9a-zA-Z]/i", "", $sid);
                        if ($sid != "") {
                            $where = " AND md5(service_id)='" . $sid . "'";
                        }
                        $sql = dquery("select date,(select service_name from tbl_services_file where id=service_id) as service,\n                                               file, reply, (credit-discount) as credit,\n                                               CONCAT(IF(tbl_order_file.user_can_c='1','Pending',IF(tbl_order_file.user_can_c='3','Rejected',IF(tbl_order_file.user_can_c='4','Available','New')))) AS status\n                                                \n                                     from tbl_order_file where user_id='" . $_SESSION["uid"] . "' " . $where);
                        $buf .= "Date,Service,Status,File,Reply,Credit\n";
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $buf .= $row["date"] . "," . $row["service"] . "," . $row["status"] . "," . $row["file"] . "," . $row["reply"] . "," . $row["credit"] . "\n";
                        }
                    } else {
                        if ($type == 3) {
                            $sid = descape($server);
                            $sid = preg_replace("/[^0-9a-zA-Z]/i", "", $sid);
                            if ($sid != "") {
                                $where = " AND md5(service_id)='" . $sid . "'";
                            }
                            $sql = dquery("select date,(select service_name from tbl_server_log where id=service_id) as service,\n                                               server, reply, (credit-discount) as credit,\n                                               CONCAT(IF(tbl_order_server.user_can_c='1','Pending',IF(tbl_order_server.user_can_c='3','Rejected',IF(tbl_order_server.user_can_c='4','Available','New')))) AS status\n                                               from tbl_order_server where user_id='" . $_SESSION["uid"] . "' " . $where);
                            $buf .= "Date,Service,Status,Server,Reply,Credit\n";
                            while ($row = mysqli_fetch_assoc($sql)) {
                                $buf .= $row["date"] . "," . $row["service"] . "," . $row["status"] . "," . $row["server"] . "," . $row["reply"] . "," . $row["credit"] . "\n";
                            }
                        }
                    }
                }
                header("Content-type: application/octet-stream");
                header("Content-Disposition: attachment; filename=\"my-data.csv\"");
                echo $buf;
                break;
            case "invoice":
                exit;
                break;
        }
    } else {
        header("Location: index.php");
    }
}

?>