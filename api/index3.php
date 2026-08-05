<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("API", true);
require "../comm.php";
unset($lng_languag);
$StatusArray = [];
$emoticons = "⏳";
$StatusArray[0] = json_decode("\"" . $emoticons . "\"");
$emoticons = "⏳";
$StatusArray[1] = json_decode("\"" . $emoticons . "\"");
$emoticons = "❌";
$StatusArray[3] = json_decode("\"" . $emoticons . "\"");
$emoticons = "✅";
$StatusArray[4] = json_decode("\"" . $emoticons . "\"");
$emoticons = "👥";
$StatusArray["user"] = json_decode("\"" . $emoticons . "\"");
$icon["user"] = json_decode("\"👤\"");
$icon["plus"] = json_decode("\"➕\"");
$icon["orders"] = json_decode("\"📦\"");
$icon["calendar"] = json_decode("\"📅\"");
$icon["back"] = json_decode("\"⬅\"");
$icon["next"] = json_decode("\"➡\"");
$icon["pin"] = json_decode("\"📌\"");
global $keyboard;
global $User;
global $HelpNotes;
if ($telegramtoken) {
    if (!cidr_match($remote_ip, ["91.108.4.0/22", "149.154.160.0/20"]) && !cidr_match($_SERVER["REMOTE_ADDR"], ["91.108.4.0/22", "149.154.160.0/20"])) {
        exit("Unauthorized access");
    }
    if ($telegramtoken == md5($config["slacktokenuser"])) {
        $inputJSON = json_decode(file_get_contents("php://input"), true);
        file_put_contents("JSON/_REQ_" . time() . ".json", json_encode($inputJSON));
        if ($inputJSON["callback_query"]) {
            $chat_instance = (int) $inputJSON["callback_query"]["chat_instance"];
            $callback_query_id = (int) $inputJSON["callback_query"]["id"];
            $userid = (int) $inputJSON["callback_query"]["from"]["id"];
            $telegramlanguage = $inputJSON["callback_query"]["from"]["language_code"];
            $message = $inputJSON["callback_query"]["data"];
            $message_id = (int) $inputJSON["callback_query"]["message"]["message_id"];
            $inline_keyboard_req = $inputJSON["callback_query"]["message"]["reply_markup"]["inline_keyboard"];
            $message_req = $inputJSON["callback_query"]["message"]["text"];
            $message_json = json_decode($message, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if ($message_json["action"]) {
                    $message = $message_json["action"];
                }
                $id = $message_json["id"];
                $info = $message_json["info"];
            }
        } else {
            $message = $inputJSON["message"]["text"];
            $userid = (int) $inputJSON["message"]["from"]["id"];
            $contact = $inputJSON["message"]["contact"];
            $telegramusername = $inputJSON["message"]["from"]["username"];
            $telegramlanguage = $inputJSON["message"]["from"]["language_code"];
        }
        $message = urldecode($message);
        loadLanguage($telegramlanguage, $userid);
        if ($message == "Cancel Registration") {
            unlink("chat/reg_" . md5($userid) . ".json");
            sendtelegram($lng_languag["startagain"], $userid, $keyboard["pairaccount"]);
            exit;
        }
        if (($contact["phone_number"] && $contact["first_name"] || is_file("chat/reg_" . md5($userid) . ".json")) && $config["allowtelegramreg"]) {
            if (is_file("chat/reg_" . md5($userid) . ".json")) {
                $contact = json_decode(file_get_contents("chat/reg_" . md5($userid) . ".json"), true);
                if (!$contact["email"]) {
                    if (filter_var($message, FILTER_VALIDATE_EMAIL)) {
                        $contact["email"] = $message;
                        if (!mysqli_num_rows(dquery("select id from tblUsers where email='" . $contact["email"] . "'"))) {
                            $Username = $contact["username"];
                            while (mysqli_num_rows(dquery("select id form tblUsers where username='" . $Username))) {
                                $Username .= rand(1, 99);
                            }
                            require_once ROOTDIR . "/includes/clients.fun.inc.php";
                            $validator["username"][0] = $Username;
                            $validator["email"][0] = $contact["email"];
                            $validator["first_name"][0] = $contact["first_name"];
                            $validator["last_name"][0] = $contact["last_name"];
                            $validator["currency"][0] = $_SESSION["system_default_currency"]["id"];
                            $validator["messengerid"][0] = $userid;
                            $validator["language"][0] = $config["language"];
                            $validator["userstatus"][0] = 0;
                            $validator["note"][0] = "Registred from Telegram";
                            $UID = addNewUser($validator, true, "", 1, "", "", $emailid = "", "quick");
                            sendtelegram($lng_languag["welcome"] . " <b>" . $contact[first_name] . " " . $contact[last_name] . "</b> - " . $lng_languag["registrationsucessful"] . "\n" . $HelpNotes, $userid, $keyboard["home"]);
                            unlink("chat/reg_" . md5($userid) . ".json");
                            exit;
                        }
                        sendtelegram($lng_languag["accountexists"] . "\n" . $lng_languag["or"] . "\n" . $lng_languag["givemeemail"], $userid, $keyboard["cancelregistration"]);
                        exit;
                    }
                    sendtelegram($lng_languag["invalidemail"] . "\n" . $lng_languag["letmeknowvalidemail"], $userid, $keyboard["cancelregistration"]);
                }
                exit;
            }
            $contact["username"] = $telegramusername;
            file_put_contents("chat/reg_" . md5($userid) . ".json", json_encode($contact));
            sendtelegram($lng_languag["welcome"] . " " . $contact["first_name"] . " \n" . $lng_languag["provideemail"], $userid, $keyboard["cancelregistration"]);
            exit;
        }
        if ($message == $lng_languag["cancelorder"]) {
            removeChat($userid);
            sendtelegram($lng_languag["startagain"], $userid, $keyboard["home"]);
        }
        if ($message == "/start" || contains($message, $lng_languag["pairaccount"])) {
            if (contains($message, $lng_languag["pairaccount"])) {
                sendtelegram($lng_languag["welcome"] . "  <b>" . $config["companyname"] . "</b>\n" . $lng_languag["logintowebsite"] . " \n\n" . $lng_languag["clicktoconnect"] . "  \n\n" . $lng_languag["getpairingcode"] . "\n" . $lng_languag["scanqrcode"] . "\n", $userid, $keyboard["pairaccount"]);
                exit;
            }
            sendtelegram($lng_languag["welcome"] . "  <b>" . $config["companyname"] . "</b>. " . $lng_languag["whatisparingcode"], $userid, $keyboard["pairaccount"]);
            exit;
        }
        if ($userid) {
            $query = dquery("select * from tblUsers \n                 where messengerid='" . $userid . "' and usertype!=3 and userstatus=0");
            $User = mysqli_fetch_assoc($query);
            $Currency = getCurrency($User["default_currency"]);
            $UserFound = false;
            if ($User["id"]) {
                $UserFound = true;
            }
        }
        if (contains($message, "start")) {
            list($__message) = explode(" ", $message);
            if (isset($__message)) {
                $message = $__message;
            }
        }
        if (!$UserFound) {
            if (is_numeric($message) && strlen($message) == 8) {
                $pairingcode = $message;
                $time = time() - 600;
                $query = dquery("select * from tblUsers \nwhere (tmp_password)='" . $pairingcode . "' and tmp_pass_time>" . $time . "\n            and messengerid='' and usertype!=3");
                if (mysqli_num_rows($query)) {
                    $User = mysqli_fetch_assoc($query);
                    dquery("update tblUsers set messengerid='" . $userid . "'\n                where id='" . $User["id"] . "' and usertype!=3");
                    sendtelegram($lng_languag["welcome"] . " <b>" . $User[first_name] . " " . $User[last_name] . "</b> - " . $lng_languag["pairedsucessfully"] . "\n" . $HelpNotes, $userid, $keyboard["home"]);
                } else {
                    sendtelegram($lng_languag["invalidpairingcode"] . $message, $userid);
                }
                exit;
            }
            sendtelegram($lng_languag["registerorpari"], $userid, $keyboard["pairaccount"]);
            exit;
        }
        if ($User["id"]) {
            if (is_file("chat/" . $userid . ".json")) {
                startChat($userid, $message);
                exit;
            }
            if (!($message == "/start" || contains($message, $lng_languag["pairaccount"]))) {
                if ($message == "/placeimeiorder" || contains($message, $lng_languag["imeiorder"]) || $message == "/placeimeiorder2" || contains($message, $lng_languag["serverorder"])) {
                    $DataS = [];
                    if ($User["data"]) {
                        $DataS = json_decode($User["data"], true);
                    }
                    if (!$DataS["telegramorder"]) {
                        sendtelegram("Place order from telegram is disabled.\nEnable Place order feature from your Profile->Telegram.", $userid, $keyboard["home"]);
                        return true;
                    }
                    $Server = 0;
                    if ($message == "/placeimeiorder2") {
                        $Server = 1;
                        $message = "/placeimeiorder";
                    }
                    if (contains($message, $lng_languag["serverorder"])) {
                        $Server = 1;
                    }
                    $WHERE = "";
                    $ActiveServices = getServicesFromClientGroup($User["client_group"]);
                    $q = dquery("select id,group_name from tbl_imei_group\n            WHERE active=1 and disabletelegram='0' and `server`='" . $Server . "' and id in (\n            select group_id from tbl_services_imei where tbl_services_imei.id in (" . implode(",", $ActiveServices) . ")\n            ) ORDER BY display_order desc limit 100");
                    while ($r = mysqli_fetch_assoc($q)) {
                        $GRoup[0]["text"] = str_replace("]", "", html_entity_decode($r["group_name"]));
                        $GRoup[0]["text"] = str_replace("[", "", html_entity_decode($GRoup[0]["text"]));
                        $GRoup[0]["callback_data"] = cb_data(["id" => $r["id"], "action" => "/selectgroup"]);
                        $_IMEI_groups[] = $GRoup;
                    }
                    sendtelegram($lng_languag["selectgroup"], $userid, "", $_IMEI_groups, $message_id);
                } else {
                    if ($message == "/imeiorders" || contains($message, $lng_languag["imeiorders"])) {
                        $query = dquery("select * from tblUsers \n                 where messengerid='" . $userid . "' and usertype!=3");
                        $User = mysqli_fetch_assoc($query);
                        $i = dquery("select imei,reply,user_can_c from\n                tbl_order_imei where server=0 and user_id='" . $User["id"] . "' order by order_id desc limit 10");
                        $Result = "<b>" . $lng_languag["last10imeiorder"] . "</b>\n\n";
                        while ($r = mysqli_fetch_assoc($i)) {
                            if ($r["user_can_c"] == 0) {
                                $emoticons = "⏳";
                                $Status = json_decode("\"" . $emoticons . "\"");
                            } else {
                                if ($r["user_can_c"] == 1) {
                                    $emoticons = "⏳";
                                    $Status = json_decode("\"" . $emoticons . "\"");
                                } else {
                                    if ($r["user_can_c"] == 3) {
                                        $emoticons = "❌";
                                        $Status = json_decode("\"" . $emoticons . "\"");
                                    } else {
                                        if ($r["user_can_c"] == 4) {
                                            $emoticons = "✅";
                                            $Status = json_decode("\"" . $emoticons . "\"");
                                        }
                                    }
                                }
                            }
                            $Result .= $Status . " <b>" . $r[imei] . "</b>\n<pre>" . strip_tags(br2nl($r[reply])) . "</pre>\n";
                        }
                        sendtelegram($Result, $userid);
                    } else {
                        if ($message == "/serverordersold" || contains($message, $lng_languag["serverorders"])) {
                            $query = dquery("select * from tblUsers \n                 where messengerid='" . $userid . "'");
                            $User = mysqli_fetch_assoc($query);
                            $i = dquery("select order_id,reply,user_can_c from\n                tbl_order_imei where server=1 and user_id='" . $User["id"] . "' order by order_id desc limit 10");
                            $Result = "<b>" . $lng_languag["last10serverorder"] . "</b>\n\n";
                            while ($r = mysqli_fetch_assoc($i)) {
                                if ($r["user_can_c"] == 0) {
                                    $emoticons = "⏳";
                                    $Status = json_decode("\"" . $emoticons . "\"");
                                } else {
                                    if ($r["user_can_c"] == 1) {
                                        $emoticons = "⏳";
                                        $Status = json_decode("\"" . $emoticons . "\"");
                                    } else {
                                        if ($r["user_can_c"] == 3) {
                                            $emoticons = "❌";
                                            $Status = json_decode("\"" . $emoticons . "\"");
                                        } else {
                                            if ($r["user_can_c"] == 4) {
                                                $emoticons = "✅";
                                                $Status = json_decode("\"" . $emoticons . "\"");
                                            }
                                        }
                                    }
                                }
                                $Result .= $Status . "<b>" . $r[order_id] . "</b> <pre>" . strip_tags(br2nl($r[reply])) . "</pre>\n\n";
                            }
                            sendtelegram($Result, $userid);
                        } else {
                            if (stripos($message, "/checkimei") !== false) {
                                $query = dquery("select * from tblUsers \n                 where messengerid='" . $userid . "'");
                                $User = mysqli_fetch_assoc($query);
                                $message = trim($message);
                                $imei = trim(str_replace("/checkimei", "", $message));
                                $imei = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $imei);
                                $order = dquery("select order_id,imei,date,user_can_c,reply from \ntbl_order_imei where imei='" . $imei . "' and user_id='" . $User["id"] . "' order by order_id desc");
                                if (mysqli_num_rows($order)) {
                                    $sendmessage = "";
                                    while ($ro = mysqli_fetch_assoc($order)) {
                                        if ($ro["order_id"]) {
                                            $sendmessage .= $StatusArray[$ro[user_can_c]] . "<b>" . $ro[imei] . "</b>\n";
                                            if ($ro[reply]) {
                                                $sendmessage .= "      <pre>" . strip_tags(br2nl($ro[reply])) . "</pre>\n";
                                            }
                                            $sendmessage .= "      <i>" . $ro[date] . "</i>\n      \n";
                                        }
                                    }
                                    sendtelegram($sendmessage, $userid);
                                } else {
                                    sendtelegram($lng_languag["ordernotfound"], $userid);
                                }
                            } else {
                                if (stripos($message, "/checkserver") !== false || $message == "/serverorders") {
                                    require_once ROOTDIR . "/includes/customfield.fun.inc.php";
                                    $query = dquery("select * from tblUsers \n                 where messengerid='" . $userid . "'");
                                    $User = mysqli_fetch_assoc($query);
                                    $message = trim($message);
                                    $imei = trim(str_replace("/checkserver", "", $message));
                                    $imei = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $imei);
                                    if ($message == "/serverorders") {
                                        $q = dquery("select order_id,service_id,(select service_name from tbl_services_imei where id=service_id) as service,qnt,date,user_can_c,reply from \ntbl_order_imei where  user_id='" . $User["id"] . "'  and server=1 order by order_id desc limit 10");
                                    } else {
                                        $q = dquery("select order_id,service_id,(select service_name from tbl_services_imei where id=service_id) as service,qnt,date,user_can_c,reply from \ntbl_order_imei where order_id='" . $imei . "' and user_id='" . $User["id"] . "'  and server=1");
                                    }
                                    $NotificationSend = false;
                                    $sendmessage = "";
                                    while ($order = mysqli_fetch_assoc($q)) {
                                        if ($order["order_id"]) {
                                            $NotificationSend = true;
                                            $Filed = getCustomFields("serviceimei", $order["service_id"], $order["order_id"]);
                                            $sendmessage .= $StatusArray[$order["user_can_c"]] . "<b>" . $order[service] . " X " . $order[qnt] . "</b>\n";
                                            if ($order[reply]) {
                                                $sendmessage .= "      <pre>" . strip_tags(br2nl($order[reply])) . "</pre>\n";
                                            }
                                            $sendmessage .= "      <i>" . $order[date] . "</i>\n";
                                            foreach ($Filed as $fieldetail) {
                                                $sendmessage .= "      <i>" . $fieldetail[name] . ": " . $fieldetail[value] . "</i>\n\n";
                                            }
                                        }
                                    }
                                    sendtelegram($sendmessage, $userid);
                                    if (!$NotificationSend) {
                                        sendtelegram($lng_languag["wrongorder"], $userid);
                                    }
                                } else {
                                    if ($message == "/me" || contains($message, $lng_languag["myaccount"])) {
                                        $query = dquery("select * from tblUsers \n                 where messengerid='" . $userid . "' and usertype!=3");
                                        $User = mysqli_fetch_assoc($query);
                                        $sendmessage = $User["first_name"] . " " . $User["last_name"] . "\n" . $icon["user"] . "<b>" . $User["username"] . "</b>\n\n" . $User[credit_left] . " " . $Currency["code"];
                                        sendtelegram($sendmessage, $userid, $keyboard["home"]);
                                    } else {
                                        if ($message == "/unpair") {
                                            dquery("UPDATE tblUsers set messengerid=''\n              where messengerid='" . $userid . "' and usertype!=3");
                                            sendtelegram($lng_languag["accountunpaired"], $userid, $keyboard["pairaccount"]);
                                        } else {
                                            if ($message == "/help") {
                                                sendtelegram($HelpNotes, $userid, $keyboard["home"]);
                                            } else {
                                                if ($message == "/favourite") {
                                                    $Fav = mysqli_fetch_assoc(dquery("select imeifrequent from tblUsers\nwhere id='" . $User["id"] . "'"));
                                                    $freq = explode(",", $Fav["imeifrequent"]);
                                                    if (in_array($id, $freq)) {
                                                        if (($key = array_search($id, $freq)) !== false) {
                                                            unset($freq[$key]);
                                                        }
                                                        $inline_keyboard_req[0][1]["text"] = " Favourite";
                                                    } else {
                                                        $freq[] = $id;
                                                        $inline_keyboard_req[0][1]["text"] = $icon["pin"] . " Favourite";
                                                    }
                                                    $freq = implode(",", $freq);
                                                    dquery("UPDATE tblUsers set imeifrequent='" . $freq . "' WHERE id='" . $User["id"] . "'");
                                                    sendtelegram($message_req, $userid, "", $inline_keyboard_req, $message_id);
                                                } else {
                                                    if ($message == "/selectservice") {
                                                        if ($id) {
                                                            require_once ROOTDIR . "/includes/fun.inc.php";
                                                            require_once ROOTDIR . "/includes/imeiservices.fun.php";
                                                            $_SESSION["uid"] = $User["id"];
                                                            $_SESSION["currency"]["id"] = $Currency["id"];
                                                            $ServiceDetails = getIMEIServicesNewSingle("", md5($id), $User["id"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $id);
                                                            $_Selected_service_name = html_entity_decode($ServiceDetails["service_name"]);
                                                            $_Selected_service_price = $ServiceDetails["credit"] . "  " . $Currency["code"];
                                                            $_FIELD_NAME = "IMEI";
                                                            $_proccing_time = $ServiceDetails["time"];
                                                            $groupid = $ServiceDetails["group_id"];
                                                            if ($info) {
                                                                $info = strip_tags($ServiceDetails["info"]);
                                                            }
                                                            $_msg = " " . $_Selected_service_name . "\n                    \nProcessing time : <b>" . $_proccing_time . "</b>\n\nPrice : <b>" . $_Selected_service_price . "</b>\n\n" . $info;
                                                            $ICON = "";
                                                            if ($User["imeifrequent"]) {
                                                                $freq = explode(",", $User["imeifrequent"]);
                                                                if (in_array($id, $freq)) {
                                                                    $ICON = $icon["pin"];
                                                                }
                                                            }
                                                            sendtelegram($_msg, $userid, "", [[["text" => (string) $icon["back"], "callback_data" => cb_data(["id" => $groupid, "action" => "/selectgroup"])], ["text" => $ICON . " " . $lng_languag["favourite"], "callback_data" => cb_data(["id" => $id, "action" => "/favourite"])], ["text" => $lng_languag["info"], "callback_data" => cb_data(["id" => $id, "action" => "/selectservice", "info" => true])]], [["text" => $lng_languag["processfororder"] . "   " . $icon["next"], "callback_data" => cb_data(["id" => $id, "action" => "/placeorder"])]]], $message_id);
                                                        } else {
                                                            replytelegram($callback_query_id, "Invalid service id");
                                                        }
                                                    } else {
                                                        if ($message == "/placeorder") {
                                                            if ($id) {
                                                                $q = mysqli_fetch_assoc(dquery("select imei_custom_name,custom_name,minqnt,maxqnt,qnt,useasserver,\nimei_custom_len,maxlength,isalpha,qntoptions\nfrom tbl_services_imei where id='" . $id . "'"));
                                                                $Question = NULL;
                                                                if ($q["useasserver"] == 0) {
                                                                    $Field = "IMEI";
                                                                    if ($q["imei_custom_name"]) {
                                                                        $Field = $q["imei_custom_name"];
                                                                        $Question["min"] = $q["imei_custom_len"] ? $q["imei_custom_len"] : 1;
                                                                        $Question["max"] = $q["maxlength"] ? $q["maxlength"] : 50;
                                                                    } else {
                                                                        $Question["fun"] = "is_imei";
                                                                    }
                                                                    $Question["q"] = $lng_languag["whatis"] . " <b>" . $Field . "</b> ?";
                                                                    $Question["name"] = "imei";
                                                                    $Question["ans"] = "";
                                                                    $_bot_questions[] = $Question;
                                                                } else {
                                                                    if ($q["qnt"]) {
                                                                        $Question["q"] = $lng_languag["howmuchqnt"];
                                                                        $Question["name"] = "qnt";
                                                                        $Question["ans"] = "";
                                                                        $Question["qnt"] = true;
                                                                        $Question["minqnt"] = $q["minqnt"];
                                                                        $Question["maxqnt"] = $q["maxqnt"];
                                                                        if ($q["qntoptions"]) {
                                                                            $Question["options"] = explode(",", $q["qntoptions"]);
                                                                        }
                                                                        $_bot_questions[] = $Question;
                                                                    }
                                                                }
                                                                $Customq = dquery("select * from tbl_customfields\n where `type`='serviceimei' and relid='" . $id . "' and required='on'");
                                                                while ($Custom = mysqli_fetch_assoc($Customq)) {
                                                                    unset($Question);
                                                                    if ($Custom["fieldtype"] == "text" || $Custom["fieldtype"] == "textarea") {
                                                                        $Question["q"] = "What is <b>" . $Custom["fieldname"] . "</b>?";
                                                                        $Question["name"] = (string) $Custom["fieldname"];
                                                                        $Question["custom"] = true;
                                                                        $Question["customfieldid"] = $Custom["id"];
                                                                        $Question["ans"] = "";
                                                                        $_bot_questions[] = $Question;
                                                                    } else {
                                                                        if ($Custom["fieldtype"] == "dropdown" || $Custom["fieldtype"] == "radio") {
                                                                            $Question["q"] = "What is <b>" . $Custom["fieldname"] . "</b>?";
                                                                            $Question["name"] = (string) $Custom["fieldname"];
                                                                            $Question["custom"] = true;
                                                                            $Question["customfieldid"] = $Custom["id"];
                                                                            $Question["ans"] = "";
                                                                            $Question["options"] = explode(",", $Custom["fieldoptions"]);
                                                                            foreach ($Question["options"] as $k => $v) {
                                                                            }
                                                                            $_bot_questions[] = $Question;
                                                                        }
                                                                    }
                                                                }
                                                                unset($Question);
                                                                $Question["q"] = "Enter 4 digit Order Pin";
                                                                $Question["pin"] = true;
                                                                $Question["ans"] = "";
                                                                $_bot_questions[] = $Question;
                                                                $_chat_session["bot_questions"] = $_bot_questions;
                                                                $_chat_session["serviceid"] = $id;
                                                                $_chat_session["action"] = "/placeorderfinal";
                                                                saveChat($userid, $_chat_session);
                                                                startChat($userid);
                                                            } else {
                                                                replytelegram($callback_query_id, "Invalid service id");
                                                            }
                                                        } else {
                                                            if ($message == "/selectgroup" || contains($message, $lng_languag["favouriteservice"])) {
                                                                if (contains($message, $lng_languag["favouriteservice"])) {
                                                                    if ($User["imeifrequent"]) {
                                                                        $User["imeifrequent"] = trim($User["imeifrequent"]);
                                                                        $User["imeifrequent"] = trim($User["imeifrequent"], ",");
                                                                        $WHERE = " tbl_services_imei.id in (" . $User["imeifrequent"] . ")";
                                                                    }
                                                                    $_Group_NAme = $lng_languag["favouriteservice"];
                                                                } else {
                                                                    if ($id) {
                                                                        $Group = mysqli_fetch_assoc(dquery("select group_name,server from tbl_imei_group\nwhere id='" . $id . "'"));
                                                                        $_Group_NAme = html_entity_decode($Group["group_name"]);
                                                                        $WHERE = " group_id='" . $id . "'";
                                                                    }
                                                                }
                                                                $ActiveServices = getServicesFromClientGroup($User["client_group"]);
                                                                $q = dquery("select id,service_name from tbl_services_imei\nwhere " . $WHERE . " and id in (" . implode(",", $ActiveServices) . ") \norder by `sort` desc");
                                                                while ($r = mysqli_fetch_assoc($q)) {
                                                                    $Service[0]["text"] = html_entity_decode($r["service_name"]);
                                                                    $Service[0]["callback_data"] = cb_data(["id" => $r["id"], "action" => "/selectservice"]);
                                                                    $_IMEI_Service[] = $Service;
                                                                }
                                                                $Service[0]["text"] = $icon["back"] . " BACK";
                                                                if ($Group["server"] == 1) {
                                                                    $Service[0]["callback_data"] = cb_data(["id" => $groupid, "action" => "/placeimeiorder2"]);
                                                                } else {
                                                                    $Service[0]["callback_data"] = cb_data(["id" => $groupid, "action" => "/placeimeiorder"]);
                                                                }
                                                                if ($Group["server"] != 1) {
                                                                }
                                                                $_IMEI_Service[] = $Service;
                                                                $_IMEI_groups = [[["text" => "Group 1", "callback_data" => cb_data(["id" => 1, "action" => "/selectgroup"])]], [["text" => "Group 2", "callback_data" => cb_data(["id" => 2, "action" => "/selectgroup"])]], [["text" => "Group 3", "callback_data" => cb_data(["id" => 3, "action" => "/selectgroup"])]], [["text" => "Group 4", "callback_data" => cb_data(["id" => 4, "action" => "/selectgroup"])]], [["text" => "Group 5", "callback_data" => cb_data(["id" => 5, "action" => "/selectgroup"])]], [["text" => "Group 6", "callback_data" => cb_data(["id" => 6, "action" => "/selectgroup"])]]];
                                                                sendtelegram((string) $_Group_NAme, $userid, "", $_IMEI_Service, $message_id);
                                                                unset($_IMEI_Service);
                                                            } else {
                                                                if (!($message == "/placeserverorder" || contains($message, $lng_languag["serverorder"]))) {
                                                                    sendtelegram($lng_languag["sorrynotunderstand"], $userid, $keyboard["home"]);
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    exit;
}
foreach ($_POST as $k => $v) {
    $buf .= $k . "=" . $v . "\n";
}
$username = preg_replace("/[^0-9\\-a-zA-Z.@_]/i", "", $username);
$action = preg_replace("/[^a-zA-Z]/i", "", $action);
$user = preg_replace("/[^0-9]/i", "", $user);
$service = preg_replace("/[^0-9]/i", "", $service);
$format = preg_replace("/[^a-zA-Z0-9]/i", "", $_GET["format"]);
if ($action == "checkurl") {
    $_OUT["STATUS"] = "SUCCESS";
    $_OUT["COMPANY"] = $config["companyname"];
    echo json_encode($_OUT);
    exit;
}
if ($user) {
    $password = md5(md5($password) . $passenc);
    $result = dquery("SELECT * FROM `tblUsers` WHERE \n                `password`='" . $password . "' and userstatus=0 and id='" . $user . "'");
    if (!mysqli_num_rows($result)) {
        $_OUT["STATUS"] = "ERROR";
        $_OUT["MSG"] = "Wrong Access";
        echo json_encode($_OUT);
        exit;
    }
}
if ($d) {
    echo "<pre>";
    print_r($_OUT);
    echo "</pre>";
} else {
    echo json_encode($_OUT);
}
function sendTelegram($message, $userid, $reply_markup = [], $replay_inline = [], $message_id = "")
{
    global $config;
    global $userid;
    $telegramurl = "";
    $post = [];
    $action = "sendMessage";
    $UserID = $userid;
    $post["chat_id"] = $userid;
    $userid = "chat_id=" . $userid;
    $resp = [];
    if (0 < count($reply_markup)) {
        $keyboard = $reply_markup;
        $resp = ["keyboard" => $keyboard, "resize_keyboard" => true, "one_time_keyboard" => true];
        $resp["keyboard"] = $reply_markup;
        $resp["resize_keyboard"] = true;
        $resp["one_time_keyboard"] = true;
    } else {
        $reply_markup = "";
    }
    if (0 < count($replay_inline)) {
        $resp = [];
        $resp["inline_keyboard"] = $replay_inline;
    } else {
        $replay_inline = "";
    }
    if (0 < count($resp)) {
        $reply_markup = "&reply_markup=" . json_encode($resp);
        $post["reply_markup"] = json_encode($resp);
    }
    if ($message_id) {
        $action = "editMessageText";
        $userid .= "&message_id=" . $message_id;
        $post["message_id"] = $message_id;
    }
    $post["parse_mode"] = "HTML";
    $post["text"] = $message;
    $telegramurl .= $action . "?" . $userid . "&parse_mode=HTML&text=" . urlencode($message) . $reply_markup;
    if (4000 < strlen($message)) {
        file_put_contents("msg.txt", $message);
        $action = "sendDocument";
        unset($post["text"]);
        unset($post["parse_mode"]);
        $FILENAME = "./msg.txt";
        $finfo = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $FILENAME);
        $cFile = new CURLFile($FILENAME, $finfo);
        $post["document"] = $cFile;
        initTelegram("", $action . "?chat_id=" . $UserID, $post);
    } else {
        initTelegram("", $action, $post);
    }
}
function replyTelegram($callback_query_id, $text)
{
    global $userid;
    $post = [];
    $post["callback_query_id"] = $callback_query_id;
    $post["text"] = $text;
    $post["show_alert"] = true;
    initTelegram("", "answerCallbackQuery", $post);
}
function initTelegram($url = "", $command = "sendMessage", $post = [])
{
    global $config;
    global $userid;
    $telegramurl = "https://api.telegram.org/bot" . $config["slacktokenuser"] . "/" . $command;
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $telegramurl);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt_array($curl_handle, [CURLOPT_HEADER => ["cache-control: no-cache", "content-type: application/x-www-form-urlencoded"], CURLOPT_RETURNTRANSFER => 1, CURLOPT_POST => 1, CURLOPT_POSTFIELDS => $post]);
    $telegramdata = curl_exec($curl_handle);
    file_put_contents("_api_responce.json", $telegramdata);
    curl_close($curl_handle);
    if (!empty($telegramdata)) {
    }
}
function initkeyboard($userid = "")
{
    global $lng_languag;
    global $icon;
    global $userid;
    global $keyboard;
    global $HelpNotes;
    global $config;
    $keyboard = [];
    $keyboard["cancel"] = [["" . $lng_languag["cancelorder"] . ""]];
    $keyboard["home"] = [[$icon["calendar"] . " " . $lng_languag["imeiorders"] . "", $icon["calendar"] . " " . $lng_languag["serverorders"] . ""], [$icon["plus"] . " " . $lng_languag["imeiorder"] . "", $icon["plus"] . " " . $lng_languag["serverorder"] . ""], [$icon["plus"] . " " . $lng_languag["favouriteservice"] . " "], [$icon["user"] . " " . $lng_languag["myaccount"] . " "]];
    $keyboard["pairaccount"] = [[(string) $lng_languag["pairaccount"]]];
    $keyboard["cancelregistration"] = [[(string) $lng_languag["cancelregistration"]]];
    if ($config["allowtelegramreg"]) {
        $keyboard["pairaccount"] = [[(string) $lng_languag["pairaccount"]], [["text" => (string) $lng_languag["registernewaccount"], "request_contact" => true]]];
    }
    $HelpNotes = $lng_languag["telegramhelp1"] . ".\n\n" . $lng_languag["telegramhelp2"] . ":\n\n/start - " . $lng_languag["telegramstart"] . "\n/unpair - " . $lng_languag["telegramunpair"] . "\n\n/me - " . $lng_languag["telegramgetacc"] . "\n/imeiorders - " . $lng_languag["telegramgetlast"] . "\n/serverorders - " . $lng_languag["telegramgetlastserver"] . "\n/checkimei 111111111111119 - " . $lng_languag["telegramcheckstatus"] . "\n/checkserver 393822 - " . $lng_languag["telegramcheckstatus"] . "\n/help - " . $lng_languag["telegramgetall"] . "";
    if (!$config["RemoveBranding"]) {
        $HelpNotes .= "\n<i>Powered By Dhru Fusion</i>";
    }
}
function startChat($userid, $message = "")
{
    global $keyboard;
    global $remote_ip;
    global $config;
    global $User;
    global $lng_languag;
    global $passenc;
    $_chat_data = json_decode(file_get_contents("chat/" . $userid . ".json"), true);
    $answred = 0;
    foreach ($_chat_data["bot_questions"] as $k => $q) {
        if ($q["ans"] == "") {
            if ($message) {
                $isValid = false;
                $CustomMessage = "";
                if ($q["qnt"]) {
                    if (is_numeric($message)) {
                        if ($q["options"]) {
                            if (in_array($message, $q["options"])) {
                                $isValid = true;
                            }
                        } else {
                            if ($q["minqnt"] && $q["maxqnt"]) {
                                if ($q["minqnt"] <= $message && $message <= $q["maxqnt"]) {
                                    $isValid = true;
                                } else {
                                    $CustomMessage = " Min. " . $q["minqnt"] . " and Max. " . $q["maxqnt"] . " Required";
                                }
                            } else {
                                $isValid = true;
                            }
                        }
                    }
                } else {
                    if ($q["options"]) {
                        if (in_array($message, $q["options"])) {
                            $isValid = true;
                        }
                    } else {
                        if ($q["fun"]) {
                            if (call_user_func($q["fun"], $message)) {
                                $isValid = true;
                            }
                        } else {
                            if ($q["regx"]) {
                                if (preg_match($q["regx"], $message)) {
                                    $isValid = true;
                                }
                            } else {
                                if ($q["min"] && $q["max"]) {
                                    if ($q["min"] <= strlen($message) && strlen($message) <= $q["max"]) {
                                        $isValid = true;
                                    }
                                } else {
                                    if ($q["pin"]) {
                                        $Data = [];
                                        if ($User["data"]) {
                                            $Data = json_decode($User["data"], true);
                                        }
                                        if (md5($message . $passenc) == $Data["telegramorderpin"]) {
                                            $isValid = true;
                                        } else {
                                            dquery("UPDATE `tblUsers` SET `login_failed_atoms`=login_failed_atoms+1 WHERE `id`= '" . $User["id"] . "'");
                                            $login_attempts = mysqli_fetch_assoc(dquery("SELECT `login_failed_atoms` FROM `tblUsers` WHERE `id`='" . $User["id"] . "' AND `login_failed_atoms` > '" . $config["MaxLoginFailedAttempts"] . "' "));
                                            if ($login_attempts) {
                                                $mail_ver["blockreson"] = "Automatically block  (" . $config["MaxLoginFailedAttempts"] . " failed place order pin attempts) from Telegram ";
                                                dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`=1,`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $User["id"] . "' ");
                                                require_once ROOTDIR . "/includes/mail.fun.php";
                                                sendMail(5, $User["id"], "", $mail_ver);
                                                removeChat($userid);
                                            }
                                        }
                                    } else {
                                        $isValid = true;
                                    }
                                }
                            }
                        }
                    }
                }
                if ($isValid) {
                    if ($message != "/selectservice" && $message != "/placeorder" && $message != "/placeserverorder" && $message != "/selectgroup") {
                        $_chat_data["bot_questions"][$k]["ans"] = $message;
                        $_chat_data["bot_questions"][$k][$q["name"]] = $message;
                        saveChat($userid, $_chat_data);
                        unset($message);
                        $answred++;
                    } else {
                        $_invalid = "Invalid," . $CustomMessage . " try again\n" . $q["q"] . "";
                        if ($q["options"]) {
                            foreach ($q["options"] as $opt) {
                                $Service[0]["text"] = urlencode(html_entity_decode($opt));
                                $Service[0]["callback_data"] = urlencode(html_entity_decode($opt));
                                $OPtions[] = $Service;
                            }
                        }
                        sendtelegram($_invalid, $userid, $keyboard["cancel"], $OPtions);
                        exit;
                    }
                } else {
                    $_invalid = "Invalid," . $CustomMessage . " try again\n" . $q["q"] . "";
                    if ($q["options"]) {
                        foreach ($q["options"] as $opt) {
                            $Service[0]["text"] = urlencode(html_entity_decode($opt));
                            $Service[0]["callback_data"] = urlencode(html_entity_decode($opt));
                            $OPtions[] = $Service;
                        }
                    }
                    sendtelegram($_invalid, $userid, $keyboard["cancel"], $OPtions);
                    exit;
                }
            } else {
                unset($OPtions);
                if ($q["options"]) {
                    foreach ($q["options"] as $opt) {
                        $Service[0]["text"] = urlencode(html_entity_decode($opt));
                        $Service[0]["callback_data"] = urlencode(html_entity_decode($opt));
                        $OPtions[] = $Service;
                    }
                }
                sendtelegram($q["q"], $userid, $keyboard["cancel"], $OPtions);
                if (count($_chat_data["bot_questions"]) == $answred) {
                    require_once ROOTDIR . "/includes/fun.inc.php";
                    require_once ROOTDIR . "/includes/client.area.inc.php";
                    require_once ROOTDIR . "/includes/clients.fun.inc.php";
                    require_once ROOTDIR . "/includes/imeiservices.fun.php";
                    global $id;
                    global $qnt;
                    global $imei_custom;
                    global $imei_bulk;
                    global $customfield;
                    global $orderfrom;
                    global $Currency;
                    $_SESSION["uid"] = $User["id"];
                    $_SESSION["currency"]["id"] = $Currency["id"];
                    $orderfrom = 3;
                    $id = $_chat_data["serviceid"];
                    $_ClientsDetails = getClientsDetails($User["id"]);
                    $serviceDetails = getIMEIServicesNewSingle("", md5($id), $User["id"], true, "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", $id);
                    $instant = false;
                    if ($serviceDetails["API"]) {
                        $Apiserver = mysqli_fetch_assoc(dquery("select `value` from tbl_apiservers\nwhere gateway='" . $serviceDetails["API"] . "' and setting='instant'"));
                        if ($Apiserver["value"]) {
                            $instant = true;
                        }
                    }
                    foreach ($_chat_data["bot_questions"] as $quearr) {
                        $Fields[$quearr["name"]] = $quearr["ans"];
                        if ($quearr["custom"]) {
                            $customfield[$quearr["customfieldid"]] = $quearr["ans"];
                        }
                    }
                    $imei_custom = $imei_bulk = $Fields["imei"];
                    $qnt = $Fields["qnt"];
                    if ($_ClientsDetails["userstatus"] == 1) {
                        sendtelegram("Your account is blocked", $userid, $keyboard["cancel"]);
                    } else {
                        if ($error = strip_tags(placeOrderIMEIvalidation($serviceDetails["reqredfield"], true, "", $serviceDetails))) {
                            $error = explode(":", $error);
                            if (trim($error[1]) != "Service Not Active") {
                            }
                            sendtelegram($id . $error[1] . " ", $userid, $keyboard["cancel"]);
                        } else {
                            if ($error = strip_tags(creditProcessIMEI($_ClientsDetails, $serviceDetails, "", "", $instant))) {
                                $_status = explode(":", $error);
                                if ($_status[0] == "success") {
                                    sendtelegram($lng_languag["orderplaced"] . " #" . $_status[2], $userid, $keyboard["home"]);
                                } else {
                                    sendtelegram($lng_languag["notenoughcredit"], $userid, $keyboard["home"]);
                                }
                                removeChat($userid);
                            }
                        }
                    }
                }
            }
        } else {
            $answred++;
        }
    }
}
function saveChat($userid, $data)
{
    file_put_contents("chat/" . $userid . ".json", json_encode($data));
}
function removeChat($userid)
{
    unlink("chat/" . $userid . ".json");
}
function is_imei($imei)
{
    if (strlen($imei) != 15 || !ctype_digit($imei)) {
        return false;
    }
    $digits = str_split($imei);
    $imei_last = array_pop($digits);
    $log = [];
    foreach ($digits as $key => $n) {
        if ($key & 1) {
            $double = str_split($n * 2);
            $n = array_sum($double);
        }
        $log[] = $n;
    }
    $sum = array_sum($log) * 9;
    return substr($sum, -1) == $imei_last;
}
function contains($string, $find)
{
    return stripos($string, $find) !== false;
}
function cb_data($callabck_data_array)
{
    return json_encode($callabck_data_array);
}
function getServicesFromClientGroup($clientgroup = "base")
{
    $clientgroup = trim($clientgroup) ? trim($clientgroup) : "base";
    $qs = dquery("select serviceid from tbl_service_status \n            where groupid='" . $clientgroup . "' and status='1'");
    while ($rs = mysqli_fetch_assoc($qs)) {
        $ActiveService[$rs["serviceid"]] = $rs["serviceid"];
    }
    return $ActiveService;
}
function cidr_match($ip, $ranges)
{
    foreach ($ranges as $range) {
        list($subnet, $bits) = explode("/", $range);
        if ($bits === NULL) {
            $bits = 32;
        }
        $ip = ip2long($ip);
        $subnet = ip2long($subnet);
        $mask = -1 << 32 - $bits;
        $subnet &= $mask;
        if (($ip & $mask) == $subnet) {
            return true;
        }
    }
    return false;
}
function loadLanguage($language, $userid = "")
{
    global $config;
    global $lng_languag;
    global $userid;
    $languageCodes = ["aa" => "Afar", "ab" => "Abkhazian", "ae" => "Avestan", "af" => "Afrikaans", "ak" => "Akan", "am" => "Amharic", "an" => "Aragonese", "ar" => "Arabic", "as" => "Assamese", "av" => "Avaric", "ay" => "Aymara", "az" => "Azerbaijani", "ba" => "Bashkir", "be" => "Belarusian", "bg" => "Bulgarian", "bh" => "Bihari", "bi" => "Bislama", "bm" => "Bambara", "bn" => "Bengali", "bo" => "Tibetan", "br" => "Breton", "bs" => "Bosnian", "ca" => "Catalan", "ce" => "Chechen", "ch" => "Chamorro", "co" => "Corsican", "cr" => "Cree", "cs" => "Czech", "cu" => "Church Slavic", "cv" => "Chuvash", "cy" => "Welsh", "da" => "Danish", "de" => "German", "dv" => "Divehi", "dz" => "Dzongkha", "ee" => "Ewe", "el" => "Greek", "en" => "English", "eo" => "Esperanto", "es" => "Spanish", "et" => "Estonian", "eu" => "Basque", "fa" => "Persian", "ff" => "Fulah", "fi" => "Finnish", "fj" => "Fijian", "fo" => "Faroese", "fr" => "French", "fy" => "Western Frisian", "ga" => "Irish", "gd" => "Scottish Gaelic", "gl" => "Galician", "gn" => "Guarani", "gu" => "Gujarati", "gv" => "Manx", "ha" => "Hausa", "he" => "Hebrew", "hi" => "Hindi", "ho" => "Hiri Motu", "hr" => "Croatian", "ht" => "Haitian", "hu" => "Hungarian", "hy" => "Armenian", "hz" => "Herero", "ia" => "Interlingua (International Auxiliary Language Association)", "id" => "Indonesian", "ie" => "Interlingue", "ig" => "Igbo", "ii" => "Sichuan Yi", "ik" => "Inupiaq", "io" => "Ido", "is" => "Icelandic", "it" => "Italian", "iu" => "Inuktitut", "ja" => "Japanese", "jv" => "Javanese", "ka" => "Georgian", "kg" => "Kongo", "ki" => "Kikuyu", "kj" => "Kwanyama", "kk" => "Kazakh", "kl" => "Kalaallisut", "km" => "Khmer", "kn" => "Kannada", "ko" => "Korean", "kr" => "Kanuri", "ks" => "Kashmiri", "ku" => "Kurdish", "kv" => "Komi", "kw" => "Cornish", "ky" => "Kirghiz", "la" => "Latin", "lb" => "Luxembourgish", "lg" => "Ganda", "li" => "Limburgish", "ln" => "Lingala", "lo" => "Lao", "lt" => "Lithuanian", "lu" => "Luba-Katanga", "lv" => "Latvian", "mg" => "Malagasy", "mh" => "Marshallese", "mi" => "Maori", "mk" => "Macedonian", "ml" => "Malayalam", "mn" => "Mongolian", "mr" => "Marathi", "ms" => "Malay", "mt" => "Maltese", "my" => "Burmese", "na" => "Nauru", "nb" => "Norwegian Bokmal", "nd" => "North Ndebele", "ne" => "Nepali", "ng" => "Ndonga", "nl" => "Dutch", "nn" => "Norwegian Nynorsk", "no" => "Norwegian", "nr" => "South Ndebele", "nv" => "Navajo", "ny" => "Chichewa", "oc" => "Occitan", "oj" => "Ojibwa", "om" => "Oromo", "or" => "Oriya", "os" => "Ossetian", "pa" => "Panjabi", "pi" => "Pali", "pl" => "Polish", "ps" => "Pashto", "pt" => "Portuguese", "qu" => "Quechua", "rm" => "Raeto-Romance", "rn" => "Kirundi", "ro" => "Romanian", "ru" => "Russian", "rw" => "Kinyarwanda", "sa" => "Sanskrit", "sc" => "Sardinian", "sd" => "Sindhi", "se" => "Northern Sami", "sg" => "Sango", "si" => "Sinhala", "sk" => "Slovak", "sl" => "Slovenian", "sm" => "Samoan", "sn" => "Shona", "so" => "Somali", "sq" => "Albanian", "sr" => "Serbian", "ss" => "Swati", "st" => "Southern Sotho", "su" => "Sundanese", "sv" => "Swedish", "sw" => "Swahili", "ta" => "Tamil", "te" => "Telugu", "tg" => "Tajik", "th" => "Thai", "ti" => "Tigrinya", "tk" => "Turkmen", "tl" => "Tagalog", "tn" => "Tswana", "to" => "Tonga", "tr" => "Turkish", "ts" => "Tsonga", "tt" => "Tatar", "tw" => "Twi", "ty" => "Tahitian", "ug" => "Uighur", "uk" => "Ukrainian", "ur" => "Urdu", "uz" => "Uzbek", "ve" => "Venda", "vi" => "Vietnamese", "vo" => "Volapuk", "wa" => "Walloon", "wo" => "Wolof", "xh" => "Xhosa", "yi" => "Yiddish", "yo" => "Yoruba", "za" => "Zhuang", "zh" => "Chinese", "zu" => "Zulu"];
    $language = $languageCodes[$language];
    ob_start();
    if (file_exists(ROOTDIR . "/" . $config["lang_folder"] . "/" . $language . ".custom.txt")) {
        include ROOTDIR . "/" . $config["lang_folder"] . "/" . $language . ".custom.txt";
    } else {
        if (file_exists(ROOTDIR . "/" . $config["lang_folder"] . "/" . $language . ".txt")) {
            include ROOTDIR . "/" . $config["lang_folder"] . "/" . $language . ".txt";
        } else {
            include ROOTDIR . "/" . $config["lang_folder"] . "/English.txt";
        }
    }
    $lang_cont = ob_get_contents();
    ob_end_clean();
    eval($lang_cont);
    initkeyboard($userid);
}

?>