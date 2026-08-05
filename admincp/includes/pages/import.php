<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\n    function changeFormat(){\n\n\n        var str=\"Username\";\n        var str1=\"username\";\n        var str2=\"myusername\";\n\n\n        var sep=\$(\"#seperator\").val();\n        if(sep==''){\n            sep=' ';\n        }\n        if(\$('#pss').is(':checked')){\n            str=str+sep+\"Password\";\n            str1=str1+sep+\"password\";\n            str2=str2+sep+\"mypass\";\n        }\n        if(\$('#fnm').is(':checked')){\n            str=str+sep+\"FirstName\";\n            str1=str1+sep+\"John\";\n            str2=str2+sep+\"Ken\";\n        }\n        if(\$('#lnm').is(':checked')){\n            str=str+sep+\"LastName\";\n            str1=str1+sep+\"Tailor\";\n            str2=str2+sep+\"Mistro\";\n        }\n\n\n        str=str+sep+\"Email\";\n        str1=str1+sep+\"john@umail.com\";\n        str2=str2+sep+\"ken@pmail.com\";\n\n        if(\$('#cnm').is(':checked')){\n            str=str+sep+\"Currency\";\n            str1=str1+sep+\"USD\";\n            str2=str2+sep+\"USD\";\n        }\n        \$(\"#fnd\").html(str);\n\n        \$(\"#exm\").html(str1+'\\n'+str2);\n        //\$(\"#exm\").html();\n\n\n    }\n</script>\n";
$pageid = 339;
checkPagePermission($pageid);
include ROOTDIR . "/includes/clients.fun.inc.php";
$CurrencyArr = [];
$q = dquery("select * from tbl_currencies");
while ($r = mysqli_fetch_assoc($q)) {
    $CurrencyArr[$r["code"]] = $r["id"];
}
$num = mysqli_num_rows(dquery("SELECT id FROM tblUsers"));
if ($num) {
    echo "<div id='notification1' class='errorbox'>" . $LNG["youhaveusers"] . "</div>";
}
if ($imported) {
    if (0 < $_FILES["imports"]["error"]) {
        $ad = mysqli_fetch_assoc(dquery("select data from\n           tbl_tmp ORDER BY id DESC"));
        $arr = unserialize($ad["data"]);
    } else {
        if ($_FILES["imports"]["tmp_name"]) {
            $arr = file($_FILES["imports"]["tmp_name"]);
            $xd = serialize($arr);
            dquery("INSERT INTO tbl_tmp (`data`) VALUES ('" . $xd . "')");
        } else {
            $ad = mysqli_fetch_assoc(dquery("select data from \n          tbl_tmp ORDER BY id DESC"));
            $arr = unserialize($ad["data"]);
        }
    }
    $tot = count($arr);
    if (!$cnt) {
        $cnt = 1;
    }
    $c = 1;
    $field = 2;
    if ($password) {
        $field++;
    }
    if ($firstname) {
        $field++;
    }
    if ($lastname) {
        $field++;
    }
    if ($currency) {
        $field++;
    }
    if (is_array($arr)) {
        foreach ($arr as $k => $v) {
            $data = explode($seperator, $v);
            foreach ($data as $k => $v) {
                $data[$k] = trim($v);
            }
            if ($c == $cnt) {
                if (count($data) == $field && !mysqli_num_rows(dquery("select * from tblUsers where username='" . $data[0] . "'"))) {
                    if (!preg_match("/[^a-zA-Z0-9-_\\.]/", $data[0])) {
                        $validator["username"] = [$data[0], true];
                        if ($password) {
                            $validator["password"] = [$data[1], true];
                        } else {
                            $validator["password"] = [ranPass(), true];
                        }
                        if ($firstname && $password) {
                            $validator["first_name"] = [$data[2], true];
                        } else {
                            if ($firstname) {
                                $validator["first_name"] = [$data[1], true];
                            }
                        }
                        if ($firstname && $password && $lastname) {
                            $validator["last_name"] = [$data[3], true];
                        } else {
                            if ($lastname) {
                                $validator["last_name"] = [$data[2], true];
                            }
                        }
                        $no = 0;
                        if ($firstname && $password && $lastname) {
                            $validator["email"] = [$data[4], true];
                            $no = 4;
                        } else {
                            if ($firstname && $lastname) {
                                $validator["email"] = [$data[3], true];
                                $no = 3;
                            } else {
                                if ($firstname && $password) {
                                    $validator["email"] = [$data[3], true];
                                    $no = 3;
                                } else {
                                    if ($lastname && $password) {
                                        $validator["email"] = [$data[3], true];
                                        $no = 3;
                                    } else {
                                        if (!$firstname && !$password && !$lastname) {
                                            $validator["email"] = [$data[1], true];
                                            $no = 1;
                                        } else {
                                            $validator["email"] = [$data[2], true];
                                            $no = 2;
                                        }
                                    }
                                }
                            }
                        }
                        if ($currency) {
                            $cid = mysqli_fetch_assoc(dquery("select id from tbl_currencies\n                       where code='" . $data[$no + 1] . "'"));
                            $validator["currency"] = [$cid["id"], true];
                        }
                        if (!mysqli_num_rows(dquery("select * from tblUsers where email='" . $validator["email"] . "'"))) {
                            if ($err = addNewUser($validator, "", "ADMIN")) {
                                echo $data[0] . " - " . $err . "  <br />";
                            } else {
                                echo $data[0] . " -  User Inserted <br />";
                            }
                            $data = NULL;
                        }
                        if ($cnt % 20 == 0 && 20 < $tot && $cnt + 20 <= $tot) {
                            echo "                                <div id='notification1' class='successbox'>\n                                    Your Batch is in Process wait for 15 Sec.\n                                    <a href=\"javascript:redirectedit('import','&cnt=";
                            echo $cnt + 1;
                            echo "&imported=true&seperator=";
                            echo $seperator;
                            echo "&password=";
                            echo $password;
                            echo "&firstname=";
                            echo $firstname;
                            echo "&lastname=";
                            echo $lastname;
                            echo "')\">\n                                        Click Here to go to Next Batch</a> </div>\n                                ";
                            sleep(15);
                            echo "                                <script>\n                                    redirectedit('import','&cnt=";
                            echo $cnt + 1;
                            echo "&imported=true&seperator=";
                            echo $seperator;
                            echo "&password=";
                            echo $password;
                            echo "&firstname=";
                            echo $firstname;
                            echo "&lastname=";
                            echo $lastname;
                            echo "');\n                                </script>\n                                ";
                        }
                    }
                }
                $cnt++;
            }
            if ($c == $tot) {
                dquery("TRUNCATE TABLE tbl_tmp");
            }
            $c++;
        }
    }
}
echo "<ul id=\"tabmenu\">\n    <li><a href=\"javascript:void(0)\" class=\"tabmenu_active\">Import</a></li>\n</ul>\n<div id=\"notification\"></div>\n<div id=\"content\">\n    <div id=\"content_padded\">\n\n        <div  class=\"groupstabes\" >\n            <h2>\n                <img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAkAAAAJCAYAAADgkQYQAAAAAXNSR0IArs4c6QAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oIGRQbOY8MjgMAAAA8SURBVBjTY2BAAzdv3vwPBAzImAGbInSFWBU9f/4cRSFWRb9+/UJRiFMRTOGNGzf+k28SUW4iynfo4QQAj22WmutXxVsAAAAASUVORK5CYII=\">\n                <span class=\"groupstabesheadertext\">Import Data</span>&nbsp;<font class=\"backline\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>\n            </h2>\n            <div class=\"groupstabescontant\">\n                ";
if ($from == 1 || $from == 3 || $from == 4 || $from == 5 || $from == 6 || !$from) {
    echo "                    <form method=\"post\">\n                        <table   class=\"form\" cellpadding=\"5\">\n                            <tbody>\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["transferfrom"];
    echo "</td>\n                                <td class=\"fieldarea\"><select name=\"from\" onchange=\"location.href='main2.php?page=import&from='+this.value\">\n                                        <option value=\"1\" ";
    if ($from == 1) {
        echo "selected";
    }
    echo "  >GSMBackbase Versio 4.8</option>\n                                        <option value=\"3\" ";
    if ($from == 3) {
        echo "selected";
    }
    echo "  >Nakshsoft</option>\n                                        <option value=\"4\" ";
    if ($from == 4) {
        echo "selected";
    }
    echo "  >Gsmgenie/GSMTool</option>\n                                        <option value=\"2\" ";
    if ($from == 2) {
        echo "selected";
    }
    echo "  >From File</option>\n                                        <option value=\"5\" ";
    if ($from == 5) {
        echo "selected";
    }
    echo "  >Gsmhub</option>\n                                        <option value=\"6\" ";
    if ($from == 6) {
        echo "selected";
    }
    echo "  >Webx</option>\n                                    </select> <br />\n                                    ";
    if ($from == 3 || $from == 4) {
        echo "Transfer Username,First Name ,Last Name, Email, Credit, Address, City, State, Zip";
    }
    echo "\n                                </td></tr>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["host"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"host\" /></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["dbname"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"database\" /></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["dbuser"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\"  class=\"txt medium\" name=\"user\" /></td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["dbpassword"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"password\" name=\"password\" /><input type=\"hidden\" value=\"on\" name=\"tblusers\" id=\"tblusers\" /></td>\n                            </tr>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["import"];
    echo "</td>\n                                <td class=\"fieldarea\">\n                                    <lable><input type=\"radio\" name=\"importwhat\" value=\"0\" checked />User</lable>\n                                    <lable><input type=\"radio\" name=\"importwhat\" value=\"1\" />IMEI Orders</lable>\n                                    <lable><input type=\"radio\" name=\"importwhat\" value=\"2\" />Server Orders</lable>\n                                    <lable><input type=\"radio\" name=\"importwhat\" value=\"3\" />Invoices</lable>\n                                </td>\n                            </tr>\n\n                            </tbody>\n                        </table>\n                        ";
    if ($limitto) {
        echo "Importing in process please wait.....";
    } else {
        echo "                            <p align=\"center\" class=\"fixedbtn\"><input type=\"submit\" name=\"transfer\"\n                                                                      value=\"";
        echo $LNG["transfer"];
        echo "\"/></p>\n                            ";
    }
    echo "                    </form>\n                    ";
} else {
    echo "\n                    <form method=\"post\" enctype=\"multipart/form-data\">\n                        <table>\n\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["transferfrom"];
    echo "</td>\n                                <td class=\"fieldarea\"><select name=\"from\" onchange=\"location.href='main2.php?page=import&from='+this.value\">\n                                        <option value=\"1\" ";
    if ($from == 1) {
        echo "selected";
    }
    echo "  >GSMBackbase Version 4.8</option>\n                                        <option value=\"2\" ";
    if ($from == 2) {
        echo "selected";
    }
    echo "  >From File</option>\n                                        <option value=\"3\" ";
    if ($from == 3) {
        echo "selected";
    }
    echo "  >Nakshsoft</option>\n                                        <option value=\"4\" ";
    if ($from == 4) {
        echo "selected";
    }
    echo "  >Gsmgenie</option>\n                                    </select></td></tr>\n\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">Import From File</td><td  class=\"fieldarea\">\n                                    <input type=\"file\" name=\"imports\" />\n                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">Field</td><td class=\"fieldarea\">\n                                    <input type=\"checkbox\" name=\"username\" checked=\"\" disabled=\"\" value=\"1\" id=\"unm\" /> <label for=\"unm\">";
    echo $LNG["username"];
    echo "</label> <br />\n                                    <input type=\"checkbox\" onclick=\"javascript: changeFormat();\" name=\"password\" checked=\"\" value=\"1\" id=\"pss\" /> <label for=\"pss\">";
    echo $LNG["password"];
    echo "</label> <br />\n                                    <input type=\"checkbox\" onclick=\"javascript: changeFormat();\" name=\"firstname\" checked=\"\" value=\"1\" id=\"fnm\" /> <label for=\"fnm\">";
    echo $LNG["firstname"];
    echo "</label> <br />\n                                    <input type=\"checkbox\" onclick=\"javascript: changeFormat();\" name=\"lastname\" checked=\"\" value=\"1\" id=\"lnm\" /> <label for=\"lnm\">";
    echo $LNG["lastname"];
    echo "</label> <br />\n                                    <input type=\"checkbox\" name=\"email\" checked=\"\" disabled=\"\" value=\"1\" id=\"eml\" /> <label for=\"eml\">";
    echo $LNG["email"];
    echo "</label> <br />\n                                    <input type=\"checkbox\" onclick=\"javascript: changeFormat();\" name=\"currency\" checked=\"\" value=\"1\" id=\"cnm\" /> <label for=\"cnm\">Currency</label> <br />\n                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\">Seperator</td><td  class=\"fieldarea\">\n                                    <input type=\"text\" id=\"seperator\"  onkeyup=\"javascript: changeFormat();\" name=\"seperator\" value=\",\" style=\"width: 30px !important;\" />\n                                </td>\n                            </tr>\n\n\n                            <tr>\n                                <td class=\"fieldlabel\">File Format</td>\n                                <td  class=\"fieldarea\">\n  <textarea id=\"exm\" cols=\"65\">username,password,John,Tailor,john@umail.com,USD\nmyusername,mypass,Ken,Mistro,ken@pmail.com,USD</textarea>\n                                    <span id=\"fnd\">Username,Password,FirstName,LastName,Email,Currency</span>\n                                </td>\n                            </tr>\n\n                            <tr>\n                                <td class=\"fieldlabel\"></td>\n                                <td  class=\"fieldarea\"><input type=\"submit\" name=\"imported\" value=\"Submit\" /></td>\n                            </tr>\n                        </table>\n                    </form>\n\n                    ";
}
if ($uploadi) {
    if (0 >= $_FILES["imports"]["error"]) {
        echo "                        <form method=\"post\">\n                            <input type=\"hidden\" name=\"password\" value=\"";
        echo $password;
        echo "\" />\n                            <input type=\"hidden\" name=\"firstname\" value=\"";
        echo $firstname;
        echo "\" />\n                            <input type=\"hidden\" name=\"lastname\" value=\"";
        echo $lastname;
        echo "\" />\n                            <input type=\"hidden\" name=\"seperator\" value=\"";
        echo $seperator;
        echo "\" />\n                            <table id=\"main_tbl\">\n                                <thead>\n                                <tr>\n                                    <th>&nbsp;</th>\n                                    <th>";
        echo $LNG["username"];
        echo "</th>\n                                    ";
        if ($password) {
            echo "                                        <th>";
            echo $LNG["password"];
            echo "</th>\n                                        ";
        }
        if ($firstname) {
            echo "                                        <th>";
            echo $LNG["firstname"];
            echo "</th>\n                                        ";
        }
        if ($lastname) {
            echo "                                        <th>";
            echo $LNG["lastname"];
            echo "</th>\n                                        ";
        }
        echo "                                    <th>";
        echo $LNG["email"];
        echo "</th>\n                                </tr>\n                                </thead>\n                                ";
        $arr = file($_FILES["imports"]["tmp_name"]);
        foreach ($arr as $k => $v) {
            $data = explode($seperator, $v);
            echo "                                    <tr>\n                                        <td><input type=\"checkbox\" name=\"chk[";
            echo $k;
            echo "]\" value=\"";
            echo $v;
            echo "\" /></td>\n                                        <td>";
            echo $data[0];
            echo "</td>\n                                        ";
            if ($password) {
                echo "                                            <td>";
                echo $data[1];
                echo "</td>\n                                            ";
            }
            if ($firstname) {
                echo "                                            <td>";
                echo $data[2];
                echo "</td>\n                                            ";
            }
            if ($lastname) {
                echo "                                            <td>";
                echo $data[3];
                echo "</td>\n                                            ";
            }
            echo "                                        <td>";
            echo $data[4];
            echo "</td>\n                                    </tr>\n                                    ";
        }
        echo "                                <tr>\n                                    <td></td>\n                                    <td colspan=\"5\" style=\"float: left;\">\n                                        <input type=\"submit\" name=\"imported\" value=\"Import User\" />\n                                    </td>\n                                </tr>\n                            </table>\n                        </form>\n                        ";
    }
}
echo "            </div></div>\n\n        ";
if ($limitto && $from && $importwhat) {
    $_POST["transfer"] = true;
}
if (isset($_POST["transfer"])) {
    checkDemoMode(false);
    if (!$limitto) {
        unset($_SESSION["gsmtoolhost"]);
        unset($_SESSION["gsmtooluser"]);
        unset($_SESSION["gsmtooldatabase"]);
        unset($_SESSION["gsmtoolpassword"]);
    }
    if (isset($_SESSION["gsmtoolhost"])) {
        $_POST["host"] = $_SESSION["gsmtoolhost"];
        $_POST["user"] = $_SESSION["gsmtooluser"];
        $_POST["database"] = $_SESSION["gsmtooldatabase"];
        $_POST["password"] = $_SESSION["gsmtoolpassword"];
    }
    $link = mysqli_connect($_POST["host"], $_POST["user"], (string) $_POST["password"], $_POST["database"]);
    exit("<div id='notification1' class='errorbox'>" . $LNG["coundtconnect"] . "</div>");
}
echo "    </div></div>";
$fileverioncheck = "6.1.0";
class crypts
{
    public $keys = NULL;
    public function crypt_key($ckey)
    {
        $this->keys = [];
        $c_key = base64_encode(sha1(md5($ckey)));
        $c_key = substr($c_key, 0, round(ord($ckey[0]) / 5));
        $c2_key = base64_encode(md5(sha1($ckey)));
        $last = strlen($ckey) - 1;
        $c2_key = substr($c2_key, 1, round(ord($ckey[$last]) / 7));
        $c3_key = base64_encode(sha1(md5($c_key) . md5($c2_key)));
        $mid = round($last / 2);
        $c3_key = substr($c3_key, 1, round(ord($ckey[$mid]) / 9));
        $c_key = $c_key . $c2_key . $c3_key;
        $c_key = base64_encode($c_key);
        for ($i = 0; $i < strlen($c_key); $i++) {
            $this->keys[] = $c_key[$i];
        }
    }
    public function encrypt($string)
    {
        $string = base64_encode($string);
        $keys = $this->keys;
        for ($i = 0; $i < strlen($string); $i++) {
            $id = $i % count($keys);
            $ord = ord($string[$i]);
            ($ord = $ord) || ord($keys[$id]);
            $id++;
            ($ord = $ord) && ord($keys[$id]);
            $id++;
            ord($keys[$id]);
            $ord = $ord xor ord($keys[$id]);
            $id++;
            $ord = $ord + ord($keys[$id]);
            $string[$i] = chr($ord);
        }
        return base64_encode($string);
    }
    public function decrypt($string)
    {
        $string = base64_decode($string);
        $keys = $this->keys;
        for ($i = 0; $i < strlen($string); $i++) {
            $id = $i % count($keys);
            $ord = ord($string[$i]);
            ord($keys[$id]);
            $ord = $ord xor ord($keys[$id]);
            $id++;
            ($ord = $ord) && ord($keys[$id]);
            $id++;
            ($ord = $ord) || ord($keys[$id]);
            $id++;
            $ord = $ord - ord($keys[$id]);
            $string[$i] = chr($ord);
        }
        return base64_decode($string);
    }
}
function theString_Decrypt($enc_text, $password = "P@88W04D", $iv_len = 16)
{
    $enc_text = base64_decode($enc_text);
    $n = strlen($enc_text);
    $i = $iv_len;
    $plain_text = "";
    $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
    while ($i < $n) {
        $block = substr($enc_text, $i, 16);
        $plain_text .= $block ^ pack("H*", md5($iv));
        $iv = substr($block . $iv, 0, 512) ^ $password;
        $i += 16;
    }
    return preg_replace("/\\x13\\x00*\$/", "", $plain_text);
}
function ranPass()
{
    $alphabet = "ABCDEFGHIJKLMNPQRSTUWXYZ123456789";
    $pass = [];
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}

?>