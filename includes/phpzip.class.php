<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

defined("DEFINE_MY_ACCESS") || exit("<h1 style=\"color: #C00; text-align: center;\"><strong>Restricted Access</strong></h1>");
class zipfile
{
    public $datasec = [];
    public $ctrl_dir = [];
    public $eof_ctrl_dir = "PK\5\6\0\0\0\0";
    public $old_offset = 0;
    public function unix2DosTime($unixtime = 0)
    {
        $timearray = $unixtime == 0 ? getdate() : getdate($unixtime);
        if ($timearray["year"] < 1980) {
            $timearray["year"] = 1980;
            $timearray["mon"] = 1;
            $timearray["mday"] = 1;
            $timearray["hours"] = 0;
            $timearray["minutes"] = 0;
            $timearray["seconds"] = 0;
        }
        return $timearray["year"] - 1980 << 25 | $timearray["mon"] << 21 | $timearray["mday"] << 16 | $timearray["hours"] << 11 | $timearray["minutes"] << 5 | $timearray["seconds"] >> 1;
    }
    public function addDir($name)
    {
        $name = str_replace("\\", "/", $name);
        $fr = "PK\3\4";
        $fr .= "\n\0";
        $fr .= "\0\0";
        $fr .= "\0\0";
        $fr .= "\0\0\0\0";
        $fr .= pack("V", 0);
        $fr .= pack("V", 0);
        $fr .= pack("V", 0);
        $fr .= pack("v", strlen($name));
        $fr .= pack("v", 0);
        $fr .= $name;
        $fr .= pack("V", $crc);
        $fr .= pack("V", $c_len);
        $fr .= pack("V", $unc_len);
        $this->datasec[] = $fr;
        $new_offset = strlen(implode("", $this->datasec));
        $cdrec = "PK\1\2";
        $cdrec .= "\0\0";
        $cdrec .= "\n\0";
        $cdrec .= "\0\0";
        $cdrec .= "\0\0";
        $cdrec .= "\0\0\0\0";
        $cdrec .= pack("V", 0);
        $cdrec .= pack("V", 0);
        $cdrec .= pack("V", 0);
        $cdrec .= pack("v", strlen($name));
        $cdrec .= pack("v", 0);
        $cdrec .= pack("v", 0);
        $cdrec .= pack("v", 0);
        $cdrec .= pack("v", 0);
        $ext = "\0\0\20\0";
        $ext = "����";
        $cdrec .= pack("V", 16);
        $cdrec .= pack("V", $this->old_offset);
        $this->old_offset = $new_offset;
        $cdrec .= $name;
        $this->ctrl_dir[] = $cdrec;
    }
    public function addFile($data, $name, $time = 0)
    {
        $name = str_replace("\\", "/", $name);
        $dtime = dechex($this->unix2DosTime($time));
        $hexdtime = "\\x" . $dtime[6] . $dtime[7] . "\\x" . $dtime[4] . $dtime[5] . "\\x" . $dtime[2] . $dtime[3] . "\\x" . $dtime[0] . $dtime[1];
        eval("\$hexdtime = \"" . $hexdtime . "\";");
        $fr = "PK\3\4";
        $fr .= "\24\0";
        $fr .= "\0\0";
        $fr .= "\10\0";
        $fr .= $hexdtime;
        $unc_len = strlen($data);
        $crc = crc32($data);
        $zdata = gzcompress($data);
        $zdata = substr(substr($zdata, 0, strlen($zdata) - 4), 2);
        $c_len = strlen($zdata);
        $fr .= pack("V", $crc);
        $fr .= pack("V", $c_len);
        $fr .= pack("V", $unc_len);
        $fr .= pack("v", strlen($name));
        $fr .= pack("v", 0);
        $fr .= $name;
        $fr .= $zdata;
        $fr .= pack("V", $crc);
        $fr .= pack("V", $c_len);
        $fr .= pack("V", $unc_len);
        $this->datasec[] = $fr;
        $cdrec = "PK\1\2";
        $cdrec .= "\0\0";
        $cdrec .= "\24\0";
        $cdrec .= "\0\0";
        $cdrec .= "\10\0";
        $cdrec .= $hexdtime;
        $cdrec .= pack("V", $crc);
        $cdrec .= pack("V", $c_len);
        $cdrec .= pack("V", $unc_len);
        $cdrec .= pack("v", strlen($name));
        $cdrec .= pack("v", 0);
        $cdrec .= pack("v", 0);
        $cdrec .= pack("v", 0);
        $cdrec .= pack("v", 0);
        $cdrec .= pack("V", 32);
        $cdrec .= pack("V", $this->old_offset);
        $this->old_offset += strlen($fr);
        $cdrec .= $name;
        $this->ctrl_dir[] = $cdrec;
    }
    public function file()
    {
        $data = implode("", $this->datasec);
        $ctrldir = implode("", $this->ctrl_dir);
        return $data . $ctrldir . $this->eof_ctrl_dir . pack("v", sizeof($this->ctrl_dir)) . pack("v", sizeof($this->ctrl_dir)) . pack("V", strlen($ctrldir)) . pack("V", strlen($data)) . "\0\0";
    }
    public function addFiles($files)
    {
        foreach ($files as $file) {
            if (is_file($file)) {
                $data = implode("", file($file));
                $this->addFile($data, $file);
            }
        }
    }
    public function output($file)
    {
        $fp = fopen($file, "w");
        fwrite($fp, $this->file());
        fclose($fp);
    }
}

?>