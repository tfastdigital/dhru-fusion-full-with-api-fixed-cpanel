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
$pageid = 538;
checkPagePermission($pageid);
$ProductToken = $licinfo["product_token"];
$post = [];
$data = initCurl("https://api.dhru.com/integration/api/v1/store?token=" . $ProductToken . "&type=banner", $post);
$banner = json_decode($data, true);
echo "\n\n    <style>\n        .banner-box {\n            border: 1px solid #f1f1f1;\n            box-sizing: border-box;\n            float: left;\n            margin: 0 25px 25px 0;\n            position: relative;\n            box-shadow: 0 0 10px rgba(0,0,0,0.1);\n            border-radius: 5px;\n            overflow: hidden;\n        }\n        .banner-box .download-links{\n            transition: 0.2s;\n            bottom: -150px;\n            padding: 10px;\n            position: absolute;left:0;right:0;background:rgba(255,255,255,1);\n        }\n        .banner-box:not(.inprocess):hover .download-links{\n            transition: 0.2s;\n            bottom: 0;\n\n        }\n        .download-links .link{\n            color:#555;\n            padding: 7px;margin-right: :10px;cursor: pointer\n        }\n        .download-links .link:hover{\n            color:black;\n        }\n        .banner-box.Other-Template{}\n        .dbanner{background-repeat: no-repeat;background-size: cover;max-width:300px;}\n        .tag-free {\n            bottom: 13px;\n            color: #008000;\n            font-size: 15px;\n            position: absolute;\n            right: 11px;\n            text-transform: uppercase;\n        }\n        .tag-install{background: black;color:white;padding:8px 10px;display:block}\n        .downloadb{background: black;color:white;padding:2px 10px;bottom:10px;left:10px;margin-top:5px;position: absolute;}\n        .temp-tab {\n            text-align: left;\n        }\n        .temp-tab li{display:inline-block;cursor: pointer;padding:5px;margin-right:10px;}\n        .temp-tab li.active {\n            background: #ffffff none repeat scroll 0 0;\n            color: #d66061;\n            margin-bottom: -1px;\n            padding: 10px 15px;\n        }\n    </style>\n\n<script>\n\n\n\n    function submitAction(buttonId,params,action,key){\n        let temp = \$(buttonId).html();\n        \$(buttonId).html('<i class=\"fa fa-spinner fa-spin\"></i>').attr(\"disabled\", true);\n        \$('#notification').removeClass('successbox');\n        \$('#notification').removeClass('errorbox');\n\n        \$('#bannerbox'+key).addClass('inprocess');\n\n\n        \$.post('api/v1/store/?action='+action+'&'+params,function (data, textStatus) {\n            \$('#notification').addClass(data.status === 'success'?'successbox':'errorbox');\n            \$('#notification').html(data.msg).show();\n            \$(buttonId).html(temp).attr(\"disabled\", false);\n\n            \$('#bannerbox'+key+'.banner-box.inprocess').removeClass('inprocess');\n\n            if(action === 'Purchase'){\n                let downloadlinks = data.data.download_links;\n\n                let linkshtml = '';\n                Object.keys(downloadlinks).map((keys)=>{\n                    linkshtml +=  `<div   class=\"link\"  onclick=\"submitAction('#btnaddgroup\${key}','banner_link=\${btoa(downloadlinks[keys])}','Install','\${key}');\">\${keys} <i class=\"fa fa-download\"></i></div>`\n                })\n\n\n                let html = `<button type=\"button\" class=\"btn btn-secondary\" id=\"btnaddgroup\${key}\"><i class=\"fa fa-download\"></i></button><div   class=\"download-links\">\${linkshtml}</div>`;\n                \$('#actions'+key).html(html)\n            }\n\n\n        });\n    }\n\n</script>\n\n    <div id=\"content\">\n        <div id=\"notification\" class=\"successbox\"></div>\n        <div  class=\"groupstabes\">\n            <div class=\"clear\"></div>\n\n            <div class=\"groupstabescontant\" style=\"text-align: center;\">\n\n                ";
foreach ($banner["data"] as $key => $ban) {
    echo "                <div class=\"banner-box\" id=\"bannerbox";
    echo $key;
    echo "\">\n\n                    <form method=\"post\" id=\"frms";
    echo $key;
    echo "\"  style=\"position: relative\">\n\n\n                        <img src=\"";
    echo $ban["thumb"];
    echo "\" style=\"border-top-left-radius: 5px;border-top-right-radius: 5px\" />\n\n                        <div style=\"display: flex;justify-content: space-between;align-items: center;padding: 10px\">\n\n                            <div id=\"actions";
    echo $key;
    echo "\">\n\n\n\n                                ";
    if ($ban["download_links"]) {
        echo "                                        <button type=\"button\" class=\"btn btn-secondary\" id=\"btnaddgroup";
        echo $key;
        echo "\">\n                                            <i class=\"fa fa-download\"></i>\n                                        </button>\n\n                                        <div   class=\"download-links\">\n                                            ";
        foreach ($ban["download_links"] as $key2 => $link) {
            echo "                                                <div   class=\"link\"  onclick=\"submitAction('#btnaddgroup";
            echo $key;
            echo "','banner_link=";
            echo base64_encode($link);
            echo "','Install','";
            echo $key;
            echo "');\">";
            echo $key2;
            echo " <i class=\"fa fa-download\"></i></div>\n                                                ";
        }
        echo "                                        </div>\n                                        ";
    } else {
        echo "                                        <button  id=\"btnaddgroup";
        echo $key;
        echo "\"  class=\"btn btn-secondary\" type=\"button\"  onclick=\"submitAction('#btnaddgroup";
        echo $key;
        echo "','store_item_id=";
        echo $ban["store_item_id"];
        echo "','Purchase','";
        echo $key;
        echo "');\">\n                                            Buy\n                                        </button>\n                                        ";
    }
    echo "                            </div>\n\n                            <div>\n\n                                ";
    $storeid = $ban["store_item_id"];
    $seller = $ban["seller_profile"];
    echo "                                <div>Credit : ";
    echo $ban["credit"];
    echo " ";
    echo $ban["id"];
    echo "</div>\n                                <div class=\"text-muted\"><small>";
    echo $seller["seller_name"];
    echo "</small> </div>\n\n                            </div>\n\n                        </div>\n\n                    </form>\n\n\n                </div>\n                    ";
}
echo "            </div>\n\n        </div>\n    </div>\n\n\n    <script type='text/javascript' src=\"templates/";
echo $_SESSION["admin_template"];
echo "/js/lazyload.js\" type=\"text/javascript\"></script>\n\n    <script>\n        new LazyLoad();\n    </script>\n\n    <script>\n        \$(document).ready(function(){\n            \$('.select-temp').click(function(){\n                \$('.select-temp.active').removeClass('active');\n                \$(this).addClass('active');\n                \$('.banner-box').hide();\n                \$('.'+\$(this).attr('id')).show();\n            });\n            \$('.select-temp:first-child').click();\n        });\n    </script>\n\n";
$fileverioncheck = "6.1.0";

?>