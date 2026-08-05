<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
$time_zone = mysqli_fetch_assoc(dquery("SELECT * from `tbl_timezone_1` WHERE `Time_zone_id`='" . $config["time_zone"] . "'"));
date_default_timezone_set($time_zone["Name"]);
unset($time_zone);
echo "<!DOCTYPE HTML>\n<head>\n\t<meta http-equiv=\"content-type\" content=\"text/html\" />\n\t<title>" . $config["companyname"] . "</title>\n    <style>body{font-family: Arial;}</style>\n    <script type=\"text/javascript\" src=\"includes/js/jquery.js\"></script>\n    <script type=\"text/javascript\" src=\"includes/js/countdown.js\"></script>\n</head>\n<body>";
echo "<script type=\"text/javascript\">\n\$(document).ready(function() {\n\t\$(\"#time\").countdown({\n\t\tdate: \"";
echo date("M d, Y H:i", $config["maintenancebacktime"]);
echo "\",  \n        htmlTemplate: \"<div class=counter> <p class=specialp><small>If all goes as planned, we hope to be back in: </small></p> <p><span>%{d}  </span><br/> <small>Days</small></p> <p><span>%{h} </span><br/> <small>Hours</small></p> <p> <span>%{m} </span><br/> <small>Minutes</small> </p>  <p><span>%{s} </span><br/> <small>Seconds</small></p><div style='clear: both';></div></div>\",\n\t\tonChange: function( event, timer ){\n\t\t},\n\t\tonComplete: function( event ){\n\t\t\t\$(this).html(\"\");\n\t\t},\n\t\tleadingZero: true,\n\t\tdirection: \"down\"\n\t});\n});\n</script>\n<style>\n    .outer{width:780px;background: #f4f4f4;padding:40px;margin: auto;-moz-border-radius-topleft: 7px;-moz-border-radius-topright: 7px;-moz-border-radius-bottomright: 0px;-moz-border-radius-bottomleft: 0px;-webkit-border-radius: 7px 7px 0px 0px;border-radius: 7px 7px 0px 0px; }\n    .innertext{font-size: 12px;color:#333333;  background: white;padding: 30px;  -webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;-webkit-box-shadow: 0px 2px 2px 1px #e3e2e2;-moz-box-shadow: 0px 2px 2px 1px #e3e2e2;box-shadow: 0px 2px 2px 1px #e3e2e2;}    \n    .counter{text-align: center;width:780px;background: #f4f4f4 url('images/outer_bg.png') repeat-x top;margin: auto;padding:30px 40px;-moz-border-radius-topleft: 0px;-moz-border-radius-topright: 0px;-moz-border-radius-bottomright: 7px;-moz-border-radius-bottomleft: 7px;-webkit-border-radius: 0px 0px 7px 7px;border-radius: 0px 0px 7px 7px; }    \n     .time .counter p{display: block;float: left;text-align: center;margin:0 10px;background: url('images/counter_bg.png') repeat-x top;width: 90px;padding: 10px 0; -webkit-border-radius: 6px;-moz-border-radius: 6px;border-radius: 6px;}\n    .time .counter span{font-weight: bold;color:white;text-shadow:0 1px 1px #666;}\n    .time .counter small{margin-top: 5px;display:block;color:white;text-shadow:0 1px 1px #666;}\n    .specialp{background:url('images/counter_text_bg.png') repeat-x top !important;width: 270px !important;padding: 20px 20px !important;}\n    \n    input,textarea{font-family:arial;padding:10px;border:#ddd solid 1px;border-radius:2px;}\n    textarea{width:90%;height:100px}\n    fieldset{border:none;font-size:15px;padding:0;}\n    .control-group{padding:10px 0;text-align: left;}\n    .control-label{display: inline-block; width:200px;}\n    .controls{}\n    .btn{cursor: pointer;}\n\n</style>\n<div class=\"outer\">\n";
$sql = mysqli_fetch_assoc(dquery("select value from tbl_settings where attribute='maintanance'"));
echo "<div class=\"innertext\"> <span style=\"font-size: 32px;color:#deb200\" > " . $config["companyname"] . " </span> ";
echo "<div >";
$vals = nl2br(html_entity_decode($sql["value"]));
if ($config["maintanacecontact"]) {
    $contact = "<form class=\"form-horizontal\"  method=\"post\" name=\"contact\" id=\"contact\">\n      <fieldset>\n          <div class=\"control-group\"> <input type=\"text\" Placeholder=\"Email\" name=\"email\" placeholder=\"Email\" /> <div class=\"controls\">\n          </div></div>\n          <div class=\"control-group\"> \n          \n        <textarea name=\"inquiry\" placeholder=\"Inquiry\"></textarea>  </div>\n        \n        <div class=\"control-group\"> <img src=\"widget/verificationimage.php\" alt=\"verification image, type it in the box\" align=\"absbottom\" />  \n              <div class=\"controls\">\n                    <input type=\"text\" placeholder=\"Captcha Code\" name=\"captcha\"> \n              </div>\n        </div>\n           \t<div class=\"control-group\"> \n              <div class=\"controls\">\n                    <input type=\"submit\"  class=\"btn btn-success\" id=\"send\"  name=\"send\" value=\"Submit\" /> \n              </div>\n        </div>\n         \n      </fieldset>\n    </form>";
    $vals .= $contact;
}
echo $vals;
echo "\n    </div></div></div>\n    <div id=\"time\" class=\"time\"></div>    \n\n</div>\n</body>\n</html>";

?>