<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function getTicket($status)
{
    global $config;
    global $db;
    $ticket = "";
    $sql = dquery("select * from tbl_support_tickets  WHERE sid='" . $status . "' group by tid");
    while ($row = mysqli_fetch_assoc($sql)) {
        $ticket[$row["id"]] = $row;
        if ($row["uid"]) {
            $user = mysqli_fetch_assoc(dquery("select * from tblUsers where id='" . $row["uid"] . "'"));
            $ticket[$row["id"]]["user"] = $user;
        }
        $depart = mysqli_fetch_assoc(dquery("select department from tbl_support_department where id='" . $row["did"] . "'"));
        $ticket[$row["id"]]["department"] = $depart["department"];
        $priority = mysqli_fetch_assoc(dquery("select priority,color from tbl_support_priority where id='" . $row["pid"] . "'"));
        $ticket[$row["id"]]["priority"] = "<span style='color:" . $priority["color"] . "'>" . $priority["priority"] . "</span>";
    }
    return $ticket;
}
function ticket($tid = "", $uid = "", $aid = "", $name = "", $email = "", $did, $pid, $ticket, $import = false)
{
    global $config;
    global $db;
    global $remote_ip;
    global $storeowner;
    require_once ROOTDIR . "/includes/mail.fun.php";
    $data["ip"] = $remote_ip;
    $data["lastreply"] = time();
    $data["date"] = date("Y-m-d H:i:s");
    $removeSmartTags = ["{php}", "{/php}", "{include", "|", "{include_php", "{insert", "{ldelim}", "{rdelim}", "{literal}", "{/literal}", "<?", "?>", "<?php", "php?>", "script>", "\"", "'", "{assign", "{counter", "{debug", "{eval", "{fetch", "{html_image", "{counter", "{cycle", "{mailto", "{math", "{popup", "{textformat", ""];
    $ticket["subject"] = str_replace($removeSmartTags, "", $ticket["subject"]);
    $ticket["message"] = str_replace($removeSmartTags, "", $ticket["message"]);
    $data["subject"] = nl2br($ticket["subject"]);
    $data["message"] = AutoHyperlinks(nl2br($ticket["message"]));
    if ($import) {
        $msg = explode("====================REPLY ABOVE THIS LINE====================", $data["message"]);
        if ($msg[0]) {
            $data["message"] = $msg[0];
        }
    }
    $data["import"] = $import;
    if ($tid) {
        $tck = mysqli_fetch_assoc(dquery("select admin_read from tbl_support_tickets\n        where tid='" . $tid . "' and order by id asc limit 1"));
        if ($aid) {
            $data["admin_read"] = $tck["admin_read"];
            $data["aid"] = $aid;
            $data["tid"] = $tid;
            $data["uid"] = $uid;
            $data["did"] = $did;
            $data["pid"] = $pid;
            $data["sid"] = 3;
            $id = $db->insert("tbl_support_tickets", $data);
            dquery("UPDATE tbl_support_tickets \n            SET sid='3' WHERE tid='" . $tid . "'");
            $mail_ver["viewticketlink"] = _url("viewticket/tid/" . md5($tid) . "/access/" . md5($id . $tid), true);
            $mail_ver["ticketsubject"] = "[#" . $tid . "] " . $ticket["subject"];
            $mail_ver["ticketid"] = $tid;
            $mail_ver["subject"] = $ticket["subject"];
            $admin = mysqli_fetch_assoc(dquery("select signature from tbl_admin where id='" . $aid . "'"));
            $mail_ver["staffsignature"] = $admin["signature"];
            $mail_ver["ticketreply"] = $data["message"];
            if ($uid) {
                sendMail(58, $uid, $did, $mail_ver, true, "", "", "", "", "", true, $mail_ver["ticketsubject"]);
            } else {
                $mail_ver["username"] = $name;
                sendMail(58, "", $did, $mail_ver, "", "", "", "", [["to" => $email, "firstname" => $name]], "", "", $mail_ver["ticketsubject"]);
            }
            $data = NULL;
        } else {
            $data["admin_read"] = $tck["admin_read"];
            $data["uid"] = $uid;
            $data["name"] = $name;
            $data["email"] = $email;
            $data["tid"] = $tid;
            $data["did"] = $did;
            $data["pid"] = $pid;
            $data["sid"] = 4;
            $id = $db->insert("tbl_support_tickets", $data);
            $data = NULL;
            dquery("UPDATE tbl_support_tickets SET sid='4' WHERE tid='" . $tid . "'");
            $sql = mysqli_fetch_assoc(dquery("select * from tbl_support_department where id='" . $did . "'"));
            $dt = date("d-m-Y H:i:s");
            $admin = dquery("select support_department,id,email from tbl_admin");
            while ($row = mysqli_fetch_assoc($admin)) {
                $arr = explode(",", $row["support_department"]);
                if (in_array($did, $arr)) {
                    $send[] = trim($row["email"]);
                }
            }
            $is = mysqli_fetch_assoc(dquery("select id,uid from tbl_support_tickets\n            where tid='" . $tid . "'"));
            $adminmessage = "Ticket #" . $tid . "  updated \r\n Ticket ID: " . $tid . " \r\n Department :" . $sql["department"] . " \r\n " . $dt . "\n            \r\n User ID : " . $is["uid"];
            $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("support.open&id=&edit='" . $is["id"] . "'") . "&title=" . base64_encode("View Ticket") . "'>here</a>";
            $adminmessage .= "<br /><br /> To view ticket details click " . $here;
            sendNotification("notforall", "Customer Replied ticket", nl2br($adminmessage), $send);
        }
    } else {
        if ($email) {
            $sql = mysqli_fetch_assoc(dquery("select id from tblUsers where email='" . $email . "'"));
            $uid = $sql["id"];
            unset($sql);
        }
        if ($uid) {
            $data["aid"] = $aid;
            $data["uid"] = $uid;
            $sql = mysqli_fetch_assoc(dquery("select first_name,last_name from tblUsers where id='" . $uid . "'"));
            $name = $sql["first_name"] . " " . $sql["last_name"];
            $data["did"] = $did;
            $data["pid"] = $pid;
            $data["sid"] = 1;
            $id = $db->insert("tbl_support_tickets", $data);
            $data = NULL;
        } else {
            $sql = dquery("select * from tbl_support_department where id='" . $did . "' AND login='1'");
            if (mysqli_num_rows($sql)) {
                logActivity("#" . $tid . " Ticket open failed : Reason-Login Required for this Department : Suspect-" . $name . " [" . $email . "]");
                return false;
            }
            $data["name"] = $name;
            $data["email"] = $email;
            $data["did"] = $did;
            $data["pid"] = $pid;
            $data["sid"] = 1;
            $id = $db->insert("tbl_support_tickets", $data);
            $data = NULL;
        }
        $rid = createtid(5 - strlen($id));
        $data["tid"] = $rid . $id;
        $tid = $data["tid"];
        $db->update("tbl_support_tickets", $data, "id='" . $id . "'");
        $data = NULL;
        $dt = date("d-m-Y H:i:s");
        $sql = mysqli_fetch_assoc(dquery("select * from tbl_support_department where id='" . $did . "'"));
        $admin = dquery("select support_department,id,email from tbl_admin");
        while ($row = mysqli_fetch_assoc($admin)) {
            $arr = explode(",", $row["support_department"]);
            if (in_array($did, $arr)) {
                $send[] = trim($row["email"]);
            }
        }
        $here = "<a href='" . $config["site_address"] . "/" . $config["admin_directory"] . "/main.php?pageurl=" . base64_encode("support.open&id=&edit='" . $id . "'") . "&title=" . base64_encode("View Ticket") . "'>here</a>";
        $adminmessage = "New ticket open by  " . $name . " \r\n Ticket ID: " . $tid . " \r\n \n        Subject : " . $ticket["subject"] . " \r\n\n        User ID : " . $uid . " \r\n  \n        Department :" . $sql["department"] . " \r\n " . $dt . " <br /> <br />\n        Click " . $here . " to view ticket details";
        sendNotification("notforall", "New ticket open", nl2br($adminmessage), $send);
        $mail_ver["subject"] = $ticket["subject"];
        $mail_ver["ticketid"] = $tid;
        $mail_ver["viewticketlink"] = _url("viewticket/tid/" . md5($tid) . "/access/" . md5($id . $tid), true);
        $mail_ver["ticketsubject"] = "[#" . $tid . "] " . $ticket["subject"];
        if ($uid) {
            sendMail(57, $uid, $did, $mail_ver, true, "", "", "", "", "", true, $mail_ver["ticketsubject"]);
        } else {
            $mail_ver["username"] = $name;
            sendMail(57, "", $did, $mail_ver, "", "", "", "", [["to" => $email, "firstname" => $name]], "", "", $mail_ver["ticketsubject"]);
        }
    }
    return $tid;
}
function AutoHyperlinks($message)
{
    $message = preg_replace("/((http(s?):\\/\\/)|(www\\.))([\\w\\.]+)([a-zA-Z0-9?&%#.;:\\/=+_-]+)/i", "<a href=\"http\$3://\$4\$5\$6\" target=\"_blank\">\$2\$4\$5\$6</a>", $message);
    return $message;
}
function createtid($len)
{
    $seeds = "123456789";
    $seeds_count = strlen($seeds) - 1;
    $i = 0;
    for ($password = ""; $i < $len; $i++) {
        $password .= $seeds[rand(0, $seeds_count)];
    }
    return $password;
}

?>