<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<ul id=\"tabmenu\">\n    <li><a class=\"tabmenu_active\" href=\"#\">Stock Transfer</a></li>\n</ul>\n\n";
error_reporting(0);
licince\reqaddon("POS");
$pageid = 494;
checkPagePermission($pageid);
dquery("ALTER TABLE `tbl_serial_list` ADD `transist` VARCHAR(20) NOT NULL");
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
echo "<script>\nvar flegu=0;\nfunction transferStock(){\n    var note=\$(\"#notes\").val();\n\n    var by=\$('input[name=\"transferby\"]:checked').val();\n\n    if(by==1){\n        if(!confirm('Are you sure want to transfer Instant?'))\n        {\n            return false;\n        }\n    }\n    var dtime=\$(\"#deliverytime\").val();\n    var ddate=\$(\".ddate\").val();\n\n\n        \$.post(\"includes/pages/pos.transfer.add.php?generate=true\",\n        {tranby:by,delt:dtime,deld:ddate,notes:note},function(data) {\n\n            if(data=='Stock transferred successfully'){\n                location.reload();\n            }\n\n        });\n}\n//////////////////////////////////////////\n\nfunction showD(val)\n{\n    if(val==2){\n        \$(\".dtim\").show();\n    }else{\n        \$(\".dtim\").hide();\n    }\n}\n\nfunction gener(e){\n     var fieldParent = \$('#pid').parents('#product');\n             var fieldChild  = \$('#pid').find('#product');\n\n             switch (e.which)\n             {\n                 case 40: { keyEvent(\$('#product'),'next');break; }\n                 case 38: { keyEvent(\$('#product'),'prev');break; }\n                 case 13:\n                 {\n\n                      \$('#pid').val(\$(\"li[class='selected'] a\").attr('class'));\n                      \$('#product').hide();\n                      \$(\"li[class='selected'] a\").removeAttr('class');\n                        return false;\n                        break;\n                 }\n                 case 9:\n                 {\n                        offFocus('#pid'); \$(\"li\").removeClass(\"selected\");\n                        break;\n                 }\n             }\n}\n\nfunction keyEvent (fieldChild,action)\n{\n            yx = 0;\n            fieldChild.find(\"li\").each(function(){\n                if(\$(this).attr(\"class\") == \"selected\")\n                yx = 1;\n            });\n            if(yx == 1)\n            {\n\n                var sel = fieldChild.find(\"li[class='selected']\");\n                (action=='next') ? sel.next().addClass(\"selected\") : sel.prev().addClass(\"selected\");\n                sel.removeClass(\"selected\");\n            }\n            else{\n                (action=='next') ? fieldChild.find(\"li:first\").addClass(\"selected\") : fieldChild.find(\"li:last\").addClass(\"selected\");\n            }\n}\nfunction offFocus(fieldChild)\n{\n    var fieldParent =  \$(fieldChild).parents('div.' + config.className);\n    fieldParent.children('div#product').delay(config.fadeTime).fadeOut();\n}\n\n///////////////////////////////////////\n \$(document).ready(function() {\n\n    \$(\"#pid\").val('');\n    \$(\"#pid\").focus();\n\n    var widf=\$(\"#widf\").val();\n    var ob=document.getElementById('widt');\n    for(var i=0; i < ob.options.length; i++)\n    {\n        if(ob.options[i].value != widf){\n            ob.options[i].selected=true;\n        }\n    }\n    setWarehouseF();\n    setWarehouseT();\n\n////////////////////////////\njQuery.fn.enter2tab = function()\n{\n    this.keyup(function(e){\n        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;\n        if(key==46){\n           Remove(\$(this).parent().parent().attr('id'));\n           jQuery.stop(e);\n           return false;\n        }else if(key==13){\n            var inputs = \$(this).closest('form').find(':input');\n            inputs.eq( inputs.index(this)+ 1 ).focus();\n        }else{\n            updateData(\$(this).parent().parent().attr('id'));\n        }\n    });\n   return this;\n}\n///////////////////////////\n    \$('#widf').change(function(e){\n        var widf=\$(\"#widf\").val();\n        var ob=document.getElementById('widt');\n        for(var i=0; i < ob.options.length; i++)\n        {\n            if(ob.options[i].value != widf){\n                ob.options[i].selected=true;\n            }\n        }\n         setWarehouseF();\n         setWarehouseT();\n    });\n    \$('#pid').keypress(function(e){\n\n          if(e.which == 13){\n               var ids=\$(this).val();\n               if(ids!='' && !isNaN(ids)){\n                \$('#pid').val('');\n                var flag=0;\n                \$.post(\"includes/pages/pos.transfer.product.php?searialno=true&s=\"+ids,function(data) {\n\n                   if(data!=undefined){\n                        flag=1;\n                        flegu=1;\n                        addItem(data,ids);\n                   }\n                });\n                if(flag==0){\n                    flegu=1;\n                  addItem(ids);\n                }\n             }else{\n                 if(\$('#pid').val()==''){\n                    \$(\".prices:first\").focus();\n                 }\n             }\n           }\n    });\n\n\n\n    \$('#frm').submit(function() {\n          return false;\n    });\n\n    \$('#deliverytime').change(function(e) {\n         var d=\$(this).val();\n\n         var today = new Date();\n         var dd =today.getFullYear()+\"-\"+(today.getMonth()+1)+\"-\"+today.getDate();\n         var dt = new Date();\n         dt.setDate(today.getDate()+parseInt(\$(this).val()));\n\n         \$(\".ddate\").val(dt.getFullYear()+\"-\"+(dt.getMonth()+1)+\"-\"+dt.getDate())\n         //alert(dt.getFullYear()+\"-\"+(dt.getMonth()+1)+\"-\"+dt.getDate());\n    });\n\n    \$('#pid').keyup(function(e) {\n        var vls=\$(this).val();\n        if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57) || (e.which>=96 && e.which<=105)){\n            \$.post(\"includes/pages/pos.transfer.product.php\", { val: vls},function(data) {\n                 \$('#product').show();\n                 \$('#product').html(data);\n            });\n        }else if(e.which==40 || e.which==38 || e.which==13){\n              gener(e);\n        }\n\n    });\n\n});\nfunction addItem(ids,serial){\n\n\n   if(flegu==0)\n   {\n         \$.post(\"includes/pages/pos.transfer.product.php?searialno=true&s=\"+ids,function(data) {\n                 if(data!=undefined){\n                       serial=ids;\n                       ids=data;\n\n                           if(ids!='' && !isNaN(ids)){\n        \$('#pid').val('');\n        \$.post(\"includes/pages/pos.transfer.add.php\", { val: ids,serial:serial},function(data) {\n\n               data=data.split('---');\n\n               if(data[1]==\"NOT\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n                    return false;\n               }\n               if(data[1]==\"ABS\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n                    return false;\n               }else{\n                 \$('#tbody').append(data[0]);\n               }\n\n        });\n    }\n                   }\n         });\n\n   }else{\n    if(ids!='' && !isNaN(ids)){\n        \$('#pid').val('');\n        \$.post(\"includes/pages/pos.transfer.add.php\", { val: ids,serial:serial},function(data) {\n               data=data.split('---');\n\n               if(data[1]==\"NOT\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n                    return false;\n               }\n               if(data[1]==\"ABS\"){\n                    alert(\"Desired Quantity is Insufficient in this warehouse.\");\n                    return false;\n               }else{\n                 \$('#tbody').append(data[0]);\n               }\n\n        });\n    }\n   }\n\n   flegu=0;\n\n}\n\nfunction setWarehouseF(){\n      ids=\$('#widf').val();\n      \$.post(\"includes/pages/pos.transfer.add.php?warehousef=true\",{ idw: ids}, function(data) {\n      });\n}\nfunction setWarehouseT(){\n      ids=\$('#widt').val();\n      \$.post(\"includes/pages/pos.transfer.add.php?warehouset=true\",{ idw: ids}, function(data) {\n      });\n}\nfunction setWet(val){\n    if(val==''){\n        document.getElementById('pid').value='Name / Barcode / Serial No';\n    }\n}\nfunction setClk(val){\n    if(val=='Name / Barcode / Serial No'){\n        document.getElementById('pid').value='';\n    }\n}\nfunction Remove(ids){\n    if(confirm(\"Are you sure want to remove ?\")){\n    \$.post(\"includes/pages/pos.transfer.add.php?remove=true\", { val: ids},function(data) {\n        \$(\"#\"+ids).remove();\n    });\n    }\n    return false;\n}\nfunction setVLL(vals){\n    flegu=1;\n    document.getElementById('pid').value=vals;\n    \$('#product').hide();\n}\n\nfunction setTo(ob){\n        ob.enter2tab();\n}\n\nfunction updateData(ids){\n    qnt=document.getElementById('qnt['+ids+']').value;\n\n    \$.post(\"includes/pages/pos.transfer.add.php?update=true\", { val: ids,q: qnt},function(data) {\n\n        var check=data.split(\"---\");\n        if(check[0]=='NOT'){\n            data=check[1];\n            alert(\"Desired Quantity is Insufficient in this warehouse. You can't  process\");\n\n\n            return false;\n        }\n        if(check[0]=='ABS'){\n               alert(\"Desired Quantity is Insufficient in this warehouse.You can't  process\");\n              return false;\n        }\n    });\n}\n\n\n\n</script>\n<style>\n.form{margin-bottom: 4px !important;}\n#product, #client {\n    background: none repeat scroll 0 0 #222222;\n    position: absolute;\n}\n#product li, #client li {\n    border-bottom: 1px solid #666666;\n    color: #ffffff !important;\n    list-style: outside none none;\n    padding: 5px;\n}\n#product li a, #client li a{\n    color:white\n}\n.selected,.selectedc{background-color: orange;}\n.fieldlabel{font-size:14px}\ninput[type=\"text\"],select,textarea{background: white;}\n#totals,#tax,#gross{font-size: 14px;text-align: right;}\n#totals{background: #222;color:white}\n#tax{background: white;}\n#gross{background: #779500;color:white}\n#disc{background: #EBAC9A;color:white}\n.textred{font-size:10px}\nfieldset{background:#f5f5f4;}\nfieldset legend{background: #eaeaea;padding:5px 10px;font-size: 14px;margin-left: 0 !important;}\n#main_tbl td{border-right:#eee solid 1px}\n#customer .fieldlabel{font-weight: normal;text-transform: capitalize;}\n#main_tbl td#totals,#main_tbl td#gross{font-size:20px}\n</style>\n\n\n<div id=\"content\">\n<div id=\"notification\"></div>\n<div id=\"content_padded\">\n\n";
echo generate_token("form");
echo "\n\n<div>\n <form id=\"frm\" name=\"\" method=\"post\">\n        <table>\n            <tr>\n                <td align=\"left\">\n                    <input type=\"text\" name=\"pid\" id=\"pid\" onclick=\"setClk(this.value)\" onblur=\"setWet(this.value)\" autocomplete=\"off\"  value=\"Name / Barcode / Serial No\" style=\"width:180px\"/>\n                    <input type=\"button\" class=\"addFromgallery\" onclick=\"addItem(document.getElementById('pid').value)\" name=\"additem\" value=\"";
echo $LNG["add"];
echo " ";
echo $LNG["item"];
echo "\" />\n                    <div style=\"display: none;z-index:999\" id=\"product\"></div>\n                </td>\n                <td align=\"right\">\n                    ";
echo $LNG["warehouse"];
echo "   ";
echo $LNG["from"];
echo " :\n                    <select style=\"width: 100px;\" id=\"widf\" name=\"widf\"  onchange=\"setWarehouseF();\"> ";
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
    echo "</option>                            ";
}
echo "                            </select>\n\n                    ";
echo $LNG["to"];
echo " : <select style=\"width: 100px;\" id=\"widt\" name=\"widt\"  onchange=\"setWarehouseT();\">  ";
$s = dquery("select * from tbl_warehouse");
while ($r = mysqli_fetch_assoc($s)) {
    echo "<option value=\"";
    echo $r["id"];
    echo "\" >";
    echo $r["name"];
    echo "</option> ";
}
echo "  </select>\n                </td>\n\n            </tr>\n        </table>\n </form>\n</div>\n\n<br /><br /><br />\n\n<div style=\"width:69%;float:left;\">\n         <form id=\"frm\" name=\"\" method=\"post\">\n            <table id=\"main_tbl\" style=\"display: table;\">\n                <thead>\n                    <tr>\n                    <th style=\"width:10%;\">";
echo $LNG["item"];
echo "#</th>\n                    <th style=\"width:30%;\">";
echo $LNG["item"];
echo " ";
echo $LNG["name"];
echo "</th>\n                    <th style=\"width:10%;text-align: center;\">";
echo $LNG["qnt"];
echo "</th>\n                    </tr>\n                </thead>\n                <tbody id=\"tbody\"></tbody>\n            </table>\n        </form>\n</div>\n\n\n<div style=\"float: right;width:29%;\">\n\n   <textarea name=\"notes\" id=\"notes\" cols=\"50\" rows=\"8\" placeholder=\"Notes \"></textarea>\n   <br />  <br />\n   <input type=\"radio\" name=\"transferby\"\n   onclick=\"showD(this.value)\"\n    checked=\"\" value=\"1\" id=\"instant\" />\n   <label for=\"instant\">Instant</label>\n\n   <input type=\"radio\" name=\"transferby\"\n   onclick=\"showD(this.value)\" value=\"2\" id=\"transport\" />\n   <label for=\"transport\">By Transport</label>\n   <br /><br />\n   <div class=\"dtim\" style=\"display: none;\">\n\n   <select name=\"deliverytime\" id=\"deliverytime\">\n   ";
for ($i = 1; $i <= 100; $i++) {
    echo "    <option>";
    echo $i;
    echo "</option>\n    ";
}
echo "   </select> <small style=\"float: right;\">( Approx  Delivery Time in days)</small>\n\n   <br /> <br />\n     <input type=\"text\" id=\"from\" class=\"ddate datepicker\"  autocomplete=\"off\" name=\"date\" value=\"";
echo date("Y-m-d");
echo "\" /> <small style=\"float: right;\">(Date)</small>\n    </div>\n\n     <br />\n      <input type=\"button\" class=\"btn save\" name=\"transfer\"\n   onclick=\"transferStock();\" value=\"";
echo $LNG["transfer"];
echo "\" />\n\n</div>\n";
$fileverioncheck = "6.1.0";

?>