<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class Barcode39
{
    /**
     * Barcode code
     *
     * @var array $_code
     */
    private $_code = [];
    /**
     * Code 39 matrix
     *
     * @var array $_codes_39
     */
    private $_codes_39 = ["32" => 274288222, "36" => -409407218, "37" => -132960086, "42" => 1101668190, "43" => 1000658090, "45" => 1001668191, "46" => -1418379682, "47" => -408407318, "48" => -31949986, "49" => 1742959439, "50" => -859339953, "51" => 1015579470, "52" => -31959985, "53" => 1842959438, "54" => -759339954, "55" => -131949985, "56" => 1742969438, "57" => -859329954, "65" => -1142942449, "66" => 549725455, "67" => -1870322418, "68" => 1377105423, "69" => -1042942450, "70" => 649725454, "71" => 1277115423, "72" => -1142932450, "73" => 549735454, "74" => 1377115422, "75" => -1141942549, "76" => 550725355, "77" => -1869322518, "78" => 1378105323, "79" => -1041942550, "80" => 650725354, "81" => 1278115323, "82" => -1141932550, "83" => 550735354, "84" => 1378115322, "85" => -1418389681, "86" => 274278223, "87" => -2145769650, "88" => 1101658191, "89" => -1318389682, "90" => 374278222];
    /**
     * Width of wide bars in barcode (should be 3:1)
     *
     * @var int $barcode_bar_thick
     */
    public $barcode_bar_thick = 3;
    /**
     * Width of thin bars in barcode (should be 3:1)
     *
     * @var int $barcode_bar_thin
     */
    public $barcode_bar_thin = 1;
    /**
     * Barcode background color (RGB)
     *
     * @var array $barcode_bg_rgb
     */
    public $barcode_bg_rgb = [255, 255, 255];
    /**
     * Barcode height
     *
     * @var int $barcode_height
     */
    public $barcode_height = 90;
    /**
     * Barcode padding
     *
     * @var int $barcode_padding
     */
    public $barcode_padding = 5;
    /**
     * Use barcode text flag
     *
     * @var bool $barcode_text
     */
    public $barcode_text = true;
    /**
     * Barcode text size
     *
     * @var int $barcode_text_size
     */
    public $barcode_text_size = 3;
    /**
     * Use dynamic barcode width (will auto set width)
     *
     * @var bool $barcode_use_dynamic_width
     */
    public $barcode_use_dynamic_width = true;
    /**
     * Barcode width (if not using dynamic width)
     *
     * @var int $barcode_width
     */
    public $barcode_width = 400;
    public $barcodes = NULL;
    public $pricing = NULL;
    public $company = NULL;
    const f2B = "11";
    const f2W = "00";
    const f2b = "10";
    const f2w = "01";
    public function __construct($code = NULL, $company = NULL, $pricing, $width = NULL, $barcodes = NULL, $height = NULL)
    {
        $this->barcodes = $barcodes;
        $this->pricing = $pricing;
        $this->company = $company;
        if ($width) {
            $this->barcode_width = $width;
        }
        if ($height) {
            $this->barcode_height = $height;
        }
        $code = (string) strtoupper($code);
        $i = 0;
        while (isset($code[$i])) {
            $this->_code[] = $code[$i++];
        }
        array_unshift($this->_code, "*");
        array_push($this->_code, "*");
    }
    public function draw($filename = NULL)
    {
        
        $bars = [];
        $pos = $this->barcode_padding;
        $barcode_string = NULL;
        $i = 0;
        foreach ($this->_code as $k => $v) {
            if (isset($this->_codes_39[ord($v)])) {
                $code = ($i ? "01" : NULL) . $this->_codes_39[ord($v)];
                if ($code) {
                    $barcode_string .= " " . $v;
                    $w = 0;
                    $f2 = $fill = NULL;
                    for ($j = 0; $j < strlen($code); $j++) {
                        $f2 .= (string) $code[$j];
                        if (strlen($f2) == 2) {
                            $fill = $f2 == "11" || $f2 == "10" ? "_000" : "_fff";
                            $w = $f2 == "11" || $f2 == "00" ? $this->barcode_bar_thick : $this->barcode_bar_thin;
                            if ($w && $fill) {
                                $bars[] = [$pos, $this->barcode_padding, $pos - 1 + $w, $this->barcode_height - $this->barcode_padding - 1, $fill];
                                $pos += $w;
                            }
                            $f2 = $fill = NULL;
                            $w = 0;
                        }
                    }
                }
                $i++;
            } else {
                unset($this->_code[$k]);
            }
        }
        if (!count($bars)) {
            return false;
        }
        $bc_w = $this->barcode_use_dynamic_width ? $pos + $this->barcode_padding : $this->barcode_width;
        if (!$this->barcode_use_dynamic_width && $this->barcode_width < $pos) {
            return false;
        }
        $img = imagecreate($bc_w, $this->barcode_height);
        $_000 = imagecolorallocate($img, 0, 0, 0);
        $_fff = imagecolorallocate($img, 255, 255, 255);
        $_bg = imagecolorallocate($img, $this->barcode_bg_rgb[0], $this->barcode_bg_rgb[1], $this->barcode_bg_rgb[2]);
        imagefilledrectangle($img, 0, 0, $bc_w, $this->barcode_height, $_bg);
        for ($i = 0; $i < count($bars); $i++) {
            imagefilledrectangle($img, $bars[$i][0], $bars[$i][1] + 10, $bars[$i][2], $bars[$i][3], ${$bars}[$i][4]);
        }
        if ($this->barcode_text) {
            $barcode_text_h = 10 + $this->barcode_padding;
            imagefilledrectangle($img, $this->barcode_padding, $this->barcode_height - $this->barcode_padding - $barcode_text_h, $bc_w - $this->barcode_padding, $this->barcode_height - $this->barcode_padding, $_fff);
            $font_size = $this->barcode_text_size;
            $font_w = imagefontwidth($font_size);
            $font_h = imagefontheight($font_size);
            $txt_w = $font_w * strlen($barcode_string);
            $pos_center = ceil(($bc_w - $this->barcode_padding - $txt_w) / 2);
            $txt_color = imagecolorallocate($img, 0, 255, 255);
            imagestring($img, $font_size, 5, 0, $this->company, $_000);
            imagestring($img, $font_size, 5, $this->barcode_height - $barcode_text_h - 2, $this->barcodes, $_000);
            if ($this->barcode_height == 55) {
                $rr = 0;
            } else {
                if ($this->barcode_height == 65) {
                    $rr = 2;
                } else {
                    $rr = 5;
                }
            }
            imagestring($img, $font_size, $bc_w - strlen($this->pricing) * 7 - $rr, $this->barcode_height - $barcode_text_h - 2, $this->pricing, $_000);
        }
        if ($filename) {
            imagegif($img, $filename);
        } else {
            header("Content-type: image/gif");
            imagegif($img);
        }
        imagedestroy($img);
        return true;
    }
}

?>