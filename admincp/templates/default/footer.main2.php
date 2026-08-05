<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<!--\n<script type=\"text/javascript\">\n\t\t\n    function setRightClick(obj){ \n        \n        \$(obj).mousedown(function(e){ \n            if( e.button == 2 ) {                                \n                \$('#rightClickMenu').disableContextMenuItems('#closeall,#closeothers');\n                \$('#rightClickMenu').css({'margin-left':'-250px'});                 \n             }              \n          });\n        \n        \$(obj).contextMenu({\t\t\t\t    \n\t\t\tmenu: 'rightClickMenu'\n\t\t}, function(action, el, pos) {\n\t\t      \n\t\t      if(action=='refresh'){\n\t\t          \$(el).find('.refresh-tab').click();\n\t\t      }\n              else if(action=='close'){\n\t\t          \$(el).find('.close-tab').click();\n\t\t      }\n              else if(action=='closeothers'){\n\t\t          \$('#tabs-group li:not(:first)').not(el).each(function(){\t\t\t              \n\t\t              \$(this).find('.close-tab').click(); \n\t\t          });\n\t\t      }\n              else if(action=='closeall'){\n\t\t          \$('#tabs-group li:not(:first)').each(function(){\t\t\t              \n\t\t              \$(this).find('.close-tab').click(); \n\t\t          });\n\t\t      }              \n\t\t}); \n        \n        \$(obj).click(function(){\n            \$(obj).parent().find('li').removeClass('active');\n            \$(this).addClass('active');            \n            \$('.tab-pane.active').removeClass('active');\n            \$('#'+\$(this).find('a').attr('class')).addClass('active'); \n        });\n        \n    }       \n</script>\n-->\n\n<script>\n    function setRightClick(obj){        \n        \$(obj).click(function(){           \n            \$(obj).parent().find('li').removeClass('active');\n            \$(this).addClass('active');                      \n            \$(this).parents('#tabs-group').next().find('.tab-pane.active').removeClass('active');            \n            \$(this).parents('#tabs-group').next().find('#'+\$('a',this).attr('href').replace('#','')).addClass('active');            \n        });\n    }     \n</script>\n\n";
if (!$isgetcont) {
    echo "</body>\n</html>\n";
}

?>