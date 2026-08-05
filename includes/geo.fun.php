<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
define("GEOIP_COUNTRY_BEGIN", 16776960);
define("GEOIP_STATE_BEGIN_REV0", 16700000);
define("GEOIP_STATE_BEGIN_REV1", 16000000);
define("GEOIP_STANDARD", 0);
define("GEOIP_MEMORY_CACHE", 1);
define("GEOIP_SHARED_MEMORY", 2);
define("STRUCTURE_INFO_MAX_SIZE", 20);
define("DATABASE_INFO_MAX_SIZE", 100);
define("GEOIP_COUNTRY_EDITION", 106);
define("GEOIP_PROXY_EDITION", 8);
define("GEOIP_ASNUM_EDITION", 9);
define("GEOIP_NETSPEED_EDITION", 10);
define("GEOIP_REGION_EDITION_REV0", 112);
define("GEOIP_REGION_EDITION_REV1", 3);
define("GEOIP_CITY_EDITION_REV0", 111);
define("GEOIP_CITY_EDITION_REV1", 2);
define("GEOIP_ORG_EDITION", 110);
define("GEOIP_ISP_EDITION", 4);
define("SEGMENT_RECORD_LENGTH", 3);
define("STANDARD_RECORD_LENGTH", 3);
define("ORG_RECORD_LENGTH", 4);
define("MAX_RECORD_LENGTH", 4);
define("MAX_ORG_RECORD_LENGTH", 300);
define("GEOIP_SHM_KEY", 1329681409);
define("US_OFFSET", 1);
define("CANADA_OFFSET", 677);
define("WORLD_OFFSET", 1353);
define("FIPS_RANGE", 360);
define("GEOIP_UNKNOWN_SPEED", 0);
define("GEOIP_DIALUP_SPEED", 1);
define("GEOIP_CABLEDSL_SPEED", 2);
define("GEOIP_CORPORATE_SPEED", 3);
define("GEOIP_DOMAIN_EDITION", 11);
define("GEOIP_LOCATIONA_EDITION", 13);
define("GEOIP_ACCURACYRADIUS_EDITION", 14);
define("GEOIP_CITYCOMBINED_EDITION", 15);
define("CITYCOMBINED_FIXED_RECORD", 7);
class GeoIP
{
    public $flags = NULL;
    public $filehandle = NULL;
    public $memory_buffer = NULL;
    public $databaseType = NULL;
    public $databaseSegments = NULL;
    public $record_length = NULL;
    public $shmid = NULL;
    public $PHONECODE_BY_COUNTRY = ["AD" => ["name" => "ANDORRA", "code" => "376"], "AE" => ["name" => "UNITED ARAB EMIRATES", "code" => "971"], "AF" => ["name" => "AFGHANISTAN", "code" => "93"], "AG" => ["name" => "ANTIGUA AND BARBUDA", "code" => "1268"], "AI" => ["name" => "ANGUILLA", "code" => "1264"], "AL" => ["name" => "ALBANIA", "code" => "355"], "AM" => ["name" => "ARMENIA", "code" => "374"], "AN" => ["name" => "NETHERLANDS ANTILLES", "code" => "599"], "AO" => ["name" => "ANGOLA", "code" => "244"], "AQ" => ["name" => "ANTARCTICA", "code" => "672"], "AR" => ["name" => "ARGENTINA", "code" => "54"], "AS" => ["name" => "AMERICAN SAMOA", "code" => "1684"], "AT" => ["name" => "AUSTRIA", "code" => "43"], "AU" => ["name" => "AUSTRALIA", "code" => "61"], "AW" => ["name" => "ARUBA", "code" => "297"], "AZ" => ["name" => "AZERBAIJAN", "code" => "994"], "BA" => ["name" => "BOSNIA AND HERZEGOVINA", "code" => "387"], "BB" => ["name" => "BARBADOS", "code" => "1246"], "BD" => ["name" => "BANGLADESH", "code" => "880"], "BE" => ["name" => "BELGIUM", "code" => "32"], "BF" => ["name" => "BURKINA FASO", "code" => "226"], "BG" => ["name" => "BULGARIA", "code" => "359"], "BH" => ["name" => "BAHRAIN", "code" => "973"], "BI" => ["name" => "BURUNDI", "code" => "257"], "BJ" => ["name" => "BENIN", "code" => "229"], "BL" => ["name" => "SAINT BARTHELEMY", "code" => "590"], "BM" => ["name" => "BERMUDA", "code" => "1441"], "BN" => ["name" => "BRUNEI DARUSSALAM", "code" => "673"], "BO" => ["name" => "BOLIVIA", "code" => "591"], "BR" => ["name" => "BRAZIL", "code" => "55"], "BS" => ["name" => "BAHAMAS", "code" => "1242"], "BT" => ["name" => "BHUTAN", "code" => "975"], "BW" => ["name" => "BOTSWANA", "code" => "267"], "BY" => ["name" => "BELARUS", "code" => "375"], "BZ" => ["name" => "BELIZE", "code" => "501"], "CA" => ["name" => "CANADA", "code" => "1"], "CC" => ["name" => "COCOS (KEELING) ISLANDS", "code" => "61"], "CD" => ["name" => "CONGO, THE DEMOCRATIC REPUBLIC OF THE", "code" => "243"], "CF" => ["name" => "CENTRAL AFRICAN REPUBLIC", "code" => "236"], "CG" => ["name" => "CONGO", "code" => "242"], "CH" => ["name" => "SWITZERLAND", "code" => "41"], "CI" => ["name" => "COTE D IVOIRE", "code" => "225"], "CK" => ["name" => "COOK ISLANDS", "code" => "682"], "CL" => ["name" => "CHILE", "code" => "56"], "CM" => ["name" => "CAMEROON", "code" => "237"], "CN" => ["name" => "CHINA", "code" => "86"], "CO" => ["name" => "COLOMBIA", "code" => "57"], "CR" => ["name" => "COSTA RICA", "code" => "506"], "CU" => ["name" => "CUBA", "code" => "53"], "CV" => ["name" => "CAPE VERDE", "code" => "238"], "CX" => ["name" => "CHRISTMAS ISLAND", "code" => "61"], "CY" => ["name" => "CYPRUS", "code" => "357"], "CZ" => ["name" => "CZECH REPUBLIC", "code" => "420"], "DE" => ["name" => "GERMANY", "code" => "49"], "DJ" => ["name" => "DJIBOUTI", "code" => "253"], "DK" => ["name" => "DENMARK", "code" => "45"], "DM" => ["name" => "DOMINICA", "code" => "1767"], "DO" => ["name" => "DOMINICAN REPUBLIC", "code" => "1809"], "DZ" => ["name" => "ALGERIA", "code" => "213"], "EC" => ["name" => "ECUADOR", "code" => "593"], "EE" => ["name" => "ESTONIA", "code" => "372"], "EG" => ["name" => "EGYPT", "code" => "20"], "ER" => ["name" => "ERITREA", "code" => "291"], "ES" => ["name" => "SPAIN", "code" => "34"], "ET" => ["name" => "ETHIOPIA", "code" => "251"], "FI" => ["name" => "FINLAND", "code" => "358"], "FJ" => ["name" => "FIJI", "code" => "679"], "FK" => ["name" => "FALKLAND ISLANDS (MALVINAS)", "code" => "500"], "FM" => ["name" => "MICRONESIA, FEDERATED STATES OF", "code" => "691"], "FO" => ["name" => "FAROE ISLANDS", "code" => "298"], "FR" => ["name" => "FRANCE", "code" => "33"], "GA" => ["name" => "GABON", "code" => "241"], "GB" => ["name" => "UNITED KINGDOM", "code" => "44"], "GD" => ["name" => "GRENADA", "code" => "1473"], "GE" => ["name" => "GEORGIA", "code" => "995"], "GH" => ["name" => "GHANA", "code" => "233"], "GI" => ["name" => "GIBRALTAR", "code" => "350"], "GL" => ["name" => "GREENLAND", "code" => "299"], "GM" => ["name" => "GAMBIA", "code" => "220"], "GN" => ["name" => "GUINEA", "code" => "224"], "GQ" => ["name" => "EQUATORIAL GUINEA", "code" => "240"], "GR" => ["name" => "GREECE", "code" => "30"], "GT" => ["name" => "GUATEMALA", "code" => "502"], "GU" => ["name" => "GUAM", "code" => "1671"], "GW" => ["name" => "GUINEA-BISSAU", "code" => "245"], "GY" => ["name" => "GUYANA", "code" => "592"], "HK" => ["name" => "HONG KONG", "code" => "852"], "HN" => ["name" => "HONDURAS", "code" => "504"], "HR" => ["name" => "CROATIA", "code" => "385"], "HT" => ["name" => "HAITI", "code" => "509"], "HU" => ["name" => "HUNGARY", "code" => "36"], "ID" => ["name" => "INDONESIA", "code" => "62"], "IE" => ["name" => "IRELAND", "code" => "353"], "IL" => ["name" => "ISRAEL", "code" => "972"], "IM" => ["name" => "ISLE OF MAN", "code" => "44"], "IN" => ["name" => "INDIA", "code" => "91"], "IQ" => ["name" => "IRAQ", "code" => "964"], "IR" => ["name" => "IRAN, ISLAMIC REPUBLIC OF", "code" => "98"], "IS" => ["name" => "ICELAND", "code" => "354"], "IT" => ["name" => "ITALY", "code" => "39"], "JM" => ["name" => "JAMAICA", "code" => "1876"], "JO" => ["name" => "JORDAN", "code" => "962"], "JP" => ["name" => "JAPAN", "code" => "81"], "KE" => ["name" => "KENYA", "code" => "254"], "KG" => ["name" => "KYRGYZSTAN", "code" => "996"], "KH" => ["name" => "CAMBODIA", "code" => "855"], "KI" => ["name" => "KIRIBATI", "code" => "686"], "KM" => ["name" => "COMOROS", "code" => "269"], "KN" => ["name" => "SAINT KITTS AND NEVIS", "code" => "1869"], "KP" => ["name" => "KOREA DEMOCRATIC PEOPLES REPUBLIC OF", "code" => "850"], "KR" => ["name" => "KOREA REPUBLIC OF", "code" => "82"], "KW" => ["name" => "KUWAIT", "code" => "965"], "KY" => ["name" => "CAYMAN ISLANDS", "code" => "1345"], "KZ" => ["name" => "KAZAKSTAN", "code" => "7"], "LA" => ["name" => "LAO PEOPLES DEMOCRATIC REPUBLIC", "code" => "856"], "LB" => ["name" => "LEBANON", "code" => "961"], "LC" => ["name" => "SAINT LUCIA", "code" => "1758"], "LI" => ["name" => "LIECHTENSTEIN", "code" => "423"], "LK" => ["name" => "SRI LANKA", "code" => "94"], "LR" => ["name" => "LIBERIA", "code" => "231"], "LS" => ["name" => "LESOTHO", "code" => "266"], "LT" => ["name" => "LITHUANIA", "code" => "370"], "LU" => ["name" => "LUXEMBOURG", "code" => "352"], "LV" => ["name" => "LATVIA", "code" => "371"], "LY" => ["name" => "LIBYAN ARAB JAMAHIRIYA", "code" => "218"], "MA" => ["name" => "MOROCCO", "code" => "212"], "MC" => ["name" => "MONACO", "code" => "377"], "MD" => ["name" => "MOLDOVA, REPUBLIC OF", "code" => "373"], "ME" => ["name" => "MONTENEGRO", "code" => "382"], "MF" => ["name" => "SAINT MARTIN", "code" => "1599"], "MG" => ["name" => "MADAGASCAR", "code" => "261"], "MH" => ["name" => "MARSHALL ISLANDS", "code" => "692"], "MK" => ["name" => "MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF", "code" => "389"], "ML" => ["name" => "MALI", "code" => "223"], "MM" => ["name" => "MYANMAR", "code" => "95"], "MN" => ["name" => "MONGOLIA", "code" => "976"], "MO" => ["name" => "MACAU", "code" => "853"], "MP" => ["name" => "NORTHERN MARIANA ISLANDS", "code" => "1670"], "MR" => ["name" => "MAURITANIA", "code" => "222"], "MS" => ["name" => "MONTSERRAT", "code" => "1664"], "MT" => ["name" => "MALTA", "code" => "356"], "MU" => ["name" => "MAURITIUS", "code" => "230"], "MV" => ["name" => "MALDIVES", "code" => "960"], "MW" => ["name" => "MALAWI", "code" => "265"], "MX" => ["name" => "MEXICO", "code" => "52"], "MY" => ["name" => "MALAYSIA", "code" => "60"], "MZ" => ["name" => "MOZAMBIQUE", "code" => "258"], "NA" => ["name" => "NAMIBIA", "code" => "264"], "NC" => ["name" => "NEW CALEDONIA", "code" => "687"], "NE" => ["name" => "NIGER", "code" => "227"], "NG" => ["name" => "NIGERIA", "code" => "234"], "NI" => ["name" => "NICARAGUA", "code" => "505"], "NL" => ["name" => "NETHERLANDS", "code" => "31"], "NO" => ["name" => "NORWAY", "code" => "47"], "NP" => ["name" => "NEPAL", "code" => "977"], "NR" => ["name" => "NAURU", "code" => "674"], "NU" => ["name" => "NIUE", "code" => "683"], "NZ" => ["name" => "NEW ZEALAND", "code" => "64"], "OM" => ["name" => "OMAN", "code" => "968"], "PA" => ["name" => "PANAMA", "code" => "507"], "PE" => ["name" => "PERU", "code" => "51"], "PF" => ["name" => "FRENCH POLYNESIA", "code" => "689"], "PG" => ["name" => "PAPUA NEW GUINEA", "code" => "675"], "PH" => ["name" => "PHILIPPINES", "code" => "63"], "PK" => ["name" => "PAKISTAN", "code" => "92"], "PL" => ["name" => "POLAND", "code" => "48"], "PM" => ["name" => "SAINT PIERRE AND MIQUELON", "code" => "508"], "PN" => ["name" => "PITCAIRN", "code" => "870"], "PR" => ["name" => "PUERTO RICO", "code" => "1"], "PT" => ["name" => "PORTUGAL", "code" => "351"], "PW" => ["name" => "PALAU", "code" => "680"], "PY" => ["name" => "PARAGUAY", "code" => "595"], "QA" => ["name" => "QATAR", "code" => "974"], "RO" => ["name" => "ROMANIA", "code" => "40"], "RS" => ["name" => "SERBIA", "code" => "381"], "RU" => ["name" => "RUSSIAN FEDERATION", "code" => "7"], "RW" => ["name" => "RWANDA", "code" => "250"], "SA" => ["name" => "SAUDI ARABIA", "code" => "966"], "SB" => ["name" => "SOLOMON ISLANDS", "code" => "677"], "SC" => ["name" => "SEYCHELLES", "code" => "248"], "SD" => ["name" => "SUDAN", "code" => "249"], "SE" => ["name" => "SWEDEN", "code" => "46"], "SG" => ["name" => "SINGAPORE", "code" => "65"], "SH" => ["name" => "SAINT HELENA", "code" => "290"], "SI" => ["name" => "SLOVENIA", "code" => "386"], "SK" => ["name" => "SLOVAKIA", "code" => "421"], "SL" => ["name" => "SIERRA LEONE", "code" => "232"], "SM" => ["name" => "SAN MARINO", "code" => "378"], "SN" => ["name" => "SENEGAL", "code" => "221"], "SO" => ["name" => "SOMALIA", "code" => "252"], "SR" => ["name" => "SURINAME", "code" => "597"], "ST" => ["name" => "SAO TOME AND PRINCIPE", "code" => "239"], "SV" => ["name" => "EL SALVADOR", "code" => "503"], "SY" => ["name" => "SYRIAN ARAB REPUBLIC", "code" => "963"], "SZ" => ["name" => "SWAZILAND", "code" => "268"], "TC" => ["name" => "TURKS AND CAICOS ISLANDS", "code" => "1649"], "TD" => ["name" => "CHAD", "code" => "235"], "TG" => ["name" => "TOGO", "code" => "228"], "TH" => ["name" => "THAILAND", "code" => "66"], "TJ" => ["name" => "TAJIKISTAN", "code" => "992"], "TK" => ["name" => "TOKELAU", "code" => "690"], "TL" => ["name" => "TIMOR-LESTE", "code" => "670"], "TM" => ["name" => "TURKMENISTAN", "code" => "993"], "TN" => ["name" => "TUNISIA", "code" => "216"], "TO" => ["name" => "TONGA", "code" => "676"], "TR" => ["name" => "TURKEY", "code" => "90"], "TT" => ["name" => "TRINIDAD AND TOBAGO", "code" => "1868"], "TV" => ["name" => "TUVALU", "code" => "688"], "TW" => ["name" => "TAIWAN, PROVINCE OF CHINA", "code" => "886"], "TZ" => ["name" => "TANZANIA, UNITED REPUBLIC OF", "code" => "255"], "UA" => ["name" => "UKRAINE", "code" => "380"], "UG" => ["name" => "UGANDA", "code" => "256"], "US" => ["name" => "UNITED STATES", "code" => "1"], "UY" => ["name" => "URUGUAY", "code" => "598"], "UZ" => ["name" => "UZBEKISTAN", "code" => "998"], "VA" => ["name" => "HOLY SEE (VATICAN CITY STATE)", "code" => "39"], "VC" => ["name" => "SAINT VINCENT AND THE GRENADINES", "code" => "1784"], "VE" => ["name" => "VENEZUELA", "code" => "58"], "VG" => ["name" => "VIRGIN ISLANDS, BRITISH", "code" => "1284"], "VI" => ["name" => "VIRGIN ISLANDS, U.S.", "code" => "1340"], "VN" => ["name" => "VIET NAM", "code" => "84"], "VU" => ["name" => "VANUATU", "code" => "678"], "WF" => ["name" => "WALLIS AND FUTUNA", "code" => "681"], "WS" => ["name" => "SAMOA", "code" => "685"], "XK" => ["name" => "KOSOVO", "code" => "381"], "YE" => ["name" => "YEMEN", "code" => "967"], "YT" => ["name" => "MAYOTTE", "code" => "262"], "ZA" => ["name" => "SOUTH AFRICA", "code" => "27"], "ZM" => ["name" => "ZAMBIA", "code" => "260"], "ZW" => ["name" => "ZIMBABWE", "code" => "263"]];
    public $GEOIP_COUNTRY_CODE_TO_NUMBER = ["" => 0, "AP" => 1, "EU" => 2, "AD" => 3, "AE" => 4, "AF" => 5, "AG" => 6, "AI" => 7, "AL" => 8, "AM" => 9, "AN" => 10, "AO" => 11, "AQ" => 12, "AR" => 13, "AS" => 14, "AT" => 15, "AU" => 16, "AW" => 17, "AZ" => 18, "BA" => 19, "BB" => 20, "BD" => 21, "BE" => 22, "BF" => 23, "BG" => 24, "BH" => 25, "BI" => 26, "BJ" => 27, "BM" => 28, "BN" => 29, "BO" => 30, "BR" => 31, "BS" => 32, "BT" => 33, "BV" => 34, "BW" => 35, "BY" => 36, "BZ" => 37, "CA" => 38, "CC" => 39, "CD" => 40, "CF" => 41, "CG" => 42, "CH" => 43, "CI" => 44, "CK" => 45, "CL" => 46, "CM" => 47, "CN" => 48, "CO" => 49, "CR" => 50, "CU" => 51, "CV" => 52, "CX" => 53, "CY" => 54, "CZ" => 55, "DE" => 56, "DJ" => 57, "DK" => 58, "DM" => 59, "DO" => 60, "DZ" => 61, "EC" => 62, "EE" => 63, "EG" => 64, "EH" => 65, "ER" => 66, "ES" => 67, "ET" => 68, "FI" => 69, "FJ" => 70, "FK" => 71, "FM" => 72, "FO" => 73, "FR" => 74, "FX" => 75, "GA" => 76, "GB" => 77, "GD" => 78, "GE" => 79, "GF" => 80, "GH" => 81, "GI" => 82, "GL" => 83, "GM" => 84, "GN" => 85, "GP" => 86, "GQ" => 87, "GR" => 88, "GS" => 89, "GT" => 90, "GU" => 91, "GW" => 92, "GY" => 93, "HK" => 94, "HM" => 95, "HN" => 96, "HR" => 97, "HT" => 98, "HU" => 99, "ID" => 100, "IE" => 101, "IL" => 102, "IN" => 103, "IO" => 104, "IQ" => 105, "IR" => 106, "IS" => 107, "IT" => 108, "JM" => 109, "JO" => 110, "JP" => 111, "KE" => 112, "KG" => 113, "KH" => 114, "KI" => 115, "KM" => 116, "KN" => 117, "KP" => 118, "KR" => 119, "KW" => 120, "KY" => 121, "KZ" => 122, "LA" => 123, "LB" => 124, "LC" => 125, "LI" => 126, "LK" => 127, "LR" => 128, "LS" => 129, "LT" => 130, "LU" => 131, "LV" => 132, "LY" => 133, "MA" => 134, "MC" => 135, "MD" => 136, "MG" => 137, "MH" => 138, "MK" => 139, "ML" => 140, "MM" => 141, "MN" => 142, "MO" => 143, "MP" => 144, "MQ" => 145, "MR" => 146, "MS" => 147, "MT" => 148, "MU" => 149, "MV" => 150, "MW" => 151, "MX" => 152, "MY" => 153, "MZ" => 154, "NA" => 155, "NC" => 156, "NE" => 157, "NF" => 158, "NG" => 159, "NI" => 160, "NL" => 161, "NO" => 162, "NP" => 163, "NR" => 164, "NU" => 165, "NZ" => 166, "OM" => 167, "PA" => 168, "PE" => 169, "PF" => 170, "PG" => 171, "PH" => 172, "PK" => 173, "PL" => 174, "PM" => 175, "PN" => 176, "PR" => 177, "PS" => 178, "PT" => 179, "PW" => 180, "PY" => 181, "QA" => 182, "RE" => 183, "RO" => 184, "RU" => 185, "RW" => 186, "SA" => 187, "SB" => 188, "SC" => 189, "SD" => 190, "SE" => 191, "SG" => 192, "SH" => 193, "SI" => 194, "SJ" => 195, "SK" => 196, "SL" => 197, "SM" => 198, "SN" => 199, "SO" => 200, "SR" => 201, "ST" => 202, "SV" => 203, "SY" => 204, "SZ" => 205, "TC" => 206, "TD" => 207, "TF" => 208, "TG" => 209, "TH" => 210, "TJ" => 211, "TK" => 212, "TM" => 213, "TN" => 214, "TO" => 215, "TL" => 216, "TR" => 217, "TT" => 218, "TV" => 219, "TW" => 220, "TZ" => 221, "UA" => 222, "UG" => 223, "UM" => 224, "US" => 225, "UY" => 226, "UZ" => 227, "VA" => 228, "VC" => 229, "VE" => 230, "VG" => 231, "VI" => 232, "VN" => 233, "VU" => 234, "WF" => 235, "WS" => 236, "YE" => 237, "YT" => 238, "RS" => 239, "ZA" => 240, "ZM" => 241, "ME" => 242, "ZW" => 243, "A1" => 244, "A2" => 245, "O1" => 246, "AX" => 247, "GG" => 248, "IM" => 249, "JE" => 250, "BL" => 251, "MF" => 252];
    public $GEOIP_COUNTRY_CODES = ["", "AP", "EU", "AD", "AE", "AF", "AG", "AI", "AL", "AM", "AN", "AO", "AQ", "AR", "AS", "AT", "AU", "AW", "AZ", "BA", "BB", "BD", "BE", "BF", "BG", "BH", "BI", "BJ", "BM", "BN", "BO", "BR", "BS", "BT", "BV", "BW", "BY", "BZ", "CA", "CC", "CD", "CF", "CG", "CH", "CI", "CK", "CL", "CM", "CN", "CO", "CR", "CU", "CV", "CX", "CY", "CZ", "DE", "DJ", "DK", "DM", "DO", "DZ", "EC", "EE", "EG", "EH", "ER", "ES", "ET", "FI", "FJ", "FK", "FM", "FO", "FR", "FX", "GA", "GB", "GD", "GE", "GF", "GH", "GI", "GL", "GM", "GN", "GP", "GQ", "GR", "GS", "GT", "GU", "GW", "GY", "HK", "HM", "HN", "HR", "HT", "HU", "ID", "IE", "IL", "IN", "IO", "IQ", "IR", "IS", "IT", "JM", "JO", "JP", "KE", "KG", "KH", "KI", "KM", "KN", "KP", "KR", "KW", "KY", "KZ", "LA", "LB", "LC", "LI", "LK", "LR", "LS", "LT", "LU", "LV", "LY", "MA", "MC", "MD", "MG", "MH", "MK", "ML", "MM", "MN", "MO", "MP", "MQ", "MR", "MS", "MT", "MU", "MV", "MW", "MX", "MY", "MZ", "NA", "NC", "NE", "NF", "NG", "NI", "NL", "NO", "NP", "NR", "NU", "NZ", "OM", "PA", "PE", "PF", "PG", "PH", "PK", "PL", "PM", "PN", "PR", "PS", "PT", "PW", "PY", "QA", "RE", "RO", "RU", "RW", "SA", "SB", "SC", "SD", "SE", "SG", "SH", "SI", "SJ", "SK", "SL", "SM", "SN", "SO", "SR", "ST", "SV", "SY", "SZ", "TC", "TD", "TF", "TG", "TH", "TJ", "TK", "TM", "TN", "TO", "TL", "TR", "TT", "TV", "TW", "TZ", "UA", "UG", "UM", "US", "UY", "UZ", "VA", "VC", "VE", "VG", "VI", "VN", "VU", "WF", "WS", "YE", "YT", "RS", "ZA", "ZM", "ME", "ZW", "A1", "A2", "O1", "AX", "GG", "IM", "JE", "BL", "MF"];
    public $GEOIP_COUNTRY_CODES3 = ["", "AP", "EU", "AND", "ARE", "AFG", "ATG", "AIA", "ALB", "ARM", "ANT", "AGO", "ATA", "ARG", "ASM", "AUT", "AUS", "ABW", "AZE", "BIH", "BRB", "BGD", "BEL", "BFA", "BGR", "BHR", "BDI", "BEN", "BMU", "BRN", "BOL", "BRA", "BHS", "BTN", "BVT", "BWA", "BLR", "BLZ", "CAN", "CCK", "COD", "CAF", "COG", "CHE", "CIV", "COK", "CHL", "CMR", "CHN", "COL", "CRI", "CUB", "CPV", "CXR", "CYP", "CZE", "DEU", "DJI", "DNK", "DMA", "DOM", "DZA", "ECU", "EST", "EGY", "ESH", "ERI", "ESP", "ETH", "FIN", "FJI", "FLK", "FSM", "FRO", "FRA", "FX", "GAB", "GBR", "GRD", "GEO", "GUF", "GHA", "GIB", "GRL", "GMB", "GIN", "GLP", "GNQ", "GRC", "SGS", "GTM", "GUM", "GNB", "GUY", "HKG", "HMD", "HND", "HRV", "HTI", "HUN", "IDN", "IRL", "ISR", "IND", "IOT", "IRQ", "IRN", "ISL", "ITA", "JAM", "JOR", "JPN", "KEN", "KGZ", "KHM", "KIR", "COM", "KNA", "PRK", "KOR", "KWT", "CYM", "KAZ", "LAO", "LBN", "LCA", "LIE", "LKA", "LBR", "LSO", "LTU", "LUX", "LVA", "LBY", "MAR", "MCO", "MDA", "MDG", "MHL", "MKD", "MLI", "MMR", "MNG", "MAC", "MNP", "MTQ", "MRT", "MSR", "MLT", "MUS", "MDV", "MWI", "MEX", "MYS", "MOZ", "NAM", "NCL", "NER", "NFK", "NGA", "NIC", "NLD", "NOR", "NPL", "NRU", "NIU", "NZL", "OMN", "PAN", "PER", "PYF", "PNG", "PHL", "PAK", "POL", "SPM", "PCN", "PRI", "PSE", "PRT", "PLW", "PRY", "QAT", "REU", "ROU", "RUS", "RWA", "SAU", "SLB", "SYC", "SDN", "SWE", "SGP", "SHN", "SVN", "SJM", "SVK", "SLE", "SMR", "SEN", "SOM", "SUR", "STP", "SLV", "SYR", "SWZ", "TCA", "TCD", "ATF", "TGO", "THA", "TJK", "TKL", "TKM", "TUN", "TON", "TLS", "TUR", "TTO", "TUV", "TWN", "TZA", "UKR", "UGA", "UMI", "USA", "URY", "UZB", "VAT", "VCT", "VEN", "VGB", "VIR", "VNM", "VUT", "WLF", "WSM", "YEM", "MYT", "SRB", "ZAF", "ZMB", "MNE", "ZWE", "A1", "A2", "O1", "ALA", "GGY", "IMN", "JEY", "BLM", "MAF"];
    public $GEOIP_COUNTRY_NAMES = ["", "Asia/Pacific Region", "Europe", "Andorra", "United Arab Emirates", "Afghanistan", "Antigua and Barbuda", "Anguilla", "Albania", "Armenia", "Netherlands Antilles", "Angola", "Antarctica", "Argentina", "American Samoa", "Austria", "Australia", "Aruba", "Azerbaijan", "Bosnia and Herzegovina", "Barbados", "Bangladesh", "Belgium", "Burkina Faso", "Bulgaria", "Bahrain", "Burundi", "Benin", "Bermuda", "Brunei Darussalam", "Bolivia", "Brazil", "Bahamas", "Bhutan", "Bouvet Island", "Botswana", "Belarus", "Belize", "Canada", "Cocos (Keeling) Islands", "Congo, The Democratic Republic of the", "Central African Republic", "Congo", "Switzerland", "Cote D'Ivoire", "Cook Islands", "Chile", "Cameroon", "China", "Colombia", "Costa Rica", "Cuba", "Cape Verde", "Christmas Island", "Cyprus", "Czech Republic", "Germany", "Djibouti", "Denmark", "Dominica", "Dominican Republic", "Algeria", "Ecuador", "Estonia", "Egypt", "Western Sahara", "Eritrea", "Spain", "Ethiopia", "Finland", "Fiji", "Falkland Islands (Malvinas)", "Micronesia, Federated States of", "Faroe Islands", "France", "France, Metropolitan", "Gabon", "United Kingdom", "Grenada", "Georgia", "French Guiana", "Ghana", "Gibraltar", "Greenland", "Gambia", "Guinea", "Guadeloupe", "Equatorial Guinea", "Greece", "South Georgia and the South Sandwich Islands", "Guatemala", "Guam", "Guinea-Bissau", "Guyana", "Hong Kong", "Heard Island and McDonald Islands", "Honduras", "Croatia", "Haiti", "Hungary", "Indonesia", "Ireland", "Israel", "India", "British Indian Ocean Territory", "Iraq", "Iran, Islamic Republic of", "Iceland", "Italy", "Jamaica", "Jordan", "Japan", "Kenya", "Kyrgyzstan", "Cambodia", "Kiribati", "Comoros", "Saint Kitts and Nevis", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Cayman Islands", "Kazakhstan", "Lao People's Democratic Republic", "Lebanon", "Saint Lucia", "Liechtenstein", "Sri Lanka", "Liberia", "Lesotho", "Lithuania", "Luxembourg", "Latvia", "Libyan Arab Jamahiriya", "Morocco", "Monaco", "Moldova, Republic of", "Madagascar", "Marshall Islands", "Macedonia", "Mali", "Myanmar", "Mongolia", "Macau", "Northern Mariana Islands", "Martinique", "Mauritania", "Montserrat", "Malta", "Mauritius", "Maldives", "Malawi", "Mexico", "Malaysia", "Mozambique", "Namibia", "New Caledonia", "Niger", "Norfolk Island", "Nigeria", "Nicaragua", "Netherlands", "Norway", "Nepal", "Nauru", "Niue", "New Zealand", "Oman", "Panama", "Peru", "French Polynesia", "Papua New Guinea", "Philippines", "Pakistan", "Poland", "Saint Pierre and Miquelon", "Pitcairn Islands", "Puerto Rico", "Palestinian Territory", "Portugal", "Palau", "Paraguay", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saudi Arabia", "Solomon Islands", "Seychelles", "Sudan", "Sweden", "Singapore", "Saint Helena", "Slovenia", "Svalbard and Jan Mayen", "Slovakia", "Sierra Leone", "San Marino", "Senegal", "Somalia", "Suriname", "Sao Tome and Principe", "El Salvador", "Syrian Arab Republic", "Swaziland", "Turks and Caicos Islands", "Chad", "French Southern Territories", "Togo", "Thailand", "Tajikistan", "Tokelau", "Turkmenistan", "Tunisia", "Tonga", "Timor-Leste", "Turkey", "Trinidad and Tobago", "Tuvalu", "Taiwan", "Tanzania, United Republic of", "Ukraine", "Uganda", "United States Minor Outlying Islands", "United States", "Uruguay", "Uzbekistan", "Holy See (Vatican City State)", "Saint Vincent and the Grenadines", "Venezuela", "Virgin Islands, British", "Virgin Islands, U.S.", "Vietnam", "Vanuatu", "Wallis and Futuna", "Samoa", "Yemen", "Mayotte", "Serbia", "South Africa", "Zambia", "Montenegro", "Zimbabwe", "Anonymous Proxy", "Satellite Provider", "Other", "Aland Islands", "Guernsey", "Isle of Man", "Jersey", "Saint Barthelemy", "Saint Martin"];
    public $GEOIP_CONTINENT_CODES = ["--", "AS", "EU", "EU", "AS", "AS", "NA", "NA", "EU", "AS", "NA", "AF", "AN", "SA", "OC", "EU", "OC", "NA", "AS", "EU", "NA", "AS", "EU", "AF", "EU", "AS", "AF", "AF", "NA", "AS", "SA", "SA", "NA", "AS", "AN", "AF", "EU", "NA", "NA", "AS", "AF", "AF", "AF", "EU", "AF", "OC", "SA", "AF", "AS", "SA", "NA", "NA", "AF", "AS", "AS", "EU", "EU", "AF", "EU", "NA", "NA", "AF", "SA", "EU", "AF", "AF", "AF", "EU", "AF", "EU", "OC", "SA", "OC", "EU", "EU", "EU", "AF", "EU", "NA", "AS", "SA", "AF", "EU", "NA", "AF", "AF", "NA", "AF", "EU", "AN", "NA", "OC", "AF", "SA", "AS", "AN", "NA", "EU", "NA", "EU", "AS", "EU", "AS", "AS", "AS", "AS", "AS", "EU", "EU", "NA", "AS", "AS", "AF", "AS", "AS", "OC", "AF", "NA", "AS", "AS", "AS", "NA", "AS", "AS", "AS", "NA", "EU", "AS", "AF", "AF", "EU", "EU", "EU", "AF", "AF", "EU", "EU", "AF", "OC", "EU", "AF", "AS", "AS", "AS", "OC", "NA", "AF", "NA", "EU", "AF", "AS", "AF", "NA", "AS", "AF", "AF", "OC", "AF", "OC", "AF", "NA", "EU", "EU", "AS", "OC", "OC", "OC", "AS", "NA", "SA", "OC", "OC", "AS", "AS", "EU", "NA", "OC", "NA", "AS", "EU", "OC", "SA", "AS", "AF", "EU", "EU", "AF", "AS", "OC", "AF", "AF", "EU", "AS", "AF", "EU", "EU", "EU", "AF", "EU", "AF", "AF", "SA", "AF", "NA", "AS", "AF", "NA", "AF", "AN", "AF", "AS", "AS", "OC", "AS", "AF", "OC", "AS", "EU", "NA", "OC", "AS", "AF", "EU", "AF", "OC", "NA", "SA", "AS", "EU", "NA", "SA", "NA", "NA", "AS", "OC", "OC", "OC", "AS", "AF", "EU", "AF", "AF", "EU", "AF", "--", "--", "--", "EU", "EU", "EU", "EU", "NA", "NA"];
}
function geoip_load_shared_mem($file)
{
    $fp = fopen($file, "rb");
    if (!$fp) {
        echo "error opening " . $file . ": " . $php_errormsg . "\n";
        exit;
    }
    $s_array = fstat($fp);
    $size = $s_array["size"];
    if ($shmid = shmop_open(GEOIP_SHM_KEY, "w", 0, 0)) {
        shmop_delete($shmid);
        shmop_close($shmid);
    }
    $shmid = shmop_open(GEOIP_SHM_KEY, "c", 420, $size);
    shmop_write($shmid, fread($fp, $size), 0);
    shmop_close($shmid);
}
function _setup_segments($gi)
{
    $gi->databaseType = GEOIP_COUNTRY_EDITION;
    $gi->record_length = STANDARD_RECORD_LENGTH;
    if ($gi->flags & GEOIP_SHARED_MEMORY) {
        $offset = shmop_size($gi->shmid) - 3;
        $i = 0;
        while ($i < STRUCTURE_INFO_MAX_SIZE) {
            $delim = shmop_read($gi->shmid, $offset, 3);
            $offset += 3;
            if ($delim == chr(255) . chr(255) . chr(255)) {
                $gi->databaseType = ord(shmop_read($gi->shmid, $offset, 1));
                $offset++;
                if ($gi->databaseType == GEOIP_REGION_EDITION_REV0) {
                    $gi->databaseSegments = GEOIP_STATE_BEGIN_REV0;
                } else {
                    if ($gi->databaseType == GEOIP_REGION_EDITION_REV1) {
                        $gi->databaseSegments = GEOIP_STATE_BEGIN_REV1;
                    } else {
                        if ($gi->databaseType == GEOIP_CITY_EDITION_REV0 || $gi->databaseType == GEOIP_CITY_EDITION_REV1 || $gi->databaseType == GEOIP_ORG_EDITION || $gi->databaseType == GEOIP_DOMAIN_EDITION || $gi->databaseType == GEOIP_ISP_EDITION || $gi->databaseType == GEOIP_LOCATIONA_EDITION || $gi->databaseType == GEOIP_ACCURACYRADIUS_EDITION || $gi->databaseType == GEOIP_ASNUM_EDITION) {
                            $gi->databaseSegments = 0;
                            $buf = shmop_read($gi->shmid, $offset, SEGMENT_RECORD_LENGTH);
                            for ($j = 0; $j < SEGMENT_RECORD_LENGTH; $j++) {
                                $gi->databaseSegments += ord($buf[$j]) << $j * 8;
                            }
                            if ($gi->databaseType == GEOIP_ORG_EDITION || $gi->databaseType == GEOIP_DOMAIN_EDITION || $gi->databaseType == GEOIP_ISP_EDITION) {
                                $gi->record_length = ORG_RECORD_LENGTH;
                            }
                        }
                    }
                }
            } else {
                $offset -= 4;
                $i++;
            }
        }
        if ($gi->databaseType == GEOIP_COUNTRY_EDITION || $gi->databaseType == GEOIP_PROXY_EDITION || $gi->databaseType == GEOIP_NETSPEED_EDITION) {
            $gi->databaseSegments = GEOIP_COUNTRY_BEGIN;
        }
    } else {
        $filepos = ftell($gi->filehandle);
        fseek($gi->filehandle, -3, SEEK_END);
        $i = 0;
        while ($i < STRUCTURE_INFO_MAX_SIZE) {
            $delim = fread($gi->filehandle, 3);
            if ($delim == chr(255) . chr(255) . chr(255)) {
                $gi->databaseType = ord(fread($gi->filehandle, 1));
                if ($gi->databaseType == GEOIP_REGION_EDITION_REV0) {
                    $gi->databaseSegments = GEOIP_STATE_BEGIN_REV0;
                } else {
                    if ($gi->databaseType == GEOIP_REGION_EDITION_REV1) {
                        $gi->databaseSegments = GEOIP_STATE_BEGIN_REV1;
                    } else {
                        if ($gi->databaseType == GEOIP_CITY_EDITION_REV0 || $gi->databaseType == GEOIP_CITY_EDITION_REV1 || $gi->databaseType == GEOIP_ORG_EDITION || $gi->databaseType == GEOIP_DOMAIN_EDITION || $gi->databaseType == GEOIP_ISP_EDITION || $gi->databaseType == GEOIP_LOCATIONA_EDITION || $gi->databaseType == GEOIP_ACCURACYRADIUS_EDITION || $gi->databaseType == GEOIP_ASNUM_EDITION) {
                            $gi->databaseSegments = 0;
                            $buf = fread($gi->filehandle, SEGMENT_RECORD_LENGTH);
                            for ($j = 0; $j < SEGMENT_RECORD_LENGTH; $j++) {
                                $gi->databaseSegments += ord($buf[$j]) << $j * 8;
                            }
                            if ($gi->databaseType == GEOIP_ORG_EDITION || $gi->databaseType == GEOIP_DOMAIN_EDITION || $gi->databaseType == GEOIP_ISP_EDITION) {
                                $gi->record_length = ORG_RECORD_LENGTH;
                            }
                        }
                    }
                }
            } else {
                fseek($gi->filehandle, -4, SEEK_CUR);
                $i++;
            }
        }
        if ($gi->databaseType == GEOIP_COUNTRY_EDITION || $gi->databaseType == GEOIP_PROXY_EDITION || $gi->databaseType == GEOIP_NETSPEED_EDITION) {
            $gi->databaseSegments = GEOIP_COUNTRY_BEGIN;
        }
        fseek($gi->filehandle, $filepos, SEEK_SET);
    }
    return $gi;
}
function geoip_open($filename, $flags)
{
    $gi = new GeoIP();
    $gi->flags = $flags;
    if ($gi->flags & GEOIP_SHARED_MEMORY) {
        $gi->shmid = shmop_open(GEOIP_SHM_KEY, "a", 0, 0);
        $gi = _setup_segments($gi);
        return $gi;
    }
    $gi->filehandle = fopen($filename, "rb");
    exit("Can not open " . $filename . "\n");
}
function geoip_close($gi)
{
    if ($gi->flags & GEOIP_SHARED_MEMORY) {
        return true;
    }
    return fclose($gi->filehandle);
}
function Dhrugeoip_country_id_by_name($gi, $name)
{
    $addr = gethostbyname($name);
    if (!$addr || $addr == $name) {
        return false;
    }
    return Dhrugeoip_country_id_by_addr($gi, $addr);
}
function Dhrugeoip_country_code_by_name($gi, $name)
{
    $country_id = dhrugeoip_country_id_by_name($gi, $name);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_CODES[$country_id];
    }
    return false;
}
function Dhrugeoip_country_name_by_name($gi, $name)
{
    $country_id = dhrugeoip_country_id_by_name($gi, $name);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_NAMES[$country_id];
    }
    return false;
}
function Dhrugeoip_country_id_by_addr($gi, $addr)
{
    $ipnum = ip2long($addr);
    return _geoip_seek_country($gi, $ipnum) - GEOIP_COUNTRY_BEGIN;
}
function Dhrugeoip_country_code_by_addr($gi, $addr)
{
    if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
        $record = geoip_record_by_addr($gi, $addr);
        if ($record !== false) {
            return $record->country_code;
        }
    } else {
        $country_id = dhrugeoip_country_id_by_addr($gi, $addr);
        if ($country_id !== false) {
            return $gi->GEOIP_COUNTRY_CODES[$country_id];
        }
    }
    return false;
}
function Dhrugeoip_country_name_by_addr($gi, $addr)
{
    if ($gi->databaseType == GEOIP_CITY_EDITION_REV1) {
        $record = geoip_record_by_addr($gi, $addr);
        return $record->country_name;
    }
    $country_id = dhrugeoip_country_id_by_addr($gi, $addr);
    if ($country_id !== false) {
        return $gi->GEOIP_COUNTRY_NAMES[$country_id];
    }
    return false;
}
function _geoip_seek_country($gi, $ipnum)
{
    $offset = 0;
    $depth = 31;
    while (0 <= $depth) {
        if ($gi->flags & GEOIP_MEMORY_CACHE) {
            $enc = mb_internal_encoding();
            mb_internal_encoding("ISO-8859-1");
            $buf = substr($gi->memory_buffer, 2 * $gi->record_length * $offset, 2 * $gi->record_length);
            mb_internal_encoding($enc);
        } else {
            if ($gi->flags & GEOIP_SHARED_MEMORY) {
                $buf = shmop_read($gi->shmid, 2 * $gi->record_length * $offset, 2 * $gi->record_length);
            } else {
                fseek($gi->filehandle, 2 * $gi->record_length * $offset, SEEK_SET) == 0;
                fseek($gi->filehandle, 2 * $gi->record_length * $offset, SEEK_SET) == 0 || exit("fseek failed");
                fseek($gi->filehandle, 2 * $gi->record_length * $offset, SEEK_SET) == 0;
                $buf = fread($gi->filehandle, 2 * $gi->record_length);
            }
        }
        $x = [0, 0];
        for ($i = 0; $i < 2; $i++) {
            for ($j = 0; $j < $gi->record_length; $j++) {
                $x[$i] += ord($buf[$gi->record_length * $i + $j]) << $j * 8;
            }
        }
        if ($ipnum & 1 << $depth) {
            if ($gi->databaseSegments <= $x[1]) {
                return $x[1];
            }
            $offset = $x[1];
        } else {
            if ($gi->databaseSegments <= $x[0]) {
                return $x[0];
            }
            $offset = $x[0];
        }
        --$depth;
    }
    trigger_error("error traversing database - perhaps it is corrupt?", 256);
    return false;
}
function _get_org($gi, $ipnum)
{
    $seek_org = _geoip_seek_country($gi, $ipnum);
    if ($seek_org == $gi->databaseSegments) {
        return NULL;
    }
    $record_pointer = $seek_org + (2 * $gi->record_length - 1) * $gi->databaseSegments;
    if ($gi->flags & GEOIP_SHARED_MEMORY) {
        $org_buf = shmop_read($gi->shmid, $record_pointer, MAX_ORG_RECORD_LENGTH);
    } else {
        fseek($gi->filehandle, $record_pointer, SEEK_SET);
        $org_buf = fread($gi->filehandle, MAX_ORG_RECORD_LENGTH);
    }
    $enc = mb_internal_encoding();
    mb_internal_encoding("ISO-8859-1");
    $org_buf = substr($org_buf, 0, strpos($org_buf, "\0"));
    mb_internal_encoding($enc);
    return $org_buf;
}
function geoip_org_by_addr($gi, $addr)
{
    if ($addr == NULL) {
        return 0;
    }
    $ipnum = ip2long($addr);
    return _get_org($gi, $ipnum);
}
function _get_region($gi, $ipnum)
{
    if ($gi->databaseType == GEOIP_REGION_EDITION_REV0) {
        $seek_region = _geoip_seek_country($gi, $ipnum) - GEOIP_STATE_BEGIN_REV0;
        if (1000 <= $seek_region) {
            $country_code = "US";
            $region = chr(($seek_region - 1000) / 26 + 65) . chr(($seek_region - 1000) % 26 + 65);
        } else {
            $country_code = $gi->GEOIP_COUNTRY_CODES[$seek_region];
            $region = "";
        }
        return [$country_code, $region];
    }
    if ($gi->databaseType == GEOIP_REGION_EDITION_REV1) {
        $seek_region = _geoip_seek_country($gi, $ipnum) - GEOIP_STATE_BEGIN_REV1;
        if ($seek_region < US_OFFSET) {
            $country_code = "";
            $region = "";
        } else {
            if ($seek_region < CANADA_OFFSET) {
                $country_code = "US";
                $region = chr(($seek_region - US_OFFSET) / 26 + 65) . chr(($seek_region - US_OFFSET) % 26 + 65);
            } else {
                if ($seek_region < WORLD_OFFSET) {
                    $country_code = "CA";
                    $region = chr(($seek_region - CANADA_OFFSET) / 26 + 65) . chr(($seek_region - CANADA_OFFSET) % 26 + 65);
                } else {
                    $country_code = $gi->GEOIP_COUNTRY_CODES[($seek_region - WORLD_OFFSET) / FIPS_RANGE];
                    $region = "";
                }
            }
        }
        return [$country_code, $region];
    }
}
function geoip_region_by_addr($gi, $addr)
{
    if ($addr == NULL) {
        return 0;
    }
    $ipnum = ip2long($addr);
    return _get_region($gi, $ipnum);
}
function getdnsattributes($l, $ip)
{
    $r = new Net_DNS_Resolver();
    $r->nameservers = ["ws1.maxmind.com"];
    $p = $r->search($l . "." . $ip . ".s.maxmind.com", "TXT", "IN");
    $str = is_object($p->answer[0]) ? $p->answer[0]->string() : "";
    $str = $regs[1];
    return $str;
}

?>