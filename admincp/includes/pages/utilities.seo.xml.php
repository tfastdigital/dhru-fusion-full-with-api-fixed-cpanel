<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 496;
checkPagePermission($pageid);
if ($generate) {
    if (!$imei && !$server && !$product && !$blogpost) {
        echo "<div id='notification1' class='errorbox' >" . $LNG["selectanyservice"] . "</div>";
    } else {
        require_once "includes/3rdparty/seo.class.php";
        $entries[] = new xml_sitemap_entry("/", "1.0000", $frequency);
        if ($lastpriority) {
            $orerd = " ORDER BY id DESC";
        } else {
            $orerd = " ORDER BY id ASC";
        }
        $ids = 1;
        if ($product) {
            $q = dquery("select id,service_name,group_id from tbl_products WHERE active='1' " . $orerd);
            $cnt = mysqli_num_rows($q);
            $cnt = (int) ($cnt / 10);
            $cnt = $cnt + 1;
            $i = 1;
            while ($row1 = mysqli_fetch_assoc($q)) {
                if ($cnt < $i) {
                    $i = 1;
                    if (0 < $ids) {
                        $ids = $ids - 0;
                    }
                }
                $i++;
                $entries[] = new xml_sitemap_entry(_url("product/" . preg_replace("/[^a-zA-Z0-9\\-]/", "", str_replace(" ", "-", $row1["service_name"])) . "/?pid=" . $row1["id"], true), $ids, $frequency);
            }
        }
        if ($features) {
            $sql = dquery("select id,group_id from tbl_products where active='1'");
            while ($row = mysqli_fetch_assoc($sql)) {
                $f = dquery("select fieldid from tbl_featuresvalues where relid='" . $row["id"] . "'\n         and (value='Yes' or value='yes')");
                while ($fea = mysqli_fetch_assoc($f)) {
                    $detail = mysqli_fetch_assoc(dquery("select fieldname from tbl_features where id='" . $fea["fieldid"] . "'"));
                    if ($detail["fieldname"]) {
                        $i++;
                    }
                }
            }
        }
        $ids = 1;
        $wheremed = "";
        if (!isset($_SESSION["uid"])) {
            $wheremed = " and hideguest='0'";
        }
        if ($imei) {
            $q = dquery("select id,service_name,group_id from tbl_services_imei \n    WHERE active='1' and retail='1' and useasserver=0 " . $wheremed . " " . $orerd);
            $cnt = mysqli_num_rows($q);
            $cnt = (int) ($cnt / 10);
            $cnt = $cnt + 1;
            $i = 1;
            while ($row1 = mysqli_fetch_assoc($q)) {
                if ($cnt < $i) {
                    $i = 1;
                    if (0 < $ids) {
                        $ids = $ids - 0;
                    }
                }
                $i++;
                $entries[] = new xml_sitemap_entry(_url("imei/" . str_replace(" ", "-", preg_replace("/[^a-zA-Z0-9 ]/", "", $row1["service_name"])) . "?pid=" . $row1["id"], true), $ids, $frequency);
            }
        }
        $ids = 1;
        if ($server) {
            $q = dquery("select id,service_name,group_id from tbl_services_imei \n    WHERE active='1' and retail='1' and useasserver=1 " . $wheremed . " " . $orerd);
            $cnt = mysqli_num_rows($q);
            $cnt = (int) ($cnt / 10);
            $cnt = $cnt + 1;
            $i = 1;
            while ($row1 = mysqli_fetch_assoc($q)) {
                if ($cnt < $i) {
                    $i = 1;
                    if (0 < $ids) {
                        $ids = $ids - 0;
                    }
                }
                $i++;
                $entries[] = new xml_sitemap_entry(_url("server/" . str_replace(" ", "-", preg_replace("/[^a-zA-Z0-9 ]/", "", $row1["service_name"])) . "?pid=" . $row1["id"], true), $ids, $frequency);
            }
        }
        $ids = 1;
        if ($blogpost) {
            $q = dquery("select * from tbl_blogposts where status='published'");
            $cnt = mysqli_num_rows($q);
            $cnt = (int) ($cnt / 10);
            $cnt = $cnt + 1;
            $i = 1;
            while ($row1 = mysqli_fetch_assoc($q)) {
                if ($cnt < $i) {
                    $i = 1;
                    if (0 < $ids) {
                        $ids = $ids - 0;
                    }
                }
                $i++;
                $title = str_replace(" ", "-", $row1["title"]);
                $title = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $title);
                $entries[] = new xml_sitemap_entry(_url("blog/post/" . $row1["id"] . "/" . $title, true), $ids, $frequency);
            }
        }
        $ids = 1;
        $q = dquery("select * from tbl_seo_links where status='1'");
        if (mysqli_num_rows($q)) {
            $cnt = mysqli_num_rows($q);
            $cnt = (int) ($cnt / 10);
            $cnt = $cnt + 1;
            $i = 1;
            while ($row1 = mysqli_fetch_assoc($q)) {
                if ($cnt < $i) {
                    $i = 1;
                    if (0 < $ids) {
                        $ids = $ids - 0;
                    }
                }
                $i++;
                $entries[] = new xml_sitemap_entry($row1["link"], $ids, $frequency);
            }
        }
        $domain = rtrim($config["config_ssl_allow"] ? $config["config_ssl_allow"] : $config["site_address"], "/");
        $conf = new xml_sitemap_generator_config();
        $conf->setDomain("");
        $conf->setPath(dirname(__FILE__) . "/");
        $conf->setFilename("../../../sitemap.xml");
        $conf->setEntries($entries);
        $generator = new xml_sitemap_generator($conf);
        $generator->write();
        echo "<div id='notification1' class='successbox' >Sitemap Generated successfully <br /> <a href='" . $config["site_address"] . "sitemap.xml' target='_blank'>" . $config["site_address"] . "sitemap.xml</a></div>";
    }
}
echo "\n<div id=\"notification\"></div>\n<div id=\"content\">\n<div id=\"content_padded\">\n\n<div  class=\"groupstabes\" >\n  <h2>\n    <span class=\"groupstabesheadertext\">XML Sitemap</span>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frm\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n<tr>\n    <td class=\"fieldlabel\">&nbsp;</td>\n    <td class=\"fieldarea\">\n<input type=\"checkbox\" name=\"lastpriority\" value=\"1\" checked=\"checked\" id=\"s1\" /> <label for=\"s1\">";
echo $LNG["autopriority"];
echo "</label>\n     </td>\n</tr>\n\n";
if (!$OnlyEcommerce) {
    echo "<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n<input type=\"checkbox\" name=\"imei\" value=\"1\"  checked=\"checked\" id=\"s2\" /> <label for=\"s2\">";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["generate"];
    echo " ";
    echo $LNG["list"];
    echo "</label>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n<input type=\"checkbox\" name=\"server\" value=\"1\"  checked=\"checked\" id=\"s3\" /> <label for=\"s3\">";
    echo $LNG["server"];
    echo " ";
    echo $LNG["generate"];
    echo " ";
    echo $LNG["list"];
    echo "</label>\n     </td>\n</tr>\n";
}
echo "<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n<input type=\"checkbox\" name=\"product\" value=\"1\"  checked=\"checked\" id=\"s4\" /> <label for=\"s4\">";
echo $LNG["product"];
echo " ";
echo $LNG["generate"];
echo " ";
echo $LNG["list"];
echo "</label>\n     </td>\n</tr>\n\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n<input type=\"checkbox\" name=\"features\" value=\"1\"  checked=\"checked\" id=\"s6\" />\n <label for=\"s6\">";
echo $LNG["product"];
echo " ";
echo $LNG["features"];
echo "</label>\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n<input type=\"checkbox\" name=\"blogpost\" value=\"1\"  checked=\"checked\" id=\"s5\" /> <label for=\"s5\">";
echo $LNG["blog"];
echo " ";
echo $LNG["post"];
echo "</label>\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\">Frequency</td>\n    <td class=\"fieldarea\">\n<select name=\"frequency\" >\n    <option value=\"always\">always</option>\n    <option value=\"hourly\">hourly</option>\n    <option selected=\"selected\" value=\"daily\">daily</option>\n    <option value=\"weekly\">weekly</option>\n    <option value=\"monthly\">monthly</option>\n    <option value=\"yearly\">yearly</option>\n    <option value=\"never\">never</option>\n</select>\n     </td>\n</tr>\n<tr>\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\">\n<a href=\"javascript:load_subpage('main2.php?page=seoextrafield', 'Extra Links');\">";
echo $LNG["add"];
echo "  ";
echo $LNG["extra"];
echo " ";
echo $LNG["link"];
echo "</a>\n     </td>\n</tr>\n</tbody>\n</table>\n<p class=\"fixedbtn\"><input type=\"submit\" name=\"generate\" value=\"";
echo $LNG["generate"];
echo " ";
echo $LNG["sitemap"];
echo "\" /></p>\n</form>\n\n</div></div>\n\n</div></div>\n ";
$fileverioncheck = "6.1.0";

?>