<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

/**
 * Created by IntelliJ IDEA.
 * User: akash
 * Date: 02-02-2019
 * Time: 02:20 PM
 */
class Log
{
    private $LogForEvent = NULL;
    private $ConfigLogPath = NULL;
    private $Data = NULL;
    public $QueryCnt = 0;
    public function __construct($LogFor)
    {
        global $LogPath;
        $_REQUEST =& $_REQUEST;
        $this->LogForEvent = $LogFor;
        $this->ConfigLogPath =& $LogPath;
        $this->Data .= date("Y-m-d H:i:s") . "\n";
        $this->Data .= "[file]" . $_SERVER["SCRIPT_NAME"] . "\n";
        $this->Data .= "[request]" . json_encode($_REQUEST) . "\n";
        $this->Data .= "[session]" . json_encode($_SESSION) . "\n";
        $this->Data .= "-----------------------------------\n";
    }
    public function processData($data)
    {
        if (is_array($data)) {
            return json_encode($data);
        }
        return str_replace("\n", " ", $data);
    }
    public function Info($data)
    {
        $this->Data .= "[info]" . $this->processData($data) . "\n";
    }
    public function Emergency($data)
    {
        $this->Data .= "[emergency]" . $this->processData($data) . "\n";
    }
    public function Alert($data)
    {
        $this->Data .= "[alert]" . $this->processData($data) . "\n";
    }
    public function Critical($data)
    {
        $this->Data .= "[critical]" . $this->processData($data) . "\n";
    }
    public function Error($data)
    {
        $this->Data .= "[error]" . $this->processData($data) . "\n";
    }
    public function Warning($data)
    {
        $this->Data .= "[warning]" . $this->processData($data) . "\n";
    }
    public function Notice($data)
    {
        $this->Data .= "[notice]" . $this->processData($data) . "\n";
    }
    public function Debug($data)
    {
        global $debuglog;
        if ($debuglog) {
            $this->Data .= "[debug]" . $this->processData($data) . "\n";
        }
    }
    public function Query($data)
    {
        global $debuglog;
        if ($debuglog) {
            $this->Data .= "[query]" . $this->processData($data) . "\n";
        }
    }
    public function Priority($data)
    {
        global $debuglog;
        if ($debuglog) {
            $this->Data .= "[priority]" . $this->processData($data) . "\n";
        }
    }
    public function logEnd()
    {
        if (!$this->ConfigLogPath) {
            return false;
        }
        $filepath = $this->makePath();
        $this->Debug($this->generateCallTrace());
        $this->Debug("Query Cnt: " . $this->QueryCnt);
        file_put_contents($filepath, $this->Data);
    }
    public function generateCallTrace()
    {
        global $debuglog;
        if ($debuglog) {
            $e = new Exception();
            $trace = explode("\n", $e->getTraceAsString());
            $trace = array_reverse($trace);
            array_shift($trace);
            array_pop($trace);
            $length = count($trace);
            $result = [];
            for ($i = 0; $i < $length; $i++) {
                $result[] = $i + 1 . ")" . substr($trace[$i], strpos($trace[$i], " "));
            }
            return "\t" . implode("\n\t", $result);
        }
    }
    public function makePath()
    {
        $_BaseDirPath = $this->ConfigLogPath . "/" . $this->LogForEvent;
        $_BaseDirPathYear = $_BaseDirPath . "/" . date(Y);
        $_BaseDirPathMonth = $_BaseDirPathYear . "/" . date(M);
        $_FinalPath = $_BaseDirPathMonth . "/" . date("d");
        if (!is_dir($_FinalPath)) {
            if (!is_dir($_BaseDirPath)) {
                mkdir($_BaseDirPath, 493);
            }
            if (!is_dir($_BaseDirPathYear)) {
                mkdir($_BaseDirPathYear, 493);
            }
            if (!is_dir($_BaseDirPathMonth)) {
                mkdir($_BaseDirPathMonth, 493);
            }
            if (!is_dir($_FinalPath)) {
                mkdir($_FinalPath, 493);
            }
        }
        $filename = date("Y_m_d__h_i_s") . ".log";
        return $_FinalPath . "/" . $filename;
    }
}

?>