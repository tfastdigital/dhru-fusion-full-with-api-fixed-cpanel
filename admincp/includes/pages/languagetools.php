<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

if (!isset($_SESSION[adminid])) {
    exit;
}
echo "<style>\n#pagging a{\n    text-decoration: none;\n    color: black;\n    border: silver solid 1px;\n    padding: 3px;\n}\n</style>\n<div id=\"content\">\n<div id=\"content_padded\">\n";
include "lang.settings.php";
if ($lang_code[$_REQUEST["lang_original"]] != "" && $lang_code[$_REQUEST["lang_translate"]] != "") {
    $G_trans = "go";
} else {
    $G_trans = "stop";
}
if ($mod_translate["backup"] == "yes" || $mod_translate["backup"] == "no") {
    $preset["backup"] = $mod_translate["backup"];
} else {
    $preset["backup"] = "yes";
}
if ($mod_translate["format"] != "") {
    $preset["format"] = $mod_translate["format"];
} else {
    $preset["format"] = "Y-m-d_H:i:s";
}
if (0 < $mod_translate["field"]) {
    $preset["field"] = $mod_translate["field"];
} else {
    $preset["field"] = 90;
}
if (0 < $mod_translate["page"]) {
    $preset["page"] = $mod_translate["page"];
} else {
    $preset["page"] = 50;
}
if ($_REQUEST["module"]) {
    $module = $_REQUEST["module"];
}
if ($_REQUEST["lang_original"] && $_REQUEST["lang_translate"]) {
    if ($ERROR != "yes") {
        if (!file_exists("../language/" . $_REQUEST["lang_original"] . ".txt")) {
            echo "<strong>ERROR! Original file not present!</strong><br />";
            $ERROR = "yes";
        }
        if (!file_exists("../language/" . $_REQUEST["lang_translate"] . ".txt")) {
            echo "<strong>ERROR! Target file not present!</strong><br />";
            $ERROR = "yes";
        }
        ob_start();
        include ROOTDIR . "/" . $languagedirectorypath . "/" . $_REQUEST["lang_original"] . ".txt";
        $lang_orig = ob_get_contents();
        ob_end_clean();
        eval($lang_orig);
        $lang_orig = $lng_languag;
        foreach ($lang_orig as $K => $V) {
            if ($V != "") {
                $get_lang[$K]["name"] = $K;
                $get_lang[$K]["orig"] = $V;
                $get_lang[$K]["orig_quote"] = "'";
            }
        }
        ob_start();
        include ROOTDIR . "/" . $languagedirectorypath . "/" . $_REQUEST["lang_translate"] . ".txt";
        $lang_orig = ob_get_contents();
        ob_end_clean();
        eval($lang_orig);
        $lang_orig = $lng_languag;
        foreach ($lang_orig as $K => $V) {
            if ($V != "") {
                $get_lang[$K]["name"] = $K;
                $get_lang[$K]["trans"] = $V;
                $get_lang[$K]["trans_quote"] = "'";
            }
        }
        if ($_REQUEST["save_translate"]) {
            if ($preset["backup"] == "yes") {
                if (!is_dir("../language/back")) {
                    mkdir("../language/back", 511, true);
                    chmod("../language/back", 511);
                }
                if (!is_dir("../language/back")) {
                    echo "ERROR failed to create directory /lang/back/<br />";
                }
                $dt = "" . date($preset["format"]);
                $file = "../language/" . $_REQUEST["lang_translate"] . ".txt";
                $newfile = "../language/back/" . $_REQUEST["lang_translate"] . "_" . $dt . ".txt";
                if (!copy($file, $newfile)) {
                    echo "ERROR copy file " . $file . "...<br />";
                }
            }
            foreach ($_REQUEST["lang_edit"] as $k => $v) {
                $get_lang[$v["name"]]["name"] = $v["name"];
                $get_lang[$v["name"]]["trans"] = $v["trans"];
            }
            $file_content_trans = "";
            $error_stop_save = "none";
            $error_stop_text = "";
            foreach ($get_lang as $k => $v) {
                $trans_save = htmlspecialchars_decode($v["trans"]);
                if ($v["trans_quote"] != "") {
                    $quote = $v["trans_quote"];
                } else {
                    $quote = $v["orig_quote"];
                }
                $err1 = 0;
                $err2 = 0;
                if (substr_count($trans_save, "'")) {
                    $quote = "\"";
                    $err1 = 1;
                }
                if (substr_count($trans_save, "\"")) {
                    $quote = "'";
                    $err2 = 1;
                }
                if ($err1 == 1 && $err2 == 1) {
                    $error_stop_save = "stop";
                    $error_stop_text .= "Variable: \$lng_languag[\"" . $v["name"] . "\"]<br />";
                    $error_stop_text .= "Original text: " . $v["orig"] . "<br />";
                    $error_stop_text .= "Translate text: " . $v["trans"] . "<br /><br />";
                } else {
                    $file_content_trans .= "\$lng_languag[\"" . $v["name"] . "\"] = " . $quote . $trans_save . $quote . ";" . "\n";
                }
            }
            if ($error_stop_save == "none") {
                file_put_contents("../language/" . $_REQUEST["lang_translate"] . ".txt", $file_content_trans);
            } else {
                echo "<br />CRITICAL ERROR!!!</span><br />The following variables are used both types of quotes -  <strong>\"</strong> and  <strong>'</strong> .<br />";
                echo $error_stop_text;
                echo "Please correct your entries. After correcting the opportunity to save your changes resumes.</span><br /><br />";
            }
        }
        $stat["same_value"] = 0;
        $stat["different_value"] = 0;
        $stat["zero_trans"] = 0;
        $stat["zero_orig"] = 0;
        $stat["search"] = 0;
        foreach ($get_lang as $k => $v) {
            if ($v["orig"] == "") {
                $stat["zero_orig"]++;
            }
            if ($v["trans"] == "") {
                $stat["zero_trans"]++;
            }
            if ($v["orig"] == $v["trans"]) {
                $stat["same_value"]++;
            }
            if ($v["orig"] != $v["trans"] && $v["trans"] != "" && $v["orig"] != "") {
                $stat["different_value"]++;
            }
            if ($_REQUEST["edit"] == "search") {
                $search_word = strtolower($_REQUEST["search_word"]);
                $search_orig = strtolower($v["orig"]);
                $search_trans = strtolower($v["trans"]);
                if (0 < mb_substr_count($search_orig, $search_word) || 0 < mb_substr_count($search_trans, $search_word)) {
                    $stat["search"]++;
                }
            }
        }
        echo "<form method=\"post\" enctype=\"application/x-www-form-urlencoded\" action=\"main2.php?page=languagetools&module=" . $module . "&lang_original=" . $_REQUEST["lang_original"] . "&lang_translate=" . $_REQUEST["lang_translate"] . "&edit=search&list=1\" >";
        if ($id == "tab2") {
            $tab2 = "class=tabmenu_active";
        } else {
            if ($id == "tab3") {
                $tab3 = "class=tabmenu_active";
            } else {
                if ($id == "tab4") {
                    $tab4 = "class=tabmenu_active";
                } else {
                    if ($id == "tab5") {
                        $tab5 = "class=tabmenu_active";
                    } else {
                        $tab1 = "class=tabmenu_active";
                    }
                }
            }
        }
        echo "<ul id=\"tabmenu\"> \n    <li><a onclick=\"redirectedit('languagetools&module=";
        echo $module;
        echo "&lang_original=";
        echo $_REQUEST["lang_original"];
        echo "&lang_translate=";
        echo $_REQUEST["lang_translate"];
        echo "&edit=all&list=1','tab1');\" ";
        echo $tab1;
        echo " >";
        if ($_REQUEST["edit"] == "all") {
            echo count($get_lang) . " - " . $LNG["all"];
        } else {
            echo count($get_lang) . " - " . $LNG["all"];
        }
        echo "</a></li>    \n    <li><a onclick=\"redirectedit('languagetools&module=";
        echo $module;
        echo "&lang_original=";
        echo $_REQUEST["lang_original"];
        echo "&lang_translate=";
        echo $_REQUEST["lang_translate"];
        echo "&edit=same_value&list=1','tab2');\" ";
        echo $tab2;
        echo " >";
        if ($_REQUEST["edit"] == "same_value") {
            echo $stat["same_value"] . " - " . $LNG["same"];
        } else {
            echo $stat["same_value"] . " - " . $LNG["same"];
        }
        echo "</a></li>    \n    <li><a onclick=\"redirectedit('languagetools&module=";
        echo $module;
        echo "&lang_original=";
        echo $_REQUEST["lang_original"];
        echo "&lang_translate=";
        echo $_REQUEST["lang_translate"];
        echo "&edit=different_value&list=1','tab3');\" ";
        echo $tab3;
        echo " >";
        if ($_REQUEST["edit"] == "different_value") {
            echo $stat["different_value"] . " - " . $LNG["different"];
        } else {
            echo $stat["different_value"] . " - " . $LNG["different"];
        }
        echo "</a></li>    \n    <li><a onclick=\"redirectedit('languagetools&module=";
        echo $module;
        echo "&lang_original=";
        echo $_REQUEST["lang_original"];
        echo "&lang_translate=";
        echo $_REQUEST["lang_translate"];
        echo "&edit=zero_trans&list=1','tab4');\" ";
        echo $tab4;
        echo " >";
        if ($_REQUEST["edit"] == "zero_trans") {
            echo $stat["zero_trans"] . " - " . $LNG["notranslation"];
        } else {
            echo $stat["zero_trans"] . " - " . $LNG["notranslation"];
        }
        echo "</a></li>    \n    <li><a onclick=\"redirectedit('languagetools&module=";
        echo $module;
        echo "&lang_original=";
        echo $_REQUEST["lang_original"];
        echo "&lang_translate=";
        echo $_REQUEST["lang_translate"];
        echo "&edit=zero_orig&list=1','tab5');\" ";
        echo $tab5;
        echo " >";
        if ($_REQUEST["edit"] == "zero_orig") {
            echo $stat["zero_orig"] . " - " . $LNG["notinoriginal"];
        } else {
            echo $stat["zero_orig"] . " - " . $LNG["notinoriginal"];
        }
        echo "</a></li>\n    <div style=\"clear:both\">\n</ul>\n        \n<div style=float:right;margin:5px>";
        if ($_REQUEST["edit"] == "search") {
            echo "" . $stat["search"] . " - ";
        } else {
            echo $stat["search"] . " -  ";
        }
        echo "<input type=\"text\" width=\"15\" name=\"search_word\" ";
        if ($_REQUEST["search_word"]) {
            echo " value=\"" . $_REQUEST["search_word"] . "\" ";
        }
        echo " ><input type=\"submit\" value=\"" . $LNG["search"] . "\" name=\"search\"> </div><div style=clear:both></div>";
        echo "</form>";
        if ($_REQUEST["edit"]) {
            echo "<br /><table id=\"main_tbl\" > <thead><tr>";
            echo "<th>" . $LNG["original"] . " - " . $_REQUEST["lang_original"] . "</th><th>" . $LNG["target"] . " - " . $_REQUEST["lang_translate"] . "</th><th>Google translate (<a href=\"#\" class=\"default_dg_a2\" id=\"tall\">Translate ALL</a>)</th></tr></thead>";
            echo "<input type=\"hidden\" name=\"lang\"  value=\"\" orig=\"" . $lang_code[$_REQUEST["lang_original"]] . "\" trans=\"" . $lang_code[$_REQUEST["lang_translate"]] . "\"/>";
            echo "<form action=\"main2.php?page=languagetools&module=" . $module . "&lang_original=" . $_REQUEST["lang_original"] . "&lang_translate=" . $_REQUEST["lang_translate"] . "&edit=" . $_REQUEST["edit"];
            if ($_REQUEST["list"]) {
                echo "&list=" . $_REQUEST["list"];
            }
            if ($_REQUEST["edit"] == "search" && isset($_REQUEST["search_word"])) {
                echo "&search_word=" . $_REQUEST["search_word"];
            }
            echo "\" method=\"post\" enctype=\"application/x-www-form-urlencoded\" name=\"edit\">";
            if ($_REQUEST["list"]) {
                $list = $_REQUEST["list"];
            } else {
                $list = 1;
            }
            $i = 0;
            $j = 1;
            if ($_REQUEST["edit"] == "all") {
                foreach ($get_lang as $k => $v) {
                    $i++;
                    if ($i == $preset["page"]) {
                        $j++;
                        $i = 0;
                    }
                    if ($list == $j) {
                        echo "<input type=\"hidden\" name=\"lang_edit[" . $v["name"] . "][name]\"  value=\"" . $v["name"] . "\" />\n                            <tr><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][orig]\"  value=\"" . $v["orig"] . "\"  width=\"" . $preset["field"] . "\"  readonly=\"\" />\n                            </td><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][trans]\" value=\"" . $v["trans"] . "\" width=\"" . $preset["field"] . "\" /></td>";
                        if ($G_trans == "go") {
                            echo "<td><a href=\"#\" class=\"default_dg_a2\" id=\"getgoogle\"><- Translate</a></td></tr>";
                        }
                    }
                }
            }
            if ($_REQUEST["edit"] == "same_value") {
                foreach ($get_lang as $k => $v) {
                    if ($v["orig"] == $v["trans"]) {
                        $i++;
                        if ($i == $preset["page"]) {
                            $j++;
                            $i = 0;
                        }
                        if ($list == $j) {
                            echo "<input type=\"hidden\" name=\"lang_edit[" . $v["name"] . "][name]\"  value=\"" . $v["name"] . "\" />\n                                <tr><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][orig]\"  value=\"" . $v["orig"] . "\"  width=\"" . $preset["field"] . "\"  readonly=\"\" />\n                            </td><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][trans]\" value=\"" . $v["trans"] . "\" width=\"" . $preset["field"] . "\" /></td>";
                            if ($G_trans == "go") {
                                echo "<td><a href=\"#\" class=\"default_dg_a2\" id=\"getgoogle\"><- Translate</a></td></tr>";
                            }
                        }
                    }
                }
            }
            if ($_REQUEST["edit"] == "different_value") {
                foreach ($get_lang as $k => $v) {
                    if ($v["orig"] != $v["trans"] && $v["trans"] != "" && $v["orig"] != "") {
                        $i++;
                        if ($i == $preset["page"]) {
                            $j++;
                            $i = 0;
                        }
                        if ($list == $j) {
                            echo "<input type=\"hidden\" name=\"lang_edit[" . $v["name"] . "][name]\"  value=\"" . $v["name"] . "\" />\n                                <tr><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][orig]\"  value=\"" . $v["orig"] . "\"  width=\"" . $preset["field"] . "\"  readonly=\"\" />\n                            </td><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][trans]\" value=\"" . $v["trans"] . "\" width=\"" . $preset["field"] . "\" /></td>";
                            if ($G_trans == "go") {
                                echo "<td><a href=\"#\" class=\"default_dg_a2\" id=\"getgoogle\"><- Translate</a></td></tr>";
                            }
                        }
                    }
                }
            }
            if ($_REQUEST["edit"] == "zero_trans") {
                foreach ($get_lang as $k => $v) {
                    if ($v["trans"] == "") {
                        $i++;
                        if ($i == $preset["page"]) {
                            $j++;
                            $i = 0;
                        }
                        if ($list == $j) {
                            echo "<input type=\"hidden\" name=\"lang_edit[" . $v["name"] . "][name]\"  value=\"" . $v["name"] . "\" />\n                                 <tr><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][orig]\"  value=\"" . $v["orig"] . "\"  width=\"" . $preset["field"] . "\"  readonly=\"\" />\n                            </td><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][trans]\" value=\"" . $v["trans"] . "\" width=\"" . $preset["field"] . "\" /></td>";
                            if ($G_trans == "go") {
                                echo "<td><a href=\"#\" class=\"default_dg_a2\" id=\"getgoogle\"><- Translate</a></td></tr>";
                            }
                        }
                    }
                }
            }
            if ($_REQUEST["edit"] == "zero_orig") {
                foreach ($get_lang as $k => $v) {
                    if ($v["orig"] == "") {
                        $i++;
                        if ($i == $preset["page"]) {
                            $j++;
                            $i = 0;
                        }
                        if ($list == $j) {
                            echo "<input type=\"hidden\" name=\"lang_edit[" . $v["name"] . "][name]\"  value=\"" . $v["name"] . "\" />\n                                <tr><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][orig]\"  value=\"" . $v["orig"] . "\"  width=\"" . $preset["field"] . "\"  readonly=\"\" />\n                            </td><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][trans]\" value=\"" . $v["trans"] . "\" width=\"" . $preset["field"] . "\" /></td>";
                            if ($G_trans == "go") {
                                echo "<td><a href=\"#\" class=\"default_dg_a2\" id=\"getgoogle\"><- Translate</a></td></tr>";
                            }
                        }
                    }
                }
            }
            if ($_REQUEST["edit"] == "search") {
                foreach ($get_lang as $k => $v) {
                    $search_word = strtolower($_REQUEST["search_word"]);
                    $search_orig = strtolower($v["orig"]);
                    $search_trans = strtolower($v["trans"]);
                    if (0 < mb_substr_count($search_orig, $search_word) || 0 < mb_substr_count($search_trans, $search_word)) {
                        $i++;
                        if ($i == $preset["page"]) {
                            $j++;
                            $i = 0;
                        }
                        if ($list == $j) {
                            echo "<input type=\"hidden\" name=\"lang_edit[" . $v["name"] . "][name]\"  value=\"" . $v["name"] . "\" />\n                                 <tr><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][orig]\"  value=\"" . $v["orig"] . "\"  width=\"" . $preset["field"] . "\"  readonly=\"\" />\n                            </td><td><input type=\"text\" name=\"lang_edit[" . $v["name"] . "][trans]\" value=\"" . $v["trans"] . "\" width=\"" . $preset["field"] . "\" /></td>";
                            if ($G_trans == "go") {
                                echo "<td><a href=\"#\" class=\"default_dg_a2\" id=\"getgoogle\"><- Translate</a></td></tr>";
                            }
                        }
                    }
                }
            }
            echo "</table><p style=\"text-align: center;\"><input name=\"save_translate\" type=\"submit\" value=\"Save change\" /></p></form><p align=\"center\" id=\"pagging\">Page: ";
            if ($_REQUEST["list"]) {
                $list = $_REQUEST["list"];
            } else {
                $list = 1;
            }
            $list_down = $list - 1;
            $list_up = $list + 1;
            $list_all = 1;
            if ($_REQUEST["edit"] == "all") {
                $list_all = ceil(count($get_lang) / $preset["page"]);
            }
            if ($_REQUEST["edit"] == "same_value") {
                $list_all = ceil($stat["same_value"] / $preset["page"]);
            }
            if ($_REQUEST["edit"] == "zero_trans") {
                $list_all = ceil($stat["zero_trans"] / $preset["page"]);
            }
            if ($_REQUEST["edit"] == "zero_orig") {
                $list_all = ceil($stat["zero_orig"] / $preset["page"]);
            }
            if ($_REQUEST["edit"] == "different_value") {
                $list_all = ceil($stat["different_value"] / $preset["page"]);
            }
            if ($_REQUEST["edit"] == "search") {
                $list_all = ceil($stat["search"] / $preset["page"]);
            }
            if (0 < $list_down) {
                echo "<a href=\"main2.php?page=languagetools&module=" . $module . "&lang_original=" . $_REQUEST["lang_original"] . "&lang_translate=" . $_REQUEST["lang_translate"] . "&edit=" . $_REQUEST["edit"] . "&list=" . $list_down;
                if ($_REQUEST["edit"] == "search" && isset($_REQUEST["search_word"])) {
                    echo "&search_word=" . $_REQUEST["search_word"];
                }
                echo "\"> << </a> ";
            } else {
                echo "  <<  ";
            }
            for ($i = 1; $i <= $list_all; $i++) {
                echo " <a href=\"main2.php?page=languagetools&module=" . $module . "&lang_original=" . $_REQUEST["lang_original"] . "&lang_translate=" . $_REQUEST["lang_translate"] . "&edit=" . $_REQUEST["edit"] . "&list=" . $i;
                if ($_REQUEST["edit"] == "search" && isset($_REQUEST["search_word"])) {
                    echo "&search_word=" . $_REQUEST["search_word"];
                }
                echo "\">";
                if ($i == $list) {
                    echo "" . $i . "";
                } else {
                    echo $i;
                }
                echo "</a> ";
            }
            if ($list_up <= $list_all) {
                echo " <a href=\"main2.php?page=languagetools&module=" . $module . "&lang_original=" . $_REQUEST["lang_original"] . "&lang_translate=" . $_REQUEST["lang_translate"] . "&edit=" . $_REQUEST["edit"] . "&list=" . $list_up;
                if ($_REQUEST["edit"] == "search" && isset($_REQUEST["search_word"])) {
                    echo "&search_word=" . $_REQUEST["search_word"];
                }
                echo "\"> >> </a> ";
            } else {
                echo "  >> </p> ";
            }
            echo "<br><br>Warning! File will be recreated.";
            if ($preset["backup"] == "yes") {
                echo "<br />Copies of files will be stored in a directory lang/back/ prefixed date and time to the file name.\n                <br />Example \"language/back/English_2010-07-06_14:15:07.txt\"";
                return 1;
            }
        }
    } else {
        echo "Check for files and correct choice of languages. <br /> If you have any difficulties, please let the developer error.";
        return 1;
    }
}
$files = "";
$count = 0;
$dir = "../language/";
$dh = opendir($dir);
while (false !== ($filefind = readdir($dh))) {
    if ($filefind != ".") {
        if ($filefind != "..") {
            if (substr($filefind, -3) == "txt") {
                $files[] = substr($filefind, 0, -4);
                $count = $count + 1;
            }
        }
    }
}
$count = $count - 1;
sort($files);
echo "<form method=\"get\" enctype=\"application/x-www-form-urlencoded\" name=\"translate\" action=\"main2.php?page=languagetools\"><input type=\"hidden\" value=\"languagetools\" name=\"page\" />";
echo "<input type=\"hidden\" value=\"" . $module . "\" name=\"module\" />";
echo "<input type=\"hidden\" value=\"all\" name=\"edit\" /><input type=\"hidden\" value=\"1\" name=\"list\" /><table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\"><tr><td> Original Language</td><td><select width=\"1\" name=\"lang_original\">";
for ($i = 0; $i <= $count; $i++) {
    echo "<option ";
    if ($files[$i] == "English") {
        echo " selected ";
    }
    echo ">" . $files[$i] . "</option>";
}
echo "</select></td><td> Target language</td><td><select width=\"1\" name=\"lang_translate\">";
for ($i = 0; $i <= $count; $i++) {
    echo "<option ";
    if ($files[$i] == "Russian") {
        echo " selected ";
    }
    echo ">" . $files[$i] . "</option>";
}
echo "</select></td></tr></table><p class=\"fixedbtn\"><input type=\"submit\" value=\"Proceed\" /></p></form></div></div>\n</div>\n";
$fileverioncheck = "6.1.0";
function lang_parsing($str)
{
    $str = trim($str);
    $str = mb_substr($str, 12);
    $str = trim($str);
    $parts = explode("=", $str);
    $parts1 = trim($parts[0]);
    $parts2 = trim($parts[1]);
    $pos11 = mb_stripos($parts1, $parts1[1], 0, "UTF-8") + 1;
    $pos12 = mb_strripos($parts1, $parts1[1], 0, "UTF-8") - $pos11;
    $pos21 = mb_stripos($parts2, $parts2[0], 0, "UTF-8") + 1;
    $pos22 = mb_strripos($parts2, $parts2[0], 0, "UTF-8") - $pos21;
    $out["var"] = trim(mb_substr($parts1, $pos11, $pos12));
    $out["val"] = trim(mb_substr($parts2, $pos21, $pos22));
    $out["quote"] = $parts2[0];
    return $out;
}

?>