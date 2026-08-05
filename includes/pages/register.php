<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

namespace ns;

define("DEFINE_MY_ACCESS", true);
define("DEFINE_DHRU_FILE", true);
define("CLIENT", true);
define("SSLON", true);
require "comm.php";
require "includes/fun.inc.php";
require "includes/client.area.inc.php";
$currentpage = "register";
$_nav = "<a href=\"" . _url("index") . "\">" . $lng_languag["home"] . "</a> / ";
$pagetitle = $lng_languag["registration"];
$_nav .= "<a href='" . _url("register") . "' >" . $lng_languag["registration"] . "</a> / ";
$templatefile = "client_registration";
$fileverioncheck = "6.1.0";
$pageicon = "";
$parentid = 1015;
unset($_SESSION["finalphone"]);
installclient($pagetitle, $pageicon, $breadcrumbnav);
if ($error == "notmode") {
    $tempalte_ver["class"] = "errorbox";
    $tempalte_ver["msg"] = $lng_languag["modenotallowd"];
    $tempalte_ver["notification"] = true;
}
if ($config["registration_type"] == 3) {
    $tempalte_ver["class"] = "errorbox";
    $tempalte_ver["msg"] = $lng_languag["newusernotallowed"];
    $tempalte_ver["notification"]["error"] = $lng_languag["newusernotallowed"];
    DisplayOutput("notallow");
    exit;
}
if ($config["googleclientid"]) {
    $_SESSION["gtoken"] = rand(20290, 22909005);
    $tempalte_ver["gauthtoken"] = md5($_SESSION["gtoken"]);
    $tempalte_ver["googleclientid"] = $config["googleclientid"];
}
if (isset($activation)) {
    $reg = descape(base64_decode($activation));
    $reg = preg_replace("/[^0-9\\-a-zA-Z]/i", "", $reg);
    $sql = mysqli_num_rows(dquery("SELECT `id` FROM `tblUsers` WHERE `random_key`='" . $reg . "' AND `userstatus`='2'"));
    if ($sql) {
        dquery("UPDATE `tblUsers` SET `userstatus`= 0 WHERE `random_key`= '" . $reg . "'");
        $uid = mysqli_fetch_assoc(dquery("SELECT `id`,`username`,master_pin as pin FROM tblUsers WHERE \n        `random_key`= '" . $reg . "'"));
        $uid["pin"] = dec($uid["pin"], "9486");
        $tempalte_ver["class"] = "successbox";
        $tempalte_ver["msg"] = $lng_languag["actsuc"];
        //include ROOTDIR . "/includes/mail.fun.php";
        $email_merge_fields["username"] = $uid["username"];
        $email_merge_fields["pin"] = $uid["pin"];
        //sendMail(9, $uid["id"], "", $email_merge_fields, true);
        $tempalte_ver["class"] = "successbox";
        $tempalte_ver["msg"] = $lng_languag["actsuc"];
    } else {
        $tempalte_ver["class"] = "errorbox";
        $tempalte_ver["msg"] = $lng_languag["wrongkey"];
    }
    $tempalte_ver["notification"] = true;
    $tempalte_ver["currency"] = "";
} else {
    $tempalte_ver["username"] = "<input type='text' autocomplete='off'  class='form-control' name='username' required='1'\n                         placeholder='" . $lng_languag["username"] . "' onblur='checkUsername(this.value,\"notification\",\"true\",\"loader\")'; value='' />";
    $tempalte_ver["password"] = "<input  autocomplete='off' class='form-control'onkeyup='checkStrength(this.value,\"passstrength\");'  required='1'\n                        placeholder='" . $lng_languag["password"] . "'  required='1' type='password' name='password' value='' />" . generate_token("form");
    $tempalte_ver["confirmation"] = "<input class='form-control' autocomplete='off' type='password'  required='1'\n                        placeholder='" . $lng_languag["confirmpass"] . "' name='confirmation' value='' />";
    $tempalte_ver["question"] = getSecurityQuestion("", "question");
    $tempalte_ver["answer"] = "<input type='text' class='form-control'  required='1' name='answer'  placeholder='" . $lng_languag["youranswer"] . "'  >";
    $tempalte_ver["email"] = "<input type='text' autocomplete='off' class='form-control'  required='1' name='email'  placeholder='" . $lng_languag["email"] . "' value='' size='20' />";
    include_once ROOTDIR . "/includes/geo.fun.php";
    //$gi = geoip_open(ROOTDIR . "/includes/geodata/GeoIP.dat", GEOIP_STANDARD);
    $login_country_code = ipToCountry($remote_ip);
    $ARR = $gi->PHONECODE_BY_COUNTRY[$login_country_code];
    $phonecode = $ARR["code"];
    $CountryCodePhone = "\n<select name=\"phonenumber1\" id=\"phonenumber1\" class=\"form-control phoness phonedrop no-chosen after-load-chosen\">\n\t<option data-countryCode=\"GB\"  value=\"44\" >UK (+44)</option>\n\t<option data-countryCode=\"US\" value=\"1\">USA (+1)</option>\n\t\t<option data-countryCode=\"DZ\" value=\"213\">Algeria (+213)</option>\n\t\t<option data-countryCode=\"AD\" value=\"376\">Andorra (+376)</option>\n\t\t<option data-countryCode=\"AO\" value=\"244\">Angola (+244)</option>\n\t\t<option data-countryCode=\"AI\" value=\"1264\">Anguilla (+1264)</option>\n\t\t<option data-countryCode=\"AG\" value=\"1268\">Antigua &amp; Barbuda (+1268)</option>\n\t\t<option data-countryCode=\"AR\" value=\"54\">Argentina (+54)</option>\n\t\t<option data-countryCode=\"AM\" value=\"374\">Armenia (+374)</option>\n\t\t<option data-countryCode=\"AW\" value=\"297\">Aruba (+297)</option>\n\t\t<option data-countryCode=\"AU\" value=\"61\">Australia (+61)</option>\n\t\t<option data-countryCode=\"AT\" value=\"43\">Austria (+43)</option>\n\t\t<option data-countryCode=\"AZ\" value=\"994\">Azerbaijan (+994)</option>\n\t\t<option data-countryCode=\"BS\" value=\"1242\">Bahamas (+1242)</option>\n\t\t<option data-countryCode=\"BH\" value=\"973\">Bahrain (+973)</option>\n\t\t<option data-countryCode=\"BD\" value=\"880\">Bangladesh (+880)</option>\n\t\t<option data-countryCode=\"BB\" value=\"1246\">Barbados (+1246)</option>\n\t\t<option data-countryCode=\"BY\" value=\"375\">Belarus (+375)</option>\n\t\t<option data-countryCode=\"BE\" value=\"32\">Belgium (+32)</option>\n\t\t<option data-countryCode=\"BZ\" value=\"501\">Belize (+501)</option>\n\t\t<option data-countryCode=\"BJ\" value=\"229\">Benin (+229)</option>\n\t\t<option data-countryCode=\"BM\" value=\"1441\">Bermuda (+1441)</option>\n\t\t<option data-countryCode=\"BT\" value=\"975\">Bhutan (+975)</option>\n\t\t<option data-countryCode=\"BO\" value=\"591\">Bolivia (+591)</option>\n\t\t<option data-countryCode=\"BA\" value=\"387\">Bosnia Herzegovina (+387)</option>\n\t\t<option data-countryCode=\"BW\" value=\"267\">Botswana (+267)</option>\n\t\t<option data-countryCode=\"BR\" value=\"55\">Brazil (+55)</option>\n\t\t<option data-countryCode=\"BN\" value=\"673\">Brunei (+673)</option>\n\t\t<option data-countryCode=\"BG\" value=\"359\">Bulgaria (+359)</option>\n\t\t<option data-countryCode=\"BF\" value=\"226\">Burkina Faso (+226)</option>\n\t\t<option data-countryCode=\"BI\" value=\"257\">Burundi (+257)</option>\n\t\t<option data-countryCode=\"KH\" value=\"855\">Cambodia (+855)</option>\n\t\t<option data-countryCode=\"CM\" value=\"237\">Cameroon (+237)</option>\n\t\t<option data-countryCode=\"CA\" value=\"1\">Canada (+1)</option>\n\t\t<option data-countryCode=\"CV\" value=\"238\">Cape Verde Islands (+238)</option>\n\t\t<option data-countryCode=\"KY\" value=\"1345\">Cayman Islands (+1345)</option>\n\t\t<option data-countryCode=\"CF\" value=\"236\">Central African Republic (+236)</option>\n\t\t<option data-countryCode=\"CL\" value=\"56\">Chile (+56)</option>\n\t\t<option data-countryCode=\"CN\" value=\"86\">China (+86)</option>\n\t\t<option data-countryCode=\"CO\" value=\"57\">Colombia (+57)</option>\n\t\t<option data-countryCode=\"KM\" value=\"269\">Comoros (+269)</option>\n\t\t<option data-countryCode=\"CG\" value=\"242\">Congo (+242)</option>\n\t\t<option data-countryCode=\"CK\" value=\"682\">Cook Islands (+682)</option>\n\t\t<option data-countryCode=\"CR\" value=\"506\">Costa Rica (+506)</option>\n\t\t<option data-countryCode=\"HR\" value=\"385\">Croatia (+385)</option>\n\t\t<option data-countryCode=\"CU\" value=\"53\">Cuba (+53)</option>\n\t\t<option data-countryCode=\"CY\" value=\"90392\">Cyprus North (+90392)</option>\n\t\t<option data-countryCode=\"CY\" value=\"357\">Cyprus South (+357)</option>\n\t\t<option data-countryCode=\"CZ\" value=\"42\">Czech Republic (+42)</option>\n\t\t<option data-countryCode=\"DK\" value=\"45\">Denmark (+45)</option>\n\t\t<option data-countryCode=\"DJ\" value=\"253\">Djibouti (+253)</option>\n\t\t<option data-countryCode=\"DM\" value=\"1809\">Dominica (+1809)</option>\n\t\t<option data-countryCode=\"DO\" value=\"1809\">Dominican Republic (+1809)</option>\n\t\t<option data-countryCode=\"EC\" value=\"593\">Ecuador (+593)</option>\n\t\t<option data-countryCode=\"EG\" value=\"20\">Egypt (+20)</option>\n\t\t<option data-countryCode=\"SV\" value=\"503\">El Salvador (+503)</option>\n\t\t<option data-countryCode=\"GQ\" value=\"240\">Equatorial Guinea (+240)</option>\n\t\t<option data-countryCode=\"ER\" value=\"291\">Eritrea (+291)</option>\n\t\t<option data-countryCode=\"EE\" value=\"372\">Estonia (+372)</option>\n\t\t<option data-countryCode=\"ET\" value=\"251\">Ethiopia (+251)</option>\n\t\t<option data-countryCode=\"FK\" value=\"500\">Falkland Islands (+500)</option>\n\t\t<option data-countryCode=\"FO\" value=\"298\">Faroe Islands (+298)</option>\n\t\t<option data-countryCode=\"FJ\" value=\"679\">Fiji (+679)</option>\n\t\t<option data-countryCode=\"FI\" value=\"358\">Finland (+358)</option>\n\t\t<option data-countryCode=\"FR\" value=\"33\">France (+33)</option>\n\t\t<option data-countryCode=\"GF\" value=\"594\">French Guiana (+594)</option>\n\t\t<option data-countryCode=\"PF\" value=\"689\">French Polynesia (+689)</option>\n\t\t<option data-countryCode=\"GA\" value=\"241\">Gabon (+241)</option>\n\t\t<option data-countryCode=\"GM\" value=\"220\">Gambia (+220)</option>\n\t\t<option data-countryCode=\"GE\" value=\"7880\">Georgia (+7880)</option>\n\t\t<option data-countryCode=\"DE\" value=\"49\">Germany (+49)</option>\n\t\t<option data-countryCode=\"GH\" value=\"233\">Ghana (+233)</option>\n\t\t<option data-countryCode=\"GI\" value=\"350\">Gibraltar (+350)</option>\n\t\t<option data-countryCode=\"GR\" value=\"30\">Greece (+30)</option>\n\t\t<option data-countryCode=\"GL\" value=\"299\">Greenland (+299)</option>\n\t\t<option data-countryCode=\"GD\" value=\"1473\">Grenada (+1473)</option>\n\t\t<option data-countryCode=\"GP\" value=\"590\">Guadeloupe (+590)</option>\n\t\t<option data-countryCode=\"GU\" value=\"671\">Guam (+671)</option>\n\t\t<option data-countryCode=\"GT\" value=\"502\">Guatemala (+502)</option>\n\t\t<option data-countryCode=\"GN\" value=\"224\">Guinea (+224)</option>\n\t\t<option data-countryCode=\"GW\" value=\"245\">Guinea - Bissau (+245)</option>\n\t\t<option data-countryCode=\"GY\" value=\"592\">Guyana (+592)</option>\n\t\t<option data-countryCode=\"HT\" value=\"509\">Haiti (+509)</option>\n\t\t<option data-countryCode=\"HN\" value=\"504\">Honduras (+504)</option>\n\t\t<option data-countryCode=\"HK\" value=\"852\">Hong Kong (+852)</option>\n\t\t<option data-countryCode=\"HU\" value=\"36\">Hungary (+36)</option>\n\t\t<option data-countryCode=\"IS\" value=\"354\">Iceland (+354)</option>\n\t\t<option data-countryCode=\"IN\" value=\"91\">India (+91)</option>\n\t\t<option data-countryCode=\"ID\" value=\"62\">Indonesia (+62)</option>\n\t\t<option data-countryCode=\"IR\" value=\"98\">Iran (+98)</option>\n\t\t<option data-countryCode=\"IQ\" value=\"964\">Iraq (+964)</option>\n\t\t<option data-countryCode=\"IE\" value=\"353\">Ireland (+353)</option>\n\t\t<option data-countryCode=\"IL\" value=\"972\">Israel (+972)</option>\n\t\t<option data-countryCode=\"IT\" value=\"39\">Italy (+39)</option>\n\t\t<option data-countryCode=\"JM\" value=\"1876\">Jamaica (+1876)</option>\n\t\t<option data-countryCode=\"JP\" value=\"81\">Japan (+81)</option>\n\t\t<option data-countryCode=\"JO\" value=\"962\">Jordan (+962)</option>\n\t\t<option data-countryCode=\"KZ\" value=\"7\">Kazakhstan (+7)</option>\n\t\t<option data-countryCode=\"KE\" value=\"254\">Kenya (+254)</option>\n\t\t<option data-countryCode=\"KI\" value=\"686\">Kiribati (+686)</option>\n\t\t<option data-countryCode=\"KP\" value=\"850\">Korea North (+850)</option>\n\t\t<option data-countryCode=\"KR\" value=\"82\">Korea South (+82)</option>\n\t\t<option data-countryCode=\"KW\" value=\"965\">Kuwait (+965)</option>\n\t\t<option data-countryCode=\"KG\" value=\"996\">Kyrgyzstan (+996)</option>\n\t\t<option data-countryCode=\"LA\" value=\"856\">Laos (+856)</option>\n\t\t<option data-countryCode=\"LV\" value=\"371\">Latvia (+371)</option>\n\t\t<option data-countryCode=\"LB\" value=\"961\">Lebanon (+961)</option>\n\t\t<option data-countryCode=\"LS\" value=\"266\">Lesotho (+266)</option>\n\t\t<option data-countryCode=\"LR\" value=\"231\">Liberia (+231)</option>\n\t\t<option data-countryCode=\"LY\" value=\"218\">Libya (+218)</option>\n\t\t<option data-countryCode=\"LI\" value=\"417\">Liechtenstein (+417)</option>\n\t\t<option data-countryCode=\"LT\" value=\"370\">Lithuania (+370)</option>\n\t\t<option data-countryCode=\"LU\" value=\"352\">Luxembourg (+352)</option>\n\t\t<option data-countryCode=\"MO\" value=\"853\">Macao (+853)</option>\n\t\t<option data-countryCode=\"MK\" value=\"389\">Macedonia (+389)</option>\n\t\t<option data-countryCode=\"MG\" value=\"261\">Madagascar (+261)</option>\n\t\t<option data-countryCode=\"MW\" value=\"265\">Malawi (+265)</option>\n\t\t<option data-countryCode=\"MY\" value=\"60\">Malaysia (+60)</option>\n\t\t<option data-countryCode=\"MV\" value=\"960\">Maldives (+960)</option>\n\t\t<option data-countryCode=\"ML\" value=\"223\">Mali (+223)</option>\n\t\t<option data-countryCode=\"MT\" value=\"356\">Malta (+356)</option>\n\t\t<option data-countryCode=\"MH\" value=\"692\">Marshall Islands (+692)</option>\n\t\t<option data-countryCode=\"MQ\" value=\"596\">Martinique (+596)</option>\n\t\t<option data-countryCode=\"MR\" value=\"222\">Mauritania (+222)</option>\n\t\t<option data-countryCode=\"YT\" value=\"269\">Mayotte (+269)</option>\n\t\t<option data-countryCode=\"MX\" value=\"52\">Mexico (+52)</option>\n\t\t<option data-countryCode=\"FM\" value=\"691\">Micronesia (+691)</option>\n\t\t<option data-countryCode=\"MD\" value=\"373\">Moldova (+373)</option>\n\t\t<option data-countryCode=\"MC\" value=\"377\">Monaco (+377)</option>\n\t\t<option data-countryCode=\"MN\" value=\"976\">Mongolia (+976)</option>\n\t\t<option data-countryCode=\"MS\" value=\"1664\">Montserrat (+1664)</option>\n\t\t<option data-countryCode=\"MA\" value=\"212\">Morocco (+212)</option>\n\t\t<option data-countryCode=\"MZ\" value=\"258\">Mozambique (+258)</option>\n\t\t<option data-countryCode=\"MN\" value=\"95\">Myanmar (+95)</option>\n\t\t<option data-countryCode=\"NA\" value=\"264\">Namibia (+264)</option>\n\t\t<option data-countryCode=\"NR\" value=\"674\">Nauru (+674)</option>\n\t\t<option data-countryCode=\"NP\" value=\"977\">Nepal (+977)</option>\n\t\t<option data-countryCode=\"NL\" value=\"31\">Netherlands (+31)</option>\n\t\t<option data-countryCode=\"NC\" value=\"687\">New Caledonia (+687)</option>\n\t\t<option data-countryCode=\"NZ\" value=\"64\">New Zealand (+64)</option>\n\t\t<option data-countryCode=\"NI\" value=\"505\">Nicaragua (+505)</option>\n\t\t<option data-countryCode=\"NE\" value=\"227\">Niger (+227)</option>\n\t\t<option data-countryCode=\"NG\" value=\"234\">Nigeria (+234)</option>\n\t\t<option data-countryCode=\"NU\" value=\"683\">Niue (+683)</option>\n\t\t<option data-countryCode=\"NF\" value=\"672\">Norfolk Islands (+672)</option>\n\t\t<option data-countryCode=\"NP\" value=\"670\">Northern Marianas (+670)</option>\n\t\t<option data-countryCode=\"NO\" value=\"47\">Norway (+47)</option>\n\t\t<option data-countryCode=\"OM\" value=\"968\">Oman (+968)</option>\n\t\t<option data-countryCode=\"PW\" value=\"680\">Palau (+680)</option>\n\t\t<option data-countryCode=\"PA\" value=\"507\">Panama (+507)</option>\n\t\t<option data-countryCode=\"PG\" value=\"675\">Papua New Guinea (+675)</option>\n\t\t<option data-countryCode=\"PY\" value=\"595\">Paraguay (+595)</option>\n\t\t<option data-countryCode=\"PE\" value=\"51\">Peru (+51)</option>\n\t\t<option data-countryCode=\"PH\" value=\"63\">Philippines (+63)</option>\n\t\t<option data-countryCode=\"PL\" value=\"48\">Poland (+48)</option>\n\t\t<option data-countryCode=\"PT\" value=\"351\">Portugal (+351)</option>\n\t\t<option data-countryCode=\"PR\" value=\"1787\">Puerto Rico (+1787)</option>\n\t\t<option data-countryCode=\"QA\" value=\"974\">Qatar (+974)</option>\n\t\t<option data-countryCode=\"RE\" value=\"262\">Reunion (+262)</option>\n\t\t<option data-countryCode=\"RO\" value=\"40\">Romania (+40)</option>\n\t\t<option data-countryCode=\"RU\" value=\"7\">Russia (+7)</option>\n\t\t<option data-countryCode=\"RW\" value=\"250\">Rwanda (+250)</option>\n\t\t<option data-countryCode=\"SM\" value=\"378\">San Marino (+378)</option>\n\t\t<option data-countryCode=\"ST\" value=\"239\">Sao Tome &amp; Principe (+239)</option>\n\t\t<option data-countryCode=\"SA\" value=\"966\">Saudi Arabia (+966)</option>\n\t\t<option data-countryCode=\"SN\" value=\"221\">Senegal (+221)</option>\n\t\t<option data-countryCode=\"CS\" value=\"381\">Serbia (+381)</option>\n\t\t<option data-countryCode=\"SC\" value=\"248\">Seychelles (+248)</option>\n\t\t<option data-countryCode=\"SL\" value=\"232\">Sierra Leone (+232)</option>\n\t\t<option data-countryCode=\"SG\" value=\"65\">Singapore (+65)</option>\n\t\t<option data-countryCode=\"SK\" value=\"421\">Slovak Republic (+421)</option>\n\t\t<option data-countryCode=\"SI\" value=\"386\">Slovenia (+386)</option>\n\t\t<option data-countryCode=\"SB\" value=\"677\">Solomon Islands (+677)</option>\n\t\t<option data-countryCode=\"SO\" value=\"252\">Somalia (+252)</option>\n\t\t<option data-countryCode=\"ZA\" value=\"27\">South Africa (+27)</option>\n\t\t<option data-countryCode=\"ES\" value=\"34\">Spain (+34)</option>\n\t\t<option data-countryCode=\"LK\" value=\"94\">Sri Lanka (+94)</option>\n\t\t<option data-countryCode=\"SH\" value=\"290\">St. Helena (+290)</option>\n\t\t<option data-countryCode=\"KN\" value=\"1869\">St. Kitts (+1869)</option>\n\t\t<option data-countryCode=\"SC\" value=\"1758\">St. Lucia (+1758)</option>\n\t\t<option data-countryCode=\"SD\" value=\"249\">Sudan (+249)</option>\n\t\t<option data-countryCode=\"SR\" value=\"597\">Suriname (+597)</option>\n\t\t<option data-countryCode=\"SZ\" value=\"268\">Swaziland (+268)</option>\n\t\t<option data-countryCode=\"SE\" value=\"46\">Sweden (+46)</option>\n\t\t<option data-countryCode=\"CH\" value=\"41\">Switzerland (+41)</option>\n\t\t<option data-countryCode=\"SI\" value=\"963\">Syria (+963)</option>\n\t\t<option data-countryCode=\"TW\" value=\"886\">Taiwan (+886)</option>\n\t\t<option data-countryCode=\"TJ\" value=\"7\">Tajikstan (+7)</option>\n\t\t<option data-countryCode=\"TH\" value=\"66\">Thailand (+66)</option>\n\t\t<option data-countryCode=\"TG\" value=\"228\">Togo (+228)</option>\n\t\t<option data-countryCode=\"TO\" value=\"676\">Tonga (+676)</option>\n\t\t<option data-countryCode=\"TT\" value=\"1868\">Trinidad &amp; Tobago (+1868)</option>\n\t\t<option data-countryCode=\"TN\" value=\"216\">Tunisia (+216)</option>\n\t\t<option data-countryCode=\"TR\" value=\"90\">Turkey (+90)</option>\n\t\t<option data-countryCode=\"TM\" value=\"7\">Turkmenistan (+7)</option>\n\t\t<option data-countryCode=\"TM\" value=\"993\">Turkmenistan (+993)</option>\n\t\t<option data-countryCode=\"TC\" value=\"1649\">Turks &amp; Caicos Islands (+1649)</option>\n\t\t<option data-countryCode=\"TV\" value=\"688\">Tuvalu (+688)</option>\n\t\t<option data-countryCode=\"UG\" value=\"256\">Uganda (+256)</option>\n\t\t<option data-countryCode=\"UA\" value=\"380\">Ukraine (+380)</option>\n\t\t<option data-countryCode=\"AE\" value=\"971\">United Arab Emirates (+971)</option>\n\t\t<option data-countryCode=\"UY\" value=\"598\">Uruguay (+598)</option>\n\t\t<option data-countryCode=\"UZ\" value=\"7\">Uzbekistan (+7)</option>\n\t\t<option data-countryCode=\"VU\" value=\"678\">Vanuatu (+678)</option>\n\t\t<option data-countryCode=\"VA\" value=\"379\">Vatican City (+379)</option>\n\t\t<option data-countryCode=\"VE\" value=\"58\">Venezuela (+58)</option>\n\t\t<option data-countryCode=\"VN\" value=\"84\">Vietnam (+84)</option>\n\t\t<option data-countryCode=\"VG\" value=\"84\">Virgin Islands - British (+1284)</option>\n\t\t<option data-countryCode=\"VI\" value=\"84\">Virgin Islands - US (+1340)</option>\n\t\t<option data-countryCode=\"WF\" value=\"681\">Wallis &amp; Futuna (+681)</option>\n\t\t<option data-countryCode=\"YE\" value=\"969\">Yemen (North)(+969)</option>\n\t\t<option data-countryCode=\"YE\" value=\"967\">Yemen (South)(+967)</option>\n\t\t<option data-countryCode=\"ZM\" value=\"260\">Zambia (+260)</option>\n\t\t<option data-countryCode=\"ZW\" value=\"263\">Zimbabwe (+263)</option>\n</select>";
    $tempalte_ver["phonenumber1"] = $CountryCodePhone;
    $tempalte_ver["phonenumber"] = "<input type='text' class='form-control phoness'   size='20'  placeholder='" . $lng_languag["mobileno"] . "'  name='phonenumber'  />";
    $tempalte_ver["first_name"] = "<input type='text' class='form-control' required='1' name='first_name'  placeholder='" . $lng_languag["firstname"] . "'/>";
    $tempalte_ver["last_name"] = "<input type='text' class='form-control' required='1' name='last_name' size='13'  placeholder='" . $lng_languag["lastname"] . "'   />";
    $tempalte_ver["address1"] = "<input type='text' class='form-control' required='1' name='address1'  placeholder='" . $lng_languag["address"] . " 1' size='20' />";
    $tempalte_ver["address2"] = "<textarea name='address2' class='form-control' cols='35'  placeholder='" . $lng_languag["address"] . " 2'></textarea>";
    $tempalte_ver["city"] = "<input type='text' class='form-control' name='city' required='1'  placeholder='" . $lng_languag["city"] . "'  />";
    $tempalte_ver["state"] = "<input type='text' class='form-control' name='state' required='1'  placeholder='" . $lng_languag["state"] . "'  />";
    $tempalte_ver["zip"] = "<input type='text' class='form-control' name='zip' required='1'  placeholder='" . $lng_languag["zip"] . "' size='10' />";
    $tempalte_ver["phonecode"] = $phonecode;
    $tempalte_ver["country"] = getCountriesDropDown($login_country_code, "country", false, $config["DefaultCountry"], "no-chosen");
    $tempalte_ver["language"] = getLanguageDropdown2($_SESSION["WLANG"], "language", "no-chosen");
    if ($config["registration_currency"]) {
        $tempalte_ver["currency"] = getCurrency2($_SESSION["currency"]["id"], "currency", $config["registration_currency"]);
    } else {
        $tempalte_ver["currency"] = getCurrency2($_SESSION["currency"]["id"], "currency");
    }
    if ($config["captcha_registration"]) {
        $LoginCaptcha = NULL;
        include_once ROOTDIR . "/includes/pages/widget/verificationimage.php";
        $LoginCaptcha = createVerification("fromreg");
        $tempalte_ver["captcha"] = "<span><img src='data:image/jpg;base64," . $LoginCaptcha . "' alt='verification image, type it in the box' id='captchaimgs3' class='captchacom' align='absbottom' /></span>\n<a href='javascript: \$(\"#captchaimgs3\").attr(\"src\", \"widget/save/register?generatecaptcha=1\");' class='reloadcaptcha'></a>\n            <input type='text' class='form-control' name='captcha' required='1'  \n            placeholder='" . $lng_languag["captcha"] . "' >";
    }
    if (!function_exists("getCustomFields")) {
        require ROOTDIR . "/includes/customfield.fun.inc.php";
    }
    $customfields = getCustomFields("regis", "", $userid, "on");
    foreach ($customfields as $value) {
        $tempalte_ver["customfields"][$value["name"]] = $value;
    }
    if ($config["registration_terms"]) {
        $tempalte_ver["terms"] = "<div class=\"custom-control custom-checkbox\">\n                                                <input type=\"checkbox\" class=\"custom-control-input\" id=\"check-terms\" name=\"terms\" value=\"1\">\n                                                <label class=\"custom-control-label\" for=\"check-terms\"> " . $lng_languag["ihaveread"] . " </label>\n                                                <a   href=\"" . _url("pages/toc?standalone=1") . "\" data-dismiss=\"modal\" data-target=\"#modal-ajax\"\n                                                   data-size=\"modal-lg\" data-toggle=\"modal\"\n                                                   data-whatever=\"Terms of Service\">" . $lng_languag["termsofserv"] . "</a>\n                                            </div>";
    }
    $tempalte_ver["newsletter"] = "<div class=\"custom-control custom-checkbox\"><input  class=\"custom-control-input\" id=\"check-newsletter\" type='checkbox' value=1 \n    name='newsletter' /> <label class=\"custom-control-label\" for=\"check-newsletter\">" . $lng_languag["subscribefornewsletter"] . "</label></div>";
    $tempalte_ver["action_link"] = _url("widget/save/register/actions/register");
}
if ($error == "emailalreadyexist") {
    $tempalte_ver["class"] = "errorbox";
    $tempalte_ver["msg"] = $lng_languag["emailalreadyexist"];
    $tempalte_ver["notification"] = true;
}
if (isset($_SESSION["uid"])) {
    $templatefile = "client_accessdenied";
    $tempalte_ver["notification"]["error"] = $lng_languag["yournotallowed"];
}
chkMd5sumsubpage();
if ($standalone) {
    echo processSingleTemplate($templatefile);
} else {
    DisplayOutput($templatefile);
}
class no
{
}

?>