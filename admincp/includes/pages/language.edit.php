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
    unlink("language/" . $reseted);
}
if ($import) {
    if (!file_exists("language/" . $_FILES["lang"]["tmp_name"])) {
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
                $LNG = NULL;
                include $_FILES["lang"]["tmp_name"];
                if (0 < count($LNG)) {
                    $LNG = NULL;
                    include "language/English.txt";
                    move_uploaded_file($_FILES["lang"]["tmp_name"], "language/" . $_FILES["lang"]["name"]);
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
echo "\n<script>\nfunction setFlag(){\n    \$(\"#flag\").val('2');\n}\nfunction resetFlag(){\n     \$(\"#flag\").val('');\n}\nfunction checkFlag(){\n    if(\$(\"#flag\").val()!=''){\n        return confirm(\"Your changes will be lost. Are you sure want to continue.\");\n    }\n}\nfunction translateALl(id,word,lang){\n    //frmlang\n    \$(\"#main_loader\").show();\n\$.post('includes/main.save.php?page=language.translate',{w: word,language: lang}, function(data, textStatus) {\n     \$(\"#main_loader\").hide();\n    data=data.split(\":\");\n     if(data[0]==\"ERROR\"){\n        alert(data[1]);\n     }else if(data[0]){\n        \$(id).val(data[0]);\n     }\n});\n}\n</script>\n\n <style>\n    .sum td{border-right:#ddd solid 1px;text-align: left;padding-left:10px}\n</style>\n\n<div id=\"notification\"></div>\n\n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n";
$lang_code = ["Afrikaans" => "af", "Albanian" => "sq", "Arabic" => "ar", "Azerbaijani" => "az", "Basque" => "bs", "Bengali" => "bn", "Chinese" => "zh", "Esperanto" => "eo", "Georgian" => "ka", "Haitian Creole" => "ht", "Kannada" => "kn", "Latin" => "la", "Tamil" => "ta", "Telugu" => "te", "Belarusian" => "be", "Bulgarian" => "bg", "Catalan" => "ca", "Chinese-Simplified" => "zh-CN", "Chinese-Traditional" => "zh-TW", "Croatian" => "hr", "Czech" => "cs", "Danish" => "da", "Dutch" => "nl", "English" => "en", "Estonian" => "et", "Filipino" => "tl", "Finnish" => "fi", "French" => "fr", "Galician" => "gl", "German" => "de", "Greek" => "el", "Hebrew" => "iw", "Hindi" => "hi", "Gujarati" => "gu", "Hungarian" => "hu", "Icelandic" => "is", "Indonesian" => "id", "Irish" => "ga", "Italian" => "it", "Japanese" => "ja", "Korean" => "ko", "Latvian" => "lv", "Lithuanian" => "lt", "Macedonian" => "mk", "Malay" => "ms", "Maltese" => "mt", "Norwegian" => "no", "Persian" => "fa", "Polish" => "pl", "Portuguese" => "pt", "Romanian" => "ro", "Russian" => "ru", "Serbian" => "sr", "Slovak" => "sk", "Slovenian" => "sl", "Spanish" => "es", "Swahili" => "sw", "Swedish" => "sv", "Thai" => "th", "Turkish" => "tr", "Ukrainian" => "uk", "Vietnamese" => "vi", "Welsh" => "cy", "Yiddish" => "yi"];
$LNG = NULL;
if ($updatecustom) {
    foreach ($lang_code as $k => $v) {
        if (is_file("language/" . $k . ".custom.txt")) {
            include "language/" . $k . ".txt";
            $origin = $LNG;
            $LNG = NULL;
            include "language/" . $k . ".custom.txt";
            $diff = array_diff($origin, $LNG);
            $LNG = NULL;
            $origin = NULL;
            if (is_array($diff)) {
                foreach ($diff as $dk => $dv) {
                    $bufs .= "\$LNG['" . $dk . "']='" . $dv . "';" . "\n";
                }
            }
            if ($bufs) {
                $data = file_get_contents("language/" . $k . ".custom.txt");
                $data = str_replace("?>", "\n" . $bufs . "?>", $data);
                $file = fopen("language/" . $k . ".custom.txt", "w");
                fwrite($file, $data);
                fclose($file);
                $data = NULL;
            }
            $bufs = NULL;
        }
    }
}
$flag = 1;
foreach ($lang_code as $k => $v) {
    if ($flag && is_file("language/" . $k . ".custom.txt")) {
        include "language/" . $k . ".custom.txt";
        $cnt = count($LNG);
        $LNG = NULL;
        include "language/" . $k . ".txt";
        if ($cnt < count($LNG)) {
            $flag = 0;
            echo "<div class='info' id='notification1'>Some words missing in your language <a href=\"javascript: \n                    reloadcurrent('utilities.language&defaultloadpage=language.edit.php','&updatecustom=true');\">click here</a> to update.</div>";
        }
        $LNG = NULL;
    }
}
include "language/English.txt";
echo "\n <div  class=\"groupstabes\">\n\n      <table class=\"sum\">\n        <tr>\n\n\n          <td><h2>\n              <span class=\"groupstabesheadertext\">\n              Google APi key\n              </span>\n            </h2>\n            <div class=\"groupstabescontant\">\n              <form id=\"frmkri\" name=\"\" method=\"post\">\n                ";
echo generate_token("form");
echo "                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                  <tbody>\n                    <tr>\n\n                     <td class=\"\" style=\"text-align: left;\"><input type=\"text\" class=\"txt\"  placeholder=\"Google ";
echo $LNG["api"] . " " . $LNG["key"];
echo "\" name=\"googlelanguageapi\" value=\"";
echo $config["googlelanguageapi"];
echo "\" />\n                        <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroups\" class=\"btn save\" type=\"button\" onClick=\"SubmitForm ('#btnaddgroups','settingappear','#frmkri','#notification','true','#main_loader');\"/>\n                            <br />\n                           <a href=\"https://code.google.com/apis/console/?api=translate\" title=\"getyour API key\" target=\"_blank\"> Google APIs console </a>\n\n                         </td>\n\n                    </tr>\n                  </tbody>\n                </table>\n              </form>\n            </div></td>\n\n\n\n          <td style=\"vertical-align: top;\"><h2>\n              <span class=\"groupstabesheadertext\">\n              ";
echo $LNG["add"];
echo "              ";
echo $LNG["language"];
echo "              </span>\n            </h2>\n            <div class=\"groupstabescontant\">\n              <form id=\"frmccc\" name=\"\" method=\"post\">\n                ";
echo generate_token("form");
echo "                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                  <tbody>\n                    <tr>\n                      <td class=\"\">\n                        <select name=\"language\">\n                          <option value=\"\">\n                          ";
echo $LNG["select"];
echo "                          </option>\n                          ";
foreach ($lang_code as $k => $v) {
    if (!is_file("../" . $languagedirectorypath . "/" . $k . ".txt")) {
        echo "                          <option value=\"";
        echo $k;
        echo "\">\n                          ";
        echo $k;
        echo "                          </option>\n                          ";
    }
}
echo "                        </select>\n\n                        <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"\n onclick=\"SubmitForm ('#btnaddgroup','language.user.add','#frmccc','#notification','true','#main_loader');\"/>\n                      </td>\n                    </tr>\n                  </tbody>\n                </table>\n              </form>\n            </div></td>\n          <td style=\"vertical-align: top;\"><h2>\n              <span class=\"groupstabesheadertext\">Export language</span>\n            </h2>\n            <div class=\"groupstabescontant\">\n              <form method=\"post\"   style=\"float: left;\"\naction=\"includes/download.php\" id=\"frms\">\n                <input type=\"hidden\" name=\"defaultloadpage\" value=\"language.edit.php\" />\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                  <tbody>\n                    <tr>\n                      <td class=\"\"><span>\n                        ";
if ($id) {
    $ln = str_replace(".txt", "", $id);
} else {
    $ln = $config["language"];
}
echo "                        </span>  <input type=\"hidden\" value=\"";
if ($id) {
    $ln = str_replace(".txt", "", $id);
} else {
    $ln = $config["language"];
}
echo ".txt\"  name=\"language\"/>\n                        <input type=\"submit\" name=\"export\" value=\"Export ";
echo $ln;
echo " Language\" />\n                      </td>\n                    </tr>\n                  </tbody>\n                </table>\n              </form>\n            </div></td>\n          <td style=\"vertical-align: top;\"><h2>\n              <span class=\"groupstabesheadertext\">Import language</span>\n            </h2>\n            <div class=\"groupstabescontant\">\n              <form   method=\"post\" enctype=\"multipart/form-data\" style=\"float: left;\">\n                <table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n                  <tbody>\n                    <tr>\n                      <td class=\"\"><input  type=\"file\" name=\"lang\" />\n                       <input type=\"hidden\" name=\"defaultloadpage\" value=\"language.edit.php\" />\n                        <input type=\"submit\" name=\"import\" value=\"Import Language\" />\n                      </td>\n                    </tr>\n                  </tbody>\n                </table>\n              </form>\n            </div></td>\n        </tr>\n      </table>\n      <div class=\"clear\"></div>\n      <hr />\n\n\n";
if ($language && $addlang) {
    $filed = str_replace(".txt", "", $language);
    if (file("language/" . $filed . ".custom.txt")) {
        $data = file_get_contents("language/" . $filed . ".custom.txt");
        $data = str_replace("?>", "\n\$LNG['" . $name . "']='" . $value . "';" . "\n" . "?>", $data);
        $file = fopen("language/" . $filed . ".custom.txt", "w");
        fwrite($file, $data);
        fclose($file);
    } else {
        copy("language/" . $language, "language/" . $filed . ".custom.txt");
        $data = file_get_contents("language/" . $filed . ".custom.txt");
        $data = str_replace("?>", "\n\$LNG['" . $name . "']='" . $value . "';" . "\n" . "?>", $data);
        $file = fopen("language/" . $filed . ".custom.txt", "w");
        fwrite($file, $data);
        fclose($file);
    }
}
if ($id) {
    $LNG = NULL;
    $filed = str_replace(".txt", "", $id);
    if (is_file("language/" . $filed . ".custom.txt")) {
        include "language/" . $filed . ".custom.txt";
    } else {
        include "language/" . $id;
    }
    $program = $LNG;
} else {
    if (is_file("language/English.custom.txt")) {
        include "language/English.custom.txt";
    } else {
        include "language/English.txt";
    }
    $program = $LNG;
}
$LNG = NULL;
include "language/English.txt";
$original = $LNG;
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
echo "<style>\n    .language-link a{text-decoration: none;font-size:15px;padding:5px 10px;display:inline-block}\n    table td.fieldlabel{text-align: right;}\n    table td.fieldarea{position: relative;padding:5px;float:none;width:50%}\n    table td.fieldarea input{ }\n    table td.fieldarea img{right:0;top:9px;}\n    #content table.form, fieldset{width:100%}\n</style>\n      <div style=\"text-align: right;border-bottom:#ddd solid 1px;padding-bottom:20px\" class=\"language-link\">\n        <div style=\"float: left;\">\n              Current Language  : <select name=\"language\"\nonchange=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php',this.value);\" style=\"margin-bottom:5px\">\n              <option>\n              ";
echo $LNG["select_"];
echo "              ";
echo $LNG["language"];
echo "              </option>\n              ";
$myDirectory = opendir("../" . $languagedirectorypath . "/");
while ($dir = readdir($myDirectory)) {
    $template = explode("_", $dir);
    if (is_file("../" . $languagedirectorypath . "/" . $dir) && $dir != "." && $dir != ".." && $dir != "" && !deregi(".custom", $dir) && !deregi(".htaccess", $dir) && !deregi("index", $dir)) {
        echo "              <option value=\"";
        echo $dir;
        echo "\"\n                ";
        if ($id == $dir) {
            echo "selected";
        }
        if (str_replace(".txt", "", $dir) == "English" && !$id) {
            echo "selected";
        }
        echo " >\n              ";
        echo str_replace(".txt", "", $dir);
        echo "              </option>\n              ";
    }
}
closedir($myDirectory);
echo "            </select>\n        </div>\n        <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php','";
echo $id;
echo "&filter=all');\">All -\n          ";
echo $all;
echo "        </a>\n        | <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php','";
echo $id;
echo "&filter=same');\">Same -\n          ";
echo $same;
echo "        </a>\n        | <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php','";
echo $id;
echo "&filter=diff');\">Different -\n          ";
echo $diff;
echo "        </a>\n        | <a href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php','";
echo $id;
echo "&filter=not');\">No Translate -\n          ";
echo $blank;
echo "        </a>\n      </div>\n      <div class=\"clear\"></div>\n\n     <table class=\"form\">\n         <tr>\n             <td class=\"fieldlabel\">\n                 <form method=\"post\">\n                     <input type=\"text\" style=\"border: #eee solid 1px;\"\n                            onfocus=\"if(this.value=='Search Word in ";
echo $config["language"];
echo "')value='';\"\n                            onblur=\"if(this.value=='')this.value='Search Word in ";
echo $config["language"];
echo "';\"  value=\"Search Word in ";
echo $config["language"];
echo "\"\n                            name=\"find\" />\n                 </form></td>\n             <td class=\"fieldarea\">\n                 <form method=\"post\">\n                     <input type=\"text\" name=\"search\"   style=\"border: #eee solid 1px;\"\n                            onfocus=\"if(this.value=='Search Word in ";
if ($id) {
    echo str_replace(".txt", "", $id);
} else {
    echo $config["language"];
}
echo "')value='';\"\n                            onblur=\"if(this.value=='')this.value='Search Word in ";
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
echo "\" />\n                 </form></td>\n\n         </tr>\n     </table>\n     <form method=\"post\" id=\"frmlang\">\n\n      <table class=\"form\">\n\n\n        <input type=\"hidden\" name=\"flag\" id=\"flag\" value=\"\" />\n        <input type=\"hidden\" name=\"language\" value=\"";
echo $id ? $id : "English.txt";
echo "\" />\n\n";
$LNG = NULL;
if ($id) {
    $filed = str_replace(".txt", "", $id);
    if (is_file("language/" . $filed . ".custom.txt")) {
        include "language/" . $filed . ".custom.txt";
    } else {
        include "language/" . $id;
    }
    $langarr = $LNG;
} else {
    if (is_file("language/English.custom.txt")) {
        include "language/English.custom.txt";
    } else {
        include "language/English.txt";
    }
    $langarr = $LNG;
    $id = "English.txt";
}
$start = $_GET["start"];
if (0 >= $start) {
    $start = 0;
}
include "language/English.txt";
$orgirr = $LNG;
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
            echo "        <tr>\n            <td class=\"fieldlabel\">";
            echo $orgirr[$k];
            echo "x</td>\n            <td class=\"fieldarea\"><input style=\"width: 90%;\"  onkeyup=\"setFlag();\" id=\"";
            echo $k;
            echo "\"\n             type=\"text\" name=\"lang[";
            echo $k;
            echo "]\" value=\"";
            echo htmlspecialchars($langarr[$k]);
            echo "\"  />\n            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
            echo $k;
            echo "','";
            echo $orgirr[$k];
            echo "','";
            echo $id;
            echo "')\" ><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;\"  /></a>\n            </td>\n\n        </tr>\n        ";
        }
    }
    if ($flag) {
        echo "        <!--\n        <tr>\n            <td colspan=\"2\" style=\"text-align: center !important;\">No Result Found <br /><br />\n            <form method=\"post\">\n            <input type=\"hidden\" name=\"language\" value=\"";
        echo $id;
        echo "\" />\n                Name : <input type=\"text\" name=\"name\" /> Value: <input type=\"text\" name=\"value\" value=\"";
        echo $search;
        echo "\" />\n                <input type=\"submit\" name=\"addlang\" value=\"Add\" class=\"btn save\"  />\n            </form>\n            </td>\n        </tr>\n        -->\n        ";
    }
} else {
    if ($filter && $filter == "diff") {
        foreach ($orgirr as $k => $v) {
            if ($langarr[$k] != $orgirr[$k]) {
                echo "        <tr>\n            <td class=\"fieldlabel\">";
                echo $orgirr[$k];
                echo "</td>\n            <td class=\"fieldarea\"><input onkeyup=\"setFlag();\"  style=\"width: 90%;\" id=\"";
                echo $k;
                echo "\"  type=\"text\" name=\"lang[";
                echo $k;
                echo "]\" value=\"";
                echo htmlspecialchars($langarr[$k]);
                echo "\" />\n            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                echo $k;
                echo "','";
                echo $orgirr[$k];
                echo "','";
                echo $id;
                echo "')\"><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;\"  /></a></td>\n        </tr>\n        ";
            }
        }
    } else {
        if ($filter && $filter == "same") {
            foreach ($orgirr as $k => $v) {
                if ($orgirr[$k] == $langarr[$k]) {
                    echo "        <tr>\n            <td class=\"fieldlabel\">";
                    echo $orgirr[$k];
                    echo " </td>\n            <td class=\"fieldarea\"><input style=\"width: 90% !important;\" onkeyup=\"setFlag();\" id=\"";
                    echo $k;
                    echo "\"  type=\"text\" name=\"lang[";
                    echo $k;
                    echo "]\" value=\"";
                    echo htmlspecialchars($langarr[$k]);
                    echo "\" />\n            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                    echo $k;
                    echo "','";
                    echo $orgirr[$k];
                    echo "','";
                    echo $id;
                    echo "')\"><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;\"  /></a></td>\n\n        </tr>\n        ";
                }
            }
        } else {
            if ($filter && $filter == "not") {
                foreach ($orgirr as $k => $v) {
                    if ($orgirr[$k] != "" && !$langarr[$k]) {
                        echo "        <tr>\n             <td class=\"fieldlabel\">";
                        echo $orgirr[$k];
                        echo "            <td class=\"fieldarea\"><input  onkeyup=\"setFlag();\" id=\"";
                        echo $k;
                        echo "\"  style=\"width: 90%;\"  type=\"text\" name=\"lang[";
                        echo $k;
                        echo "]\" value=\"";
                        echo htmlspecialchars($langarr[$k]);
                        echo "\" />\n            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                        echo $k;
                        echo "','";
                        echo $orgirr[$k];
                        echo "','";
                        echo $id;
                        echo "')\"><img src=\"images/googles.png\" border=\"0\"  vspace=\"0\"  style=\"vertical-align: middle;\"  /></a></td>\n\n            </td>\n        </tr>\n        ";
                    }
                }
            } else {
                foreach ($orgirr as $k => $v) {
                    $d++;
                    if ($eu <= $d && $ki < $limit) {
                        $ki++;
                        echo "        <tr>\n            <td class=\"fieldlabel\">";
                        echo $orgirr[$k];
                        echo "</td>\n            <td  class=\"fieldarea\"><input onkeyup=\"setFlag();\" type=\"text\"  style=\"width: 90%;\" id=\"";
                        echo $k;
                        echo "\" name=\"lang[";
                        echo $k;
                        echo "]\" value=\"";
                        echo htmlspecialchars($langarr[$k]);
                        echo "\" />\n            <a title=\"Google Translator\" href=\"javascript: translateALl('#";
                        echo $k;
                        echo "','";
                        echo $orgirr[$k];
                        echo "','";
                        echo $id;
                        echo "')\"><img src=\"images/googles.png\" border=\"0\" vspace=\"0\"  style=\"vertical-align: middle;\"  /></a></td>\n\n        </tr>\n        ";
                    }
                }
            }
        }
    }
}
echo "</tbody></table>\n</form>\n";
$p_limit = 100;
$p_f = $_GET["p_f"];
if (0 >= $p_f) {
    $p_f = 0;
}
$p_fwd = $p_f + $p_limit;
$p_back = $p_f - $p_limit;
echo "\n<div style=\"text-align: center;margin-top:5px\">\n  <form method=\"post\" onsubmit=\"return confirm('Are you sure want to reset default Language');\">\n <input type=\"hidden\" name=\"reseted\" value=\"";
echo $id;
echo "\" />\n<input value=\"";
echo $LNG["reset"];
echo " ";
echo $LNG["default"];
echo "\"  class=\"btn\" type=\"submit\" />\n</form>\n</div>\n\n<table align = 'center' class='paging fixedbtn'  ><tr><td> <input value=\"";
echo $LNG["save"];
echo "\" id=\"btnaddgroups\" class=\"btn save\" type=\"button\"\n onclick=\"SubmitForm ('#btnaddgroups','language.edit','#frmlang','#notification','true','#main_loader');resetFlag();\"/> </td> <td  align=center>\n\n";
if (0 <= $back) {
    echo "<a onclick=\"return checkFlag();\" href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php','";
    echo $id;
    echo "&start=";
    echo $back;
    echo "&p_f=";
    echo $p_f;
    echo "');\" style='text-decoration:none;'>&lsaquo;&lsaquo;</a>\n";
}
$sky = 0;
$i = $p_f;
while ($i < $nume) {
    $sky++;
    if ($i != $eu) {
        $i2 = $i + $p_f;
        echo "<a  onclick=\"return checkFlag();\" href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php','";
        echo $id;
        echo "&start=";
        echo $i;
        echo "&p_f=";
        echo $p_f;
        echo "');\" style='text-decoration:none;  padding:1px; margin:20px 5px 5px 5px;'> <span class=\"box\">";
        echo $sky;
        echo "</span> </a>\n";
    } else {
        echo "<a class='selected' href='#' ><span class='box'>" . $sky . "</span></a>";
    }
    $i = $i + $limit;
}
if ($this1 < $nume) {
    echo "<a  onclick=\"return checkFlag();\" href=\"javascript: reloadcurrent('utilities.language&defaultloadpage=language.edit.php','";
    echo $id;
    echo "&start=";
    echo $next;
    echo "&p_f=";
    echo $p_f;
    echo "');\" style='text-decoration:none;'> &rsaquo;&rsaquo; </a>\n";
}
echo "</td> <td style=\"width: 300px;\">\n</td> </tr></table></div>\n</div>\n</div>";
$fileverioncheck = "6.1.0";

?>