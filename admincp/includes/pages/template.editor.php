<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$pageid = 531;
checkPagePermission($pageid);
echo "<script>\nfunction loadFiles(template){\n    if(\$.trim(\$('#'+template).html()))\n    {\n        \$('#'+template).html('');\n    }else{\n        \$('#main_loader').fadeIn();\n        \$.post('includes/pages/loadtemplatefiles.php', {template:template},function (data,  textStatus) {\n\n                \$('#'+template).html(data);\n                \$('#main_loader').fadeOut();\n                \$('.subsub').click(function(){\n                    \$(this).toggleClass('open');\n                    \$(this).parent().next().toggleClass('open');                    \n                });\n        });\n    }\n    \$('.main-tmp').toggleClass('open');    \n    \n}\nfunction showTemplate(templ){\n \n    var list=\$('.'+templ).length;\n    var obj=\$('.'+templ);\n    for(var i=0;i<list;i++){\n       \n        if(obj[i].style.display=='none'){\n            obj[i].style.display='';        \n        }else{\n            obj[i].style.display='none';\n        }\n    }\n}\n</script>\n<form method=\"post\">\n<table class=\"form\" >\n \n  <tr>\n        \n        <td>\n        \n        ";
echo $LNG["template"];
echo "  \n        <select name=\"template\">\n            <option value=\"\">";
echo $LNG["select"];
echo "</option>\n        ";
$myDirectory = opendir("../templates");
while ($dir = readdir($myDirectory)) {
    if (is_dir("../templates/" . $dir) && $dir != "." && $dir != ".." && $dir != "") {
        echo "                    <option value=\"";
        echo $dir;
        echo "\">";
        echo str_replace(".txt", "", $dir);
        echo "</option>\n                ";
    }
}
closedir($myDirectory);
echo "        </select>\n        \n       &nbsp;&nbsp;&nbsp;  Copy To  : <input type=\"text\" style=\"background: #f4f4f4;\"  name=\"newtemplate\" placeholder=\"";
echo $LNG["new"] . "  " . $LNG["template"] . "  " . $LNG["name"];
echo "\"/>\n        \n       <input type=\"submit\" name=\"create\" value=\"";
echo $LNG["add"];
echo "\" class=\"btn btn-primary\"/>\n       \n        </td>        \n  </tr>\n</thead> \n</table>\n</form>\n";
if ($create) {
    if ($DEMOMODE) {
        echo "<div id='notification1' class='errorbox'>Demo mode enabled</div>";
    } else {
        if ($template && $newtemplate) {
            if (!is_dir("../templates/" . $newtemplate)) {
                recurse_copy("../templates/" . $template, "../templates/" . $newtemplate);
                if (!is_file("../templates/tlog.txt")) {
                    $content = $template . "=" . $newtemplate . "\n";
                    $fp = fopen("../templates/tlog.txt", "wb");
                    fwrite($fp, $content);
                    fclose($fp);
                } else {
                    $myFile = "../templates/tlog.txt";
                    $fh = fopen($myFile, "a");
                    $stringData = $template . "=" . $newtemplate . "\n";
                    fwrite($fh, $stringData);
                    fclose($fh);
                }
            } else {
                echo "<div id='notification1' class='errorbox'>" . $LNG["template"] . " \n                " . $LNG["already"] . " " . $LNG["exists"] . "</div>";
            }
        } else {
            echo "<div id='notification1' class='errorbox'>" . $LNG["fieldblank"] . "</div>";
        }
    }
}
echo "\n\n";
if (is_file("../templates/tlog.txt")) {
    $filearr = file("../templates/tlog.txt");
    foreach ($filearr as $k => $v) {
        $v = explode("=", $v);
        $filearr[$k] = trim($v[1]);
    }
}
echo "<table  id=\"main_tbl\">\n<tbody>\n";
if (is_file("../templates/tlog.txt")) {
    $fp = fopen("../templates/tlog.txt", "r");
    $version = fgets($fp);
    fclose($fp);
}
$version = explode("\n", $version);
$myDirectory = opendir("../templates");
while ($dir = readdir($myDirectory)) {
    if (is_dir("../templates/" . $dir) && in_array($dir, $filearr)) {
        echo "            <tr>\n                <td onclick=\"loadFiles('";
        echo $dir;
        echo "');\" colspan=\"3\" style=\"text-align: left !important;cursor: pointer;font-weight: bold;font-size:13px;\" class=\"main-tmp\">  ";
        echo $dir;
        echo "                \n                ";
        foreach ($version as $v) {
            $r = explode("=", $v);
            if (trim($r[1]) == trim($dir)) {
                echo "<span class='copyedfrom'> [Copied From " . $r[0] . "]</span>";
            }
        }
        echo "                </td>\n            </tr> \n            <tbody class=\"subtable\" id=\"";
        echo $dir;
        echo "\">\n\n        </tbody>\n";
    }
}
echo "</tbody>\n\n</table>\n\n</div>\n\n\n \n\n</div>";
$fileverioncheck = "6.1.0";
function recurse_copy($src, $dst)
{
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if ($file != "." && $file != "..") {
            if (is_dir($src . "/" . $file)) {
                recurse_copy($src . "/" . $file, $dst . "/" . $file);
            } else {
                copy($src . "/" . $file, $dst . "/" . $file);
            }
        }
    }
    closedir($dir);
}

?>