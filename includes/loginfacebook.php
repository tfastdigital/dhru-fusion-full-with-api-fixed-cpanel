<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
require "includes/openid/facebook.php";
$facebook = new Facebook(["appId" => "143499322366154", "secret" => "df0bd8e94a33bf1cd26766b59954cdb0", "cookie" => true]);
$session = $facebook->getSession();
$me = NULL;
if ($session) {
    try {
        $uid = $facebook->getUser();
        $me = $facebook->api("/me");
    } catch (FacebookApiException $e) {
        error_log($e);
    }
}
if ($me) {
    $logoutUrl = $facebook->getLogoutUrl();
} else {
    $loginUrl = $facebook->getLoginUrl();
}
$naitik = $facebook->api("/naitik");
echo "<!doctype html>\n<html xmlns:fb=\"http://www.facebook.com/2008/fbml\">\n  <head>\n    <title>php-sdk</title>\n    <style>\n      body {\n        font-family: 'Lucida Grande', Verdana, Arial, sans-serif;\n      }\n      h1 a {\n        text-decoration: none;\n        color: #3b5998;\n      }\n      h1 a:hover {\n        text-decoration: underline;\n      }\n    </style>\n  </head>\n  <body>\n    <!--\n      We use the JS SDK to provide a richer user experience. For more info,\n      look here: http://github.com/facebook/connect-js\n    -->\n    <div id=\"fb-root\"></div>\n    <script>\n      window.fbAsyncInit = function() {\n        FB.init({\n          appId   : '";
echo $facebook->getAppId();
echo "',\n          session : ";
echo json_encode($session);
echo ", // don't refetch the session when PHP already has it\n          status  : true, // check login status\n          cookie  : true, // enable cookies to allow the server to access the session\n          xfbml   : true // parse XFBML\n        });\n\n        // whenever the user logs in, we refresh the page\n        FB.Event.subscribe('auth.login', function() {\n          window.location.reload();\n        });\n      };\n\n      (function() {\n        var e = document.createElement('script');\n        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';\n        e.async = true;\n        document.getElementById('fb-root').appendChild(e);\n      }());\n    </script>\n\n\n    <h1><a href=\"example.php\">php-sdk</a></h1>\n\n    ";
if ($me) {
    echo "    <a href=\"";
    echo $logoutUrl;
    echo "\">\n      <img src=\"http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif\">\n    </a>\n    ";
} else {
    echo "    <div>\n      Using JavaScript &amp; XFBML: <fb:login-button></fb:login-button>\n    </div>\n    <div>\n      Without using JavaScript &amp; XFBML:\n      <a href=\"";
    echo $loginUrl;
    echo "\">\n        <img src=\"http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif\">\n      </a>\n    </div>\n    ";
}
echo "\n    <h3>Session</h3>\n    ";
if ($me) {
    echo "    <pre>";
    print_r($session);
    echo "</pre>\n\n    <h3>You</h3>\n    <img src=\"https://graph.facebook.com/";
    echo $uid;
    echo "/picture\">\n    ";
    echo $me["name"];
    echo "\n    <h3>Your User Object</h3>\n    <pre>";
    print_r($me);
    echo "</pre>\n    ";
} else {
    echo "    <strong><em>You are not Connected.</em></strong>\n    ";
}
echo "\n    <h3>Naitik</h3>\n    <img src=\"https://graph.facebook.com/naitik/picture\">\n    ";
echo $naitik["name"];
echo "  </body>\n</html>";

?>