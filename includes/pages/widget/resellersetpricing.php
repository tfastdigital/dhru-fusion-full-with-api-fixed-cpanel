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
require ROOTDIR . "/includes/client.area.inc.php";
if (!isset($_SESSION["uid"])) {
    exit;
}
if ($actions) {
    $action = $actions;
}
$usersId = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $usersId);
if ($_SESSION["uid"]) {
    if ($action == "IMEI") {
        include_once ROOTDIR . "/includes/imeiservices.fun.php";
        $pagetitle = $lng_languag["imeiservice"];
        $_nav .= "<a href='" . _url("widget/resellersetpricing/actions/IMEI") . "' >" . $lng_languag["imeiservice"] . "</a> / ";
        $templatefile = "client_reseller_imeipricing";
        $pageicon = "";
        installclient($pagetitle, $pageicon, $breadcrumbnav);
        $usersId = descape($usersId);
        $serviceDetails = getIMEIServices("", "", $_SESSION["uid"], 1, "", $usersId, "", "", "", "", "", "", 958558);
        $tempalte_ver["imeiservicelist"] = $serviceDetails;
        $tempalte_ver["action_link"] = _url("widget/save/reseller/actions/imeipricing/usersId/" . $usersId);
        $tempalte_ver["action_link1"] = _url("widget/save/reseller/actions/resetiprice/usersId/" . $usersId);
        $tempalte_ver["token"] = generate_token("form");
    } else {
        if ($action == "file") {
            include_once ROOTDIR . "/includes/fileservices.fun.php";
            $pagetitle = $lng_languag["fileservice"];
            $_nav .= "<a href='" . _url("widget/resellersetpricing/actions/file") . "' >" . $lng_languag["fileservice"] . "</a> / ";
            $templatefile = "client_reseller_filepricing";
            $pageicon = "";
            installclient($pagetitle, $pageicon, $breadcrumbnav);
            $usersId = descape($usersId);
            $serviceDetails = getFileServices("", "", $_SESSION["uid"], "", "", $usersId, "", "", "", 9899998);
            $tempalte_ver["fileservicelist"] = $serviceDetails;
            $tempalte_ver["action_link"] = "includes/getdata/reseller.save.php?action=filepricing&usersId=" . $usersId;
            $tempalte_ver["action_link1"] = "includes/getdata/reseller.save.php?action=resetfprice&usersId=" . $usersId;
            $tempalte_ver["token"] = generate_token("form");
        } else {
            if ($action == "server") {
                include_once ROOTDIR . "/includes/imeiservices.fun.php";
                $pagetitle = $lng_languag["serverservice"];
                $_nav .= "<a href='" . _url("widget/resellersetpricing/actions/server") . "' >" . $lng_languag["serverservice"] . "</a> / ";
                $templatefile = "client_reseller_serverpricing";
                $pageicon = "";
                installclient($pagetitle, $pageicon, $breadcrumbnav);
                $usersId = descape($usersId);
                $serviceDetails = getIMEIServices("", "", $_SESSION["uid"], "", "", $usersId, "", "", "", "", "", "", 958558, "", "", "", "", "", "", "", 2);
                $tempalte_ver["serverservicelist"] = $serviceDetails;
                $tempalte_ver["action_link"] = "includes/getdata/reseller.save.php?action=serverpricing&usersId=" . $usersId;
                $tempalte_ver["action_link1"] = "includes/getdata/reseller.save.php?action=resetsprice&usersId=" . $usersId;
                $tempalte_ver["token"] = generate_token("form");
            } else {
                if ($action == "imeilist") {
                    include_once ROOTDIR . "/includes/imeiservices.fun.php";
                    $pagetitle = $lng_languag["imeiservice"];
                    $_nav .= "<a href='" . _url("widget/resellersetpricing/actions/IMEI") . "' >" . $lng_languag["imeiservice"] . "</a> / ";
                    $templatefile = "client_reseller_imeipricelist";
                    $pageicon = "";
                    installclient($pagetitle, $pageicon, $breadcrumbnav);
                    $serviceDetails = getIMEIServices("", "", $_SESSION["uid"], 1, "", "", "", "", "", "", "", "", 958558);
                    $tempalte_ver["imeiservicelist"] = $serviceDetails;
                    $serviceprice = 0;
                    foreach ($serviceDetails as $gid => $gdet) {
                        foreach ($gdet as $serviceid => $servicedetail) {
                            $tempalte_ver["calculated"][$servicedetail["newid"]] = $servicedetail["credit"] - $servicedetail["discount"];
                        }
                    }
                    $qc = dquery("select * from tbl_store_pricing \nwhere resellerid='" . $_SESSION["uid"] . "' and servicetype='imei'");
                    while ($rc = mysqli_fetch_assoc($qc)) {
                        $tempalte_ver["storeprice"][$rc["serviceid"]] = $rc;
                        if (0 < $rc["increase"]) {
                            $serviceprice = $tempalte_ver["calculated"][$rc["serviceid"]];
                            if ($rc["increaseby"] == "Percent") {
                                $serviceprice = $serviceprice + round($serviceprice * $rc["increase"] / 100, 2);
                            } else {
                                $serviceprice = $serviceprice + round($rc["increase"], 2);
                            }
                            $tempalte_ver["calculated"][$rc["serviceid"]] = $serviceprice;
                        }
                    }
                    $tempalte_ver["action_link"] = _url("widget/save/reseller/actions/imeipricelist");
                    $tempalte_ver["token"] = generate_token("form");
                } else {
                    if ($action == "filelist") {
                        include_once ROOTDIR . "/includes/fileservices.fun.php";
                        $pagetitle = $lng_languag["fileservice"];
                        $_nav .= "<a href='" . _url("widget/resellersetpricing/actions/file") . "' >" . $lng_languag["fileservice"] . "</a> / ";
                        $templatefile = "client_reseller_imeipricelist";
                        $pageicon = "";
                        installclient($pagetitle, $pageicon, $breadcrumbnav);
                        $serviceDetails = getFileServices("", "", $_SESSION["uid"], "", "", "", "", "", "", "", "", "", 958558);
                        $tempalte_ver["imeiservicelist"] = $serviceDetails;
                        $serviceprice = 0;
                        foreach ($serviceDetails as $gid => $gdet) {
                            foreach ($gdet as $serviceid => $servicedetail) {
                                $tempalte_ver["calculated"][$servicedetail["id"]] = $servicedetail["credit"] - $servicedetail["discount"];
                            }
                        }
                        $qc = dquery("select * from tbl_store_pricing \nwhere resellerid='" . $_SESSION["uid"] . "' and servicetype='file'");
                        while ($rc = mysqli_fetch_assoc($qc)) {
                            $tempalte_ver["storeprice"][$rc["serviceid"]] = $rc;
                            if (0 < $rc["increase"]) {
                                $serviceprice = $tempalte_ver["calculated"][$rc["serviceid"]];
                                if ($rc["increaseby"] == "Percent") {
                                    $serviceprice = $serviceprice + round($serviceprice * $rc["increase"] / 100, 2);
                                } else {
                                    $serviceprice = $serviceprice + round($rc["increase"], 2);
                                }
                                $tempalte_ver["calculated"][$rc["serviceid"]] = $serviceprice;
                            }
                        }
                        $tempalte_ver["action_link"] = _url("widget/save/reseller/actions/filepricelist");
                        $tempalte_ver["token"] = generate_token("form");
                        $tempalte_ver["filepersave"] = _url("widget/save/settings/actions/fileresellerincrease");
                    } else {
                        if ($action == "serverlist") {
                            include_once ROOTDIR . "/includes/imeiservices.fun.php";
                            $pagetitle = $lng_languag["fileservice"];
                            $_nav .= "<a href='" . _url("widget/resellersetpricing/actions/server") . "' >" . $lng_languag["serverservice"] . "</a> / ";
                            $templatefile = "client_reseller_imeipricelist";
                            $pageicon = "";
                            installclient($pagetitle, $pageicon, $breadcrumbnav);
                            $serviceDetails = getIMEIServices("", "", $_SESSION["uid"], 1, "", "", "", "", "", "", "", "", 958558, "", "", "", "", "", "", "", 1);
                            $tempalte_ver["imeiservicelist"] = $serviceDetails;
                            $serviceprice = 0;
                            foreach ($serviceDetails as $gid => $gdet) {
                                foreach ($gdet as $serviceid => $servicedetail) {
                                    $tempalte_ver["calculated"][$servicedetail["newid"]] = $servicedetail["credit"] - $servicedetail["discount"];
                                }
                            }
                            $qc = dquery("select * from tbl_store_pricing \nwhere resellerid='" . $_SESSION["uid"] . "' and servicetype='imei'");
                            while ($rc = mysqli_fetch_assoc($qc)) {
                                $tempalte_ver["storeprice"][$rc["serviceid"]] = $rc;
                                if (0 < $rc["increase"]) {
                                    $serviceprice = $tempalte_ver["calculated"][$rc["serviceid"]];
                                    if ($rc["increaseby"] == "Percent") {
                                        $serviceprice = $serviceprice + round($serviceprice * $rc["increase"] / 100, 2);
                                    } else {
                                        $serviceprice = $serviceprice + round($rc["increase"], 2);
                                    }
                                    $tempalte_ver["calculated"][$rc["serviceid"]] = $serviceprice;
                                }
                            }
                            $tempalte_ver["action_link"] = _url("widget/save/reseller/actions/serverpricelist");
                            $tempalte_ver["token"] = generate_token("form");
                            $tempalte_ver["serverpersave"] = _url("widget/save/settings/actions/serverresellerincrease");
                        } else {
                            if ($action == "remotelist") {
                                include_once ROOTDIR . "/includes/imeiservices.fun.php";
                                $pagetitle = $lng_languag["remote"] . " " . $lng_languag["service"];
                                $_nav .= "<a href='" . _url("widget/resellersetpricing/actions/remote") . "' >" . $lng_languag["remote"] . " " . $lng_languag["service"] . "</a> / ";
                                $templatefile = "client_reseller_imeipricelist";
                                $pageicon = "";
                                installclient($pagetitle, $pageicon, $breadcrumbnav);
                                $serviceDetails = getIMEIServices("", "", $_SESSION["uid"], 1, "", "", "", "", "", "", "", "", 958558, "", "", "", "", "", "", "", 2);
                                $tempalte_ver["imeiservicelist"] = $serviceDetails;
                                $serviceprice = 0;
                                foreach ($serviceDetails as $gid => $gdet) {
                                    foreach ($gdet as $serviceid => $servicedetail) {
                                        $tempalte_ver["calculated"][$servicedetail["newid"]] = $servicedetail["credit"] - $servicedetail["discount"];
                                    }
                                }
                                $qc = dquery("select * from tbl_store_pricing \nwhere resellerid='" . $_SESSION["uid"] . "' and servicetype='imei'");
                                while ($rc = mysqli_fetch_assoc($qc)) {
                                    $tempalte_ver["storeprice"][$rc["serviceid"]] = $rc;
                                    if (0 < $rc["increase"]) {
                                        $serviceprice = $tempalte_ver["calculated"][$rc["serviceid"]];
                                        if ($rc["increaseby"] == "Percent") {
                                            $serviceprice = $serviceprice + round($serviceprice * $rc["increase"] / 100, 2);
                                        } else {
                                            $serviceprice = $serviceprice + round($rc["increase"], 2);
                                        }
                                        $tempalte_ver["calculated"][$rc["serviceid"]] = $serviceprice;
                                    }
                                }
                                $tempalte_ver["action_link"] = _url("widget/save/reseller/actions/remotepricelist");
                                $tempalte_ver["token"] = generate_token("form");
                                $tempalte_ver["remotepersave"] = _url("widget/save/settings/actions/remoteresellerincrease");
                            }
                        }
                    }
                }
            }
        }
    }
    $tempalte_ver["token"] = generate_token("form");
    echo processSingleTemplate($templatefile);
} else {
    echo "<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>";
}
echo " ";

?>