<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<link href=\"../includes/icons/flags/flags.css\" rel=\"stylesheet\" />\n<script src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/highcharts.js\"></script>\n<script>\nfunction DeleteUser(uid){\n    var answer = confirm('Are you sure to delete this user?');\n    if(answer)\n    {\n        DeleteItem (uid,'edituser.deluser','#frmedituser','#table_'+uid,'#notification','true','#main_loader');\n    }\n}\nfunction genpass(){\n    var answer = confirm('";
echo $LNG["areyousuretoresetpassword"];
echo "');\n    if(answer)\n    {\n        SubmitForm ('#btnedituserpass','edituser.sendpasswordmail','#frmedituser','#notification','true','#main_loader');\n    }\n}\nfunction reactivateAcc(clientid)\n{\n    if(confirm('";
echo $LNG["areyousurereactivate"];
echo "'))\n    {\n        SubmitForm ('#btnedituserpass','edituser.resetaccount','#frmedituser','#notification','true','#main_loader');\n    }\n}\n</script>\n<style>\n\n#tabmenu li {\n\tlist-style: none;\n}\n#deshbordsub {\n\twidth:100%;\n\tpadding:10px\n}\n#deshbordsub td {\n\tborder-bottom: 1px dotted #F4F4F4 !important;\n\tcolor: #666666;\n\tpadding: 6px 0;\n}\n#deshbordsub td a {\n\tcolor:#888;\n\ttext-decoration: none;\n}\n#deshbordsub th {\n    font-size: 18px;\n    font-weight: normal;\n    color: black;\n    text-align: left;\n}\n#deshbordsub th {\n\tbackground: transparent !important;\n}\n#deshbordsub th strong {\n\tcolor:#888;\n\tfont-weight: normal;\n\ttext-shadow:0 1px 1px white;\n}\n#deshbordsub td strong {\n\tfont-weight: normal;\n}\n.fixedheight {\n\theight:450px;\n\toverflow-y:scroll;\n}\n.scrollgeneric {\n\tfont-size:1px;\n\tleft:0;\n\tline-height:1px;\n\tposition:absolute;\n\ttop:0;\n}\n.vscrollerbase {\n\tbackground:#f4f4f4;\n\twidth:10px;\n}\n.vscrollerbar {\n\tbackground:#90c0db;\n\twidth:10px;\n}\n.hscrollerbar {\n\tbackground:#99CBCB;\n\theight:15px;\n}\n.groupstabesheadertext{\n    color: #cccccc;\n    font-size: 30px;\n    font-weight: 300;\n    padding: 0;\n    text-transform: capitalize;\n    letter-spacing: -1px;\n}\n.inv-table td{vertical-align: top;padding:10px 0;}\n #main_tbl tr td{border:none}\n table td.fieldarea{min-height:10px;}\n a{text-decoration: none;}\n .quicklink a{padding: 2px 10px;display: block;}\n\n h2{margin-bottom:15px;}\n .groupstabescontant li{padding:0;}\n</style>\n<div title=\"useroverview\" id=\"tutid\"></div>\n";
$pageid = 47;
checkPagePermission($pageid);
if (isset($_POST["unblock"])) {
    dquery("UPDATE tblUsers SET userstatus='0' WHERE id='" . $id . "'");
}
include_once ROOTDIR . "/includes/clients.fun.inc.php";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$clientDetails = getClientsDetails($id);
include_once DATAGRID_DIR2 . "comm.php";
$exp = explode(",", $_SESSION["page_access"]);
echo "<div id=\"notification\"></div>\n<div id=\"content\">\n  <div id=\"content_padded\">\n    <form id=\"frmedituser\" name=\"\" method=\"post\" autocomplete=\"off\">\n      ";
echo generate_token("form");
echo "      <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n      <input type=\"hidden\" name=\"username\" value=\"";
echo $clientDetails["username"];
echo "\" />\n";
if ($clientDetails["usertype"] == "0") {
    $type = $LNG["user"];
    $color = "gray";
} else {
    if ($clientDetails["usertype"] == "1") {
        $type = $LNG["advance"] . " " . $LNG["reseller"];
        $color = "black";
    } else {
        if ($clientDetails["usertype"] == "3") {
            $type = $LNG["resellersusers"];
            $color = "gray";
        }
    }
}
if ($clientDetails["closeac"]) {
    $status = "<strong>" . $LNG["closed"] . "</strong>";
    $color1 = "#C50606";
} else {
    if ($clientDetails["userstatus"] == "0") {
        $status = $LNG["active"];
        $color1 = "#28ac7c";
    } else {
        if ($clientDetails["userstatus"] == "1") {
            $status = $LNG["blocked"];
            $color1 = "#C50606";
        } else {
            if ($clientDetails["userstatus"] == "2") {
                $status = $LNG["inactive"];
                $color1 = "#C50606";
            }
        }
    }
}
$diff = time() - $clientDetails["credit"]["date"];
$days = round($diff / 86400);
if ($clientDetails["credit"]["validity"] != 0) {
    if ($days < $clientDetails["credit"]["validity"]) {
        $color = "#779500";
    } else {
        if ($clientDetails["credit"]["validity"] == $days) {
            $color = "#779500";
        } else {
            $color = "#c00";
        }
    }
}
if (is_file("../images/avtar/" . $id . "_avtar.jpg")) {
    $avatar = "../images/avtar/" . $id . "_avtar.jpg";
}
echo "<script>\nfunction changePhoneStat(clientid)\n{\n    \$.post(\"includes/pages/verifyphone.php?clientid=\"+clientid, function(data, status){\n        \$(\".unverified\").html(\"Verified\");\n    });\n}\n</script>\n<style>\n.balanceinfo .sbox {\n    background: #fafafa none repeat scroll 0 0;\n    border: 1px solid #eeeeee;\n    border-radius: 5px;\n    color: #888888;\n    float: left;\n    font-size: 16px;\n    font-weight: bold;\n    height: 70px;\n    margin: 5px 0;\n    padding: 7px;\n    text-align: center;\n    width: 150px;\n}\n.balanceinfo .bbox{\n    font-size: 16px;\n    font-weight: bold;\n    margin:5px 0;\n    padding: 2px;\n    background: #fafafa;\n    text-shadow:1px 1px white;\n    border-radius: 2px 2px 2px 2px;\n    float: left;\n    width: 153px;\n    text-align: center;\n    color:#bbb;\n    border: #fafafa solid 10px;\n}\n .balanceinfo .sbox span{\n    display: block;\n    font-size: 12px;\n    font-weight: normal;\n    text-transform: capitalize;\n }\n .balanceinfo .bbox span{\n    font-size: 12px;\n    font-weight: normal;\n    text-transform: capitalize;\n    display: block;\n    color:#bbb;\n}\n.btn-info{margin-bottom: 5px;}\n</style>\n\n      <div  class=\"\" style=\"border:none;padding-bottom: 0;\">\n          <input type=\"text\" style=\"display: none\" />\n        <div class=\"\">\n\n            ";
if ($clientDetails["note"]) {
    echo "            <div id=\"notification1\" class=\"info\">\n                <span><strong>\n  ";
    echo nl2br($clientDetails["note"]);
    echo "  </strong></span></div>\n\n            ";
}
echo "\n\n\n            <div class=\"d-flex\">\n\n\n                <div>\n                    <div  class=\"groupstabes first\">\n                        ";
$dc = mysqli_fetch_assoc(dquery("select id,status from tbl_document where uid='" . $clientDetails["id"] . "'"));
echo "\n                        <h2><span> Personal Info </span></h2>\n\n                        <div>\n                             <strong style=\"text-transform: capitalize\"> ";
echo $clientDetails["firstname"] . " " . $clientDetails["lastname"];
echo " ";
echo $clientDetails["groupname"] ? "(" . $clientDetails["groupname"] . ")" : "";
echo " </strong>\n                        </div>\n\n                        <div>\n\n                        <span style=\"font-weight: normal; \">\n                            ";
echo $clientDetails["companyname"] ? "[" . $clientDetails["companyname"] . "]" : "";
echo "                        </span>\n\n                        ";
echo $clientDetails["email"];
echo "                        <br />\n                        <span style=\"display: block;\">\n                            ";
if ($clientDetails["phonenumber"]) {
    echo $clientDetails["phonenumber"];
    if ($clientDetails["verified"] == 0) {
        echo " &nbsp;&nbsp;<span onclick=\"changePhoneStat(" . $clientDetails[id] . ");\" class=\"unverified textred\">Unverified</span> ";
    }
}
echo "                        </span>\n                        <span>User Since\n                      ";
if ($clientDetails["signupdate"]) {
    echo date("d M Y", $clientDetails["signupdate"]);
}
echo "                      </span>\n                        <br />\n                        <span>\n                      ";
echo $clientDetails["countryname"];
echo "                      </span>\n                        <div>\n                            ID/KYC :  ";
echo !$dc ? "Not Submitted" : "<a class=\"default_dg_a2 editdata\" href=\"javascript:load_fromsubpage('document.detail&id=" . $dc["id"] . "','KYC/" . $clientDetails["username"] . "')\"><span class='textred'>" . ($dc["status"] == 2 ? "Rejected" : ($dc["status"] == 1 ? "<span style=\"color:#779500;\">Completed</span>" : "<span style='color: #9B410E;'>Pending Verification</span></a>")) . "</a>";
echo "                        </div>\n\n                        </div>\n\n                    </div>\n                </div>\n\n\n                <div class=\"ml-auto\">\n                    <div  class=\"text-right\">\n                            <span style=\"background:";
echo $color1;
echo ";color:white;padding:5px 10px;text-align: center;;border-radius:3px\">\n                            ";
echo $status;
echo "                         </span>\n\n                        ";
if ($status === "Blocked") {
    echo "                        <div class=\"mt-1\"><small>";
    echo $clientDetails["block_reason"];
    echo "</small></div>\n\n                        ";
}
echo "\n                        <div class=\"mt-2\">\n                        ";
if ($clientDetails["closeac"]) {
    echo "                            <a href=\"#\" onclick=\"reactivateAcc('";
    echo $clientDetails["id"];
    echo "');\">";
    echo $LNG["reactive"];
    echo " ";
    echo $LNG["account"];
    echo "</a>\n                            ";
}
if (($clientDetails["userstatus"] == "1" || $clientDetails["userstatus"] == "2") && $clientDetails["closeac"] == 0) {
    echo "                                <input type=\"submit\" class=\"\" name=\"unblock\"  value=\"";
    echo $LNG["active"];
    echo " ";
    echo $LNG["account"];
    echo "\" />\n                                ";
}
echo "                        </div>\n                    </div>\n\n                   ";
if ($config["config_ssl_allow"]) {
    $siteaddress = $config["config_ssl_allow"];
} else {
    $siteaddress = $config["site_address"];
}
echo "\n\n                    <ul class=\"text-right\">\n                       <div><a  href=\"";
echo _url("login/action/clientlogin/loginpasskey/" . base64_encode($clientDetails["username"] . "," . md5($clientDetails["firstname"])), true);
echo "\" target=\"_blank\">Login as client</a></div>\n\n                    </ul>\n\n\n                </div>\n            </div>\n\n\n\n           <div>\n                  <div>\n\n\n          <div style=\"\">\n\n                <div  class=\"groupstabes\" > <h2><span> Credit Info </span></h2>\n\n\n                    <div class=\"sbox\">\n                      <div class=\"d-flex align-items-center\">\n                        <span class=\"mr-3\"><strong style=\"font-size: 40px;font-weight:100;\">";
echo formatCurrency($clientDetails["credit"]["credit"], $clientDetails["currency"]);
echo "</strong></span>\n                          <span><button type=\"button\"  style=\"min-width:30px\" class=\"btn btn-success btn-sm\" onclick=\"getContect('#tab1','main2.php?page=edituser.accountfinancial&ptype=add','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\">+</button></span>\n                         <span class=\"ml-2\"><button  type=\"button\"   style=\"min-width:30px\"   class=\"btn btn-danger btn-sm\" onclick=\"getContect('#tab1','main2.php?page=edituser.accountfinancial&ptype=rebate','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\">-</button></span>\n                      </div>\n\n                        <div> <small style=\"font-size:14px\"> ";
echo $LNG["balance"];
echo " </small> </div>\n\n                      <span class=\"fieldarea\" style=\"color: ";
echo $color;
echo ";\">\n                      ";
if ($clientDetails["credit"]["validity"] != "0") {
    $validity = $clientDetails["credit"]["validity"];
    $validity = date("Y-m-d", strtotime(date("Y-m-d", $clientDetails["credit"]["date"]) . "+" . $validity . " day"));
    echo "" . formatDate($validity) . "";
}
echo "                      </span>\n                    </div>\n                    <div class=\"clear\"></div>\n    <br />\n                    <div class=\"d-flex  flex-wrap\">\n\n                    <div class=\"sbox mr-3\">\n                      <span>\n                      <strong  style=\"font-size: 20px;font-weight:400\">\n                          ";
$am = getInprocessbyUid($clientDetails["id"]);
echo "                      ";
echo formatCurrency($am, $clientDetails["currency"]);
echo "                      </strong> <br />\n                      <small>  ";
echo $LNG["creditinprocess"];
echo "</small>\n                      </span>\n                    </div>\n\n                    ";
if (!$OnlyEcommerce) {
    echo "\n                    <div class=\"bbox  mr-3\">\n                      <span>\n                      <strong  style=\"font-size: 20px;font-weight:400\">";
    echo formatCurrency($clientDetails["credit"]["credit"] + $clientDetails["credit"]["used"], $clientDetails["currency"]);
    echo "</strong> <br />\n                      <small> ";
    echo $LNG["totalreceipt"];
    echo "  </small>\n                      </span>\n                    </div>\n\n                    <div class=\"bbox  mr-3\">\n                      <span>\n                      <strong  style=\"font-size: 20px;font-weight:400\">";
    echo formatCurrency($clientDetails["credit"]["selling_limit"], $clientDetails["currency"]);
    echo "</strong> <br />\n                      <small> ";
    echo $LNG["sellcreditlimit"];
    echo "   </small>\n                      </span>\n                    </div>\n       ";
    if ($config["rewardpoint"]) {
        echo "           <div class=\"bbox  mr-3\">\n                      <span>\n                      <strong  style=\"font-size: 20px;font-weight:400\">";
        echo getRewardPoint($id);
        echo "</strong> <br />\n                      <small> Reward Points   </small>\n                      </span>\n           </div>\n               ";
    }
    echo "\n                    ";
}
echo "\n                    </div>\n                    <div style=\"clear: both\"></div>\n\n\n\n    </div>\n\n\n    </div>\n\n\n\n     <div style=\"cursor:pointer;margin-bottom:20px\"\n     onclick=\"getContect('#tab81','main2.php?page=edituser.invoice&id=";
echo $id;
echo "&proforma=1&byadmin=1','";
echo $id;
echo "','','#tabcontent',true,'#main_loader');\">\n         <div  class=\"groupstabes\" > <h2><span> ";
echo $LNG["unpaid"];
echo " ";
echo $LNG["balance"];
echo "</span></h2>\n            <div class=\"sbox\">\n           <span>  <strong  style=\"font-size: 40px;font-weight:100;\">\n         ";
$user = mysqli_fetch_assoc(dquery("select sum(total) as tot from tbl_invoices\n   where userid='" . $id . "' and status='Unpaid' and adminid!=''"));
$date = date("Y-m-d");
$due = mysqli_fetch_assoc(dquery("select sum(total) as tot from tbl_invoices\n   where userid='" . $id . "' and status='Unpaid' and adminid!='' and duedate>='" . $date . "'"));
echo formatCurrency($user["tot"], $clientDetails["currency"]);
echo "</strong></span> <br />\n              <small>";
echo $LNG["unpaidproforma"];
echo "</small>\n              <br /><div class=\"clear\"></div><br />\n         <span><strong  class=\"textred\" style=\"font-size: 20px;font-weight:400;\">\n         ";
echo formatCurrency($due["tot"], $clientDetails["currency"]);
echo "                </strong> <br />\n                <small class=\"textred\">";
echo $LNG["due"];
echo " ";
echo $LNG["balance"];
echo " ";
echo $LNG["as"];
echo " ";
echo $LNG["on"];
echo " ";
echo $date;
echo "</small>\n         </span>\n            </div>\n        </div>\n     </div>\n\n\n    <div class=\"clear\"></div>\n\n\n\n\n\n                  \n                      <div>\n                          <div  class=\"groupstabes\">\n\n                              <h2><span> Quick Actions </span></h2>\n\n                              <ul>\n\n                                  <div><a href=\"#\"  onclick=\"genpass();\">";
echo $LNG["resetpass"];
echo "</a></div>\n                                  <div><a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','tmppass','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["tmppassword"];
echo "</a></div>\n                                  <div><a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','edituser.resetpin','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["resetpinmail"];
echo "</a></div>\n\n                                  <div><a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','edituser.resetque','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["reset"];
echo " ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "</a></div>\n                                  <div><a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','edituser.resetotp','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["reset"];
echo " OTP/ 2 Step Authentication</a></div>\n\n\n                              </ul>\n\n                          </div>\n                      </div>\n\n\n\n     <div  class=\"d-none groupstabes\" > <h2><span> Quick Action </span></h2>\n\n\n\n\n         <div style=\"\">\n                      <div class=\"groupstabescontant\" style=\"font-size: 14px;background: transparent !important;\">\n\n                        <input type=\"hidden\" name=\"short\" value=\"1\" />\n\n                       <div>\n                        <select name=\"profilemail\" class=\"chosen\">\n                          <option value=\"\">\n                          ";
echo $LNG["select"];
echo "                          </option>\n                          ";
$d = dquery("select type from tbl_emailtemplates where type='general' or type='other' group by type");
while ($ss = mysqli_fetch_assoc($d)) {
    echo "                          <optgroup style=\"background-color: #DFDFDF;\" label=\"";
    echo $ss["type"];
    echo "\" >\n                          ";
    $s = dquery("select id,name,type from tbl_emailtemplates WHERE type='" . $ss["type"] . "'");
    while ($r = mysqli_fetch_assoc($s)) {
        echo "                          <option  style=\"background-color: #FFF;\" value=\"";
        echo $r["id"];
        echo "\">\n                          ";
        echo $r["name"];
        echo "                          </option>\n                          ";
    }
    echo "                          </optgroup>\n                          ";
}
echo "                        </select>\n\n                        <input type=\"button\" class=\"addFromgallery\" name=\"resetpin\" value=\"";
echo $LNG["send"];
echo " ";
echo $LNG["email"];
echo "\" id=\"btnpsail\"  onclick=\"SubmitForm ('#btnpsail','edituser.sendprofilemail','#frmedituser','#notification','true','#main_loader');\" />\n\n\n                      </div>\n                      <br />\n\n\n                        ";
if ($clientDetails["usertype"] != 3) {
    if (!$OnlyEcommerce) {
        echo "                        <li>\n                          <input  type=\"checkbox\"  name=\"allowtransfer\" value=\"1\" onClick=\"shower(this)\" id=\"allowtransfer\" ";
        if ($clientDetails["access"]["credit_transfer"] == "1") {
            echo "checked";
        }
        echo "/>\n                          <label for=\"allowtransfer\">\n                          ";
        echo $LNG["allowtransfer"];
        echo "                          </label>\n                        </li>\n                        ";
    }
    echo "                        <li id=\"donot\" ";
    if ($clientDetails["access"]["credit_transfer"] != "1") {
        echo "style='display:none';";
    }
    echo " >\n                          <input  type=\"checkbox\"   name=\"notdiscounteduser\" value=\"1\" id=\"donotdiscount\" ";
    if ($clientDetails["access"]["notdiscounteduser"] == "1") {
        echo "checked";
    }
    echo "/>\n                          <label for=\"donotdiscount\">\n                          ";
    echo $LNG["donotdiscounted"];
    echo "                          </label>\n                        </li>\n                        <li>\n                          <input type='checkbox'  name='fraud_protection' id='ed' value='1' ";
    if ($clientDetails["fraud_protection"]) {
        echo "checked='checked'";
    }
    echo " />\n                          <label for=\"ed\">\n                          ";
    echo $LNG["enable"];
    echo "                          ";
    echo $LNG["fraudprotection"];
    echo "                          ";
    echo $LNG["manual"];
    echo "                          ";
    echo $LNG["addfund"];
    echo "                          </label>\n                        </li>\n                        <li>\n                          <input type='checkbox'  name='ordersms' id='pos' value='1' ";
    if ($clientDetails["ordersms"]) {
        echo "checked='checked'";
    }
    echo " />\n                          <label for=\"pos\">Place Order SMS Notification</label>\n                        </li>\n                        ";
    if ($config["block_ac_on_country_mismatch"]) {
        echo "                            <li>\n                                <input type='checkbox'  name='allowcountry' id='allowcountry' value='1' ";
        if ($clientDetails["allowcountry"]) {
            echo "checked='checked'";
        }
        echo " />\n                                <label for=\"allowcountry\">Allow Login from Other Country </label>\n                            </li>\n                          ";
    }
}
echo "                        ";
if ($clientDetails["guest"]) {
    echo "                        <li>\n                          <input type=\"checkbox\"   name=\"regular\" id=\"guest\" value=\"1\"\n  ";
    if (!$clientDetails["guest"]) {
        echo "checked='checked'";
    }
    echo "  />\n                          <label for=\"guest\">Make user Regular user</label>\n                        </li>\n ";
}
echo "\n                      </div>\n";
if ($clientDetails["usertype"] != 3 || $clientDetails["guest"]) {
    echo "<br />\n<input onClick=\"SubmitForm('#savac','edituser.overview','#frmedituser','#notification','true','#main_loader');\" type=\"button\" name=\"savac\" class=\"btn btn-primary\" id=\"savac\" value=\"";
    echo $LNG["save"];
    echo "\"  />\n";
}
echo "\n             ";
if (in_array(55, $exp)) {
    echo "                 <input type=\"button\" class=\"button_remove\"  style=\"float: right;\" name=\"note\" value=\"";
    echo $LNG["close"];
    echo " ";
    echo $LNG["account"];
    echo "\" id=\"btnclose\"\n                        onclick=\"load_subpage('main2.php?page=edituser.closeaccount&id=";
    echo $id;
    echo "','";
    echo $LNG["close"];
    echo " ";
    echo $LNG["account"];
    echo " : <strong>";
    echo $clientDetails["username"];
    echo "</strong>')\" />\n&nbsp;&nbsp;&nbsp;\n                 <input type=\"button\" class=\"button_remove\"   name=\"note\" value=\"";
    echo $LNG["reset"];
    echo " ";
    echo $LNG["discount"];
    echo "\" id=\"resetdiscount\"\n                        onclick=\"if(confirm('Are you sure want to Reset Discount ?')){ SubmitForm ('#resetdiscount','edituser.resetdiscount','#frmedituser','#notification','true',\n                        '#main_loader'); } \" />\n\n                 ";
}
echo "                    </div>\n\n\n                <div>\n\n                    <ul class=\"quicklink\">\n                           <a href=\"#\"  onclick=\"genpass();\">";
echo $LNG["resetpass"];
echo "</a>\n                           <a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','tmppass','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["tmppassword"];
echo "</a>\n                           <a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','edituser.resetpin','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["resetpinmail"];
echo "</a>\n\n                           <a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','edituser.resetque','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["reset"];
echo " ";
echo $LNG["security"];
echo " ";
echo $LNG["question"];
echo "</a>\n                           <a href=\"#\"   onclick=\"SubmitForm ('#btnresetpin','edituser.resetotp','#frmedituser','#notification','true','#main_loader');\" >";
echo $LNG["reset"];
echo " OTP/ 2 Step Authentication</a>\n\n                           <a href=\"#\"   onclick=\"load_subpage('main2.php?page=edituser.log&id=";
echo $id;
echo "','";
echo $LNG["login"];
echo "  ";
echo $LNG["log"];
echo "');\">";
echo $LNG["login"];
echo "  ";
echo $LNG["log"];
echo "</a>\n                           <a href=\"#\" onclick=\"load_subpage('main2.php?page=edituser.notes&id=";
echo $id;
echo "','";
echo $LNG["notes"];
echo "');\" >";
echo $LNG["notes"];
echo "</a>\n                        </ul>\n\n                </div>\n              <div class=\"clear\"></div>\n    </div>\n\n\n<div  class=\"d-none groupstabes\" >\n\n    <div style=\"width: 49%;float:left; border-right: 1px solid #ccc; margin-right: 20px;\">\n        <h2><span> Admin Notes </span></h2>\n        <textarea name=\"notes\" cols=\"45\" rows=\"4\">";
echo $clientDetails["note"];
echo "</textarea>\n    </div>\n    <div style=\"width: 49%;float:left;\">\n        <h2><span> User Notes </span></h2>\n        <textarea name=\"message\" cols=\"45\" rows=\"4\">";
echo $clientDetails["message"];
echo "</textarea>\n        <br/>\n        ";
echo $LNG["user"];
echo "  ";
echo $LNG["notification"];
echo " ";
echo $LNG["display"];
echo " till: <input type=\"text\" name=\"date\"    placeholder=\"yyyy-mm-dd\" size=\"8\" value=\"";
echo $clientDetails["messagedate"];
echo "\" class=\"datepicker\" />\n\n    </div>\n    <input onClick=\"SubmitForm ('#savac','edituser.notes','#frmedituser','#notification','true','#main_loader');\" type=\"button\" name=\"savan\" class=\"btn btn-primary\" id=\"savan\" value=\"";
echo $LNG["save"];
echo "\"  />\n    </table>\n</div>\n\n<script>\n    getContect('#tab','main2.php?page=edituser.topservice','";
echo $id;
echo "','','#tabcontent2',true,'#main_loader');\n</script>\n\n";
$sql = "select count(*) as total,MONTH(date) as month,user_can_c,1 as tbl  from tbl_order_imei WHERE year( date ) = year( now( ) ) and user_id='" . $id . "' group by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,2  from tbl_order_file WHERE year( date ) = year( now( ) ) and user_id='" . $id . "' group by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,3  from tbl_order_server WHERE year( date ) = year( now( ) ) and user_id='" . $id . "' group by MONTH(date),user_can_c union select count(*) as total,MONTH(date) as month,user_can_c,4  from tbl_order_product WHERE year( date ) = year( now( ) ) and user_id='" . $id . "' group by MONTH(date),user_can_c";
$result = dquery($sql);
$no_rows = mysqli_num_rows($result);
while ($row = mysqli_fetch_assoc($result)) {
    $_order[$row["tbl"]][$row["month"]][$row["user_can_c"]]["count"] = $row["total"];
}
for ($i = 1; $i <= 4; $i++) {
    for ($j = 1; $j <= 12; $j++) {
        if (!$_order[$i][$j][4]) {
            $_order[$i][$j][4]["count"] = 0;
        }
    }
}
echo "<div class=\"clear\"></div>\n\n   <div>\n\n      <div class=\"d-none\">\n        <div  class=\"groupstabes\"> <h2><span> Top Services </span></h2>\n        <div  id='tabcontent2' style=\"margin-top: 0px;\">\n        </div>\n      </div>\n    </div>\n\n </div>\n     </div>\n\n\n\n\n          <div class=\"clear\"></div>\n          <br />\n        </div>\n      </div>\n      <div class=\"clear\"></div>\n      <div class=\"clear\"></div>\n      <br />\n<script>\nfunction shower(ob){\n    if(ob.checked){\n        document.getElementById('donot').style.display='';\n    }else{\n        document.getElementById('donot').style.display='none';\n    }\n}\n</script>\n\n\n    </form>\n  </div>\n</div>\n";
if (!$fusionlite && $config["wikihelp"]) {
    echo "<div class=\"help_icon\"><a href=\"https://support.dhru.com/Dhru-Fusion/article/Clients---Suppliers/?aid=29&cid=5&pid=1\" target=\"_blank\"><img src=\"images/help_icon.png\"/> Wiki Help</a>\n</div>\n";
}
$fileverioncheck = "6.1.0";
echo "\n";

?>