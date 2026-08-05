<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script>\n    function removeField(key)\n    {\n        \$(\".rem\"+key).remove();\n    }\n    function addMore(key){\n\n        \$(\"#load\"+key).append('<div style=\"padding: 3px 0\" class=\"rem'+key+'\"> <input type=\"text\" class=\"form-control\" placeholder=\"Mapping Name\"  name=\"other['+key+'][]\" /></div>');\n    }\n    function check(id,id2){\n        if(id2.checked==true){\n            document.getElementById(id).checked=false;\n            document.getElementById('customlength').style.display='none';\n            document.getElementById('customimeiname').style.display='none';\n            document.getElementById('customimeiinfo').style.display='none';\n            document.getElementById('customimeich').style.display='none';\n        }\n    }\n    function bulkClick(id)\n    {\n        if(id.checked)\n        {\n            \$(\"#bulkimeis\").show();\n        }else{\n            \$(\"#bulkimeis\").hide();\n        }\n    }\n    function showHide(id){\n        if(id.checked==false)\n        {\n            document.getElementById('customlength').style.display='none';\n            document.getElementById('customimeiname').style.display='none';\n            document.getElementById('customimeiinfo').style.display='none';\n            document.getElementById('customimeich').style.display='none';\n        }\n        else\n        {\n            document.getElementById('customlength').style.display='table-row';\n            document.getElementById('customimeiname').style.display='table-row';\n            document.getElementById('customimeiinfo').style.display='table-row';\n            document.getElementById('customimeich').style.display='table-row';\n            if(id.checked==true){\n                document.getElementById('imei').checked=false;\n            }\n        }\n    }\n    function DeleteCustom(cid){\n        var answer = confirm('Are you sure to delete this item?');\n        if(answer)\n        {\n            DeleteItem (cid,'editimeiservice.delcustom','#frmedituser','#table_'+cid,'#notification','true','#main_loader');\n            \$(\"#\"+cid).hide();\n        }\n    }\n    \$(document).ready(function(){\n        \$(\".customfield\").change(function(){\n            \$(\".customfield\").each(function(index, value) {\n                if(\$(this).val()=='dropdown' || \$(this).val()=='radio'){\n                    \$(\".fieldoptions\").each(function(index2, value2) {\n                        if(index==index2) {\n                            \$(this).prop(\"disabled\", false);\n                        }\n                    });\n                }\n            });\n        });\n        \$(\".toggle_container\").hide();\n        \$(\"input.trigger\").click(function(){\n            \$(this).toggleClass(\"active\").next().slideToggle(\"slow\");\n        });\n    });\n</script>\n";
$pageid = 95;
checkPagePermission($pageid);
include_once ROOTDIR . "/includes/apiserver.fun.php";
$serviceDetails = mysqli_fetch_assoc(dquery("SELECT API,API_ID FROM tbl_services_imei WHERE id='" . $id . "' "));
include_once ROOTDIR . "/includes/imeiservices.fun.php";
$md5id = md5($id);
$imeiserviceDetails = getIMEIServices("", $md5id);
if (!$imeiserviceDetails["reqredfield"]["validateimei"]) {
    $displaybulk = " style='display:none;'";
}
echo "<div id=\"notification\"></div>\n\n\n<div id=\"content\">\n    <div id=\"content_padded\">\n\n        <form id=\"frmedituser\" name=\"\" method=\"post\">\n            <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"id\"/>\n            ";
echo generate_token("form");
echo "\n\n\n            ";
if ($imeiserviceDetails["useasserver"] == 0) {
    echo "                <div  class=\"groupstabes first\" >\n                    <h2>\n                        <span class=\"groupstabesheadertext\">";
    echo $LNG["imei"];
    echo " / ";
    echo $LNG["serialno"];
    echo " / ";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["field"];
    echo "  </span>\n                    </h2>\n                    <div class=\"groupstabescontant\">\n\n                        <table class=\"form\">\n                            <tbody>\n                            <tr>\n                                <td class=\"fieldlabel\">";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["field"];
    echo " ";
    echo $LNG["allow"];
    echo "</td>\n                                <td class=\"fieldarea\">\n                                    <span><input ";
    if ($imeiserviceDetails["reqredfield"]["imei_single"] == "1") {
        echo "checked=checked";
    }
    echo " id=\"imei\" name=\"imei\" onclick=\"check('custom',this);\" value=\"1\" type=\"checkbox\" /><label for=\"imei\">";
    echo $LNG["single"] . " " . $LNG["imei"];
    echo "</label></span>\n                                    <span><input ";
    if ($imeiserviceDetails["imei_custom"] == "1") {
        echo "checked=checked";
    }
    echo " id=\"custom\" name=\"custom\" value=\"1\" onclick=\"showHide(this);\" type=\"checkbox\" /><label for=\"custom\">";
    echo $LNG["custom"];
    echo "</label></span>\n                                    <span><input ";
    if ($imeiserviceDetails["reqredfield"]["imei_bulk"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"bulk\" id=\"bulk\" onclick=\"bulkClick(this);\" value=\"1\" type=\"checkbox\" /><label for=\"bulk\">";
    echo $LNG["bulk"];
    echo "</label></span>\n                                </td>\n                            </tr>\n                            ";
    if ($imeiserviceDetails["imei_custom"] != "1") {
        $display = "style=display:none";
    }
    echo "\n                            <tr id=\"customimeiname\" ";
    echo $display;
    echo ">\n                                <td class=\"fieldlabel\">";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["name"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\" name=\"customimeiname\"\n                                                             value=\"";
    echo $imeiserviceDetails["imei_custom_name"];
    echo "\"/></td>\n                            </tr>\n\n                            <tr id=\"customlength\" ";
    echo $display;
    echo ">\n                                <td class=\"fieldlabel\">";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["length"];
    echo " ";
    echo $LNG["minimum"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\" name=\"customlength\" value=\"";
    echo $imeiserviceDetails["imei_custom_len"] ? $imeiserviceDetails["imei_custom_len"] : 1;
    echo "\" style=\"width:50px\n    !important\"/></td>\n                            </tr>\n\n                            <tr id=\"customlength\" ";
    echo $display;
    echo ">\n                                <td class=\"fieldlabel\">";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["length"];
    echo " ";
    echo $LNG["maximum"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\" name=\"maxlength\" value=\"";
    echo $imeiserviceDetails["maxlength"] ? $imeiserviceDetails["maxlength"] : 20;
    echo "\"\n                                                             style=\"width:50px !important\"/>\n                                    <small>";
    echo $LNG["optional"];
    echo " If you want range </small>\n                                </td>\n                            </tr>\n                            <tr id=\"customimeiname\" ";
    echo $display;
    echo ">\n                                <td class=\"fieldlabel\">";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["regularexpression"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\" name=\"imeiregex\"\n                                                             value=\"";
    echo $imeiserviceDetails["imeiregex"];
    echo "\"/></td>\n                            </tr>\n\n\n\n                            <tr id=\"customimeiinfo\" ";
    echo $display;
    echo ">\n                                <td class=\"fieldlabel\">";
    echo $LNG["custom"];
    echo " ";
    echo $LNG["imei"];
    echo " ";
    echo $LNG["info"];
    echo "</td>\n                                <td class=\"fieldarea\"><input type=\"text\" name=\"customimeiinfo\" value=\"";
    echo $imeiserviceDetails["imei_custom_info"];
    echo "\"/></td>\n                            </tr>\n\n\n                            <tr id=\"customimeich\" ";
    echo $display;
    echo ">\n                                <td class=\"fieldlabel\"></td>\n                                <td class=\"fieldarea\"><input type=\"checkbox\"\n                                                             name=\"isalpha\" value=\"1\" ";
    if ($imeiserviceDetails["isalpha"]) {
        echo "checked";
    }
    echo " id=\"isal\"    />\n                                    <label for=\"isal\"> Accept Alphabet</label>\n                                </td>\n                            </tr>\n                            <!--\n<tr id=\"bulkimeis\" ";
    echo $displaybulk;
    echo ">\n    <td class=\"fieldlabel\"></td>\n    <td class=\"fieldarea\"><input type=\"checkbox\"\n    name=\"validateimei\" value=\"1\" ";
    if ($imeiserviceDetails["reqredfield"]["validateimei"]) {
        echo "checked";
    }
    echo " id=\"valsime\"    />\n    <label for=\"valsime\"> Validate IMEI for Last Digit</label>\n    </td>\n</tr>\n-->\n                            </tbody></table>\n\n                    </div></div>\n                ";
}
echo "\n\n            <script type=\"text/javascript\" src=\"includes/3rdparty/sort/jquery.tablednd.js\"></script>\n            <script>\n                \$(document).ready(function() {\n                    \$('.sorthis').tableDnD({\n                        onDrop: function(table, row) {\n                            var serialized= \$.tableDnD.serialize();\n                            \$.ajax({\n                                type: 'POST',\n                                url: \"includes/pages/imeifield.order.save.php\",\n                                data: serialized,\n                                success: function(data) {\n\n                                    \$(\"#notification\").addClass('successbox');\n                                    \$(\"#notification\").html(data).show();\n                                }\n                            });\n                        }\n                    });\n                });\n            </script>\n            ";
include_once ROOTDIR . "/includes/customfield.fun.inc.php";
$row = getCustomfieldServicewise("serviceimei", $id);
echo "\n            <div class=\"groupstabes border-0\"  style=\"position: relative;\">\n                <h2>\n                    <span class=\"groupstabesheadertext\">Custom Fields [ ** Dropdown will not display on App]</span>\n                </h2>\n                <div class=\"groupstabescontant\">\n\n                    <table id=\"main_tbl\"  class='sorthis sortable'>\n                        <thead>\n                        <tr>\n                            <th>";
echo $LNG["field"];
echo " ";
echo $LNG["type"];
echo "</th>\n                            <th>";
echo $LNG["name"];
echo "</th>\n                            <th>";
echo $LNG["description"];
echo "</th>\n                            <th>";
echo $LNG["fieldoptions"];
echo "</th>\n                            <th>";
echo $LNG["validation"];
echo "</th>\n                            <th>";
echo $LNG["required"];
echo "</th>\n                            <th align=\"right\">";
echo $LNG["action"];
echo "</th>\n                        </tr>\n                        </thead>\n\n                        <tr  class=\"adddatarow nocheckboxchecked\">\n                            <input type=\"hidden\" value=\"serviceimei\" name=\"customfield[-1][type]\"/>\n                            <input type=\"hidden\" value=\"";
echo $id;
echo "\" name=\"customfield[-1][relid]\"/>\n                            <td><select class=\"customfield form-control\"  name=\"customfield[-1][fieldtype]\"><option value=\"text\">";
echo $LNG["text"];
echo "</option><option value=\"dropdown\">";
echo $LNG["dropdown"];
echo "</option><option value=\"radio\">";
echo $LNG["radio"];
echo "</option><option value=\"textarea\">";
echo $LNG["textarea"];
echo "</option><option value=\"tickbox\">";
echo $LNG["tickbox"];
echo "</option></select></td>\n                            <td><input class=\" form-control\" name=\"customfield[-1][fieldname]\"  value=\"\" type=\"text\"/> </td>\n                            <td><input name=\"customfield[-1][description]\"  class=\" form-control\"  value=\"\" type=\"text\" /></td>\n                            <td><input class='fieldoptions form-control' name=\"customfield[-1][fieldoptions]\"     disabled=\"disabled\" value=\"\" type=\"text\"/>  <small>";
echo $LNG["seperatedbycommas"];
echo "</small></td>\n                            <td><input class='regexpr' class=\" form-control\"  name=\"customfield[-1][regexpr]\"   value=\"\" type=\"text\" /> <small>";
echo $LNG["regularexpression"];
echo "  <a href=\"javascript:void(0)\">Help</a> </small></td>\n                            <td><input value=\"on\"  name=\"customfield[-1][required]\"   id=\"required\" checked=\"checked\" type=\"checkbox\" /> <label for=\"required\"></label></td>\n                            <td><span class=\"datagridbtn\"><input value=\"+ ";
echo $LNG["add"];
echo "\" id=\"btnaddgroup\"\n                                                                 class=\"button add\" type=\"button\"\n                                                                 onclick=\"SubmitForm('#btnaddgroup','editimeiservice.field','#frmedituser','#notification','true','#main_loader','main2.php?page=editimeiservice.field','";
echo $id;
echo "');\"/> </span> </td>\n                        </tr>\n\n                        ";
if ($row) {
    foreach ($row as $key => $value) {
        echo "                                <tr class=\"nocheckboxchecked\" id=\"";
        echo $key;
        echo "\" style=\"vertical-align: top\">\n                                    <td>";
        echo $row[$key]["fieldtype"];
        echo "</td>\n                                    <td>";
        echo $row[$key]["fieldname"];
        echo "\n<div id=\"load";
        echo $key;
        echo "\" style=\"padding: 3px 0\">\n                                        ";
        if ($row[$key]["fieldother"]) {
            $field = json_decode($row[$key]["fieldother"], true);
            foreach ($field as $fo => $fh) {
                echo "                                               <div  class=\"rem";
                echo $key . $fo;
                echo "\"> <input type=\"text\" class=\"form-control\" placeholder=\"Mapping Name\" name=\"other[";
                echo $key;
                echo "][]\"  value=\"";
                echo $fh;
                echo "\"/> <i onclick=\"removeField('";
                echo $key . $fo;
                echo "')\" class=\"fa fa-remove\" ></i> </div>\n                                        ";
            }
        }
        echo "</div>\n                                        <div>\n                                        <button type=\"button\" style=\"background: transparent;color:black !important\" class=\"btn\" name=\"addmore[";
        echo $key;
        echo "]\" onclick=\"addMore(";
        echo $key;
        echo ");\">+More Mapping</button>\n                                        </div>\n\n                                    </td>\n                                    <td>";
        echo $row[$key]["description"];
        echo "</td>\n                                    <td>";
        echo $row[$key]["fieldoptions"];
        echo "</td>\n                                    <td>";
        echo $row[$key]["regexpr"];
        echo "</td>\n                                    <td>";
        echo $row[$key]["required"];
        echo "</td>\n                                    <td align=\"right\"><div align=\"right\">\n                                            <input value=\"";
        echo $LNG["delete"];
        echo "\" id=\"";
        echo $key;
        echo "\"\n                                                   class=\"button delete deletedata\" type=\"button\"\n                                                   onclick=\"DeleteCustom(";
        echo $key;
        echo ")\"/></div></td>\n                                </tr>\n                                ";
    }
}
echo "                    </table>\n\n                </div>\n            </div>\n\n\n            <div  class=\"groupstabes border-0 \" >\n                <h2>\n                    <span class=\"groupstabesheadertext\">Field</span>\n                </h2>\n\n\n\n                <div class=\"groupstabescontant\">\n\n                    <div>\n                        <table class=\"form\">\n                            <tbody>\n                            ";
if ($imeiserviceDetails["useasserver"] == 0) {
    echo "                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["field"];
    echo " ";
    echo $LNG["listing"];
    echo " ";
    echo $LNG["for"];
    echo " </td>\n                                    <td class=\"fieldarea\"> <select style=\"width: 300px;\" name=\"listing\" onchange=\"SubmitForm ('#btnedituser','editimeiservice.field','#frmedituser','#notification','true','#main_loader','main2.php?page=editimeiservice.field','";
    echo $id;
    echo "');\">\n                                            ";
    $result = dquery("SELECT value,gateway from `tbl_apiservers` WHERE setting='name'");
    while ($Row = mysqli_fetch_assoc($result)) {
        $customname = mysqli_fetch_assoc(dquery("SELECT * FROM `tbl_apiservers` WHERE `setting`='customname' AND `gateway`='" . $Row["gateway"] . "' "));
        if ($customname) {
            $customname = " (" . $customname["value"] . ") ";
        }
        echo "<option value=\"";
        echo $Row["gateway"];
        echo "\" ";
        if ($Row["gateway"] == $imeiserviceDetails["listing"]) {
            echo "SELECTED";
        }
        echo " > ";
        echo $Row["value"] . $customname;
        echo " </option>";
    }
    echo "                                        </select>\n                                        <a href=\"#\" data-target=\"apisetting\" data-target-header=\"";
    echo $LNG["manage"];
    echo " ";
    echo $LNG["api"];
    echo "\" onclick=\"AddnewInpopup(this);\">";
    echo $LNG["manage"];
    echo " ";
    echo $LNG["api"];
    echo "</a>\n                                    </td>\n                                </tr>\n\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["brand"];
    echo " / ";
    echo $LNG["model"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["model"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"model\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hs\"/><label for=\"hs\"></label>\n                                        <span class=\"hs\"> <span class=\"textgreen\"><a onclick=\"load_subpage('main2.php?page=editimeiservice.assignbrand&id=";
    echo $id;
    echo "','";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["brand"];
    echo "');\">";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["brand"];
    echo "</a></span>   <span class=\"textgreen\" ><a onclick=\"load_subpage('main2.php?page=editimeiservice.assignmodel&id=";
    echo $id;
    echo "','";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["model"];
    echo "');\">";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["model"];
    echo "</a></span>   <a id='btnbrand' style=\"text-decoration:none;\" href=\"javascript:SubmitForm ('#btnbrand','editimeiservice.resetbrand','#frmedituser','#notification','true','#main_loader');\"  onclick=\" return confirm('Are you sure want to reset assigned Brand/Models');\">";
    echo $LNG["reset"];
    echo "</a> </span></td>\n                                </tr>\n\n\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["country"];
    echo " / ";
    echo $LNG["provider"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["provider"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"provider\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hs1\"/><label for=\"hs1\"></label>\n                                        <span class=\"hs1\"> <span class=\"textgreen\" ><a onclick=\"load_subpage('main2.php?page=editimeiservice.assigncountry&id=";
    echo $id;
    echo "','";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["country"];
    echo "');\">";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["country"];
    echo "</a></span>   <span class=\"textgreen\" ><a onclick=\"load_subpage('main2.php?page=editimeiservice.assignprovider&id=";
    echo $id;
    echo "','";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["provider"];
    echo "');\">";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["provider"];
    echo "</a></span>  <a id='btnbrand' style=\"text-decoration:none;\" href=\"javascript:SubmitForm ('#btnbrand','editimeiservice.resetcountry','#frmedituser','#notification','true','#main_loader');\"  onclick=\" return confirm('Are you sure want to reset assigned Country/Provider');\">";
    echo $LNG["reset"];
    echo "</a> </span></td>\n                                </tr>\n\n                                <tr>\n                                    <td class=\"fieldlabel\">Blackberry ";
    echo $LNG["mep"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["mep"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"mep\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"hs2\"/><label for=\"hs2\"></label>\n\n                                        <span class=\"hs2\">  <span class=\"textgreen\" ><a onclick=\"load_subpage('main2.php?page=editimeiservice.assignmep&id=";
    echo $id;
    echo "','";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["mep"];
    echo "');\">";
    echo $LNG["assign"];
    echo " ";
    echo $LNG["mep"];
    echo "</a></span>  <a id='btnbrand' style=\"text-decoration:none;\" href=\"javascript:SubmitForm ('#btnbrand','editimeiservice.resetmep','#frmedituser','#notification','true','#main_loader');\"  onclick=\" return confirm('Are you sure want to reset assigned MEP');\">";
    echo $LNG["reset"];
    echo "</a> </span>\n\n                                    </td>\n                                </tr>\n                                ";
} else {
    echo "                                <tr>\n                                    <td class=\"fieldlabel\"> ";
    echo $LNG["allow"];
    echo " ";
    echo $LNG["qnt"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["qnt"] == 1) {
        echo "checked=checked";
    }
    echo " name=\"qnt\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"sfhs\"/><label for=\"sfhs\"></label>\n                                    </td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\"> ";
    echo $LNG["qnt"];
    echo " Dropdown ";
    echo $LNG["options"];
    echo "</td>\n                                    <td class=\"fieldarea\">\n                                        <input type=\"text\" name=\"qntoptions\" value=\"";
    echo $imeiserviceDetails["qntoptions"];
    echo "\" />\n                                        <small>Qnt Options e.g. 10,20,30</small>\n                                    </td>\n                                </tr>\n                                <tr>\n                                    <td>\n                                    </td>\n                                    <td>\n                                        Or\n                                    </td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\"> ";
    echo $LNG["qnt"];
    echo " Range</td>\n                                    <td class=\"fieldarea\">\n                                        <input type=\"text\" placeholder=\"Min. Qnt\" name=\"minqnt\" size=\"4\" value=\"";
    echo $imeiserviceDetails["minqnt"];
    echo "\" />\n                                        -\n                                        <input type=\"text\" placeholder=\"Max. Qnt\" name=\"maxqnt\" size=\"4\" value=\"";
    echo $imeiserviceDetails["maxqnt"];
    echo "\" />\n                                        <small>e.g. 10-50</small>\n                                        <div >\n                                            Min &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\n                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Max\n                                        </div>\n                                    </td>\n                                </tr>\n                                ";
}
echo "\n                            </tbody>\n                        </table>\n                    </div>\n                    ";
if ($imeiserviceDetails["useasserver"] == 0) {
    echo "                        <div>\n\n                            <table class=\"form\">\n                                <tbody>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["type"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["type"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"type\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"type1\"/><label for=\"type1\"></label></td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["pin"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["PIN"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"pin\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"pin1\"/><label for=\"pin1\"></label></td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["kbh"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["KBH"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"kbh\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"kbh1\"/><label for=\"kbh1\"></label></td>\n                                </tr>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["prd"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["PRD"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"prd\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"prd1\"/><label for=\"prd1\"></label></td>\n                                </tr>\n                                </tbody>\n                            </table>\n                        </div>\n\n                        <div>\n                            <table class=\"form\">\n                                <tbody>\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["reference"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["reference"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"reference\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"reference1\"/><label for=\"reference1\"></label></td>\n                                </tr>\n\n                                <tr>\n                                    <td class=\"fieldlabel\">";
    echo $LNG["locks"];
    echo "</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["locks"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"locks\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"locks1\"/><label for=\"locks1\"></label></td>\n                                </tr>\n\n                                <tr>\n                                    <td class=\"fieldlabel\">SN</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["SN"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"SN\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"sn\"/><label for=\"sn\"></label></td>\n                                </tr>\n\n                                <tr>\n                                    <td class=\"fieldlabel\">SecRO</td>\n                                    <td class=\"fieldarea\"><input ";
    if ($imeiserviceDetails["reqredfield"]["SecRO"] == "1") {
        echo "checked=checked";
    }
    echo " name=\"SecRO\" value=\"1\" type=\"checkbox\" class=\"onoff {labelOn: 'Yes', labelOff: 'No'}\" id=\"secr\"/><label for=\"secr\"></label></td>\n                                </tr>\n                                </tbody>\n                            </table>\n                        </div>\n                        ";
}
echo "                    <div class=\"clear\"></div>\n\n                </div></div>\n\n\n\n            <p class=\"fixedbtn\">\n    <span ><input value=\"";
echo $LNG["save"];
echo "\" id=\"btnedituser\" class=\"button_save\" type=\"button\"\n                  onclick=\"SubmitForm ('#btnedituser','editimeiservice.field','#frmedituser','#notification','true','#main_loader','main2.php?page=editimeiservice.field','";
echo $id;
echo "');\"/></span>\n            </p>\n                    </form>\n    </div>\n</div>\n<div>+More Mapping: Different names known in other fusion or other scripts  e.g. SERIAL_NUMBER, SRNO, Serial No etc</div>\n\n<div id=\"page_info\" class=\"page_info\">\n    <li>Change Default field settings.</li>\n    <li>Create new custom field for service</li>\n    <li>Set IMEI length or enable bulk IMEI</li>\n</div>";
$fileverioncheck = "6.1.0";

?>