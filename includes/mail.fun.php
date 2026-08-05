<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function sendMail($mailtemplateId, $userid = "", $relId = "", $email_merge_fields = "", $updateclientdetails = false, $attachmentfilename = "", $attachmentdata = "", $supplierid = "", $toemailsnew = [], $body = "", $history = true, $subject = "", $ReplyTo = "", $sendnow = "", $preview = false, $typeoverwrite = "", $lang = "", $backup = false, $mailserv = "")
{
    global $config;
    global $emaildebug;
    global $storeowner;
    global $templatecompilerpath;
    if ($mailtemplateId == 999999) {
        return true;
    }
    if ($mailtemplateId == 73) {
        $history = false;
    }
    $Table = "tbl_emailtemplates";
    if ($backup) {
        $Table = "tbl_emailtemplates_backup";
    }
    $toemails = [];
    if ($toemailsnew != "") {
        $toemails = $toemailsnew;
    }
    if ($userid) {
        $q = mysqli_fetch_assoc(dquery("select guest from tblUsers where id='" . $userid . "'"));
        if ($q["guest"] && $mailtemplateId != 14 && $mailtemplateId != 31 && $mailtemplateId != 6 && $mailtemplateId != 9) {
            dquery("DELETE FROM tbl_sheduledmail WHERE id='" . $sendnow . "'");
            return false;
        }
    }
    if (!$sendnow) {
        if (!$userid && $mailtemplateId != 82) {
            $userid = $_SESSION["uid"];
        }
        if (!$storeowner["id"]) {
            $config = [];
            $result = mysqli_fetch_assoc(select_query("tbl_settings", "", ["attribute" => "config"]));
            $config = unserialize($result["value"]);
            $config["config_template_c"] = $templatecompilerpath;
        }
        global $_ClientsDetails;
        if (!$_ClientsDetails) {
            if (!function_exists("getClientDetails")) {
                include_once ROOTDIR . "/includes/clients.fun.inc.php";
            }
            $ClientsDetails = getClientsDetails($userid);
        }
        if ($updateclientdetails) {
            if (!function_exists("getClientDetails")) {
                include_once ROOTDIR . "/includes/clients.fun.inc.php";
            }
            $ClientsDetails = getClientsDetails($userid);
            if ($ClientsDetails["language"] != "English") {
                $lang = $ClientsDetails["language"];
            }
        }
        if ($supplierid) {
            $sql = mysqli_fetch_assoc(dquery("SELECT `email`,`first_name`,`last_name` FROM `tbl_supplier` WHERE `id`='" . $supplierid . "'"));
            if (is_array($toemails)) {
                array_push($toemails, ["to" => $sql["email"], "firstname" => $sql["first_name"], "lastname" => $sql["last_name"]]);
            } else {
                $toemails[] = ["to" => $sql["email"], "firstname" => $sql["first_name"], "lastname" => $sql["last_name"]];
            }
        }
        if (!$ClientsDetails["email"] && count($toemails) == 0) {
            return false;
        }
        if ($ClientsDetails["closeac"] == 1) {
            return false;
        }
        if ($lang) {
            $result = select_query($Table, "", ["id" => $mailtemplateId]);
            $data = mysqli_fetch_assoc($result);
            $rq = select_query("tbl_emailtemplate_language", "", ["template_id" => $mailtemplateId, "language" => $lang]);
            $res = mysqli_fetch_assoc($rq);
            if ($res["subject"]) {
                $data["subject"] = $res["subject"];
                $data["message"] = $res["message"];
            }
        } else {
            $result = select_query($Table, "", ["id" => $mailtemplateId]);
            $data = mysqli_fetch_assoc($result);
        }
        $type = $data["type"];
        if ($typeoverwrite) {
            $type = $typeoverwrite;
        }
        if (!$subject) {
            $subject = $data["subject"];
        }
        $message = $data["message"];
        $fromname = $data["fromname"];
        $fromemail = $data["fromemail"];
        $disabled = $data["disabled"];
        $copyto = $data["copyto"];
        $plaintext = $data["plaintext"];
        $scheduled = $data["scheduled"];
        $mailserv = $data["mailserv"];
        $layoutid = $data["layoutid"];
        if (trim($fromemail) && !filter_var($fromemail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        if ($layoutid) {
            $layout = mysqli_fetch_assoc(dquery("select * from tbl_email_layout where id='" . $layoutid . "'"));
            $message = html_entity_decode($layout["header"]) . $message . html_entity_decode($layout["footer"]);
        }
        if (defined("MASSMAIL")) {
            $mssi = mysqli_fetch_assoc(dquery("select id from tbl_massmail order by id desc"));
            $mssi = md5($mssi["id"]);
            $message = "<div style='text-align:center;'><a href='" . $config["site_address"] . "viewemail.php?i=" . $mssi . "'>Problem viewing this email? View it in your browser.</a></div>" . $message;
        }
        if (!$mailtemplateId || $mailtemplateId == 1000) {
            $scheduled = 1;
        }
        if ($ClientsDetails["language"] != "English") {
        }
        $result = select_query("tbl_emailtemplates_reseller", "", ["template_id " => $mailtemplateId, "uid" => $userid, "flag" => 1]);
        $data1 = mysqli_fetch_assoc($result);
        if ($data1["id"]) {
            $subject = str_replace("[", "{", $data1["subject"]);
            $subject = str_replace("]", "}", $subject);
            $message = str_replace("[", "{", $data1["message"]);
            $message = str_replace("]", "}", $message);
            $plaintext = $data1["plaintext"];
        }
        if ($ClientsDetails["usertype"] == 3 || $ClientsDetails["reseller_id"] || $ClientsDetails["storeownerid"]) {
            $result = select_query("tbl_emailtemplates_reseller", "", ["template_id" => $mailtemplateId, "uid" => $ClientsDetails["reseller_id"]]);
            $data1 = mysqli_fetch_assoc($result);
            if ($data1) {
                $removeSmartTags = ["{php}", "{/php}", "{include", "|", "{include_php", "{insert", "{ldelim}", "{rdelim}", "{literal}", "{/literal}", "<?", "?>", "<?php", "php?>", "script>", "?", "\"", "'", "{assign", "{counter", "{debug", "{eval", "{fetch", "{html_image", "{counter", "{cycle", "{mailto", "{math", "{popup", "{textformat", ""];
                $subject = str_replace($removeSmartTags, "", $data1["subject"]);
                $message = str_replace($removeSmartTags, "", $data1["message"]);
                $subject = str_replace("[", "{", $subject);
                $subject = str_replace("]", "}", $subject);
                $message = str_replace("[", "{", $message);
                $message = str_replace("]", "}", $message);
                $fromname = $data1["fromname"];
                $fromemail = $data1["fromemail"];
                $plaintext = $data1["plaintext"];
            }
            if (trim($fromemail) && !filter_var($fromemail, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            if ($ClientsDetails["reseller_id"] || $ClientsDetails["storeownerid"]) {
                $_sid = $ClientsDetails["reseller_id"] ? $ClientsDetails["reseller_id"] : $ClientsDetails["storeownerid"];
                $result = select_query("tbl_store_config", "", ["uid" => $_sid]);
                while ($data = mysqli_fetch_assoc($result)) {
                    $config["" . $data["attribute"]] = "" . $data["value"];
                }
            }
        }
        if ($userid && !$disabled && ($mailtemplateId == 14 || $mailtemplateId == 6 || $mailtemplateId == 16 || $mailtemplateId == 44 || $mailtemplateId == 17 || $mailtemplateId == 45 || $mailtemplateId == 49 || $mailtemplateId == 50)) {
            $ds = mysqli_num_rows(dquery("select id from tbl_disabledemail where uid='" . $userid . "' and tid='" . $mailtemplateId . "'"));
            if ($ds) {
                return false;
            }
        }
        if ($disabled) {
            return false;
        }
        if ($type == "imeiorder" || $type == "serverorder" || $type == "remoteorder") {
            $orderdtl = mysqli_fetch_assoc(dquery("SELECT *,(select service_name from tbl_services_imei\r\n            where id=service_id)  as service FROM `tbl_order_imei` WHERE `order_id`='" . $relId . "'"));
        }
        if ($type == "fileorder") {
            $orderdtl = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_order_file` WHERE `order_id`='" . $relId . "'"));
        }
        if ($type == "serverorder") {
        }
        if ($type == "supportticket") {
            $dept = mysqli_fetch_assoc(dquery("select email,department from tbl_support_department where id='" . $relId . "'"));
            $fromemail = $dept["email"];
            $fromname = $dept["department"];
        }
        if ($fromname == "") {
            $fromname = $config["config_admin_name"];
        }
        if ($fromemail == "") {
            $fromemail = $config["config_admin_mail"];
        }
        if (trim($fromemail) && !filter_var($fromemail, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        include_once ROOTDIR . "/includes/smarty/SmartyBC.class.php";
        $smarty = new SmartyBC();
        $smarty->caching = 0;
        $cache_id = md5($_SERVER["REQUEST_URI"]);
        $smarty->compile_dir = ROOTDIR . "/" . $templatecompilerpath;
        $smarty->compile_id = md5($subject . $message);
        $smarty->assign("emailsubject", trim($subject));
        $smarty->assign("emailmessage", $message);
        if ($ClientsDetails) {
            foreach ($ClientsDetails as $mergefield => $mergevalue) {
                $smarty->assign($mergefield, $mergevalue);
            }
        }
        if (is_array($email_merge_fields)) {
            foreach ($email_merge_fields as $mergefield => $mergevalue) {
                $smarty->assign($mergefield, $mergevalue);
            }
        }
        $enc = md5($ClientsDetails["id"]) . "-" . md5($data["id"]);
        $smarty->assign("enc", $enc);
        $priority = 0;
        if ($type == "serverorderOLD") {
            $priority = 1;
            $smarty->assign("orderid", $orderdtl["order_id"]);
            $smarty->assign("notes", $orderdtl["note"]);
            $smarty->assign("comments", $orderdtl["comments"]);
            $creditdtl = NULL;
            $creditdtl = $orderdtl["credit"] - $orderdtl["discount"];
            $smarty->assign("ordercredit", $creditdtl);
            if (!$email_merge_fields["custom"]) {
                include_once ROOTDIR . "/includes/customfield.fun.inc.php";
                $customs = getCustomFields("serviceserver", $orderdtl["service_id"], $orderdtl["order_id"], "on");
                $smarty->assign("custom", $customs);
            } else {
                $smarty->assign("custom", $email_merge_fields["custom"]);
            }
        }
        if ($type == "fileorder") {
            $priority = 1;
            $smarty->assign("orderid", $orderdtl["order_id"]);
            $smarty->assign("requestedfile", $orderdtl["file"]);
            $smarty->assign("notes", $orderdtl["note"]);
            $smarty->assign("orderdatetime", date("d-m-Y H:i:s", $orderdtl["time"]));
            $smarty->assign("comments", $orderdtl["comments"]);
            $creditdtl = NULL;
            $creditdtl = $orderdtl["credit"] - $orderdtl["discount"];
            $smarty->assign("ordercredit", $creditdtl);
            include_once ROOTDIR . "/includes/customfield.fun.inc.php";
            $customs = getCustomFields("servicefile", $orderdtl["service_id"], $orderdtl["order_id"], "on");
            $smarty->assign("custom", $customs);
        }
        if ($type == "imeiorder" || $type == "serverorder" || $type == "remoteorder") {
            $priority = 1;
            if ($config["encryptedorderid"]) {
                $smarty->assign("orderid", $orderdtl["encnum"] ? $orderdtl["encnum"] : $orderdtl["order_id"]);
            } else {
                $smarty->assign("orderid", $orderdtl["order_id"]);
            }
            $smarty->assign("imei", $orderdtl["imei"]);
            $smarty->assign("reply", $orderdtl["reply"]);
            $smarty->assign("orderdatetime", date("d-m-Y H:i:s", $orderdtl["time"]));
            $smarty->assign("replydatetime", date("d-m-Y H:i:s", $orderdtl["reply_time"]));
            if ($orderdtl["ORDERAPI"] && $orderdtl["ORDERAPI_ID"]) {
            }
            $smarty->assign("qnt", $orderdtl["qnt"]);
            $smarty->assign("service", $orderdtl["service"]);
            $smarty->assign("notes", $orderdtl["note"]);
            $smarty->assign("comments", $orderdtl["comments"]);
            $creditdtl = $orderdtl["credit"] - $orderdtl["discount"];
            $smarty->assign("ordercredit", $creditdtl);
            $smarty->assign("pin", $orderdtl["PIN"]);
            $smarty->assign("kbh", $orderdtl["KBH"]);
            $smarty->assign("prd", $orderdtl["PRD"]);
            $smarty->assign("type", $orderdtl["Type"]);
            $smarty->assign("reference", $orderdtl["Reference"]);
            $smarty->assign("locks", $orderdtl["Locks"]);
            $smarty->assign("SN", $orderdtl["SN"]);
            $smarty->assign("SecRO", $orderdtl["SecRO"]);
            $models = mysqli_fetch_assoc(dquery("SELECT `Name` FROM tbl_mobile WHERE ID='" . $orderdtl["model_id"] . "'"));
            $smarty->assign("model", $models["Name"]);
            $models = mysqli_fetch_assoc(dquery("SELECT `Name` FROM tbl_provider WHERE ID='" . $orderdtl["provider_id"] . "'"));
            $smarty->assign("provider", $models["Name"]);
            $models = mysqli_fetch_assoc(dquery("SELECT mep FROM tbl_mep WHERE ID='" . $orderdtl["mep"] . "'"));
            $smarty->assign("mep", $models["mep"]);
            if (!$email_merge_fields["custom"]) {
                include_once ROOTDIR . "/includes/customfield.fun.inc.php";
                $customs = getCustomFields("serviceimei", $orderdtl["service_id"], $orderdtl["order_id"], "on");
                $smarty->assign("custom", $customs);
            } else {
                $smarty->assign("custom", $email_merge_fields["custom"]);
            }
        }
        if ($ClientsDetails) {
            $smarty->assign("balance", $ClientsDetails["credit"]["credit"]);
        }
        $smarty->assign("companyname", $config["companyname"]);
        $SiteAddress = $config["site_address"];
        if ($config["config_ssl_allow"]) {
            $SiteAddress = $config["config_ssl_allow"];
        }
        $Unique = md5($ClientsDetails["id"] . $ClientsDetails["email"]);
        $smarty->assign("unsubscribepref", _url("main/unsubpref/" . $Unique, true));
        $smarty->assign("adminsignature", $config["adminsignature"]);
        $smarty->assign("adminmail", $config["config_admin_mail"]);
        $smarty->assign("siteaddress", $config["site_address"]);
        $smarty->assign("twitter", $config["twitter"]);
        $smarty->assign("facebook", $config["facebook_link"]);
        $smarty->assign("linkedln", $config["linkedln"]);
        $subject = $smarty->fetch("string:" . $subject);
        $message = $smarty->fetch("string:" . $message);
        if ($preview) {
            return $message;
        }
        if ($config["mail_sending_type"] == 1 && $scheduled == 1) {
            if ($orderdtl["response_email"] != "") {
                $response_email = trim($response_email);
            }
            insert_query("tbl_sheduledmail", ["userid" => $userid, "subject" => $subject, "message" => $message, "fromname" => $fromname, "fromemail" => $fromemail, "attachname" => serialize($attachmentfilename), "attachment" => base64_encode(serialize($attachmentdata)), "priority" => $priority, "to" => serialize($toemails), "cc" => serialize($copyto), "replyto" => $ReplyTo, "response_email" => $response_email, "plaintext" => $plaintext, "history" => $history ? $history : $config["mail_history"], "mailserv" => $mailserv]);
            return true;
        }
    } else {
        $result = select_query($Table, "", ["id" => $mailtemplateId]);
        $data = mysqli_fetch_assoc($result);
        if ($data["disabled"]) {
            return false;
        }
        global $_ClientsDetails;
        if (!$_ClientsDetails && $userid) {
            if (!function_exists("getClientDetails")) {
                include_once ROOTDIR . "/includes/clients.fun.inc.php";
            }
            $ClientsDetails = getClientsDetails($userid);
            if ($ClientsDetails["language"] != "English") {
                $rq = select_query("tbl_emailtemplate_language", "", ["template_id" => $mailtemplateId, "language" => $ClientsDetails["language"]]);
                $rdata = mysqli_fetch_assoc($rq);
                if ($rdata["subject"]) {
                    $data["subject"] = $rdata["subject"];
                    $data["message"] = $rdata["message"];
                }
            }
        }
        $clientid = $ClientsDetails["id"];
        if ($ClientsDetails["unsubscribe"]) {
        }
        $type = $data["type"];
        $orderdtl = "";
        if ($type == "imeiorder") {
            $mailtype = "imeiorder";
            $orderdtl = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_order_imei` WHERE `order_id`='" . $relId . "'"));
        }
        if ($type == "imeiorderbulk") {
            $mailtype = "imeiorder";
        }
        if ($type == "fileorder") {
            $mailtype = "fileorder";
            $orderdtl = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_order_file` WHERE `order_id`='" . $relId . "'"));
        }
        if ($type == "serverorder") {
            $mailtype = "serverorder";
            $orderdtl = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_order_imei` WHERE `order_id`='" . $relId . "'"));
        }
        if ($type == "remoteorder") {
            $mailtype = "remoteorder";
        }
        if ($type == "shoporder") {
            $mailtype = "shoporder";
        }
        if ($data["name"] == "Price update notification") {
            $mailtype = "priceupdate";
        }
        if ($mailtype && mysqli_num_rows(dquery("select id from tbl_disabledemail where uid='" . $clientid . "' and mailtype='" . $mailtype . "'"))) {
            return false;
        }
        $shdl = mysqli_fetch_assoc(dquery("select * from tbl_sheduledmail \r\n        where id='" . $sendnow . "'"));
        dquery("DELETE FROM tbl_sheduledmail WHERE id='" . $sendnow . "'");
        $body = $shdl["message"];
        $fromemail = $shdl["fromemail"];
        $fromname = $shdl["fromname"];
        $ReplyTo = $shdl["replyto"];
        $toemails = unserialize($shdl["to"]);
        $orderdtl["response_email"] = $shdl["response_email"];
        $copyto = unserialize($shdl["cc"]);
        $subject = $shdl["subject"];
        $plaintext = html_entity_decode($shdl["plaintext"]);
        $attachmentfilename = unserialize($shdl["attachname"]);
        $attachmentdata = unserialize(base64_decode($shdl["attachment"]));
        $mailserv = $shdl["mailserv"];
        $response_email = $shdl["response_email"];
        $history = $shdl["history"];
        if (!$toemails) {
            if (!function_exists("getClientDetails")) {
                include_once ROOTDIR . "/includes/clients.fun.inc.php";
            }
            $ClientsDetails = getClientsDetails($shdl["userid"]);
        }
    }
    if ($body) {
        $message .= "\t\n \t\n" . $body;
    }
    if (is_file("Mail.php")) {
        //require_once "Mail.php";
    } else {
        include_once ROOTDIR . "/includes/phpmailer.class.php";
    }
    if ($plaintext) {
        $message = str_replace("<br>", "", $message);
        $message = str_replace("<p>", "", $message);
        $message = str_replace("</p>", "", $message);
        $message = str_replace("<br />", "", $message);
        $message = str_replace("<br />", "", $message);
        $message = strip_tags($message);
        if (!strpos($message, "unsubpref")) {
            $message .= "\n \n  \n  \n If you no longer wish to receive these emails, you can unsubscribe with this link : " . _url("main/unsubpref/" . $Unique, true);
        }
    } else {
        if (!strpos($message, "unsubpref")) {
            $message .= "<br /> <br /> <br /> <br /> <small>If you no longer wish to receive these emails, you can <a href='" . _url("main/unsubpref/" . $Unique) . "'>unsubscribe.</a></small>";
        }
    }
    if ($mailserv) {
        $config["mail_type"] = $config["mail_type" . $mailserv];
        $config["smtp_host"] = $config["smtp_host" . $mailserv];
        $config["smtp_port"] = $config["smtp_port" . $mailserv];
        $config["smtp_enc"] = $config["smtp_enc" . $mailserv];
        $config["smtp_username"] = $config["smtp_username" . $mailserv];
        $config["smtp_password"] = $config["smtp_password" . $mailserv];
    }
   
    if ($config["mail_type"] == "sendgrid") {
        $mail->Mailer = "aggregator";
        if ($ClientsDetails["email"] && $mailtemplateId != 82 && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($ClientsDetails["email"]))) {
            $toemails[]["to"] = trim($ClientsDetails["email"]);
        }
        if ($orderdtl["response_email"] != "" && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($orderdtl["response_email"]))) {
            $toemails[]["to"] = trim($orderdtl["response_email"]);
        }
        $Json = [];
        foreach ($toemails as $mail) {
            $Json["personalizations"][0]["to"][]["email"] = $mail["to"];
        }
        $Json["from"]["email"] = $fromemail;
        $Json["subject"] = $subject;
        if ($mailtemplateId == 7878787) {
            $plaintext = 0;
        }
        if ($plaintext) {
            $Json["content"][0]["value"] = $message;
            $Json["content"][0]["type"] = "text/plain";
        } else {
            $Json["content"][0]["value"] = $message;
            $Json["content"][0]["type"] = "text/html";
        }
        $CURLheaders["HEADER"] = ["Authorization: Bearer " . $config["aggregatorapi"], "Content-Type: application/json"];
        $OUT = initCurl("https://api.sendgrid.com/v3/mail/send", "", $CURLheaders, "", $Json);
        if ($OUT) {
            logActivity("SendGrid Error Log: " . $OUT);
        }
        if ($userid && $config["mail_history"] && $history) {
            insert_query("tbl_email_history", ["userid" => $userid, "subject" => $subject, "message" => $message, "date" => "now()", "to" => $email, "cc" => $copyto, "bcc" => $config["BCC_Messages"]]);
        }
        logActivity("Email Sent to " . $ClientsDetails["username"] . " " . $ClientsDetails["email"] . "#" . $userid . "(" . $subject . ")");
        return true;
    } else {
        if ($config["mail_type"] == "mailgun") {
            $mail->Mailer = "aggregator";
            if ($ClientsDetails["email"] && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($ClientsDetails["email"]))) {
                $toemails[]["to"] = trim($ClientsDetails["email"]);
            }
            if ($orderdtl["response_email"] != "" && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($orderdtl["response_email"]))) {
                $toemails[]["to"] = trim($orderdtl["response_email"]);
            }
            foreach ($toemails as $mail) {
                $buff .= $mail["to"] . ",";
            }
            $Field["to"] = trim($buff, ",");
            $Field["from"] = $fromname . "<" . $fromemail . ">";
            $Field["fromname"] = $fromname;
            $Field["subject"] = $subject;
            if ($mailtemplateId == 7878787) {
                $plaintext = 0;
            }
            if ($plaintext) {
                $Field["text"] = $message;
            } else {
                $Field["html"] = $message;
            }
            $Field["apikey"] = $config["aggregatorapi"];
            $OUT = initCurl("https://api.mailgun.net/v3/" . $config["mailgundomain"] . "/messages", $Field, "", $config["aggregatorapi"]);
            $OUT = json_decode($OUT, true);
            logActivity(json_encode($OUT));
            if ($OUT["id"]) {
                if ($userid && $config["mail_history"] && $history) {
                    insert_query("tbl_email_history", ["userid" => $userid, "subject" => $subject, "message" => $message, "date" => "now()", "to" => $email, "cc" => $copyto, "bcc" => $config["BCC_Messages"]]);
                }
                logActivity("Email Sent to " . $ClientsDetails["username"] . " " . $ClientsDetails["email"] . "#" . $userid . "(" . $subject . ")");
                return true;
            }
            logActivity("Email Sending Failed 2 - " . $ClientsDetails["username"] . $OUT["msg"] . " (User ID: " . $userid . " - Subject: " . $subject . ")");
            return false;
        } else {
            if ($config["mail_type"] == "aggregator") {
                $mail->Mailer = "aggregator";
                if ($ClientsDetails["email"] && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($ClientsDetails["email"]))) {
                    $toemails[]["to"] = trim($ClientsDetails["email"]);
                }
                if ($orderdtl["response_email"] != "" && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($orderdtl["response_email"]))) {
                    $toemails[]["to"] = trim($orderdtl["response_email"]);
                }
                foreach ($toemails as $mail) {
                    $buff .= $mail["to"];
                }
                $Field["toemails"] = json_encode($toemails);
                $Field["from"] = $fromemail;
                $Field["fromname"] = $fromname;
                $Field["subject"] = $subject;
                $Field["message"] = $message;
                $Field["html"] = $plaintext;
                $Field["apikey"] = $config["aggregatorapi"];
                $OUT = initCurl($config["aggregatorlink"], $Field);
                $OUT = json_decode($OUT, true);
                if ($OUT["status"] == "success") {
                    if ($userid && $config["mail_history"] && $history) {
                        insert_query("tbl_email_history", ["userid" => $userid, "subject" => $subject, "message" => $message, "date" => "now()", "to" => $email, "cc" => $copyto, "bcc" => $config["BCC_Messages"]]);
                    }
                    logActivity("Email Sent to " . $ClientsDetails["username"] . " " . $ClientsDetails["email"] . "#" . $userid . "(" . $subject . ")");
                    return true;
                }
                logActivity("Email Sending Failed - " . $ClientsDetails["username"] . $OUT["msg"] . " (User ID: " . $userid . " - Subject: " . $subject . ")");
                return false;
            } else {
                $mail = new PHPMailer();
                if ($config["mail_type"] == "mail") {
                    $mail->Mailer = "mail";
                } else {
                    if ($config["mail_type"] == "smtp") {
                        $mail->IsSMTP();
                        $mail->Host = $config["smtp_host"];
                        $mail->Port = $config["smtp_port"];
                        $mail->Hostname = $_SERVER["SERVER_NAME"];
                        if ($config["smtp_enc"]) {
                            $mail->SMTPSecure = "ssl";
                        }
                        if ($config["smtp_username"]) {
                            $mail->SMTPAuth = true;
                            $mail->Username = $config["smtp_username"];
                            $mail->Password = $config["smtp_password"];
                        }
                        $mail->Sender = $mail->From;
                    }
                }
                $mail->CharSet = $config["charset"];
                if ($config["BCC_Messages"] != "") {
                    $bcc = $config["BCC_Messages"] . ",";
                    $bcc = explode(",", $bcc);
                    foreach ($bcc as $value) {
                        if ($value != "" && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($value))) {
                            $mail->AddBCC($value);
                        }
                    }
                }
               
                if ($ClientsDetails["email"] && count($toemails) == 0 && $mailtemplateId != 82 && preg_match("/([\\w\\-]+\\@[\\w\\-]+\\.[\\w\\-]+)/", trim($ClientsDetails["email"]))) {
                    $toemails[]["to"] = trim($ClientsDetails["email"]);
                }
                if (count($toemails) == 0) {
                    return false;
                }
                
             
                $additionalccs = "";
              
                if ($mailtemplateId == 7878787) {
                    $plaintext = 0;
                    $message = html_entity_decode($message);
                }
                $mail->Subject = html_entity_decode($subject);
                if ($plaintext) {
                    $mail->Body = html_entity_decode($message);
                } else {
                    $message_text = str_replace("<p>", "", $message);
                    $message_text = str_replace("</p>", "", $message_text);
                    $message_text = str_replace("<br>", "", $message_text);
                    $message_text = str_replace("<br />", "", $message_text);
                    $message_text = strip_tags($message_text);
                    $mail->Body = $message;
                    $mail->AltBody = $message_text;
                }
                if ($attachmentfilename) {
                    if (is_array($attachmentfilename)) {
                        $count = 0;
                        foreach ($attachmentfilename as $filelist) {
                            $mail->AddStringAttachment($attachmentdata[$count], $filelist);
                            $count++;
                        }
                    } else {
                        $mail->AddStringAttachment($attachmentdata, $attachmentfilename);
                    }
                }
                global $smtp_debug;
                global $email_debug;
                global $smtpdebug;
                if ($smtpdebug || $smtp_debug || $email_debug) {
                    $mail->SMTPDebug = true;
                }
                if ($emaildebug) {
                    echo "Email: " . $email . "<br>Subject: " . $subject . "<br>Message: " . $message . "<br>Attachment: " . $attachmentfilename . "<br><br>";
                    return false;
                }
                try {
                    $mail->Send();
                    if ($userid && $config["mail_history"] && $history) {
                        insert_query("tbl_email_history", ["userid" => $userid, "subject" => $subject, "message" => $message, "date" => "now()", "to" => $email, "cc" => $copyto, "bcc" => $config["BCC_Messages"]]);
                    }
                    logActivity("Email Sent to " . $ClientsDetails["username"] . " " . $ClientsDetails["email"] . ($userid ? "#" . $userid : "") . "  (" . $subject . ")");
                    $mail->ClearAddresses();
                } catch (phpmailerException $e) {
                    logActivity("Email Sending Failed - " . $ClientsDetails["username"] . $e->getMessage() . " (User ID: " . $userid . " - Subject: " . $subject . ")");
                    return false;
                } catch (exception $e) {
                    logActivity("Email Sending Failed - " . $e->getMessage() . " (User ID: " . $userid . " - Subject: " . $subject . ")");
                    return false;
                }
                return true;
            }
        }
    }
}
function sendNotification($to = "system", $subject, $adminmessage, $mailto, $adminnotificaionfromname = "", $attachmentfilename = "", $attachmentdata = "", $ReplyTo = "")
{
    global $config;
    global $smtpdebug;
    global $storeowner;
    if (!$adminmessage) {
        return false;
    }
    $message .= "<font style=\"font-family:Verdana;font-size:11px\"><p>" . $adminmessage . "</p>";
    if (is_file("Mail.php")) {
        require_once "Mail.php";
    } else {
        include_once ROOTDIR . "/includes/phpmailer.class.php";
    }
    $toemails = [];
    $mail = new PHPMailer();
    $mail->From = $config["config_admin_mail"];
    if (trim($adminnotificaionfromname)) {
        $mail->FromName = $adminnotificaionfromname;
    } else {
        $mail->FromName = "[FUSION]";
    }
    $mail->Subject = $subject;
    $mail->CharSet = $config["charset"];
    if ($config["mail_type"] == "sendgrid") {
        $mail->Mailer = "SendGrid";
        if ($to == "system" || $to == "account" || $to == "support") {
            $_result = dquery("SELECT tbl_admin.email,tbl_admin.firstname,tbl_admin.lastname\r\n            FROM tbl_admin ,tbl_admin_access_group\r\n            WHERE tbl_admin.group_id = tbl_admin_access_group.id\r\n            AND tbl_admin_access_group." . $to . " = '1'");
            while ($data = mysqli_fetch_assoc($_result)) {
                if ($data["email"]) {
                    $toemails[]["to"] = $data["email"];
                    $emailcount++;
                }
            }
        }
        if ($mailto) {
            foreach ($mailto as $othertomail) {
                $toemails[]["to"] = trim($othertomail);
                $emailcount++;
            }
        }
        $Json = [];
        foreach ($toemails as $mail) {
            $Json["personalizations"][0]["to"][]["email"] = $mail["to"];
        }
        if (!$fromemail) {
            $fromemail = $config["config_admin_mail"];
        }
        $Json["from"]["email"] = $fromemail;
        $Json["subject"] = $subject;
        if ($plaintext) {
            $Json["content"][0]["value"] = $message;
            $Json["content"][0]["type"] = "text/plain";
        } else {
            $Json["content"][0]["value"] = $message;
            $Json["content"][0]["type"] = "text/html";
        }
        $CURLheaders["HEADER"] = ["Authorization: Bearer " . $config["aggregatorapi"], "Content-Type: application/json"];
        $OUT = initCurl("https://api.sendgrid.com/v3/mail/send", "", $CURLheaders, $config["aggregatorapi"], $Json);
        logActivity("from" . $OUT);
        return true;
    } else {
        if ($config["mail_type"] == "mailgun") {
            $mail->Mailer = "mailgun";
            if ($to == "system" || $to == "account" || $to == "support") {
                $_result = dquery("SELECT tbl_admin.email,tbl_admin.firstname,tbl_admin.lastname\r\n            FROM tbl_admin ,tbl_admin_access_group\r\n            WHERE tbl_admin.group_id = tbl_admin_access_group.id\r\n            AND tbl_admin_access_group." . $to . " = '1'");
                while ($data = mysqli_fetch_assoc($_result)) {
                    if ($data["email"]) {
                        $toemails[]["to"] = $data["email"];
                        $emailcount++;
                    }
                }
            }
            if ($mailto) {
                foreach ($mailto as $othertomail) {
                    $toemails[]["to"] = trim($othertomail);
                    $emailcount++;
                }
            }
            foreach ($toemails as $e) {
                $buff .= $e . ",";
            }
            $Field["to"] = trim($buff, ",");
            $Field["from"] = $fromname . "<" . $fromemail . ">";
            $Field["fromname"] = $fromname;
            $Field["subject"] = $subject;
            if ($plaintext) {
                $Field["text"] = $message;
            } else {
                $Field["html"] = $message;
            }
            $Field["apikey"] = $config["aggregatorapi"];
            $OUT = initCurl("https://api.mailgun.net/v3/" . $config["mailgundomain"] . "/messages", $Field, "", $config["aggregatorapi"]);
            $OUT = json_decode($OUT, true);
            if ($OUT["id"]) {
                logActivity("Admin Email Notification Sending Failed - " . $OUT["msg"] . " (Subject: " . $subject . ")");
                return false;
            }
            return true;
        } else {
            if ($config["mail_type"] == "aggregator") {
                $mail->Mailer = "aggregator";
                if ($to == "system" || $to == "account" || $to == "support") {
                    $_result = dquery("SELECT tbl_admin.email,tbl_admin.firstname,tbl_admin.lastname\r\n            FROM tbl_admin ,tbl_admin_access_group\r\n            WHERE tbl_admin.group_id = tbl_admin_access_group.id\r\n            AND tbl_admin_access_group." . $to . " = '1'");
                    while ($data = mysqli_fetch_assoc($_result)) {
                        if ($data["email"]) {
                            $toemails[]["to"] = $data["email"];
                            $emailcount++;
                        }
                    }
                }
                if ($mailto) {
                    foreach ($mailto as $othertomail) {
                        $toemails[]["to"] = trim($othertomail);
                        $emailcount++;
                    }
                }
                $Field["toemails"] = json_encode($toemails);
                $Field["from"] = $config["config_admin_mail"];
                $Field["fromname"] = "[FUSION]";
                $Field["subject"] = $subject;
                $Field["message"] = $message;
                $Field["apikey"] = $config["aggregatorapi"];
                $OUT = initCurl($config["aggregatorlink"], $Field);
                $OUT = json_decode($OUT, true);
                if ($OUT["status"] != "success") {
                    logActivity("Admin Email Notification Sending Failed - " . $OUT["msg"] . " (Subject: " . $subject . ")");
                    return false;
                }
                return true;
            } else {
                if ($config["mail_type"] == "mail") {
                    $mail->Mailer = "mail";
                } else {
                    if ($config["mail_type"] == "smtp") {
                        $mail->IsSMTP();
                        $mail->Host = $config["smtp_host"];
                        $mail->Port = $config["smtp_port"];
                        $mail->Hostname = $_SERVER["SERVER_NAME"];
                        if ($config["smtp_enc"]) {
                            $mail->SMTPSecure = "ssl";
                        }
                        if ($config["smtp_username"]) {
                            $mail->SMTPAuth = true;
                            $mail->Username = $config["smtp_username"];
                            $mail->Password = $config["smtp_password"];
                        }
                        $mail->Sender = $mail->From;
                    }
                }
                if ($smtp_debug) {
                    $mail->SMTPDebug = true;
                }
                $message_text = str_replace("</p>", "", $message);
                $message_text = str_replace("<br>", "", $message_text);
                $message_text = str_replace("<br />", "", $message_text);
                if ($storeowner["id"]) {
                    $message = strip_tags($message, "<br>");
                }
                $message_text = strip_tags($message_text);
                $mail->Body = $message;
                $mail->AltBody = $message_text;
                if ($attachmentfilename) {
                    if (is_array($attachmentfilename)) {
                        $count = 0;
                        foreach ($attachmentfilename as $filelist) {
                            $mail->AddStringAttachment($attachmentdata[$count], $filelist);
                            $count++;
                        }
                    } else {
                        $mail->AddStringAttachment($attachmentdata, $attachmentfilename);
                    }
                }
                $emailcount = 0;
                if ($to == "system" || $to == "account" || $to == "support") {
                    $_result = dquery("SELECT tbl_admin.email,tbl_admin.firstname,tbl_admin.lastname\r\n                    FROM tbl_admin ,tbl_admin_access_group\r\n                    WHERE tbl_admin.group_id = tbl_admin_access_group.id\r\n                    AND tbl_admin_access_group." . $to . " = '1'");
                    while ($data = mysqli_fetch_assoc($_result)) {
                        if ($data["email"]) {
                            $mail->AddAddress($data["email"], $data["firstname"] . " " . $data["lastname"]);
                            $emailcount++;
                        }
                    }
                }
                if ($ReplyTo) {
                    $mail->AddReplyTo($ReplyTo);
                }
                if ($mailto) {
                    foreach ($mailto as $othertomail) {
                        $mail->AddAddress(trim($othertomail));
                        $emailcount++;
                    }
                }
                if (!$emailcount) {
                    return false;
                }
                if (!$mail->Send()) {
                    logActivity("Admin Email Notification Sending Failed - " . $mail->ErrorInfo . " (Subject: " . $subject . ")");
                } else {
                    logActivity("Admin Email Notification Sending Successs - " . $OUT["msg"] . " (Subject: " . $subject . ")");
                }
                $mail->ClearAddresses();
            }
        }
    }
}
function sendAdminNotification($admin = "system", $templateid = 4, $variable)
{
    if ($admin == "system") {
        $sql = dquery("select contact from tbl_admin");
        while ($row = mysqli_fetch_assoc($sql)) {
            sendSMS($row["contact"], $templateid, "", $variable);
        }
    }
}
function sendSMS($to, $templateid, $msg = "", $variable = "", $uid = "")
{
    global $config;
    global $smsgatewayconfig;
    $to = trim($to);
    if (!$smsgatewayconfig) {
        $smsgatewayconfig = [];
        $result = mysqli_fetch_assoc(select_query("tbl_settings", "", ["attribute" => "smsgateway"]));
        $smsgatewayconfig = unserialize($result["value"]);
    }
    if (!$msg) {
        $sql = mysqli_fetch_assoc(dquery("select * from tbl_smstemplate where id='" . $templateid . "'"));
        if ($uid) {
            $usr = mysqli_fetch_assoc(dquery("select language from tblUsers where id='" . $uid . "'"));
            if ($usr["language"] != "English") {
                $lang = mysqli_fetch_assoc(dquery("select message from tbl_smstemplate_language\r\n                 where template_id='" . $templateid . "' AND language='" . $usr["language"] . "'"));
                if ($lang["message"]) {
                    $sql["message"] = $lang["message"];
                }
            }
        }
        if (!$sql["status"]) {
            return "error: Template not enabled";
        }
        $msg = $sql["message"];
        $msg = str_replace("\n", "%0A", $msg);
        $msg1 = str_replace("{\$PASSWORD}", "XXXX", $msg);
        if ($variable) {
            foreach ($variable as $k => $v) {
                $msg = str_replace("{\$" . $k . "}", $v, $msg);
                $msg1 = str_replace("{\$" . $k . "}", $v, $msg1);
            }
        }
    }
    if ($config["smsgateway"] == "clickatell") {
        $sendlink = "https://api.clickatell.com/http/sendmsg?user=" . $smsgatewayconfig["clickatellusername"] . "&password=" . $smsgatewayconfig["clickatellpassword"] . "&api_id=" . $smsgatewayconfig["clickatellapikey"] . "&to=" . $to . "&text=" . str_replace(" ", "+", $msg);
        if ($smsgatewayconfig["senderid"] != "") {
        }
        if ($smsgatewayconfig["forcesenderid"] == 1) {
        }
        if ($smsgatewayconfig["unicode"] == 1) {
        }
        $responce = file_get_contents($sendlink);
        if (stripos($responce, "ID") !== false) {
            $smsid = str_replace("ID: ", "", $responce);
            $return = "success: Message sent Successfull -" . $smsid;
        } else {
            if (stripos($responce, "Cannot route message") !== false) {
                $return = "error:Invalid phone number";
            } else {
                $return = "error:" . $responce;
            }
        }
        $datas = "To : " . $to . " <br> Message : " . $msg1;
        if (mysqli_num_rows(dquery("select * from tbl_smsgatewaylog")) < $config["ActivityLogLimit"]) {
            insert_query("tbl_smsgatewaylog", ["date" => "now()", "gateway" => $config["smsgateway"], "data" => $datas, "result" => $responce]);
        }
    } else {
        if ($config["smsgateway"] == "customgateway") {
            $buff = "";
            if ($smsgatewayconfig["customparameter1"] && $smsgatewayconfig["customparameter1value"]) {
                $buff .= "&" . $smsgatewayconfig["customparameter1"] . "=" . $smsgatewayconfig["customparameter1value"];
            }
            if ($smsgatewayconfig["customparameter2"] && $smsgatewayconfig["customparameter2value"]) {
                $buff .= "&" . $smsgatewayconfig["customparameter2"] . "=" . $smsgatewayconfig["customparameter2value"];
            }
            if ($smsgatewayconfig["customparameter3"] && $smsgatewayconfig["customparameter3value"]) {
                $buff .= "&" . $smsgatewayconfig["customparameter3"] . "=" . $smsgatewayconfig["customparameter3value"];
            }
            if ($smsgatewayconfig["customparameter4"] && $smsgatewayconfig["customparameter4value"]) {
                $buff .= "&" . $smsgatewayconfig["customparameter4"] . "=" . $smsgatewayconfig["customparameter4value"];
            }
            if ($smsgatewayconfig["customparameter5"] && $smsgatewayconfig["customparameter5value"]) {
                $buff .= "&" . $smsgatewayconfig["customparameter5"] . "=" . $smsgatewayconfig["customparameter5value"];
            }
            $sendlink = $smsgatewayconfig["httpgeturl"] . "?" . $smsgatewayconfig["usernameparameter"] . "=" . $smsgatewayconfig["smsgatwayusername"] . "&" . $smsgatewayconfig["passwordparameter"] . "=" . $smsgatewayconfig["smsgatwaypassword"] . $buff . "&" . $smsgatewayconfig["toparameter"] . "=" . $smsgatewayconfig["addbeforenumber"] . $to . "&" . $smsgatewayconfig["textparameter"] . "=" . str_replace(" ", "+", $msg);
            if ($smsgatewayconfig["senderid"] != "") {
                $sendlink .= "&from=" . $smsgatewayconfig["senderid"];
            }
            if ($smsgatewayconfig["forcesenderid"] == 1) {
                $sendlink .= "&req_feat=32";
            }
            if ($smsgatewayconfig["unicode"] == 1) {
                $sendlink .= "&unicode=1";
            }
            $POSTFIELDS = [];
            if ($smsgatewayconfig["customparameter5"] == "Bearer") {
                $POSTFIELDS["HEADER"][] = "Content-Type: application/json";
                $POSTFIELDS["HEADER"][] = "Accept: application/json";
                $POSTFIELDS["HEADER"][] = "Authorization: Bearer " . $smsgatewayconfig["customparameter5value"];
            }
            $responce = initCurl($sendlink, "", $POSTFIELDS);
            $return = "success: " . $responce;
            $datas = "To : " . $to . " <br> Message : " . $msg;
            if (mysqli_num_rows(dquery("select * from tbl_smsgatewaylog")) < $config["ActivityLogLimit"]) {
                insert_query("tbl_smsgatewaylog", ["date" => "now()", "gateway" => $config["smsgateway"], "data" => $datas, "result" => $responce]);
            }
        }
    }
    return $return;
}
function emailtpl_template($tpl_name, &$tpl_source, &$smarty_obj)
{
    $tpl_source = $smarty_obj->get_template_vars($tpl_name);
    return empty($tpl_source) ? false : true;
}
function emailtpl_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj)
{
    return true;
}
function emailtpl_secure($tpl_name, &$smarty_obj)
{
    return true;
}
function emailtpl_trusted($tpl_name, &$smarty_obj)
{
}

?>