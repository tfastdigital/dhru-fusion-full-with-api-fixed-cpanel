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
echo "<script>\n\$(document).ready(function() {\n        MgetWaiting('#userlistw','false','');\n});\nfunction getActivate(){\n    var buffer=\"\";\n    \$(\"input:checkbox[name=ids]:checked\").each(function()\n    {\n         buffer =buffer+\$(this).val()+\"-\";\n    });\n    buffer = buffer.slice(0, -1);\n    \$('#uids').val(buffer);\n    SubmitForm ('#btnedituserpass','edituser.profile','#frmedituser','#notificationw','false','');\n     MgetWaiting('#userlistw','false','');\n}\nfunction getRemove(){\n    var buffer=\"\";\n    \$(\"input:checkbox[name=ids]:checked\").each(function()\n    {\n         buffer =buffer+\$(this).val()+\"-\";\n    });\n    buffer = buffer.slice(0, -1);\n    \$('#uids').val(buffer);\n    \$('#remove').val('1');\n    SubmitForm ('#btnedituserpass','edituser.profile','#frmedituser','#notificationw','false','');\n     MgetWaiting('#userlistw','false','');\n}\nfunction setcheck(ids){\n    if(document.getElementById(ids).checked){\n        document.getElementById(ids).checked=false;\n    }else{\n        document.getElementById(ids).checked=true;\n    }\n}\n</script>\n    <div  id=\"notificationw\"></div>\n\n<form id=\"frmedituser\" method=\"post\">\n";
echo generate_token("form");
echo "<input type=\"hidden\" name=\"mobile\" value=\"1\" />\n<input type=\"hidden\" name=\"alls\" value=\"1\" />\n<input type=\"hidden\" id=\"remove\" name=\"remove\" value=\"\" />\n<input type=\"hidden\" id=\"uids\" name=\"id\" value=\"90000000\" />\n</form>\n\n  <div  id=\"userlistw\"  class=\"panel\">\n\n  </div>\n\n<div class=\"action2\">\n        <div class=\"panel\">\n            <p><a onclick=\"getActivate()\" class=\"btn\">Active Selected</a></p>\n            <p><a onclick=\"getRemove();\"  class=\"btn\">Remove Selected</a></p>\n        </div>\n  </div>\n\n\n";

?>