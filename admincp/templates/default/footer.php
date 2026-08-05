<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

echo "<script type=\"text/javascript\">\n\n    function setRightClick(obj){ \n        \n        \$(obj).mousedown(function(e){ \n            if( e.button == 2 ) {                \n                if(\$(this).text().trim()=='Dashboard'){\n                    \$('#rightClickMenu').disableContextMenuItems('#closeall,#close');\n                }\n                else{\n                    \$('#rightClickMenu').enableContextMenuItems('#closeall,#close');\n                }                 \n             }              \n          });\n        \n        \$(obj).contextMenu({\t\t\t\t    \n\t\t\tmenu: 'rightClickMenu'\n\t\t}, function(action, el, pos) {\t\t      \n\t\t      if(action=='refresh'){\n\t\t          \$(el).find('.refresh-tab').click();\n\t\t      }\n              else if(action=='close'){\n\t\t          \$(el).find('.close-tab').click();\n\t\t      }\n              else if(action=='closeothers'){\n\t\t          \$('#tabs-group li:not(:first)').not(el).each(function(){\t\t\t              \n\t\t              \$(this).find('.close-tab').click(); \n\t\t          });\n\t\t      }\n              else if(action=='closeall'){\n\t\t          \$('#tabs-group li:not(:first)').each(function(){\t\t\t              \n\t\t              \$(this).find('.close-tab').click(); \n\t\t          });\n\t\t      }              \n\t\t}); \n        \n        \$(obj).click(function(){\n            \$(obj).parent().find('li').removeClass('active');\n            \$(this).addClass('active');            \n            \$('.tab-pane.active').removeClass('active');\n            \$('#'+\$(this).find('a').attr('class')).addClass('active'); \n        });       \n        \n    }\n</script>\n\n</div>\n</div>\n</div> \n</body>\n\n</html>";

?>