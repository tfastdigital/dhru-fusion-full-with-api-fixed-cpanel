<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

$CustomFieldsMap = ["SerialNo" => "serialno_U4L6", "Email" => "email_B5D9", "Quantity" => "quantity_G7V7", "Username" => "username_K4I8", "Username:" => "username_K4I8", "Serial No" => "serialno_Z2O5", "ProductId Code" => "productidcode_E0U2", "Phone No" => "phoneno_C2Q9", "MEID" => "meid_Z5H1", "Country" => "country_V6A3", "Network" => "network_S4A4", "Provider Id" => "providerid_H1Y9", "Mep Code" => "mepcode_J8G4", "PRD Number" => "prdnumber_Q3V3", "CheckMend Report" => "checkmendreport_V7B8", "Model No" => "modelno_T3R8", "iCloud Email ID" => "icloudemailid_G0D4", "UDID" => "udid_I1A9", "KBH KRH" => "kbhkrh_B7K3", "Image URL" => "imageurl_F8O2", "Sent Pictures" => "sentpictures_L1T0", "MEP CODES" => "mepcodes_P7Y0", "PRD CODES" => "prdcodes_D3O0", "Dongle ID" => "dongleid_D7V1", "Active Code" => "activecode_Q7B2", "Password" => "pasward_V6I0", "Type Screen Hint" => "U4G4T7U9K8R6F3L1J9", "MSLsn" => "N2B4R0Y7T4W5D0I4K3", "SWID" => "K9Y2N8V1A4X1C4Y7Y8", "Service Terms" => "E4C6G0W5U1K0X4K7P5", "FingerPrint" => "Q6H1H9H4I2H2I4Y2K6", "USERNAME/SN" => "O7V8E3J2J4X6X1V6V2", "Z3X Credit Counts" => "R5C9X7Y9C2J3K9J9P0", "Types" => "A5C9F8O2Y0W8Q9M7C7", "SamKey TMO" => "I9E8C7S2D7I3R0T7Z1", "Sold By info" => "S9Z5X9R6B4M8C9J5L5", "User Type" => "W6A2C3K7V9A4Z1D1R2", "UMT Serial" => "K1Y3K9E2C6A7L9Q7D1", "Email Notification" => "L7E4X6J1P9T7B0L1N3", "Best Dongle Serial" => "F7A9A6N2E5T5E6B0L4", "Requested Service" => "F9A3K7E1J4F2R4F9O8", "TeamViewer Password" => "F9F1P8W7W8S6S3G7M9", "TYPE 5 DIGIT" => "G3S5Z4F0E1T6Y4S5D1", "WRITE MODEL . SAMPLE" => "G5S2H3Y8K6M6M5A5Y3", "Type" => "G7A9H4E7F9O5N8O2Z6", "Key Lock" => "G7N2T2G7P9J8M3W3O4", "UltraViewer Password" => "H1J7O7U1F8X7D1Z5K9", "Whatsapp Contact number" => "H1L1Y4T6X5L1M9W4B9", "Password Melok-Team.com" => "H6I1H4K6J0R5V1H5V6", "Infinity Box Serial" => "H7H6V6F7F0Z7F9B1H0", "put your device model for example" => "I2Q6N8T5C9M2B4E7E2", "Mobile Number" => "I3U6I4R5P5D8H2F0R7", "Facebook User Link" => "I6R9B8B4U6W9M2H1N6", "IOS Version" => "I7A8I4T5Z6Q4U0M6Z4", "UDID/SERIAL" => "J7H2C6M8P1I7V5S2L9", "Model" => "K2Z0J6Q4H7E1V8N3P9", "SERIAL_NUMBER" => "M4O5U3B8X3N5X7P8T0", "GC Pro Credit" => "M9A3U4F1G7X1P3R7K5", "TeamViewer ID" => "M9E8Y6P6R7V7D1X5H8", "Response e-mail" => "N1I3F4Z7W6A8Y2Y0J7", "11 Digit Serial" => "N1O7A1F4R3J1O2R8D5", "infinity CDMA Tool Serial" => "O4Q1P6M6K9M1U4M6W8", "you must write the word \"ALL\" case sensitivity (in..." => "P4B3J4C6C7V2Y7N2G5", "IMEI or Serial" => "P5C7N4I0X5N8A2L2X5", "Link picture/hình" => "Q5F9S5M7Y8K7T0T5D6", "Type any 15 digit" => "Q6X2N9J0Q0X0H8N7N9", "REFILL_LOGIN" => "R1R9F5K6P3Z4Q8X1F3", "Type A7 only | do not use other word for order" => "R7V4F9L4R3H5E2J9D3", "Type A8 only | do not use other word for order" => "U5V8J9Y4E9B0D3I1J7", "Part Number , Sale Number" => "U6G1V7X3J7G7Q0C1Y1", "TYPE ANY 2 RANDOM DIGIT" => "V4J3X6K7V2M3L1O7W0", "Model Name" => "W7T0P0L1I8Y1F1Q0Z8", "Check Case" => "X5Z8G6Y3N7L1X0M3M8", "HWID" => "Y6V7X8W9L1K3P4Q4T7", "Model_" => "Z9H8N8L7B3L8L8X8C1", "SN" => "W5P9M3M4F1X3J6N0V0", "Type A5 only | do not use other word for order" => "B0P3X4W1V4P6Q7G0I3", "Brand" => "B0X3E6Y8Y9L6J2D7C7", "Email Melok-Team.com" => "B0Z0U1X6M0C4N2J9T7", "R3-Tools Key" => "B4N1Q3E3B1K8L2P9R9", "User Type2" => "C1E7F6A8U2B8M4T1M5", "infinity CDMA Tool Serial2" => "J5O5R3C3Q7Z9S3L7V8", "HWID2" => "A7X7P9A0A3H6A9P2X8", "Best Dongle Serial2" => "X9Z7Z7H1I6K8A7D7X1"];
class gsmtool
{
    public $objCurl = NULL;
    public $result = [];
    public $APIError = "";
    public $xml = "";
    public function getResult()
    {
        return $this->result;
    }
    public function apiError()
    {
        return $this->APIError;
    }
    public function checkError($result)
    {
        if (isset($result["ERR"])) {
            echo "<h2> Error Code: " . $result["STATUS"] . "</h2>";
            echo "<h3>" . $result["ERR"] . "</h3>";
            exit;
        }
    }
    public function action($toDo, $apiKey, $url, $userId, $parameters = [])
    {
        if (is_string($toDo) && is_array($parameters)) {
            $parameters["apiKey"] = $apiKey;
            $parameters["userId"] = $userId;
            $parameters["action"] = $toDo;
            $this->objCurl = curl_init();
            curl_setopt($this->objCurl, CURLOPT_HEADER, false);
            curl_setopt($this->objCurl, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
            curl_setopt($this->objCurl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($this->objCurl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->objCurl, CURLOPT_TIMEOUT, 10);
            if (is_array($parameters)) {
                $vars = implode("&", $parameters);
            }
            curl_setopt($this->objCurl, CURLOPT_URL, $url . "/gsmfusion_api/");
            curl_setopt($this->objCurl, CURLOPT_POST, true);
            curl_setopt($this->objCurl, CURLOPT_POSTFIELDS, $parameters);
            $this->result = curl_exec($this->objCurl);
            if (curl_errno($this->objCurl) != CURLE_OK) {
                $this->APIError = "API Communication error: " . curl_error($this->objCurl);
            }
            curl_close($this->objCurl);
            $this->getResult();
            $this->XmlToArray($this->getResult());
            return $this->createArray();
        }
    }
    public function XmlToArray($xml)
    {
        $this->xml = $xml;
    }
    public function _struct_to_array($values, &$i)
    {
        $child = [];
        if (isset($values[$i]["value"])) {
            array_push($child, $values[$i]["value"]);
            while ($i++ < count($values)) {
            }
            return $child;
        }
        switch ($values[$i]["type"]) {
            case "cdata":
                array_push($child, $values[$i]["value"]);
                break;
            case "complete":
                $name = $values[$i]["tag"];
                if (!empty($name)) {
                    $child[$name] = $values[$i]["value"] ? $values[$i]["value"] : "";
                    if (isset($values[$i]["attributes"])) {
                        $child[$name] = $values[$i]["attributes"];
                    }
                }
                break;
            case "open":
                $name = $values[$i]["tag"];
                $size = isset($child[$name]) ? sizeof($child[$name]) : 0;
                $child[$name][$size] = $this->_struct_to_array($values, $i);
                break;
            case "close":
                return $child;
                break;
        }
    }
    public function createArray()
    {
        $xml = $this->xml;
        $values = [];
        $index = [];
        $array = [];
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parse_into_struct($parser, $xml, $values, $index);
        xml_parser_free($parser);
        $i = 0;
        $name = $values[$i]["tag"];
        $array[$name] = isset($values[$i]["attributes"]) ? $values[$i]["attributes"] : "";
        $array[$name] = $this->_struct_to_array($values, $i);
        return $array;
    }
}

?>