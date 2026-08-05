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
echo "<style>\n.form{margin-bottom: 4px !important;}\n.box{\n    border: 1px solid #ccc;\n    padding:4px 6px 4px 6px;\n    margin:20px 2px 5px 2px;\n    height: 7px;\n}\n.selected{\n    font-weight: bold;\n}\n</style>\n<script>\nfunction setFlag(){\n    \$(\"#flag\").val('2');\n}\nfunction resetFlag(){\n     \$(\"#flag\").val('');\n}\nfunction checkFlag(){\n    if(\$(\"#flag\").val()!=''){\n        return confirm(\"Your changes will be lost. Are you sure want to continue.\");\n    }\n}\nfunction translateALl(id,word,lang){\n    //frmlang\n    \$(\"#main_loader\").show();\n\$.post('includes/main.save.php?page=language.translate',{w: word,language: lang}, function(data, textStatus) {\n     \$(\"#main_loader\").hide();\n    data=data.explode(\":\");\n     if(data[0]==\"ERROR\"){\n        alert(data[1]);\n     }else if(data[0]){\n        \$(id).val(data[0]);\n     }\n});\n}\n</script>\n<div id=\"notification\"></div>\n\n\n<div id=\"content\">\n<div id=\"content_padded\">\n\n";
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
echo "<div  class=\"groupstabes\"  style=\"width: 49%; float: left;\">\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">";
echo $LNG["add"];
echo " ";
echo $LNG["language"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frmccc\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n<tr>\n    <td class=\"fieldarea\"><span>\n<select name=\"language\">\n<option value=\"\">";
echo $LNG["select"];
echo "</option>\n";
foreach ($lang_code as $k => $v) {
    if (!is_file("language/" . $k . ".txt")) {
        echo "            <option value=\"";
        echo $k;
        echo "\">";
        echo $k;
        echo "</option>\n        ";
    }
}
echo "</select>\n\n    </span></td>\n</tr>\n<tr>\n    <td class=\"fieldarea\"><span>\n\n  <input value=\"";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\" class=\"btn save\" type=\"button\"\n onclick=\"SubmitForm ('#btnaddgroup','language.add','#frmccc','#notification','true','#main_loader');\"/>\n\n  </span></td>\n</tr>\n\n\n</tbody>\n</table>\n\n</form>\n</div></div>\n\n\n<div  class=\"groupstabes\"  style=\"width: 49%; float: right;\">\n  <h2>\n    <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n    <span class=\"groupstabesheadertext\">Google ";
echo $LNG["api"] . " " . $LNG["key"];
echo "</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n  </h2>\n  <div class=\"groupstabescontant\">\n\n<form id=\"frmkri\" name=\"\" method=\"post\">\n";
echo generate_token("form");
echo "\n<table class=\"form\" border=\"0\" cellpadding=\"3\" cellspacing=\"2\" width=\"100%\">\n<tbody>\n\n";

?>