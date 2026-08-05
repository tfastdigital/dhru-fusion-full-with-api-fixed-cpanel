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
if ($reseted) {
    $reseted = str_replace(".txt", ".custom.txt", $reseted);
    unlink("../" . $languagedirectorypath . "/" . $reseted);
}
if ($import) {
    if (!file_exists("../" . $languagedirectorypath . "/" . $_FILES["lang"]["tmp_name"])) {
        if (0 >= $_FILES["lang"]["error"]) {
            $ext = explode(".", $_FILES["lang"]["name"]);
            if ($ext[1] == "txt") {
                $dts = file_get_contents($_FILES["lang"]["tmp_name"]);
                $dts = explode("\n", $dts);
                foreach ($dts as $k => $v) {
                    if (!trim($v)) {
                        unset($dts[$k]);
                    }
                }
                ob_start();
                include $_FILES["lang"]["tmp_name"];
                $lang_cont = ob_get_contents();
                ob_end_clean();
                eval($lang_cont);
                $getcount = count($lng_languag);
                if (0 < $getcount) {
                    move_uploaded_file($_FILES["lang"]["tmp_name"], "../" . $languagedirectorypath . "/" . $_FILES["lang"]["name"]);
                    echo "<div id='notification1' class='successbox' >Language imported successfully</div>";
                } else {
                    echo "<div id='notification1' class='errorbox' >Wrong File Format</div>";
                }
            } else {
                echo "<div id='notification1' class='errorbox' >Wrong File Extension</div>";
            }
        }
    } else {
        echo "<div id='notification1' class='errorbox' >Language already exist please delete current file to upload new</div>";
    }
}
error_reporting(0);
echo "<script>\n    function setFlag(){\n        \$(\"#flag\").val('2');\n    }\n    function resetFlag(){\n        \$(\"#flag\").val('');\n    }\n    function checkFlag(){\n        if(\$(\"#flag\").val()!=''){\n            return confirm(\"Your changes will be lost. Are you sure want to continue.\");\n        }\n    }\n    function translateALl(id,word,lang){\n        //frmlang\n        \$(\"#main_loader\").show();\n        \$.post('includes/main.save.php?page=language.translate',{w: word,language: lang}, function(data, textStatus) {\n            \$(\"#main_loader\").hide();\n            data=data.split(\":\");\n            if(data[0]==\"ERROR\"){\n                alert(data[1]);\n            }else if(data[0]){\n                \$(id).val(data[0]);\n            }\n        });\n    }\n</script>\n\n<style>\n    .sum td{border-right:#ddd solid 1px;text-align: left;padding-left:10px}\n</style>\n\n<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n        ";
$lang_code = ["Afrikaans" => "af", "Albanian" => "sq", "Arabic" => "ar", "Azerbaijani" => "az", "Basque" => "bs", "Bengali" => "bn", "Chinese" => "zh", "Esperanto" => "eo", "Georgian" => "ka", "Haitian Creole" => "ht", "Kannada" => "kn", "Latin" => "la", "Tamil" => "ta", "Telugu" => "te", "Belarusian" => "be", "Bulgarian" => "bg", "Catalan" => "ca", "Chinese-Simplified" => "zh-CN", "Chinese-Traditional" => "zh-TW", "Croatian" => "hr", "Czech" => "cs", "Danish" => "da", "Dutch" => "nl", "English" => "en", "Estonian" => "et", "Filipino" => "tl", "Finnish" => "fi", "French" => "fr", "Galician" => "gl", "German" => "de", "Greek" => "el", "Hebrew" => "iw", "Hindi" => "hi", "Gujarati" => "gu", "Hungarian" => "hu", "Icelandic" => "is", "Indonesian" => "id", "Irish" => "ga", "Italian" => "it", "Japanese" => "ja", "Korean" => "ko", "Latvian" => "lv", "Lithuanian" => "lt", "Macedonian" => "mk", "Malay" => "ms", "Maltese" => "mt", "Norwegian" => "no", "Persian" => "fa", "Polish" => "pl", "Portuguese" => "pt", "Romanian" => "ro", "Russian" => "ru", "Serbian" => "sr", "Slovak" => "sk", "Slovenian" => "sl", "Spanish" => "es", "Swahili" => "sw", "Swedish" => "sv", "Thai" => "th", "Turkish" => "tr", "Ukrainian" => "uk", "Vietnamese" => "vi", "Welsh" => "cy", "Yiddish" => "yi"];
if ($updatecustom) {
    foreach ($lang_code as $k => $v) {
        if (is_file("../" . $languagedirectorypath . "/" . $k . ".custom.txt")) {
            ob_start();
            include "../" . $languagedirectorypath . "/" . $k . ".txt";
            $lang_cont = ob_get_contents();
            ob_end_clean();
            eval($lang_cont);
            $origin = $lng_languag;
            $lng_languag = NULL;
            ob_start();
            include "../" . $languagedirectorypath . "/" . $k . ".custom.txt";
            $lang_cont = ob_get_contents();
            ob_end_clean();
            eval($lang_cont);
            $diff = array_diff_key($origin, $lng_languag);
            $lng_languag = NULL;
            $origin = NULL;
            if (is_array($diff)) {
                $bufs = "\n";
                foreach ($diff as $dk => $dv) {
                    $bufs .= "\$lng_languag['" . $dk . "']='" . $dv . "';" . "\n";
                }
            }
            if ($bufs) {
                file_put_contents("../" . $languagedirectorypath . "/" . $k . ".custom.txt", $bufs, FILE_APPEND);
            }
            $bufs = NULL;
        }
    }
}
$flag = 1;
foreach ($lang_code as $k => $v) {
    if ($flag && is_file("../" . $languagedirectorypath . "/" . $k . ".custom.txt")) {
        ob_start();
        include "../" . $languagedirectorypath . "/" . $k . ".custom.txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        if (!function_exists("eval")) {
            echo "'eval' Function not exists";
        }
        eval($lang_cont);
        $cnt = count($lng_languag);
        $lng_languag = NULL;
        ob_start();
        include "../" . $languagedirectorypath . "/" . $k . ".txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
        if ($cnt != count($lng_languag)) {
            $flag = 0;
            echo "<div class='info' id='notification1'>Some words missing in your language <a href=\"javascript: \n                    reloadcurrent('utilities.language&defaultloadpage=language.add.php','&updatecustom=true');\">click here</a> to update.</div>";
        }
        $lng_languag = NULL;
    }
}
echo "        <div  class=\"groupstabes\">\n\n            <table class=\"sum\">\n                <tr>\n                    <td><h2>\n              <span class=\"groupstabesheadertext\">\n              Google APi key\n              </span>\n                        </h2>\n                        <div class=\"groupstabescontant\">\n                            <form id=\"frmkri\" name=\"\" method=\"post\">\n                                ";
echo generate_token("form");
echo "                                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                                    <tbody>\n                                    <tr>\n                                        <td class=\"\" style=\"text-align: left;\"><input style=\"background: #f4f4f4;\" type=\"text\" class=\"txt\"  placeholder=\"Google ";
echo $LNG["api"] . " " . $LNG["key"];
echo "\" name=\"googlelanguageapi\" value=\"";
echo $config["googlelanguageapi"];
echo "\" />\n                                            <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroups\" class=\"btn save\" type=\"button\" onClick=\"SubmitForm ('#btnaddgroups','settingappear','#frmkri','#notification','true','#main_loader');\"/> <br />\n                                            <a href=\"https://code.google.com/apis/console/?api=translate\" title=\"getyour API key\" target=\"_blank\"> Google APIs console </a>\n                                        </td>\n                                    </tr>\n                                    </tbody>\n                                </table>\n                            </form>\n                        </div></td>\n                    <td style=\"vertical-align: top;\"><h2>\n              <span class=\"groupstabesheadertext\">\n              ";
echo $LNG["add"];
echo "              ";
echo $LNG["language"];
echo "              </span>\n                        </h2>\n                        <div class=\"groupstabescontant\">\n                            <form id=\"frmccc\" name=\"\" method=\"post\">\n                                ";
echo generate_token("form");
echo "                                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                                    <tbody>\n                                    <tr>\n                                        <td class=\"\">\n                                            <select name=\"language\">\n                                                <option value=\"\">\n                                                    ";
echo $LNG["select"];
echo "                                                </option>\n                                                ";
foreach ($lang_code as $k => $v) {
    if (!is_file("../" . $languagedirectorypath . "/" . $k . ".txt")) {
        echo "                                                        <option value=\"";
        echo $k;
        echo "\">\n                                                            ";
        echo $k;
        echo "                                                        </option>\n                                                        ";
    }
}
echo "                                            </select>\n\n                                            <input   value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"\n                                                     onclick=\"SubmitForm ('#btnaddgroup','language.user.add','#frmccc','#notification','true','#main_loader');\"/>\n                                        </td>\n                                    </tr>\n                                    </tbody>\n                                </table>\n                            </form>\n                        </div></td>\n                    <td style=\"vertical-align: top;\"><h2>\n                            <span class=\"groupstabesheadertext\">Export language</span>\n                        </h2>\n                        <div class=\"groupstabescontant\">\n                            <form method=\"post\"   style=\"float: left;\"\n                                  action=\"includes/download.php\" id=\"frms\">\n                                <input type=\"hidden\" name=\"defaultloadpage\" value=\"language.add.php\" />\n                                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                                    <tbody>\n                                    <tr>\n                                        <td class=\"\"><span>\n                        ";
if ($id) {
    $ln = str_replace(".txt", "", $id);
} else {
    $ln = $config["language"];
}
echo "                        </span>  <input type=\"hidden\" value=\"";
if ($id) {
    echo $ln = str_replace(".txt", "", $id);
    if (file("../" . $languagedirectorypath . "/" . $ln . ".custom.txt")) {
        echo ".custom";
    }
} else {
    echo $ln = $config["language"];
}
echo ".txt\"  name=\"language\"/>\n                                            <input type=\"submit\" name=\"export\" value=\"Export ";
echo $ln;
echo " Language\" />\n                                        </td>\n                                    </tr>\n                                    </tbody>\n                                </table>\n                            </form>\n                        </div></td>\n                    <td style=\"vertical-align: top;\"><h2>\n                            <span class=\"groupstabesheadertext\">Import language</span>\n                        </h2>\n                        <div class=\"groupstabescontant\">\n                            <form   method=\"post\" enctype=\"multipart/form-data\" style=\"float: left;\">\n                                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                                    <tbody>\n                                    <tr>\n                                        <td class=\"\"><input  type=\"file\" name=\"lang\" />\n                                            <input type=\"hidden\" name=\"defaultloadpage\" value=\"language.add.php\" />\n                                            <input type=\"submit\" name=\"import\" value=\"Import Language\" />\n                                        </td>\n                                    </tr>\n                                    </tbody>\n                                </table>\n                            </form>\n                        </div></td>\n                </tr>\n            </table>\n            <div class=\"clear\"></div>\n            <hr />\n            ";
if ($language && $addlang) {
    $filed = str_replace(".txt", "", $language);
    if (file("../" . $languagedirectorypath . "/" . $filed . ".custom.txt")) {
        fopen("../" . $languagedirectorypath . "/" . $filed . ".custom.txt", "a");
        $data = sprintf("\n%s", "\$lng_languag['" . $name . "']='" . $value . "';");
        file_put_contents("../" . $languagedirectorypath . "/" . $filed . ".custom.txt", $data, FILE_APPEND);
    } else {
        copy("../" . $languagedirectorypath . "/" . $language, "../" . $languagedirectorypath . "/" . $filed . ".custom.txt");
        fopen("../" . $languagedirectorypath . "/" . $filed . ".custom.txt", "a");
        $data = sprintf("\n%s", "\$lng_languag['" . $name . "']='" . $value . "';");
        file_put_contents("../" . $languagedirectorypath . "/" . $filed . ".custom.txt", $data, FILE_APPEND);
    }
}
if ($id) {
    $lng_languag = NULL;
    $filed = str_replace(".txt", "", $id);
    if (is_file("../" . $languagedirectorypath . "/" . $filed . ".custom.txt")) {
        ob_start();
        include "../" . $languagedirectorypath . "/" . $filed . ".custom.txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    } else {
        ob_start();
        include "../" . $languagedirectorypath . "/" . $id;
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    }
    $program = $lng_languag;
} else {
    if (is_file("../" . $languagedirectorypath . "/English.custom.txt")) {
        ob_start();
        include "../" . $languagedirectorypath . "/English.custom.txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    } else {
        ob_start();
        include "../" . $languagedirectorypath . "/English.txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    }
    $program = $lng_languag;
}
$lng_languag = NULL;
ob_start();
include "../" . $languagedirectorypath . "/English.txt";
$lang_cont = ob_get_contents();
ob_end_clean();
eval($lang_cont);
$original = $lng_languag;
foreach ($original as $k => $v) {
    if (!$program[$k] || $program[$k] == "") {
        $blank++;
    }
}
$diff = array_diff($original, $program);
$diff = count($diff);
$all = count($program);
$same = $all - $diff;
$blank = $blank ? $blank : "0";
echo "            <style>\n                .language-link a{text-decoration: none;font-size:15px;padding:5px 10px;display:inline-block}\n                table td.fieldlabel{text-align: right;}\n                table td.fieldarea{position: relative;padding:5px;float:none;width:50%}\n                table td.fieldarea input{}\n                table td.fieldarea img{right:0;top:9px;}\n                #content table.form, fieldset{width:100%}\n            </style>\n            <div style=\"text-align: right;border-bottom:#ddd solid 1px;padding-bottom:10px\" class=\"language-link\">\n                <div style=\"float: left;\">\n                    Current Language  : <select name=\"language\"\n                                                onchange=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php',this.value);\" style=\"margin-bottom:5px\">\n                        <option>\n                            ";
echo $LNG["select_"];
echo "                            ";
echo $LNG["language"];
echo "                        </option>\n                        ";
$myDirectory = opendir("../" . $languagedirectorypath . "/");
while ($dir = readdir($myDirectory)) {
    $template = explode("_", $dir);
    if (is_file("../" . $languagedirectorypath . "/" . $dir) && $dir != "." && $dir != ".." && $dir != "" && !deregi(".custom", $dir) && !deregi(".htaccess", $dir) && !deregi("index", $dir)) {
        echo "                                    <option value=\"";
        echo $dir;
        echo "\"\n                                        ";
        if ($id == $dir) {
            echo "selected";
        }
        if (str_replace(".txt", "", $dir) == "English" && !$id) {
            echo "selected";
        }
        echo " >\n                                        ";
        echo str_replace(".txt", "", $dir);
        echo "                                    </option>\n                                    ";
    }
}
closedir($myDirectory);
echo "                    </select>\n                </div>\n                <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php','";
echo $id;
echo "&filter=all');\">All -\n                    ";
echo $all;
echo "                </a>\n                | <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php','";
echo $id;
echo "&filter=same');\">Same -\n                    ";
echo $same;
echo "                </a>\n                | <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php','";
echo $id;
echo "&filter=diff');\">Different -\n                    ";
echo $diff;
echo "                </a>\n                | <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php','";
echo $id;
echo "&filter=not');\">No Translate -\n                    ";
echo $blank;
echo "                </a>\n            </div>\n            <div class=\"clear\"></div>\n            <table class=\"form\">\n                <tr>\n                    <td class=\"fieldlabel\">\n                        <form method=\"post\">\n                            <input type=\"text\" style=\"border: #eee solid 1px;\"\n                                   onfocus=\"if(this.value=='Search Word in ";
echo $config["language"];
echo "')value='';\"\n                                   onblur=\"if(this.value=='')this.value='Search Word in ";
echo $config["language"];
echo "';\"  value=\"Search Word in ";
echo $config["language"];
echo "\"\n                                   name=\"find\" />\n                        </form></td>\n                    <td class=\"fieldarea\">\n                        <form method=\"post\">\n                            <input type=\"text\" name=\"search\"   style=\"border: #eee solid 1px;\"\n                                   onfocus=\"if(this.value=='Search Word in ";
if ($id) {
    echo str_replace(".txt", "", $id);
} else {
    echo $config["language"];
}
echo "')value='';\"\n                                   onblur=\"if(this.value=='')this.value='Search Word in ";
if ($id) {
    echo str_replace(".txt", "", $id);
} else {
    echo $config["language"];
}
echo "';\"  value=\"Search Word in ";
if ($id) {
    echo str_replace(".txt", "", $id);
} else {
    echo $config["language"];
}
echo "\" />\n                        </form></td>\n\n                </tr>\n\n            </table>\n            <form method=\"post\" id=\"frmlangbbc\">\n\n                <table class=\"form\">\n\n                    <input type=\"hidden\" name=\"flag\" id=\"flag\" value=\"\" />\n                    <input type=\"hidden\" name=\"language\" value=\"";
echo $id ? $id : "English.txt";
echo "\" />\n                    ";
$lng_languag = NULL;
if ($id) {
    $filed = str_replace(".txt", "", $id);
    if (is_file("../" . $languagedirectorypath . "/" . $filed . ".custom.txt")) {
        ob_start();
        include "../" . $languagedirectorypath . "/" . $filed . ".custom.txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    } else {
        ob_start();
        include "../" . $languagedirectorypath . "/" . $id;
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    }
    $langarr = $lng_languag;
} else {
    if (is_file("../" . $languagedirectorypath . "/English.custom.txt")) {
        ob_start();
        include "../" . $languagedirectorypath . "/English.custom.txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    } else {
        ob_start();
        include "../" . $languagedirectorypath . "/English.txt";
        $lang_cont = ob_get_contents();
        ob_end_clean();
        eval($lang_cont);
    }
    $langarr = $lng_languag;
    $id = "English.txt";
}
$start = $_GET["start"];
if (0 >= $start) {
    $start = 0;
}
ob_start();
include "../" . $languagedirectorypath . "/English.txt";
$lang_cont = ob_get_contents();
ob_end_clean();
eval($lang_cont);
$orgirr = $lng_languag;
$eu = $start - 0;
$limit = 100;
$this1 = $eu + $limit;
$back = $eu - $limit;
$next = $eu + $limit;
$cnt = count($orgirr);
$nume = $cnt;
$d = 0;
$ki = 0;
if ($search) {
    $flag = true;
    foreach ($orgirr as $k => $v) {
        if (deregi($search, $langarr[$k])) {
            $flag = false;
            echo "                                <tr>\n                                    <td style=\"width: 49%;\">";
            echo $orgirr[$k];
            echo "</td>\n                                    <td><input onKeyUp=\"setFlag();\" style=\"width: 90%;\" id=\"";
            echo $k;
            echo "\"  type=\"text\" name=\"lang[";
            echo $k;
            echo "]\" value=\"";
            echo htmlspecialchars($langarr[$k]);
            echo "\" />\n                                        <a title=\"Google Translator\" href=\"javascript: translateALl('#";
            echo $k;
            echo "','";
            echo $orgirr[$k];
            echo "','";
            echo $id;
            echo "')\" ><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;position:absolute;\"  /></a>\n                                    </td>\n\n                                </tr>\n                                ";
        }
    }
} else {
    if ($find) {
        foreach ($orgirr as $k => $v) {
            if (deregi($find, $orgirr[$k])) {
                echo "                                <tr>\n                                    <td style=\"width: 49%;\" class=\"fieldlabel\">";
                echo $orgirr[$k];
                echo "</td>\n                                    <td class=\"fieldarea\"><input onKeyUp=\"setFlag();\" style=\"width: 90%;\" id=\"";
                echo $k;
                echo "\"  type=\"text\" name=\"lang[";
                echo $k;
                echo "]\" value=\"";
                echo htmlspecialchars($langarr[$k]);
                echo "\" />\n                                        <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                echo $k;
                echo "','";
                echo $orgirr[$k];
                echo "','";
                echo $id;
                echo "')\" ><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;position:absolute;\"  /></a>\n                                    </td>\n                                </tr>\n                                ";
            }
        }
    } else {
        if ($filter && $filter == "diff") {
            foreach ($orgirr as $k => $v) {
                if ($langarr[$k] != $orgirr[$k]) {
                    echo "                                    <tr>\n                                        <td  style=\"width: 49%;\" class=\"fieldlabel\">";
                    echo $orgirr[$k];
                    echo "</td>\n                                        <td  class=\"fieldarea\"><input onKeyUp=\"setFlag();\" style=\"width: 90%;\" id=\"";
                    echo $k;
                    echo "\"  type=\"text\" name=\"lang[";
                    echo $k;
                    echo "]\" value=\"";
                    echo htmlspecialchars($langarr[$k]);
                    echo "\" />\n                                            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                    echo $k;
                    echo "','";
                    echo $orgirr[$k];
                    echo "','";
                    echo $id;
                    echo "')\"><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;position:absolute;\"  /></a></td>\n                                    </tr>\n                                    ";
                }
            }
        } else {
            if ($filter && $filter == "same") {
                foreach ($orgirr as $k => $v) {
                    if ($orgirr[$k] == $langarr[$k]) {
                        echo "                                    <tr>\n                                        <td  style=\"width: 49%;\" class=\"fieldlabel\">";
                        echo $orgirr[$k];
                        echo "                                        </td>\n                                        <td  class=\"fieldarea\"><input onKeyUp=\"setFlag();\" style=\"width: 90%;\" id=\"";
                        echo $k;
                        echo "\"  type=\"text\" name=\"lang[";
                        echo $k;
                        echo "]\" value=\"";
                        echo htmlspecialchars($langarr[$k]);
                        echo "\" />\n                                            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                        echo $k;
                        echo "','";
                        echo $orgirr[$k];
                        echo "','";
                        echo $id;
                        echo "')\"><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;position:absolute;\"  /></a></td>\n                                    </tr>\n                                    ";
                    }
                }
            } else {
                if ($filter && $filter == "not") {
                    foreach ($orgirr as $k => $v) {
                        if ($orgirr[$k] != "" && !$langarr[$k]) {
                            echo "                                    <tr>\n                                        <td style=\"width: 49%;\" class=\"fieldlabel\">";
                            echo $orgirr[$k];
                            echo "</td>\n                                        <td class=\"fieldarea\"><input onKeyUp=\"setFlag();\" id=\"";
                            echo $k;
                            echo "\"  style=\"width: 90%;\" type=\"text\" name=\"lang[";
                            echo $k;
                            echo "]\" value=\"";
                            echo htmlspecialchars($langarr[$k]);
                            echo "\" />\n                                            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                            echo $k;
                            echo "','";
                            echo $orgirr[$k];
                            echo "','";
                            echo $id;
                            echo "')\"><img src=\"images/googles.png\" border=\"0\"  vspace=\"0\"  style=\"vertical-align: middle;position:absolute;\"  /></a></td>\n                                    </tr>\n                                    ";
                        }
                    }
                } else {
                    foreach ($orgirr as $k => $v) {
                        $d++;
                        if ($eu <= $d && $ki < $limit) {
                            $ki++;
                            echo "                                    <tr>\n                                        <td style=\"width: 49%;\" class=\"fieldlabel\">";
                            echo $orgirr[$k];
                            echo "</td>\n                                        <td  class=\"fieldarea\"><input onKeyUp=\"setFlag();\" type=\"text\" id=\"";
                            echo $k;
                            echo "\"\n                                                                      name=\"lang[";
                            echo $k;
                            echo "]\" value=\"";
                            echo htmlspecialchars($langarr[$k]);
                            echo "\" style=\"width: 90%;\" />\n                                            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                            echo $k;
                            echo "','";
                            echo $orgirr[$k];
                            echo "','";
                            echo $id;
                            echo "')\"><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;position:absolute;\"  /></a></td>\n                                    </tr>\n                                    ";
                        }
                    }
                }
            }
        }
    }
}
echo "                </table>\n            </form>\n            ";
$p_limit = 100;
$p_f = $_GET["p_f"];
if (0 >= $p_f) {
    $p_f = 0;
}
$p_fwd = $p_f + $p_limit;
$p_back = $p_f - $p_limit;
echo "            <div style=\"text-align: center;margin-top:5px\">\n\n                <form method=\"post\" onSubmit=\"return confirm('Are you sure want to reset default Language');\">\n                    <input type=\"hidden\" name=\"reseted\" value=\"";
echo $id;
echo "\" />\n                    <input type=\"hidden\" name=\"defaultloadpage\" value=\"language.add.php\" />\n                    <input value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["default"];
echo "\"  class=\"btn\" type=\"submit\" />\n                </form>\n\n            </div>\n            <table align = 'center' class='paging fixedbtn'  >\n                <tr>\n                    <td><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroups\" class=\"btn save\" type=\"button\"\n                               onclick=\"SubmitForm ('#btnaddgroups','language.user','#frmlangbbc','#notification','true','#main_loader');\n    resetFlag();\"/>\n                    </td>\n                    <td style=\"text-align: center;\">";
if (0 <= $back) {
    echo "                            <a onClick=\"return checkFlag();\" href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php','";
    echo $id;
    echo "&start=";
    echo $back;
    echo "&p_f=";
    echo $p_f;
    echo "');\" style='text-decoration:none;'>&lsaquo;\n                                &lsaquo;\n                            </a>\n                            ";
}
$sky = 0;
$i = $p_f;
while ($i < $nume) {
    $sky++;
    if ($i != $eu) {
        $i2 = $i + $p_f;
        echo "                                <a   onclick=\"return checkFlag();\" href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php','";
        echo $id;
        echo "&start=";
        echo $i;
        echo "&p_f=";
        echo $p_f;
        echo "');\" style='text-decoration:none;padding:1px; margin:20px 5px 5px 5px;'><span class=\"box\">\n              ";
        echo $sky;
        echo "              </span>\n                                </a>\n                                ";
    } else {
        echo "<a class='selected' href='#' ><span class='box'>" . $sky . "</span></a>";
    }
    $i = $i + $limit;
}
if ($this1 < $nume) {
    echo "                            <a  onclick=\"return checkFlag();\" href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.add.php','";
    echo $id;
    echo "&start=";
    echo $next;
    echo "&p_f=";
    echo $p_f;
    echo "');\" style='text-decoration:none;'>&rsaquo;\n                                &rsaquo;\n                            </a>\n                            ";
}
echo "                    </td>\n                    <td style=\"width: 300px;\"></td>\n                </tr>\n            </table>\n        </div>\n    </div>\n</div>\n";
$fileverioncheck = "6.1.0";

?>