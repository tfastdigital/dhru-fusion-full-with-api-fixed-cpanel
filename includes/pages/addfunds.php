<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "./comm.php";
if ($_GET["accesskey"] || $_POST["accesskey"]) {
    if ($_GET["accesskey"]) {
        $accesskey = $_GET["accesskey"];
    } else {
        if ($_POST["accesskey"]) {
            $accesskey = $_POST["accesskey"];
        }
    }
    $key = base64_decode($accesskey);
    $creditials = explode("===", $key);
    $tempalte_ver["application"] = true;
    $tempalte_ver["accesskey"] = $accesskey;
    $tempalte_ver["id"] = $accesskey;
    $username = descape($creditials[0]);
    $password = $creditials[1];
    $result = dquery("SELECT * FROM `tblUsers` WHERE (`username`='" . $username . "' or `email`='" . $username . "')");
    $data = mysqli_fetch_assoc($result);
    if ($data["id"]) {
        $validIp[] = $data["ip_range1"];
        $validIp[] = $data["ip_range2"];
        $validIp[] = $data["ip_range3"];
        $validIp[] = $data["ip_range4"];
        $validIp[] = $data["ip_range5"];
        if (trim($data["tmp_password"]) == md5($password) && $data["tmp_pass_time"] + 3600 < time()) {
            $err_output .= "<li>" . $lng_languag["passexipred"] . "</li>";
        } else {
            if ($data["password"] != md5(md5($password) . "9486") && trim($data["tmp_password"]) != md5($password) && !$_SESSION["adminid"]) {
                $err_output .= "<li>" . $lng_languag["passnotmatch"] . "</li>";
                dquery("UPDATE `tblUsers` SET `login_failed_atoms`=login_failed_atoms+1 \n                                                WHERE `id`= '" . $data["id"] . "'");
                $mail_ver["blockreson"] = "Automatically block (" . $config["MaxLoginFailedAttempts"] . " failed login attempts) from IP -" . $remote_ip;
                $config["MaxLoginFailedAttempts"] = $config["MaxLoginFailedAttempts"] - 1;
                $login_attempts = mysqli_fetch_assoc(dquery("SELECT `login_failed_atoms` FROM `tblUsers` WHERE `id`='" . $data["id"] . "' AND `login_failed_atoms` > '" . $config["MaxLoginFailedAttempts"] . "' "));
                if ($login_attempts) {
                    dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`=1,`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $data["id"] . "' ");
                    if (!isWhiteIP($remote_ip)) {
                        blockIP($remote_ip, $mail_ver["blockreson"], 15);
                    }
                    require_once ROOTDIR . "/includes/mail.fun.php";
                    sendMail(5, $data["id"], "", $mail_ver);
                }
            } else {
                if ($data["userstatus"] != "0" && !$_SESSION["adminid"]) {
                    if ($data["canactive"] && $config["smsgateway"]) {
                        $_SESSION["CANACTIVE"] = true;
                        $varac = "<br />To active your account<strong><a href='" . _url("./activeuser") . "'> click here</a></strong>";
                    }
                    $err_output .= "<li>" . $lng_languag["accoutnotact"] . " " . $data["block_reason"] . $varac . " </li>";
                } else {
                    $ipvalidation = false;
                    if ($data["ip_range"]) {
                        $ipvalidation = checkIPinList($data["ip_range"], $remote_ip);
                    } else {
                        $ipvalidation = true;
                    }
                    if ($ipvalidation) {
                        include_once ROOTDIR . "/includes/geo.fun.php";
                        $login_country_code = ipToCountry($remote_ip);
                        $login_country = $login_country_code;
                        if ($data["login_country"]) {
                            if ($data["country"] != $login_country_code && !$development && trim($data["tmp_password"]) != md5($password)) {
                                $mail_ver["loginip"] = $remote_ip;
                                $mail_ver["logincountry"] = $login_country;
                                $mail_ver["logincountrycode"] = $login_country_code;
                                require_once ROOTDIR . "/includes/mail.fun.php";
                                sendMail(51, $data["id"], "", $mail_ver);
                                if ($config["block_ac_on_country_mismatch"] && !isWhiteIP($remote_ip)) {
                                    $mail_ver["blockreson"] = "Login from " . $login_country . "(" . $login_country_code . ") " . $remote_ip;
                                    dquery("UPDATE `tblUsers` SET `block_reason`='" . $mail_ver["blockreson"] . "',`canactive`='1',`userstatus`='1',`login_failed_atoms`='0' WHERE `id`='" . $data["id"] . "' ");
                                    blockIP($remote_ip, $mail_ver["blockreson"], 15);
                                    sendMail(5, $data["id"], "", $mail_ver);
                                    $block_accout = true;
                                }
                            }
                        } else {
                            $_addd_to_update = " , `login_country`='" . $login_country_code . "'";
                        }
                        geoip_close($gi);
                        $lastlogin = time();
                        $encdata = md5($_SERVER["HTTP_USER_AGENT"] . $remote_ip);
                        $session = session_id();
                        $time = time();
                        dquery("UPDATE `tblUsers` SET `enc_login`= '" . $encdata . "',`last_login`='" . $lastlogin . "',`last_login_ip`='" . $remote_ip . "',`current_session_id`='" . $session . "',\n                    `current_login_time`='" . $time . "',`online_status`='1' " . $_addd_to_update . ",`login_failed_atoms`='0'\n                    WHERE `id`= '" . $data["id"] . "' ");
                        $ins = NULL;
                        $ins["username"] = $username;
                        $ins["userid"] = $data["id"];
                        $ins["ip"] = $remote_ip;
                        $ins["time"] = time();
                        $db->insert("tbl_loginlog_user", $ins);
                        $ins = NULL;
                        if ($rememberme) {
                            setcookie("GSMBACKBASEUID", $username, time() + 31536000);
                            setcookie("GSMBACKBASEPW", $password, time() + 31536000);
                        }
                        if (!$block_accout) {
                            $_SESSION["uid"] = $data["id"];
                            $_SESSION["username"] = $data["username"];
                            $_SESSION["fullname"] = $data["first_name"] . " " . $data["last_name"];
                            dquery("DELETE FROM `tbl_chat_visitor` \n                        WHERE `username`= '" . $_SESSION["user_livechat_username"] . "'");
                            $_SESSION["user_livechat_username"] = $data["username"];
                            $_SESSION["USERLANG"] = $data["language"];
                            $_SESSION["currency"] = $data["default_currency"];
                            $_SESSION["shippingzip"] = $data["zip"];
                            $_SESSION["shippingstate"] = $data["state"];
                            $_SESSION["shippingcountry"] = $data["country"];
                            if ($config["afterlogin_apply"] && $config["template_afterlogin"] != "") {
                                $_SESSION["template"] = $config["template_afterlogin"];
                            } else {
                                if ($data["default_theme"]) {
                                    $_SESSION["template"] = $data["default_theme"];
                                } else {
                                    $_SESSION["template"] = $config["template_afterlogin"];
                                }
                            }
                            $_SESSION["encdata"] = $encdata;
                        }
                        $_SESSION["last_login"] = $data["last_login"] . "," . $data["last_login_ip"];
                        $days = $data["lastpassreset"] + $config["password_expired"] * 86400;
                        if ($days < time() && 0 < $config["password_expired"] && !$_SESSION["CART"]) {
                            $_SESSION["afterloginredirect"] = _url("./settings/action/password/msg/1");
                        }
                        if ($_SESSION["afterloginredirect"]) {
                            if (stripos($_SESSION["afterloginredirect"], "http") !== false) {
                                $ste_addr = str_replace("http://", "", $_SESSION["afterloginredirect"]);
                                $succ_output .= "redirectto: " . $ste_addr;
                            } else {
                                $succ_output .= "redirect: " . $_SESSION["afterloginredirect"];
                            }
                            unset($_SESSION["afterloginredirect"]);
                        } else {
                            $succ_output .= "redirect:main.php?lgin=success" . $lastlogin;
                        }
                    } else {
                        $_SESSION["validIp"] = $_SESSION["validIp"] + 1;
                        if (2 < $_SESSION["validIp"]) {
                            dquery("UPDATE `tblUsers` SET `block_reason`='Automatically block (login tried from IP-" . $remote_ip . ")',`userstatus`='1' WHERE `id`='" . $data["id"] . "'");
                            unset($_SESSION["validIp"]);
                        }
                        $err_output .= "<li>" . $lng_languag["ipnotmatch"] . " (" . $remote_ip . ")</li>";
                    }
                }
            }
        }
    } else {
        $err_output .= "<li>" . $lng_languag["userincorrect"] . "</li>";
    }
}
require ROOTDIR . "/includes/fun.inc.php";
require ROOTDIR . "/includes/client.area.inc.php";
$bid = mysqli_fetch_assoc(dquery("select id from tbl_currencies where `default`='1'"));
if (isset($_SESSION["uid"])) {
    if (isset($_SESSION["fromapp"])) {
        $tempalte_ver["fromapp"] = 1;
        $tempalte_ver["standalone"] = true;
    }
    if ($standalone) {
        $tempalte_ver["standalone"] = true;
    }
    if ($paymentmethod && !mysqli_num_rows(dquery("select * from tbl_paymentgateways\n        where gateway='" . $paymentmethod . "'"))) {
        exit("Something Wrong #81281");
    }
    $gatewaywise = json_decode($config["otherfundlimit"], true);
    $currentpage = "settings";
    if ($_SESSION["template"] == "wallet") {
        $pagetitle = $lng_languag["rechargewallet"];
        $_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
        $_nav .= "<a href=\"" . _url("addfunds") . "\">" . $lng_languag["rechargewallet"] . "</a>";
    } else {
        $pagetitle = $lng_languag["addfund"];
        $_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
        $_nav .= "<a href=\"" . _url("addfunds") . "\">" . $lng_languag["addfund"] . "</a>";
    }
    $templatefile = "client_addfunds";
    $pageicon = "";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
    $smarty->assign("directfundlink", _url("widget/save/settings/getdirectinfo/"));
    $smarty->assign("directfundsave", _url("widget/save/directtxn/"));
    $smarty->assign("directfundresend", _url("widget/save/directtxn/resend/1"));
    if (0 < $gatewaywise[$paymentmethod]["maxlimit"]) {
        $config["AddFundsMaximum"] = $gatewaywise[$paymentmethod]["maxlimit"];
    }
    if (0 < $gatewaywise[$paymentmethod]["minlimit"]) {
        $config["AddFundsMinimum"] = $gatewaywise[$paymentmethod]["minlimit"];
    }
    if (0 < $config["gatewayminlimit" . $paymentmethod]) {
        $config["AddFundsMinimum"] = $config["gatewayminlimit" . $paymentmethod];
    }
    if (0 < $config["gatewaymaxlimit" . $paymentmethod]) {
        $config["AddFundsMaximum"] = $config["gatewaymaxlimit" . $paymentmethod];
    }
    $user = mysqli_fetch_assoc(dquery("select minaddfund,maxaddfund,(select minaddfund \n    from tbl_client_group where id=client_group) as groupminfund ,\n    (select maxaddfund from tbl_client_group where id=client_group) as groupmaxfund\n    from tblUsers where id='" . $_SESSION["uid"] . "'"));
    if (0 < $user["groupmaxfund"] && 0 < $user["groupminfund"]) {
        $config["AddFundsMinimum"] = $user["groupminfund"];
        $config["AddFundsMaximum"] = $user["groupmaxfund"];
    }
    if (0 < $user["maxaddfund"] && 0 < $user["minaddfund"]) {
        $config["AddFundsMinimum"] = $user["minaddfund"];
        $config["AddFundsMaximum"] = $user["maxaddfund"];
    }
    $min = convertCurrency($config["AddFundsMinimum"], $bid["id"], $_ClientsDetails["currency_id"]);
    $max = convertCurrency($config["AddFundsMaximum"], $bid["id"], $_ClientsDetails["currency_id"]);
    $maxbal = convertCurrency($config["AddFundsMaximumBalance"], $bid["id"], $_ClientsDetails["currency_id"]);
    if (!$config["addfund"]) {
        $tempalte_ver["notification"]["error"] = $lng_languag["pagedisabled"];
        output($templatefile);
        exit;
    }
    if (!$config["addfund"]) {
        $tempalte_ver["notification"]["error"] = $lng_languag["addfundsnotallowed"];
    } else {
        if ($amount) {
            $totalcredit = $_ClientsDetails["credit"]["credit"] + $amount;
            if ($maxbal < $totalcredit) {
                $errormessage = $lng_languag["addfundsmaximumbalanceerror"] . " " . formatCurrency($maxbal);
            }
            if ($max < $amount) {
                $errormessage = $lng_languag["addfundsmaximumerror"] . " " . formatCurrency($max);
            }
            if ($amount < $min) {
                $errormessage = $lng_languag["addfundsminimumerror"] . " " . formatCurrency($min);
            }
            if ($errormessage) {
                $tempalte_ver["notification"]["error"] = $errormessage;
            } else {
                $taxed = 0;
                if ($config["AddFunds_taxenabled"]) {
                    $taxed = 1;
                }
                dquery("DELETE from tbl_invoiceitems\n           where invoiceid='0' and userid='" . $_SESSION["uid"] . "'");
                insert_query("tbl_invoiceitems", ["userid" => $_SESSION["uid"], "type" => "AddFunds", "relid" => "", "description" => $lng_languag["addfund"], "amount" => $amount, "taxed" => $taxed, "duedate" => "now()", "paymentmethod" => $paymentmethod]);
                require_once ROOTDIR . "/includes/invoice.fun.php";
                $invoiceid = generateInvoice($_SESSION["uid"]);
                header("Location: " . _url("./viewinvoice/a/1/id/" . md5($invoiceid)));
                header("Location: " . _url("./viewinvoice/a/1/id/" . md5($invoiceid))) . "";
                echo "<script> location.href=";
                echo _url("viewinvoice/a/1/id/" . md5($invoiceid));
                echo "; </script>\n";
                exit;
            }
        } else {
            $amount = $config["AddFundsMinimum"];
        }
        if (!function_exists(getGateways)) {
            include_once ROOTDIR . "/includes/gateway.fun.php";
        }
        $allwoedgate = getGateways("", true);
        foreach ($allwoedgate as $k => $detail) {
            if (mysqli_num_rows(dquery("select gateway from tbl_paymentgateways\nwhere gateway='" . $detail["sysname"] . "' and setting='hideaddfund' and value=1"))) {
                unset($allwoedgate[$k]);
            }
        }
        if (count($allwoedgate) == 0) {
            $error["error"] = $lng_languag["gatewaynotallocated"];
            $smarty->assign("notification", $error);
            $smarty->assign("disable", 1);
        }
        $smarty->assign("gateways", $allwoedgate);
        $smarty->assign("minimumamount", formatCurrency($min));
        $smarty->assign("maximumamount", formatCurrency($max));
        $smarty->assign("maximumbalance", formatCurrency($maxbal));
        $smarty->assign("amount", $min);
        $gat = dquery("select value,gateway from tbl_paymentgateways where gateway like 'directpaypal%' and setting='payto'");
        while ($rg = mysqli_fetch_assoc($gat)) {
            if (!(mysqli_num_rows(dquery("select * from tbl_user_gateway\n            where userid='" . $_SESSION["uid"] . "'")) || mysqli_num_rows(dquery("select id from tblUsers \nwhere id='" . $_SESSION["uid"] . "' and customgateway=1"))) || mysqli_num_rows(dquery("select * from tbl_user_gateway\n                where userid='" . $_SESSION["uid"] . "' and payment='" . $rg["gateway"] . "'"))) {
                $DirectPaypal[$rg["gateway"]] = $rg["value"];
            }
        }
        $smarty->assign("directpaypal", $DirectPaypal);
    }
} else {
    include_once ROOTDIR . "/includes/login.inc.php";
    installclient($pagetitle, $pageicon, $breadcrumbnav);
}
$tempalte_ver["idverificationlink"] = _url("settings/idverification");
if (!$config["idverified"]) {
    $tempalte_ver["notification"]["error"] = $lng_languag["accountnotverifyid"];
}
$fileverioncheck = "6.1.0";
chkMd5sumsubpage();
if (isset($_SESSION["fromapp"]) || $standalone) {
    echo processSingleTemplate($templatefile);
    exit;
}
DisplayOutput($templatefile);
class no
{
}

?>