<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
function generate_token($type = "form")
{
    $token = sha1(session_id() . ":RopccsS33");
    if ($type == "plain") {
        return $token;
    }
    if ($type == "link") {
        return "&token=" . $token;
    }
    if ($type == "form") {
        return "<input type=\"hidden\" name=\"token\" id=\"token\" value=\"" . $token . "\" />";
    }
}
function secondsToTime($inputSeconds)
{
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;
    $days = floor($inputSeconds / $secondsInADay);
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);
    $obj = ["d" => (int) $days, "h" => (int) $hours, "m" => (int) $minutes, "s" => (int) $seconds];
    return $obj;
}
function checkCreditCard($cardnumber, $cardname, &$errornumber, &$errortext)
{
    $cards = [["name" => "amx", "length" => "15", "prefixes" => "34,37", "checkdigit" => true], ["name" => "Diners Club Carte Blanche", "length" => "14", "prefixes" => "300,301,302,303,304,305", "checkdigit" => true], ["name" => "dnr", "length" => "14,16", "prefixes" => "36,54,55", "checkdigit" => true], ["name" => "dis", "length" => "16", "prefixes" => "6011,622,64,65", "checkdigit" => true], ["name" => "Diners Club Enroute", "length" => "15", "prefixes" => "2014,2149", "checkdigit" => true], ["name" => "JCB", "length" => "16", "prefixes" => "35", "checkdigit" => true], ["name" => "Maestro", "length" => "12,13,14,15,16,18,19", "prefixes" => "5018,5020,5038,6304,6759,6761,6762,6763", "checkdigit" => true], ["name" => "mcd", "length" => "16", "prefixes" => "51,52,53,54,55", "checkdigit" => true], ["name" => "Solo", "length" => "16,18,19", "prefixes" => "6334,6767", "checkdigit" => true], ["name" => "Switch", "length" => "16,18,19", "prefixes" => "4903,4905,4911,4936,564182,633110,6333,6759", "checkdigit" => true], ["name" => "vis", "length" => "16", "prefixes" => "4", "checkdigit" => true], ["name" => "VISA Electron", "length" => "16", "prefixes" => "417500,4917,4913,4508,4844", "checkdigit" => true], ["name" => "LaserCard", "length" => "16,17,18,19", "prefixes" => "6304,6706,6771,6709", "checkdigit" => true]];
    $ccErrorNo = 0;
    $ccErrors[0] = "Unknown card type";
    $ccErrors[1] = "No card number provided";
    $ccErrors[2] = "Credit card number has invalid format";
    $ccErrors[3] = "Credit card number is invalid";
    $ccErrors[4] = "Credit card number is wrong length";
    $cardType = -1;
    $i = 0;
    while ($i < sizeof($cards)) {
        if (strtolower($cardname) == strtolower($cards[$i]["name"])) {
            $cardType = $i;
        } else {
            $i++;
        }
    }
    if ($cardType == -1) {
        $errornumber = 0;
        $errortext = $ccErrors[$errornumber];
        return false;
    }
    if (strlen($cardnumber) == 0) {
        $errornumber = 1;
        $errortext = $ccErrors[$errornumber];
        return false;
    }
    $cardNo = str_replace(" ", "", $cardnumber);
    if (!preg_match("/^[0-9]{13,19}\$/", $cardNo)) {
        $errornumber = 2;
        $errortext = $ccErrors[$errornumber];
        return false;
    }
    if ($cards[$cardType]["checkdigit"]) {
        $checksum = 0;
        $mychar = "";
        $j = 1;
        for ($i = strlen($cardNo) - 1; 0 <= $i; $i--) {
            $calc = $cardNo[$i] * $j;
            if (9 < $calc) {
                $checksum = $checksum + 1;
                $calc = $calc - 10;
            }
            $checksum = $checksum + $calc;
            if ($j == 1) {
                $j = 2;
            } else {
                $j = 1;
            }
        }
        if ($checksum % 10 != 0) {
            $errornumber = 3;
            $errortext = $ccErrors[$errornumber];
            return false;
        }
    }
    $prefix = explode(",", $cards[$cardType]["prefixes"]);
    $PrefixValid = false;
    $i = 0;
    while ($i < sizeof($prefix)) {
        $exp = "/^" . $prefix[$i] . "/";
        if (preg_match($exp, $cardNo)) {
            $PrefixValid = true;
        } else {
            $i++;
        }
    }
    if (!$PrefixValid) {
        $errornumber = 3;
        $errortext = $ccErrors[$errornumber];
        return false;
    }
    $LengthValid = false;
    $lengths = explode(",", $cards[$cardType]["length"]);
    $j = 0;
    while ($j < sizeof($lengths)) {
        if (strlen($cardNo) == $lengths[$j]) {
            $LengthValid = true;
        } else {
            $j++;
        }
    }
    if (!$LengthValid) {
        $errornumber = 4;
        $errortext = $ccErrors[$errornumber];
        return false;
    }
    return true;
}
function getSubscribestatus($uid, $sid, $type)
{
    $counter = mysqli_fetch_assoc(dquery("select subscriptionorderlimit from " . $type . " where id='" . $sid . "'"));
    if ($counter["subscriptionorderlimit"]) {
        $sql = dquery("SELECT * FROM tbl_subscribers WHERE user_id='" . $uid . "' AND service_id='" . $sid . "' AND type='" . $type . "' AND " . $counter["subscriptionorderlimit"] . ">`used`  AND status='active'");
    } else {
        $sql = dquery("SELECT * FROM tbl_subscribers WHERE user_id='" . $uid . "' AND service_id='" . $sid . "' AND type='" . $type . "' AND status='active'");
    }
    if (mysqli_num_rows($sql)) {
        $subscribe = mysqli_fetch_assoc($sql);
        if ($subscribe["status"] != "active") {
            return false;
        }
        $time = time();
        $status = mysqli_fetch_assoc(dquery("SELECT subscribe FROM " . $type . " WHERE id='" . $sid . "'"));
        if ($subscribe["subscribe_start"] <= $time && $time <= $subscribe["subscribe_end"] && $status["subscribe"]) {
            return true;
        }
        return false;
    }
    return false;
}
function getALLIMEIServices($server = false)
{
    global $config;
    global $db;
    global $precision;
    global $_ClientsDetails;
    if (!isset($_ClientsDetails)) {
        include_once ROOTDIR . "/includes/clients.fun.inc.php";
        $_ClientsDetails = getClientsDetails($_SESSION["uid"]);
    }
    $_currencyid = $_ClientsDetails["default_currency"] ? $_ClientsDetails["default_currency"] : $SystemCurrency;
    if ($_ClientsDetails["client_group"]) {
        $_clientgroup = $_ClientsDetails["client_group"];
    } else {
        $_clientgroup = "base";
    }
    require_once ROOTDIR . "/includes/imeiservices.fun.php";
    $uid = $_SESSION["uid"];
    if ($server) {
        $wherecond = " where `server`='1'";
        $whereforservice = " where useasserver=1";
    } else {
        $wherecond = " where `server`='0'";
        $whereforservice = " where useasserver=0";
    }
    $s = dquery("select service_name,(select group_name from \ntbl_imei_group where id=group_id) as groupname,promotiondis,credit,id,active \n        from tbl_services_imei    " . $whereforservice . " \n        and active<2  order by sort asc");
    while ($d = mysqli_fetch_assoc($s)) {
        $ServicePrice = new ServicePrice($d["id"]);
        $Credit = round($ServicePrice->getServicePricing($_currencyid, 1, $_clientgroup, $_SESSION["uid"]), $precision);
        if ($Credit) {
            $d["credit"] = $Credit;
            $servlist[$d["groupname"]][$d["id"]] = $d;
        }
    }
    mysqli_free_result($s);
    return $servlist;
}
function getPurchaseCost($cid, $sid, $type)
{
    global $config;
    global $db;
    $sql = mysqli_fetch_assoc(dquery("select price from tbl_purchase_cost \n    where cid='" . $cid . "' and sid='" . $sid . "' and type='" . $type . "'"));
    if ($sql["price"] != "") {
        return $sql["price"];
    }
    return false;
}
function getALLFileServices()
{
    global $config;
    global $db;
    global $precision;
    require_once ROOTDIR . "/includes/fileservices.fun.php";
    global $_ClientsDetails;
    $uid = $_SESSION["uid"];
    $sql = dquery("select * from tbl_file_group");
    while ($row = mysqli_fetch_assoc($sql)) {
        $s = dquery("select service_name,id,credit,active from tbl_services_file where group_id='" . $row["id"] . "' and active<2");
        while ($d = mysqli_fetch_assoc($s)) {
            $d["defaultcredit"] = getFilePrice($d["id"], $_ClientsDetails["currency"]["id"]);
            if (!$d["defaultcredit"]) {
                $d["defaultcredit"] = round($d["credit"] * $_ClientsDetails["currency"]["rate"], $precision);
            }
            if ($d["active"]) {
                if ($vals = getFilePrice($d["id"], $_ClientsDetails["currency"]["id"])) {
                    $d["credit"] = $vals;
                } else {
                    $d["credit"] = round($d["credit"] * $_ClientsDetails["currency"]["rate"], $precision);
                }
                $d["discount"] = getDiscountFile($d["id"], $uid);
                $d["cartdiscount"] = 0;
                if ($config["happyhours"]) {
                    $happyhours = getFilehappyhours($d["id"]);
                    if ($d["promotiondis"] && $happyhours["promotiondis"]) {
                        $d["cartdiscount"] = round($d["promotiondis"] * $_ClientsDetails["currency"]["rate"], $precision);
                        if (0 < $d["cartdiscount"]) {
                            $promotion_found = true;
                        }
                    }
                }
                if (!$d["discount"] && $config["happyhours"]) {
                    $happyhours = getFilehappyhours($d["id"]);
                    if ($d["promotiondis"] && $happyhours["promotiondis"]) {
                        $d["discount"] = round($d["promotiondis"] * $_ClientsDetails["currency"]["rate"], $precision);
                    }
                }
                if (getsubscribestatus($uid, $d["id"], "tbl_services_file")) {
                    $d["credit"] = 0;
                    $d["discount"] = 0;
                    $d["cartdiscount"] = 0;
                    $d["subscription"] = true;
                }
            } else {
                if ($dsrs = getFilePrice($d["id"], $_SESSION["currency"]["id"])) {
                    $d["credit"] = $dsrs;
                } else {
                    $d["credit"] = round($d["credit"] * $_SESSION["currency"]["rate"], $precision);
                }
                if ($config["happyhours"]) {
                    $happyhours = getFilehappyhours($d["id"]);
                    if ($d["promotiondis"] && $happyhours["promotiondis"]) {
                        $d["discount"] = round($d["promotiondis"] * $_SESSION["currency"]["rate"], $precision);
                    }
                }
                $d["cartdiscount"] = $d["discount"];
            }
            $new = $d["credit"] - $d["discount"];
            if ($d["defaultcredit"] != 0) {
                $disc = 100 * ($d["defaultcredit"] - $new) / $d["defaultcredit"];
            }
            $d["disc"] = round($disc, $precision);
            $servlist[$row["group_name"]][$d["id"]] = $d;
        }
    }
    return $servlist;
}
function getALLServerServices()
{
    global $config;
    global $db;
    global $precision;
    require_once ROOTDIR . "/includes/serverservices.fun.php";
    global $_ClientsDetails;
    $uid = $_SESSION["uid"];
    $sql = dquery("select * from tbl_server_group");
    while ($row = mysqli_fetch_assoc($sql)) {
        $s = dquery("select service_name,credit,id,active from tbl_server_log where group_id='" . $row["id"] . "' and active<2");
        while ($d = mysqli_fetch_assoc($s)) {
            $d["defaultcredit"] = getServerPrice($d["id"], $_ClientsDetails["currency"]["id"]);
            if (!$d["defaultcredit"]) {
                $d["defaultcredit"] = round($d["credit"] * $_ClientsDetails["currency"]["rate"], $precision);
            }
            if ($d["active"]) {
                if ($vals = getServerPrice($d["id"], $_ClientsDetails["currency"]["id"])) {
                    $d["credit"] = $vals;
                } else {
                    $d["credit"] = round($d["credit"] * $_ClientsDetails["currency"]["rate"], $precision);
                }
                $d["discount"] = getDiscountServer($d["id"], $uid);
                $d["cartdiscount"] = 0;
                if ($config["happyhours"]) {
                    $happyhours = getServerhappyhours($d["id"]);
                    if ($d["promotiondis"] && $happyhours["promotiondis"]) {
                        $d["cartdiscount"] = round($d["promotiondis"] * $_ClientsDetails["currency"]["rate"], $precision);
                        if (0 < $d["cartdiscount"]) {
                            $promotion_found = true;
                        }
                    }
                }
                if (!$d["discount"] && $config["happyhours"]) {
                    $happyhours = getServerhappyhours($d["id"]);
                    if ($d["promotiondis"] && $happyhours["promotiondis"]) {
                        $d["discount"] = round($d["promotiondis"] * $_ClientsDetails["currency"]["rate"], $precision);
                    }
                }
                if (getsubscribestatus($uid, $d["id"], "tbl_server_log")) {
                    $d["credit"] = 0;
                    $d["discount"] = 0;
                    $d["cartdiscount"] = 0;
                    $d["subscription"] = true;
                }
            } else {
                if ($dsrs = getServerPrice($d["id"], $_SESSION["currency"]["id"])) {
                    $d["credit"] = $dsrs;
                } else {
                    $d["credit"] = round($d["credit"] * $_SESSION["currency"]["rate"], $precision);
                }
                if ($config["happyhours"]) {
                    $happyhours = getServerhappyhours($d["id"]);
                    if ($d["promotiondis"] && $happyhours["promotiondis"]) {
                        $d["discount"] = round($d["promotiondis"] * $_SESSION["currency"]["rate"], $precision);
                    }
                }
                $d["cartdiscount"] = $d["discount"];
            }
            $new = $d["credit"] - $d["discount"];
            if ($d["defaultcredit"] != 0) {
                $disc = 100 * ($d["defaultcredit"] - $new) / $d["defaultcredit"];
            }
            $d["disc"] = round($disc, $precision);
            $servlist[$row["group_name"]][$d["id"]] = $d;
        }
    }
    return $servlist;
}
function compareArr($arr1, $arr2)
{
    foreach ($arr1 as $k => $v) {
        if ($arr1[$k] != $arr2[$k] && $v != 0 && $v != 1 && $v != 2) {
            $arr[$k] = $arr2[$k] . " => " . $v;
        }
    }
    return $arr;
}
function check_token()
{
    if (ADMIN) {
        if ($_REQUEST["token"] != generate_token("plain")) {
            return false;
        }
    } else {
        global $lng_languag;
        if ($_REQUEST["token"] != generate_token("plain")) {
            exit($lng_languag["invalidtoken"]);
        }
    }
    return true;
}
function generatePW($password = "", $len)
{
    if (!$password) {
        $seeds = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        $seeds_count = strlen($seeds) - 1;
        for ($i = 0; $i < $len; $i++) {
            $password .= $seeds[rand(0, $seeds_count)];
        }
    }
    $pw["password"] = md5($password);
    $pw["txt"] = $password;
    return $pw;
}
function createP($password = "", $len)
{
    if (!$password) {
        $seeds = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        $seeds_count = strlen($seeds) - 1;
        for ($i = 0; $i < $len; $i++) {
            $password .= $seeds[rand(0, $seeds_count)];
        }
    }
    return $password;
}
function getCurrency2($selected = "", $fieldname = "country", $onlysingle = false)
{
    global $lng_languag;
    global $config;
    if ($onlysingle) {
        $cur = mysqli_fetch_assoc(dquery("select * from \n        tbl_currencies where id='" . $onlysingle . "'"));
        $dropdowncode = "<input type=\"hidden\" name=\"" . $fieldname . "\" \n        value=\"" . $cur["id"] . "\" />" . $lng_languag["user"] . " " . $lng_languag["currency"] . ": <strong>" . $cur["code"] . "</strong>";
    } else {
        $dropdowncode = "<select class=\"form-control\" name=\"" . $fieldname . "\">";
        $sql = dquery("SELECT * FROM `tbl_currencies`");
        while ($row = mysqli_fetch_assoc($sql)) {
            if ($selected == $row["id"]) {
                $isselected = "selected";
            } else {
                $isselected = "";
            }
            $dropdowncode .= "<option value='" . $row["id"] . "' " . $isselected . " >" . $row["code"] . "</option>";
        }
        $dropdowncode .= "</select>";
    }
    return $dropdowncode;
}
function getCountriesDropDown($selected = "", $fieldname = "country", $configdefault = true, $select = "", $class = "")
{
    global $lng_languag;
    global $LNG;
    require ROOTDIR . "/includes/countries.php";
    global $config;
    if ($selected == "" && $configdefault) {
        $selected = $config["DefaultCountry"];
    }
    $dropdowncode = "<select class=\"form-control chosen " . $class . "\" name=\"" . $fieldname . "\">";
    if ($select) {
        $dropdowncode .= "<option value=\"\">" . $select . "</option>";
    } else {
        $dropdowncode .= "<option value=\"\">" . $lng_languag["select"] . $LNG["select"] . "</option>";
    }
    foreach ($countries as $countriesvalue1 => $countriesvalue2) {
        $dropdowncode .= "<option value=\"" . $countriesvalue1 . "\"";
        if ($countriesvalue1 == $selected) {
            $dropdowncode .= " selected=\"selected\"";
        }
        $dropdowncode .= ">" . $countriesvalue2 . "</option>";
    }
    $dropdowncode .= "</select>";
    return $dropdowncode;
}
function getSecurityQuestion($selected = "", $fieldname = "question")
{
    global $config;
    global $db;
    $dropdowncode = "<select class=\"form-control\" name=\"" . $fieldname . "\">";
    $sql = dquery("SELECT * FROM `tbl_security_question`");
    while ($row = mysqli_fetch_assoc($sql)) {
        if ($selected == $row["id"]) {
            $isselected = "selected";
        } else {
            $isselected = "";
        }
        $dropdowncode .= "<option value='" . $row["id"] . "' " . $isselected . " >" . $row["question"] . "</option>";
    }
    $dropdowncode .= "</select>";
    return $dropdowncode;
}
function getMyMailTemplate($id)
{
    global $config;
    global $db;
    if (!$id) {
        $id = $_SESSION["uid"];
    }
    $mailtype["imeiorder"] = "IMEI Order";
    $mailtype["fileorder"] = "File Order";
    $mailtype["serverorder"] = "Server Order";
    $mailtype["remoteorder"] = "Remote Order";
    $mailtype["shoporder"] = "Shop Order";
    $mailtype["priceupdate"] = "Price Update";
    foreach ($mailtype as $type => $name) {
        $cnt = mysqli_num_rows(dquery("select id from tbl_disabledemail where uid='" . $id . "' and\n    \tmailtype='" . $type . "'"));
        $row["name"] = $name;
        if ($cnt) {
            $row["flag"] = 0;
        } else {
            $row["flag"] = 1;
        }
        $maillist[$type] = $row;
    }
    return $maillist;
}
function addStatementuser($uid = "", $description, $type, $amount, $relid, $service = "", $sell = 0, $admin_note = "", $user_note = "", $transfer = 0)
{
    global $db;
    global $remote_ip;
    global $precision;
    if (!$uid) {
        $uid = $_SESSION["uid"];
    }
    if ($_SESSION["adminid"] && ADMIN == "1") {
        $insData["adminid"] = $_SESSION["adminid"];
    }
    $insData["uid"] = $uid;
    $insData["date"] = date("Y-m-d");
    $insData["time"] = time();
    $insData["description"] = $description;
    $insData["type"] = $type;
    $insData["amount"] = $amount;
    $insData["relid"] = $relid;
    $insData["stype"] = $service;
    $insData["user_note"] = $user_note;
    if ($service == "Transfer") {
        $Detail["fee"] = $transfer;
        $Detail["paidto"] = $_SESSION["merchantname"];
        $Detail["paidfrom"] = $_SESSION["fullname"];
        $Detail["item"] = $_SESSION["merchantitem"];
        $Detail["custom"] = $_SESSION["merchantcustomid"];
        $Detail["merchant"] = $_SESSION["merchantkey"];
        $insData["data"] = json_encode($Detail);
    }
    $u = mysqli_fetch_assoc(dquery("select credit_left from\n     tblUsers where id='" . $uid . "'"));
    $insData["balance"] = round($u["credit_left"], $precision);
    if ($admin_note) {
        $insData["admin_note"] = $admin_note;
    }
    $insData["ip"] = $remote_ip;
    $insData["transferfee"] = $transfer;
    if ($sell) {
        $insData["sell_credit"] = 1;
    }
    $sid = $db->insert("tbl_statement_user", $insData);
    return $sid;
}
function generatePaginate($query, $service = "", $paging = false)
{
    global $pagelimit;
    global $tempalte_ver;
    global $page;
    global $requesturl;
    global $config;
    global $templates;
    if ($_SESSION["template"] != "default") {
        return generatePaginate2($query, $service, $paging);
    }
    $requesturl1 = NULL;
    $requesturl1 = str_replace("next", "nx", $config["site_address"] . $requesturl);
    $requesturl1 = str_replace("page", "px", $requesturl1);
    $requesturl1 = str_replace("pxlimit", "pagelimit", $requesturl1);
    $query = explode("LIMIT", $query);
    if (stripos($query[0], "tbl_order_imei") !== false) {
        $total = mysqli_num_rows(dquery($query[0] . " LIMIT 500"));
    } else {
        $total = mysqli_num_rows(dquery($query[0]));
    }
    $pages = ceil($total / $pagelimit);
    if (5 < $pages) {
        $pages = $pages - 1;
    }
    $_page_limit = 0;
    $next_page = $page - 1;
    if ($page != 1) {
    }
    $front = false;
    $lastd = false;
    $lastpos = $pages;
    if (5 < $pages) {
        if ($page) {
            if ($page < 4) {
                $j = 1;
            } else {
                if ($lastpos < $page + 2) {
                    $j = $lastpos - 4;
                } else {
                    $j = $page - 2;
                }
            }
        } else {
            $j = 1;
        }
        $pages = $j + 4;
    } else {
        $j = 1;
    }
    if ($j != 1) {
        $front = true;
    }
    if ($page + 2 < $lastpos && 5 < $lastpos) {
        $lastd = true;
    }
    $requestnew = $config["site_address"] . ltrim($_SERVER["REQUEST_URI"], "/");
    if (dContain($requestnew, "?")) {
        $requestnew .= "&";
    } else {
        $requestnew .= "?";
    }
    foreach ($_GET as $k => $v) {
        $requestnew .= $k . "=" . $v . "&";
    }
    for ($i = $j; $i <= $pages; $i++) {
        if ($page != $i) {
            $link = "href='" . $requesturl1 . "&next=" . $_page_limit . "&page=" . $i . "' ";
        } else {
            $class = "active";
        }
        $buf .= "<li   class='page-item' ><a class='page-link' " . $link . ">" . $i . "</a></li>";
        $link = $class = NULL;
        $_page_limit = $_page_limit + $pagelimit;
    }
    $next_page = $page + 1;
    $last = $pages;
    if ($page != $pages) {
    }
    if ($front) {
        $grs = explode("/", $_SERVER["REQUEST_URI"]);
        if (stripos(end($grs), "?") !== false) {
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        } else {
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        }
        $buf = "<li class='page-item'><a class='page-link' href='" . $requestnew . "&" . $_page_limit . "&page=1' >Previous</a></li> <li class='page-item'> <a class='page-link' href='" . $requestnew . "&" . $_page_limit . "&page=" . ($page - 1 < 1 ? 1 : $page - 1) . "' >&laquo;</a></li>" . $buf;
    }
    if ($lastd) {
        $grs = explode("/", $_SERVER["REQUEST_URI"]);
        if (stripos(end($grs), "?") !== false) {
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        } else {
            if (!$page) {
                $page = 1;
            }
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        }
        $buf = $buf . "<li class='page-item'><a class='page-link' href='" . $requesturl1 . "' >&raquo;</a></li> <li class='page-item'><a class='page-link' href='" . $requestnew . "&" . $_page_limit . "&page=" . $lastpos . "' >Next</a></li>";
    }
    if ($lastpos) {
        $sels = "<li class='page-item'><span class='page-link'> Jump to page :\n        <input style='width:50px !important;height:19px;text-align:center' type='number'\n        max='" . $lastpos . "' value='" . $page . "' data-d='bbc'\n        name='jump'  onkeyup='javascript: location.href=\"" . $requestnew . "&page=\"+this.value+\"&l=1\"' /> &nbsp;/&nbsp; " . $lastpos . "   </span></li>";
    }
    if ($buf) {
        $buf = $buf;
    } else {
        $buf = "";
    }
    if ($service == "products" && $paging && $total) {
        $tempalte_ver["paginate_products"] = $buf;
    }
    $tempalte_ver["paginate"] = $sels . " " . $buf . " ";
}
function generatePaginate2($query, $service = "", $paging = false)
{
    global $pagelimit;
    global $tempalte_ver;
    global $page;
    global $requesturl;
    global $config;
    global $userlimit;
    global $next;
    if (!$userlimit) {
        $userlimit = 500;
    }
    if (!$_SERVER["PHP_SELF"]) {
        $_SERVER["PHP_SELF"] = $_SERVER["REQUEST_URI"];
    }
    if ($config["cms_seofriendly"] == "on") {
        $requesturl1 = str_replace("next", "nx", $config["site_address"] . $requesturl);
    } else {
        $requesturl1 = str_replace("next", "nx", $config["site_address"] . $_SERVER["PHP_SELF"] . $requesturl);
    }
    $requesturl1 = str_replace("page", "px", $requesturl1);
    $requesturl1 = str_replace("pxlimit", "pagelimit", $requesturl1);
    $query = explode("LIMIT", $query);
    if (stripos($query[0], "tbl_order_imei") !== false) {
        $total = mysqli_num_rows(dquery($query[0] . " LIMIT " . $userlimit));
    } else {
        if (stripos($query[0], "tbl_statement_user") !== false) {
            $query[0] = str_replace("*", "id", $query[0]);
            $total = mysqli_num_rows(dquery($query[0]));
        } else {
            $total = mysqli_num_rows(dquery($query[0]));
        }
    }
    $pages = ceil($total / $pagelimit);
    if (5 < $pages) {
        $pages = $pages - 1;
    }
    $_page_limit = 0;
    $next_page = $page - 1;
    if ($page != 1) {
    }
    $front = false;
    $lastd = false;
    $lastpos = $pages;
    if (5 < $pages) {
        if ($page) {
            if ($page < 4) {
                $j = 1;
            } else {
                if ($lastpos < $page + 2) {
                    $j = $lastpos - 4;
                } else {
                    $j = $page - 2;
                }
            }
        } else {
            $j = 1;
        }
        $pages = $j + 4;
    } else {
        $j = 1;
    }
    if ($j != 1) {
        $front = true;
    }
    if ($page + 2 < $lastpos && 5 < $lastpos) {
        $lastd = true;
    }
    $requestnew = $config["site_address"] . $_SERVER["REQUEST_URI"];
    $requestnew .= "?";
    foreach ($_GET as $k => $v) {
        $requestnew .= $k . "=" . $v . "&";
    }
    for ($i = $j; $i <= $pages; $i++) {
        if ($page != $i) {
            $link = "href='" . $requesturl1 . "&next=" . ($i * $config["default_page_limit"] - $config["default_page_limit"]) . "&page=" . $i . "' ";
        } else {
            $class = "class='active'";
        }
        $buf .= "<li  " . $class . " style='float:left;'><a " . $link . ">" . $i . "</a></li>";
        $link = $class = NULL;
        $_page_limit = $_page_limit + $pagelimit;
    }
    $next_page = $page + 1;
    $last = $pages;
    if ($page != $pages) {
    }
    if ($front) {
        $grs = explode("/", $_SERVER["REQUEST_URI"]);
        if (stripos(end($grs), "?") !== false) {
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        } else {
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        }
        $buf = "<li style='float:left'><a href='" . $requestnew . "&" . $_page_limit . "&page=1' >|&laquo;</a></li> <li style='float:left;'> <a href='" . $requestnew . "&" . $_page_limit . "&page=" . ($page - 1 < 1 ? 1 : $page - 1) . "' >&laquo;</a></li>" . $buf;
    }
    if ($lastd) {
        $grs = explode("/", $_SERVER["REQUEST_URI"]);
        if (stripos(end($grs), "?") !== false) {
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        } else {
            if (!$page) {
                $page = 1;
            }
            $requesturl1 = $requestnew . "&page=" . ($page + 1) . "&l=1";
        }
        $buf = $buf . "<li style='float:left'><a href='" . $requesturl1 . "' >&raquo;</a></li> <li style='float:left;'><a href='" . $requestnew . "&page=" . $lastpos . "&next=" . $lastpos * $pagelimit . "' >&raquo;|</a></li>";
    }
    if ($lastpos) {
        $requestnew = ltrim($requestnew, "/");
        $sels = "<div class='pages-dropdown' style='float:left'>Jump to page :\n        <input style='width:50px !important;' type='number'\n        max='" . $lastpos . "' value='" . $page . "'\n        name='jump' onkeyup='javascript: location.href=\"" . $requestnew . "&page=\"+this.value+\"&l=1\"' /> &nbsp;/&nbsp; " . $lastpos . " </div>";
    }
    if ($buf) {
        $buf = $buf;
    } else {
        $buf = "";
    }
    if ($service == "products" && $paging && $total) {
        $tempalte_ver["paginate_products"] = $buf;
    }
    $tempalte_ver["paginate"] = $sels . "<ul style=\"float:right;list-style:none;\">" . $buf . "</ul>\n   <div class=\"clearfix\"></div>";
}
function getLanguageDropdown2($selected = "", $fieldname = "language", $class = "")
{
    global $config;
    global $languagedirectorypath;
    if ($selected == "") {
        $selected = $config["language"];
    }
    $dropdowncode = "<select class=\"form-control " . $class . "\" name=\"" . $fieldname . "\">";
    $dh = opendir(ROOTDIR . "/" . $languagedirectorypath . "/");
    while (false !== ($file2 = readdir($dh))) {
        if (!is_dir(ROOTDIR . "" . "/" . $languagedirectorypath . "/" . $file2)) {
            $pieces = explode(".", $file2);
            if ($pieces[1] == "txt") {
                $piece = $pieces[0];
                $dropdowncode .= "<option value=\"" . $piece . "\"";
                if ($piece == $selected) {
                    $dropdowncode .= " selected=\"selected\"";
                }
                $dropdowncode .= ">" . $piece . "</option>";
            }
        }
    }
    closedir($dh);
    $dropdowncode .= "</select>";
    return $dropdowncode;
}
function getTemplatesDropDown($selected = "", $fieldname = "template", $getresellertemplate = false, $selectdefault = true)
{
    global $config;
    if ($selected == "" && $selectdefault) {
        $selected = $config["template"];
    }
    $dropdowncode = "<select class=\"form-control\" name=\"" . $fieldname . "\">";
    $dropdowncode .= "<option value=''>-Select-</option>";
    $dh = opendir(ROOTDIR . "/templates/");
    while (false !== ($file2 = readdir($dh))) {
        if (is_dir(ROOTDIR . "/templates/" . $file2) && $file2 != "." && $file2 != "..") {
            $get = explode("_", $file2);
            if ($get[0] == "store") {
                $file3 = $get[1];
            } else {
                $file3 = $file2;
            }
            if ($get[0] == "store" && $getresellertemplate) {
                $dropdowncode .= "<option value=\"" . $file2 . "\"";
                if ($file2 == $selected) {
                    $dropdowncode .= " selected=\"selected\"";
                }
                $dropdowncode .= ">" . $file3 . "</option>";
            } else {
                if ($get[0] != "store" && !$getresellertemplate) {
                    $dropdowncode .= "<option value=\"" . $file2 . "\"";
                    if ($file2 == $selected) {
                        $dropdowncode .= " selected=\"selected\"";
                    }
                    $dropdowncode .= ">" . $file3 . "</option>";
                }
            }
        }
    }
    closedir($dh);
    $dropdowncode .= "</select>";
    return $dropdowncode;
}
function saveStoreConfig($uid, $fields)
{
    global $config;
    global $lng_languag;
    if (is_array($fields)) {
        foreach ($fields as $id => $value) {
            $value = nl2br($value);
            if ($id == "adminsignature") {
                $value = htmlspecialchars(strip_tags(html_entity_decode($value)));
            }
            if ($id == "site_address" && (!preg_match("/(http):\\/\\/+[a-zA-Z0-9-\\.\\_\\/]+(\\/)\$/", $value) || stripos($config["site_address"], $value) !== false)) {
                return "Wrong store url";
            }
            if ($id == "config_ssl_allow" && $value != "" && (!preg_match("/(https):\\/\\/+[a-zA-Z0-9-\\.\\_\\/]+(\\/)\$/", $value) || stripos($config["site_address"], $value) !== false)) {
                return "Wrong store SSL url";
            }
            if ($id == "domain") {
                if (stripos($config["site_address"], $value) !== false) {
                    return "Domain name should not be Site Address";
                }
                if (!preg_match("#^([a-z0-9]([-a-z0-9]*)?\\.)+([a-z]+)\$#i", $value)) {
                    return "Domain Invalid";
                }
                $value = strtolower($value);
                $value = str_replace("http:", "", $value);
                $value = str_replace("/", "", $value);
            }
            if ($id == "paypaltax" && $value != "" && !is_numeric($value)) {
                return "Paypal tax should be numeric only";
            }
            if ($id == "config_admin_mail" && !preg_match("/^([a-zA-Z0-9])+([\\.a-zA-Z0-9+_-])*@([a-zA-Z0-9_-])+(\\.[a-zA-Z0-9_-]+)*\\.([a-zA-Z]{2,6})\$/", $value)) {
                return $lng_languag["clientareaerroremailinvalid"];
            }
            $result = dquery("SELECT * from `tbl_store_config` WHERE `attribute`='" . $id . "' AND `uid`='" . $uid . "'");
            $num_rows = mysqli_num_rows($result);
            if ($num_rows == "0") {
                insert_query("tbl_store_config", ["attribute" => $id, "uid" => $uid, "value" => $value]);
            } else {
                update_query("tbl_store_config", ["value" => $value], ["attribute" => $id, "uid" => $uid]);
            }
        }
    }
    return false;
}
function displayNew($v, $r)
{
    global $config;
    if ($config["version"] == $v && $config["release_candidate"] == $r) {
        echo "<span class=\"new-u\" title=\"New in " . $config["release_candidate"] . "\">new</span>";
    }
}

?>