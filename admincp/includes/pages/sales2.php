<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

unset($_SESSION["SALES"]);
unset($_SESSION["unique"]);
unset($_SESSION["AMOUNT"]);
unset($_SESSION["CUSTOMER"]);
unset($_SESSION["NOTES"]);
unset($_SESSION["STYPE"]);
unset($_SESSION["SHIP"]);
unset($_SESSION["WAREHOUSE"]);
unset($_SESSION["LAST"]);
unset($_SESSION["FIRST"]);
unset($_SESSION["EMAIL"]);
unset($_SESSION["PHONE"]);
dquery("ALTER TABLE `tbl_serial_list`  \nADD `date` VARCHAR(50) NOT NULL  AFTER `refund`,  \nADD `aid` INT(5) NOT NULL  AFTER `date`");
dquery("ALTER TABLE `tbl_stock_history` \n ADD `remove` INT(1) NOT NULL  AFTER `status`");
if (!mysqli_num_rows(dquery("select * from tbl_admin_access\n where id=524"))) {
    dquery("INSERT INTO `fusion_fusion`.`tbl_admin_access` (\n`id` ,`page_name` ,`page_description` ,`groupname` ,`shop`)\nVALUES (NULL , 'stock.php', 'Remove Stock', 'pos', '')");
}
if (!mysqli_num_rows(dquery("select * from tbl_admin_access\n where id=525"))) {
    dquery("INSERT INTO `fusion_fusion`.`tbl_admin_access` (\n`id` ,`page_name` ,`page_description` ,`groupname` ,`shop`)\nVALUES (NULL , 'pos.sales.php', 'Can Change Warehouse', 'pos', '')");
}
$pos = mysqli_fetch_assoc(dquery("select * from tbl_pos_setting"));
$w = mysqli_fetch_assoc(dquery("select mywarehouse,group_id \nfrom tbl_admin where id='" . $_SESSION["adminid"] . "'"));
$acc = mysqli_fetch_assoc(dquery("select access from tbl_admin_access_group\nwhere id=(select group_id from tbl_admin where id='" . $_SESSION["adminid"] . "')"));
$perms = explode(",", $acc["access"]);
echo "<script>\nfunction generate()\n{\n    var reply=confirm(\"Do you want to complete sale\");\n    if(reply){\n        var a=\$('#pay').val();\n        var n=\$('#note').html();\n        var s=\$('#stype').val();\n        var wr=\$('#wid').val();\n        var fn=\$('#firstname').val();\n        var ln=\$('#lastname').val();\n        var em=\$('#email').val();\n        var ph=\$('#phone').val();\n        var gt=\$('#gateway').val();\n        var ship=\$('#ship').val();\n        var i=\$('#printi:checked').val();\n    \n        \$.post(\"includes/pages/pos.sales.add.php?generate2=true\", \n        { amount: a,note :n,stype :s,ship:ship,wr:wr,fn:fn,gt:gt,ln:ln,em:em,ph:ph},function(data) {\n          \n         \n           obj = JSON.parse(data);\n           \n         if(s==2){\n            if(obj['STATUS']=='error'){\n              alert(obj['MSG']);\n            }else{\n              alert(obj['MSG']);\n            }\n         }else{\n           if(obj['STATUS']=='error'){\n              alert(obj['MSG']);\n           }else{\n            \nnewwindow=window.open('includes/pages/printsale.php?action=";
echo $pos["template"];
echo "&print='+i+'&invoiceid='+obj['MSG'],'name','scrollbars=yes,resizeable=yes,menubar=no,height=650,width=650');\nif (window.focus) {newwindow.focus()}\n            \n            }\n          }\n        });\n       \n    }\n}\n\nfunction setVLL1(vals){\n    if(vals!=undefined){\n        document.getElementById('cid').value=vals;\n        \$('#client').hide();\n        \$.post(\"includes/pages/pos.sales.add.php?customer=true\", { val: vals},function(data) {\n              \$('#customer').html(data);                  \n        });\n    }else{\n        document.getElementById('cid').value='';\n    }\n}\nfunction detach(){\n     \$.post(\"includes/pages/pos.sales.add.php?detach=true\", function(data) {              \n              \$('#customer').html(data);              \n    });\n}\nfunction updateTotal()\n{\n     try{\n         var subtotal= 0;\n         var price=\$('.price');\n         var disc=\$('.disc');\n         \n         \$('.qnts').each(function(key, object){\n            try{\n                 \$.post(\"includes/pages/pos.get.php?action=update\",{id:key,qnt:object.value,price:price[key].value,discount: disc[key].value},function(data) {\n                     var cto=parseInt(object.value)*parseFloat(price[key].value);\n                     var disco=(( parseFloat(cto)*parseFloat(disc[key].value) )/100).toFixed(2);\n                     subtotal+=parseFloat(cto)-parseFloat(disco);\n                     \$(\".tot_\"+(key+10)).html( parseFloat(cto)-parseFloat(disco) );\n                 });\n            }catch(e){\n               // alert(e);\n            }\n         });\n     setTimeout(function(){\n    var tax=0;\n    subtotal=parseFloat(subtotal);\n         \n    \$.post(\"includes/pages/pos.get.php?action=tax\",function(data) {\n           \n        obj = JSON.parse(data);\n        for (i = 0; i < obj.length; i++) {\n          \n            if(obj[i]['name']){\n                \$(\".\"+obj[i]['name']).show();\n                var ttax=(subtotal*parseFloat(obj[i]['taxrate'])/100).toFixed(2);\n                \$(\".tax_\"+obj[i]['id']).html(ttax);\n                tax+=ttax;\n                \$(\"#total\").html((subtotal+parseFloat(tax)+parseFloat(\$('#ship').val() )).toFixed(2) ) ;\n            }  \n        }    \n    });\n        \n     \$(\"#subtotal\").html(subtotal);\n        }, 300);\n     }catch(es){\n      //  alert(es);\n     }         \n}\n\$(document).ready(function() {\n     \$(this).focus();\n    \n    \$('#cid').keyup(function(e) {\n          var vls=\$(this).val();\n          if((e.which>=65 && e.which<=90) || (e.which>=48 && e.which<=57)  || (e.which>=96 && e.which<=105)){ \n            \$.post(\"includes/pages/pos.sales.product.php?client=true\", { val: vls},function(data) {\n                 \$('#client').show();\n                 \$('#client').html(data);\n            });\n          }\n        \n    });    \n    \n    \n     \$('#serial').keypress(function(e){\n              if(e.which == 13){\n                    if(\$(this).val()!='')\n                    {\n                        \n                      \n        \$.post(\"includes/pages/pos.get.php?action=add\", \n        {serial:\$(this).val(),wid: document.getElementById('wid').value},\n        function(data) {\n           \n            var sales=\$('#sales');\n            obj = JSON.parse(data);\n            \n            if(obj['status']=='success')\n            {\n               \n                if(obj['data']['qnt']>1){\n                    \$(\"#row\"+obj['data']['id']).remove();\n                }\n                \n                var trow=\"<tr id='row\"+obj['data']['id']+\"'><td><input type='hidden' name='sid[\"+obj['data']['id']+\"]' value='\"+obj['data']['id']+\"' />\"+\n                \" \"+obj['data']['item']+\" [\"+obj['data']['serial']\n                +\"]</td><td><input type='text' onkeyup='updateTotal()' name='price[\"+obj['data']['id']\n                +\"]' value='\"+obj['data']['price']+\"' class='price' /></td><td><input type='text' name='qnt[\"\n                +obj['data']['id']+\"]' class='qnts' onkeyup='updateTotal()' value='\"+obj['data']['qnt']+\n                \"' /></td><td><input type='text' class='disc' onkeyup='updateTotal()' name='discount[\"+obj['data']['id']+\n                \"]' value='\"+obj['data']['discount']+\"' /></td><td class='tot_\"+obj['data']['id']+\"'>\"\n                +(parseInt(obj['data']['qnt'])*parseFloat(obj['data']['price']) )+\"</td></tr>\";\n                \n                sales.append(trow);\n                \n                updateTotal();\n                \n            }else if(obj['status']=='error'){                \n                for (i = 0; i < obj['data'].length; i++) {\n                   alert(obj['data'][i]);\n                }\n            } \n            \n            \$(\"#serial\").val(\"\");\n            \n        });\n                    }\n              }\n     });\n});\n</script>\n<div align='center'>\n<input type=\"text\" name=\"serial\" id=\"serial\" />\n";
if (!in_array(525, $perms)) {
    $wars = mysqli_fetch_assoc(dquery("select name from tbl_warehouse\n    where id='" . $w["mywarehouse"] . "'"));
    echo "Warehouse: " . $wars["name"];
    echo "    <input type=\"hidden\" name=\"wid\" id=\"wid\" value=\"";
    echo $w["mywarehouse"];
    echo "\" />\n    ";
} else {
    echo "          \n<select style=\"width: 100px;\" id=\"wid\" name=\"wid\"  > \n ";
    $s = dquery("select * from tbl_warehouse");
    while ($r = mysqli_fetch_assoc($s)) {
        echo " \n  <option value=\"";
        echo $r["id"];
        echo "\"\n   ";
        if ($r["id"] == $w["mywarehouse"]) {
            echo "selected";
        }
        echo ">";
        echo $r["name"];
        echo "</option>  \n       ";
    }
    echo "</select> \n";
}
echo "<select name=\"stype\" id=\"stype\">\n    <option value=\"1\">Sale</option>\n    <option value=\"2\">Return</option>\n</select>\n<br /><br />\n<table>\n<thead>\n<th>Item</th>\n<th>Price</th>\n<th>Qnt</th>\n<th>Discount %</th>\n<th>Total</th>\n</thead>\n<tbody id=\"sales\"> \n</tbody>\n\n</table>\n\n<div style=\"float: right; widht: 300px;\">\nSubtotal : <span id=\"subtotal\">0</span> <br />\n";
if ($config["taxtype"] != "Inclusive") {
    $tx = dquery("select * from tbl_tax");
    while ($rt = mysqli_fetch_assoc($tx)) {
        echo "    <div style=\"display: none;\" class=\"";
        echo $rt["name"];
        echo "\" >\n    ";
        echo $rt["name"];
        echo " ";
        echo $rt["taxrate"];
        echo "%: \n    <span class=\"tax_";
        echo $rt["id"];
        echo "\">0</span>\n    </div>\n    ";
    }
}
echo "<br />\nTotal : <span id=\"total\">0</span> \n</div>\n\n</div>\n<div style=\"clear: both;\">&nbsp;&nbsp;<br />&nbsp;</div>\n<div style=\"float: right;\">\nPayment Gateway:\n  <select name=\"gateway\"   id=\"gateway\">            \n                 ";
$q = dquery("select value,gateway from tbl_paymentgateways where setting='POS (Point of sales)' and value = '1'");
while ($row = mysqli_fetch_assoc($q)) {
    $cc = mysqli_fetch_assoc(dquery("select value from tbl_paymentgateways\n                    where setting='name' and gateway='" . $row["gateway"] . "'"));
    echo "                <option value=\"";
    echo $row["gateway"];
    echo "\">";
    echo $cc["value"];
    echo "</option>\n                ";
}
echo "                 </select> <br />\nShipping Cost :  <input type=\"text\" onkeyup=\"updateTotal()\" name=\"shipping\" value=\"0\" id=\"ship\" /> <br />\nPayment :  <input type=\"text\" name=\"payment\" value=\"\" id=\"pay\" /> <br />\nNote : <textarea name=\"note\" id=\"note\" ></textarea>\n<br />\n<label><input type=\"checkbox\" name=\"print\" id=\"printi\" value=\"1\" /> Print</label>\n<br />\n<input type=\"button\" name=\"generate\" value=\"Generate\" onclick=\"generate();\" />\n</div>\n<div id=\"customer\">                        \n<input type=\"text\" name=\"customer\" id=\"cid\" style=\"width: 200px;\"  value=\"\" placeholder=\"Username\" />\n<a onclick=\"javascript: \$('.clients').toggle();\" href=\"#\">+";
echo $LNG["add"];
echo " ";
echo $LNG["client"];
echo "</a>\n<div id=\"client\" style=\"display: none;\"></div>       \n<div style=\"display: none;\" class=\"clients\" >\n<input type=\"text\" name=\"firstname\" id=\"firstname\" value=\"\" placeholder=\"First Name\" /> <br />\n<input type=\"text\" name=\"lastname\" id=\"lastname\" value=\"\" placeholder=\"Last Name\" /> <br />\n<input type=\"text\" name=\"email\" id=\"email\" value=\"\" placeholder=\"Email\" /> <br />\n<input type=\"text\" name=\"phone\" id=\"phone\" value=\"\" placeholder=\"Phone\" /> <br />\n</div>  \n</div>";
$fileverioncheck = "6.1.0";

?>