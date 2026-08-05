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
require ROOTDIR . "/includes/clients.fun.inc.php";
require ROOTDIR . "/includes/features.fun.php";
$gid = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $gid);
$features = getFeaturesFromGroup($gid);
$q = dquery("select id,service_name,manufacture_id \nfrom tbl_products where active='1' and group_id='" . $gid . "'");
$features = [];
$manufacture = [];
while ($r = mysqli_fetch_assoc($q)) {
    if ($r["manufacture_id"]) {
        $manufacture[$r["manufacture_id"]]["m"] = $r["manufacture_id"];
        $manufacture[$r["manufacture_id"]]["p"][] = $r["id"];
    }
    $f = dquery("select id,fieldid,value,(select\n    fieldname from tbl_features where id=fieldid and filter=1) as feature from tbl_featuresvalues \n    where relid='" . $r["id"] . "'");
    while ($rf = mysqli_fetch_assoc($f)) {
        if ($rf["value"]) {
            if ($features[$rf["fieldid"]]) {
                $features[$rf["fieldid"]]["product"][] = $r["id"];
                $features[$rf["fieldid"]]["vals"][] = $rf["value"];
            } else {
                $rf["product"][] = $r["id"];
                $rf["vals"][] = $rf["value"];
                $features[$rf["fieldid"]] = $rf;
            }
        }
    }
}
$valarr = [];
foreach ($features as $f) {
    foreach ($f["vals"] as $vs) {
        $valarr[] = $vs;
    }
}
$valarr = array_unique($valarr);
$_SESSION["valarr"] = $valarr;
$formid = "frmfilters" . rand(1000, 10000);
echo "<form method=\"post\" id=\"";
echo $formid;
echo "\">\n\n    <ul class=\"filter-features\">\n";
if ($_SESSION["manufacture"] || $_SESSION["filter"]) {
    echo "<input type=\"submit\" name=\"filterremove\" class=\"btn-reset\" value=\"Clear All Filter\" />\n";
}
if (count($manufacture)) {
    echo "\n <li  class=\"cart\">\n     <div class=\"nav-header\">Brand</div>\n     <ul  class=\"catloglist \">\n     ";
    foreach ($manufacture as $k => $m) {
        $ms = mysqli_fetch_assoc(dquery("select name from tbl_manufacture where id='" . $k . "'"));
        $selected = "";
        if (isset($_SESSION["manufacture"][$m["m"]])) {
            $selected = "checked='checked'";
        }
        $disabled = "";
        $disabledl = "";
        $cnts = 0;
        if ($_SESSION["filter"]) {
            $fpr = [];
            foreach ($_SESSION["filter"] as $kfr => $vfr) {
                $cnts++;
                $kfr = explode("_", $kfr);
                $valsr = $valarr[$kfr[1]];
                $fpf = dquery("select relid from tbl_featuresvalues where\n                         value='" . $valsr . "' and fieldid='" . $kfr[0] . "'");
                while ($rfpf = mysqli_fetch_assoc($fpf)) {
                    $fpr[] = $rfpf["relid"];
                }
            }
            $fpr = array_unique($fpr);
            $availablepro = 0;
            foreach ($fpr as $fst) {
                $availablepro += mysqli_num_rows(dquery("select id \n                        from tbl_products where id='" . $fst . "' and manufacture_id='" . $k . "'"));
            }
            $fprs = [];
            foreach ($fpr as $kfr) {
                $fpf = dquery("select manufacture_id from tbl_products\n                         where id='" . $kfr . "' and group_id='" . $gid . "'");
                while ($rfpf = mysqli_fetch_assoc($fpf)) {
                    $fprs[] = $rfpf["manufacture_id"];
                }
            }
            $fprs = array_unique($fprs);
            $flagsp = 0;
            foreach ($fprs as $vps) {
                if ($vps == $k) {
                    $flagsp = 1;
                }
            }
            if ($flagsp == 0) {
                $disabled = " disabled";
                $disabledl = " class='disable-label'";
            }
        }
        if ($disabled == "" && $_SESSION["manufacture"]) {
            foreach ($_SESSION["manufacture"] as $kmc => $mfc) {
                if ($kmc != $m["m"]) {
                    $disabled = " disabled";
                    $disabledl = " class='disable-label'";
                }
            }
        }
        $uniqpro = $fpr;
        $cnts--;
        if ($disabled == "") {
            $valuesarras = [];
            $manuarr = [];
            foreach ($_SESSION["filter"] as $kfr => $fs) {
                $uniq = $kfr;
                $kfr = explode("_", $kfr);
                $vals = $valarr[$kfr[1]];
                $qpr = dquery("select relid from tbl_featuresvalues \n                            where value='" . $vals . "' and fieldid='" . $kfr[0] . "'");
                while ($rqpr = mysqli_fetch_assoc($qpr)) {
                    foreach ($_SESSION["filter"] as $mykfr => $myfs) {
                        if ($mykfr != $uniq) {
                            $mykfr = explode("_", $mykfr);
                            $valsr = $valarr[$mykfr[1]];
                            if (!mysqli_num_rows(dquery("select relid from tbl_featuresvalues \n                                        where value='" . $valsr . "' and fieldid='" . $mykfr[0] . "'\n                                        and relid='" . $rqpr["relid"] . "'"))) {
                                foreach ($uniqpro as $kpro => $vpro) {
                                    if ($vpro == $rqpr["relid"]) {
                                        unset($uniqpro[$kpro]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $flagofm = 0;
        foreach ($uniqpro as $u) {
            if (mysqli_num_rows(dquery("select manufacture_id from tbl_products\n                    where manufacture_id='" . $m["m"] . "' and id='" . $u . "'"))) {
                $flagofm = 1;
            }
        }
        if ($flagofm == 0 && $_SESSION["filter"]) {
            $disabled = " disabled";
            $disabledl = " class='disable-label'";
        }
        echo "<label ";
        echo $disabledl;
        echo ">\n<input type=\"checkbox\" ";
        echo $disabled;
        echo " ";
        echo $selected;
        echo " name=\"manufacture[";
        echo $m["m"];
        echo "]\"\nonclick=\"\$('#loader').show(); \$('#";
        echo $formid;
        echo "').submit();\"  />\n&nbsp;";
        echo $ms["name"];
        echo " [";
        echo $availablepro ? $availablepro : count($m["p"]);
        echo "]</label> <br />\n\n       ";
    }
    echo "</ul>\n</li>\n\n    ";
}
$valuesarras = [];
$manuarr = [];
foreach ($_SESSION["filter"] as $kfr => $fs) {
    $uniq = $kfr;
    $kfr = explode("_", $kfr);
    $vals = $valarr[$kfr[1]];
    $qpr = dquery("select relid from tbl_featuresvalues \n        where value='" . $vals . "' and fieldid='" . $kfr[0] . "'");
    while ($rqpr = mysqli_fetch_assoc($qpr)) {
        foreach ($_SESSION["filter"] as $mykfr => $myfs) {
            if ($mykfr != $uniq) {
                $mykfr = explode("_", $mykfr);
                $valsr = $valarr[$mykfr[1]];
                if (!mysqli_num_rows(dquery("select relid from tbl_featuresvalues \n                    where value='" . $valsr . "' and fieldid='" . $mykfr[0] . "'\n                    and relid='" . $rqpr["relid"] . "'"))) {
                    foreach ($uniqpro as $kpro => $vpro) {
                        if ($vpro == $rqpr["relid"]) {
                            unset($uniqpro[$kpro]);
                        }
                    }
                }
            }
        }
    }
}
if ($_SESSION["manufacture"]) {
    $manurs = [];
    foreach ($_SESSION["manufacture"] as $mf => $mfp) {
        $pr = dquery("select id from tbl_products\n            where manufacture_id='" . $mf . "'");
        while ($rpr = mysqli_fetch_assoc($pr)) {
            $manurs[] = $rpr["id"];
        }
    }
    $manurs = array_unique($manurs);
}
if ($uniqpro && $manurs) {
    foreach ($manurs as $ser) {
        if (in_array($ser, $uniqpro)) {
            $newunique[] = $ser;
        }
    }
} else {
    if ($uniqpro) {
        $newunique = $uniqpro;
    } else {
        $newunique = $manurs;
    }
}
$newunique = array_unique($newunique);
if (count($features)) {
    $uniqpro = $newunique;
    foreach ($features as $fid => $f) {
        if ($f["feature"] && count($f["vals"])) {
            $f["vals"] = array_unique($f["vals"]);
            $flag = 0;
            foreach ($f["vals"] as $v) {
                if ($v) {
                    $fs = dquery("select relid from tbl_featuresvalues\n                where fieldid='" . $fid . "' and value='" . $v . "'\n                 and (select group_id from tbl_products where id=relid)='" . $gid . "'");
                    while ($r = mysqli_fetch_assoc($fs)) {
                        $pars[$r["relid"]] = $r["relid"];
                    }
                    if (count($pars)) {
                        $flag = 1;
                    }
                }
            }
            if ($flag == 1) {
                echo " <li   class=\"cart\">\n     <div class=\"nav-header\">";
                echo $f["feature"];
                echo "</div>\n     <ul  class=\"catloglist \">\n     ";
                foreach ($f["vals"] as $v) {
                    if ($v) {
                        $selected = "";
                        $disabledl = "";
                        if ($_SESSION["filter"][$fid . "_" . array_search($v, $valarr)]) {
                            $selected = "checked='checked'";
                        }
                        $pars = NULL;
                        $fs = dquery("select relid from tbl_featuresvalues\n                where fieldid='" . $fid . "' and value='" . $v . "'\n                 and (select group_id from tbl_products where id=relid)='" . $gid . "'");
                        while ($r = mysqli_fetch_assoc($fs)) {
                            $pars[$r["relid"]] = $r["relid"];
                        }
                        if (count($pars)) {
                            $disabled = "";
                            if ($_SESSION["filter"]) {
                                $fpr = [];
                                foreach ($_SESSION["filter"] as $kfr => $vfr) {
                                    $kfr = explode("_", $kfr);
                                    $valsr = $valarr[$kfr[1]];
                                    $fpf = dquery("select relid from tbl_featuresvalues where\n                         value='" . $valsr . "'");
                                    while ($rfpf = mysqli_fetch_assoc($fpf)) {
                                        $fpr[] = $rfpf["relid"];
                                    }
                                }
                                $fpr = array_unique($fpr);
                                $fprs = [];
                                foreach ($fpr as $kfr) {
                                    $fpf = dquery("select value from tbl_featuresvalues where relid='" . $kfr . "'");
                                    while ($rfpf = mysqli_fetch_assoc($fpf)) {
                                        $fprs[] = $rfpf["value"];
                                    }
                                }
                                $fprs = array_unique($fprs);
                                $flagsp = 0;
                                foreach ($fprs as $vps) {
                                    if ($vps == $v) {
                                        $flagsp = 1;
                                    }
                                }
                                if ($flagsp == 0) {
                                    $disabled = " disabled";
                                    $disabledl = "class='disable-label'";
                                }
                            }
                            $flagsr = 0;
                            foreach ($uniqpro as $uni) {
                                if (mysqli_num_rows(dquery("select relid from tbl_featuresvalues where\n                       relid='" . $uni . "' and value='" . $v . "' and fieldid='" . $fid . "'"))) {
                                    $flagsr++;
                                }
                            }
                            if ($flagsr == 0 && $_SESSION["filter"]) {
                            }
                            if ($disabled == "" && $_SESSION["manufacture"]) {
                                $prarr = [];
                                foreach ($_SESSION["manufacture"] as $kmc => $mfc) {
                                    $mprl = dquery("select id from tbl_products\n                        where manufacture_id='" . $kmc . "'");
                                    while ($rmprl = mysqli_fetch_assoc($mprl)) {
                                        $prarr[] = $rmprl["id"];
                                    }
                                }
                                $prarr = array_unique($prarr);
                                $uniqcnt = 0;
                                foreach ($prarr as $kfr) {
                                    if (mysqli_num_rows(dquery("select value from tbl_featuresvalues \n                        where relid='" . $kfr . "' and fieldid='" . $fid . "' and value='" . $v . "'"))) {
                                        $uniqcnt++;
                                    }
                                }
                                $fprs = NULL;
                                foreach ($prarr as $kfr) {
                                    $fpf = dquery("select value from tbl_featuresvalues \n                        where relid='" . $kfr . "' and fieldid='" . $fid . "'");
                                    while ($rfpf = mysqli_fetch_assoc($fpf)) {
                                        $fprs[] = $rfpf["value"];
                                    }
                                }
                                $fprs = array_unique($fprs);
                                $flagsp = 0;
                                foreach ($fprs as $vps) {
                                    if ($vps == $v) {
                                        $flagsp = 1;
                                    }
                                }
                                if ($flagsp == 0) {
                                }
                            }
                            if ($selected) {
                                $disabled = "";
                                $disabledl = "";
                            }
                            echo "<label ";
                            echo $disabledl;
                            echo ">\n<input type=\"checkbox\" ";
                            echo $disabled;
                            echo " ";
                            echo $selected;
                            echo "  name=\"filter[";
                            echo $fid;
                            echo "_";
                            echo array_search($v, $valarr);
                            echo "]\"\nonclick=\"\$('#loader').show(); \$('#";
                            echo $formid;
                            echo "').submit();\" />\n&nbsp;";
                            echo $v;
                            echo " [";
                            echo $flagsr ? $flagsr : count($pars);
                            echo "]</label> <br />\n            ";
                            $disabled = "";
                        }
                    }
                }
                echo "     </ul>\n </li>\n        ";
            }
        }
    }
    echo "\n<!--\n<div style=\"border:1px solid #ccc;padding:0 0 10px 0;margin-bottom:12px;\"  class=\"cart\">\n <li class=\"nav-header\">";
    echo $lng_languag["features"];
    echo "</li>\n\n<ul  id=\"catloglist\">\n";
    foreach ($features as $k => $v) {
        $detail = explode("_", $v);
        if ($config["cms_seofriendly"] == "on") {
            echo "<li><a href='" . $gid . "/feature/" . $k . "/" . str_replace(" ", "_", $detail[0]) . ".html'>" . $detail[0] . " [" . $detail[1] . "]</a></a></li>";
        } else {
            echo "<li><a href='" . _url("cart/group/" . $gid . "/service/product/fid/" . $k) . "'>" . $detail[0] . " [" . $detail[1] . "]</a></a></li>";
        }
    }
    echo "</ul>\n</div>\n-->\n\n";
}
echo "<li  class=\"cart\">\n    <div class=\"nav-header\">";
echo $lng_languag["price"];
echo "</div>\n    <ul  class=\"catloglist d-flex align-items-center justify-content-between\">\n      ";
$range = explode("_", $_SESSION["findbyprice"]);
echo "         <input type=\"text\" size=\"5\"  class=\"form-control\" name=\"from\" value=\"";
echo $range[0];
echo "\" /> -\n        <input type=\"text\"  class=\"form-control\" value=\"";
echo $range[1];
echo "\" name=\"to\" size=\"5\" />\n        <input type=\"submit\" name=\"findbyprice\" class=\"btn btn-secondary\" value=\"Find\" />\n    </ul>\n</li>\n\n\n    </ul>\n\n</form>\n";

?>