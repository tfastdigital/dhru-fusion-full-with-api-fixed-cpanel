<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">Stock Transfer</a></li>\n</ul>\n";
error_reporting(0);
licince\reqaddon("POS");
$pageid = 494;
checkPagePermission($pageid);
unset($_SESSION["TRANS"]);
unset($_SESSION["DESIRED"]);
unset($_SESSION["WAREHOUSEF"]);
unset($_SESSION["WAREHOUSET"]);
$w = mysqli_fetch_assoc(dquery("select mywarehouse from tbl_admin where id='" . $_SESSION["adminid"] . "'"));
if ($w["mywarehouse"]) {
    $_SESSION["WAREHOUSEF"] = $w["mywarehouse"];
} else {
    $w = mysqli_fetch_assoc(dquery("select id from tbl_warehouse limit 1"));
    $_SESSION["WAREHOUSEF"] = $w["id"];
}
$w = mysqli_fetch_assoc(dquery("select id from tbl_warehouse limit 1"));
$_SESSION["WAREHOUSET"] = $w["id"];
$pos = mysqli_fetch_assoc(dquery("select * from tbl_pos_setting"));
echo "<script>\nfunction transferStock(){\n  \n        \$.post(\"includes/pages/pos.transfer.add2.php?generate=true\",function(data) {\n            alert(data);\n            if(data=='Stock transferred successfully'){\n                location.reload();\n\n            }\n            \n        });\n \n}\n//////////////////////////////////////////\n \nfunction gener(e){\n     var fieldParent = \$('#pid').parents('#product');\n             var fieldChild  = \$('#pid').find('#product');\n       \n             switch (e.which)\n             {\n                 case 40: { keyEvent(\$('#product'),'next');break; }\n                 case 38: { keyEvent(\$('#product'),'prev');break; }\n                 case 13:\n                 {\n                      \$('#pid').val(\$(\"li[class='selected'] a\").attr('class'));\n                      \$('#product').hide();\n                      \$(\"li[class='selected'] a\").removeAttr('class'); \n                        return false;\n                        break;\n                 }\n                 case 9:\n                 {\n                        offFocus('#pid'); \$(\"li\").removeClass(\"selected\");\n                        break;\n                 }\n             }\n}\n\nfunction keyEvent (fieldChild,action)\n{\n            yx = 0;\n            fieldChild.find(\"li\").each(function(){\n                if(\$(this).attr(\"class\") == \"selected\")\n                yx = 1;\n            });\n            if(yx == 1)\n            {\n              \n                var sel = fieldChild.find(\"li[class='selected']\");\n                (action=='next') ? sel.next().addClass(\"selected\") : sel.prev().addClass(\"selected\");\n                sel.removeClass(\"selected\");\n            }\n            else{\n                (action=='next') ? fieldChild.find(\"li:first\").addClass(\"selected\") : fieldChild.find(\"li:last\").addClass(\"selected\");\n            }\n} \nfunction offFocus(fieldChild)\n{\n    var fieldParent =  \$(fieldChild).parents('div.' + config.className);\n    fieldParent.children('div#product').delay(config.fadeTime).fadeOut();\n}           \n   \n///////////////////////////////////////\n \$(document).ready(function() {\n    \$(\"#pid\").val('');\n    \$(\"#pid\").focus();\n////////////////////////////\njQuery.fn.enter2tab = function()\n{\n    this.keyup(function(e){\n        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;\n        if(key==46){\n           Remove(\$(this).parent().parent().attr('id'));\n           jQuery.stop(e);\n           return false;\n        }else if(key==13){ \n            var inputs = \$(this).closest('form').find(':input');\n            inputs.eq( inputs.index(this)+ 1 ).focus();\n           \n        }else{\n            updateData(\$(this).parent().parent().attr('id'));\n        }\n      \n    });\n   return this;\n}\n///////////////////////////\n    \$('#pid').keypress(function(e){\n        \n          if(e.which == 13){\n               var ids=\$(this).val();\n              if(ids!='' && !isNaN(ids)){               \n                \$('#pid').val('');\n                addItem(ids);\n             }else{\n                 if(\$('#pid').val()==''){\n                              \$(\".prices:first\").focus();\n                }\n             }\n           }\n    });\n   \n    \n    \n    \$('#frm').submit(function() {\n          return false;\n    });\n    \n    \n      \n    \$('#pid').keyup(function(e) {\n        var vls=\$(this).val();\n        if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57) || (e.which>=96 && e.which<=105)){\n            //\$.post(\"includes/pages/pos.transfer.product2.php\", { val: vls},function(data) {\n            //     \$('#product').show();\n            //     \$('#product').html(data);\n           // });\n        }else if(e.which==40 || e.which==38 || e.which==13){\n              gener(e);\n        }    \n       \n    });\n    \n});\nfunction addItem(ids){\n    if(ids!='' && !isNaN(ids)){\n        \$('#pid').val('');\n        \$.post(\"includes/pages/pos.transfer.add2.php\", { val: ids},function(data) {\n               data=data.split('---');\n               if(data[0]==\"UNAVL\"){\n                    alert(\"Product out of stock.\");\n                    return false;\n               }\n               if(data[1]==\"NOT\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n                    return false;\n               }\n               if(data[1]==\"ABS\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n                    return false;\n               }else{\n                 \$('#tbody').append(data[0]);\n               }\n                            \n        });\n    }\n}\n\nfunction setWarehouseF(){\n      ids=\$('#widf').val();\n      \$.post(\"includes/pages/pos.transfer.add2.php?warehousef=true\",{ idw: ids}, function(data) {\n      });\n}\nfunction setWarehouseT(){\n      ids=\$('#widt').val();\n      \$.post(\"includes/pages/pos.transfer.add2.php?warehouset=true\",{ idw: ids}, function(data) {\n      });\n}\nfunction setWet(val){\n    if(val==''){\n        document.getElementById('pid').value='Serial No';\n    }\n}\nfunction setClk(val){\n    if(val=='Serial No'){\n        document.getElementById('pid').value='';\n    }\n}\nfunction Remove(ids){\n    if(confirm(\"Are you sure want to remove ?\")){\n        \$.post(\"includes/pages/pos.transfer.add2.php?remove=true\", { val: ids},function(data) {\n            \$(\"#\"+ids).remove();\n        });\n    }\n    return false;\n}\nfunction setVLL(vals){\n    document.getElementById('pid').value=vals;\n    \$('#product').hide();\n}\n\nfunction setTo(ob){\n        ob.enter2tab();\n}\nfunction updateData(ids){\n    qnt=1\n    \n    \$.post(\"includes/pages/pos.transfer.add2.php?update=true\", { val: ids,q: qnt},function(data) {\n     \n        var check=data.split(\"---\");\n        if(check[0]=='NOT'){\n            data=check[1];\n            alert(\"Desired Quantity is Insufficient in this warehouse. You can't  process\");\n            return false;\n        }\n        if(check[0]=='ABS'){\n               alert(\"Desired Quantity is Insufficient in this warehouse.You can't  process\");\n              return false;\n        }\n    });    \n}\n</script>\n<style>    \n.form{margin-bottom: 4px !important;}\n#product,#client{position: absolute;background: white;min-width:200px;border:#dddddd solid 3px;}\n#product li,#client li{border-bottom: #f5f5f5 solid 1px;padding:5px;}\n.selected,.selectedc{background-color: #e6e5e5;}\n.fieldlabel{font-size:14px}\ninput[type=\"text\"],select,textarea{background: white;}\n#totals,#tax,#gross{font-size: 14px;text-align: right;}\n#totals{background: #53637D;color:white}\n#tax{background: white;}\n#gross{background: #779500;color:white}\n#disc{background: #EBAC9A;color:white}\n.textred{font-size:10px}\nfieldset{background:#f5f5f4;}\nfieldset legend{background: #eaeaea;padding:5px 10px;font-size: 14px;margin-left: 0 !important;}\n#main_tbl thead th{background-image: none !important;background-color: #53637D !important;color:white !important;padding:8px 5px}\n#main_tbl td,#main_tbl th{border-right: #cccccc solid 1px;}\n</style> \n\n\n<div id=\"content\">\n<div id=\"notification\"></div>\n<div id=\"content_padded\">\n\n";
echo generate_token("form");
echo "\n\n<div style=\"background: #f4f4f4;padding:10px\">\n <form id=\"frm\" name=\"\" method=\"post\">\n        <table>\n            <tr>\n                <td align=\"left\">\n                    <input type=\"text\" name=\"pid\" id=\"pid\" onclick=\"setClk(this.value)\"\n                     onblur=\"setWet(this.value)\" autocomplete=\"off\"  value=\"Serial No\" style=\"width:180px\"/>\n                    <input type=\"button\" class=\"addFromgallery\" \n                    onclick=\"addItem(document.getElementById('pid').value)\"\n                     name=\"additem\" value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["item"];
echo "\" />                          \n                    <div style=\"display: none;z-index:999\" id=\"product\"></div>\n                </td>                \n                <td align=\"center\">\n                <!--    ";
echo $LNG["warehouse"];
echo "   ";
echo $LNG["from"];
echo " : \n                    <select style=\"width: 100px;\" id=\"widf\" name=\"widf\"  onchange=\"setWarehouseF();\"> ";
$s = dquery("select * from tbl_warehouse");
while ($r = mysqli_fetch_assoc($s)) {
    echo "                     <option value=\"";
    echo $r["id"];
    echo "\" ";
    if ($r["id"] == $_SESSION["admwid"]) {
        echo "selected";
    }
    echo ">";
    echo $r["name"];
    echo "</option>  ";
}
echo "</select>\n                     -->  \n                </td>\n                <td align=\"right\">\n                 ";
echo $LNG["transfer"];
echo "   ";
echo $LNG["to"];
echo " : <select style=\"width: 100px;\" id=\"widt\" name=\"widt\" \n                     onchange=\"setWarehouseT();\"> \n                      ";
$s = dquery("select * from tbl_warehouse");
while ($r = mysqli_fetch_assoc($s)) {
    echo "<option value=\"";
    echo $r["id"];
    echo "\" >\n                      ";
    echo $r["name"];
    echo "</option> ";
}
echo "  </select> \n                </td>\n                <td align=\"right\">\n                   <input type=\"button\" class=\"btn save\" name=\"transfer\" \n                   onclick=\"transferStock();\" value=\"";
echo $LNG["transfer"];
echo "\" />   \n                </td>\n            </tr>\n        </table>            \n </form> \n</div>\n\n\n<div style=\"position: relative;min-height:200px\">                        \n         <form id=\"frm\" name=\"\" method=\"post\">\n            <table id=\"main_tbl\" style=\"display: table;border: #53637D solid 5px;\">\n                <thead>\n                    <tr>\n                    <th style=\"width:10%;\">";
echo $LNG["item"];
echo "#</th>\n                    <th style=\"width:30%;\">";
echo $LNG["item"];
echo " ";
echo $LNG["name"];
echo "</th>\n                     <th style=\"width:10%;text-align: center;\">";
echo $LNG["warehouse"];
echo "</th>\n                    <th style=\"width:10%;text-align: center;\">";
echo $LNG["qnt"];
echo "</th>\n                    </tr>\n                </thead>\n                <tbody id=\"tbody\"></tbody>\n            </table>\n        </form>                                 \n</div> \n";
$fileverioncheck = "6.1.0";

?>