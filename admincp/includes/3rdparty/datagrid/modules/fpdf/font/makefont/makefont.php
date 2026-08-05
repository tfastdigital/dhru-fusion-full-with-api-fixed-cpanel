<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

function ReadMap($enc)
{
    $file = dirname(__FILE__) . "/" . strtolower($enc) . ".map";
    $a = file($file);
    if (empty($a)) {
        exit("<B>Error:</B> encoding not found: " . $enc);
    }
    $cc2gn = [];
    foreach ($a as $l) {
        if ($l[0] == "!") {
            $e = preg_split("/[ \\t]+/", rtrim($l));
            $cc = hexdec(substr($e[0], 1));
            $gn = $e[2];
            $cc2gn[$cc] = $gn;
        }
    }
    for ($i = 0; $i <= 255; $i++) {
        if (!isset($cc2gn[$i])) {
            $cc2gn[$i] = ".notdef";
        }
    }
    return $cc2gn;
}
function ReadAFM($file, &$map)
{
    $a = file($file);
    if (empty($a)) {
        exit("File not found");
    }
    $widths = [];
    $fm = [];
    $fix = ["Edot" => "Edotaccent", "edot" => "edotaccent", "Idot" => "Idotaccent", "Zdot" => "Zdotaccent", "zdot" => "zdotaccent", "Odblacute" => "Ohungarumlaut", "odblacute" => "ohungarumlaut", "Udblacute" => "Uhungarumlaut", "udblacute" => "uhungarumlaut", "Gcedilla" => "Gcommaaccent", "gcedilla" => "gcommaaccent", "Kcedilla" => "Kcommaaccent", "kcedilla" => "kcommaaccent", "Lcedilla" => "Lcommaaccent", "lcedilla" => "lcommaaccent", "Ncedilla" => "Ncommaaccent", "ncedilla" => "ncommaaccent", "Rcedilla" => "Rcommaaccent", "rcedilla" => "rcommaaccent", "Scedilla" => "Scommaaccent", "scedilla" => "scommaaccent", "Tcedilla" => "Tcommaaccent", "tcedilla" => "tcommaaccent", "Dslash" => "Dcroat", "dslash" => "dcroat", "Dmacron" => "Dcroat", "dmacron" => "dcroat", "combininggraveaccent" => "gravecomb", "combininghookabove" => "hookabovecomb", "combiningtildeaccent" => "tildecomb", "combiningacuteaccent" => "acutecomb", "combiningdotbelow" => "dotbelowcomb", "dongsign" => "dong"];
    foreach ($a as $l) {
        $e = explode(" ", rtrim($l));
        if (count($e) >= 2) {
            list($code, $param) = $e;
            if ($code == "C") {
                $cc = (int) $e[1];
                list($w, $gn) = $e;
                if (substr($gn, -4) == "20AC") {
                    $gn = "Euro";
                }
                if (isset($fix[$gn])) {
                    foreach ($map as $c => $n) {
                        if ($n == $fix[$gn]) {
                            $map[$c] = $gn;
                        }
                    }
                }
                if (empty($map)) {
                    $widths[$cc] = $w;
                } else {
                    $widths[$gn] = $w;
                    if ($gn == "X") {
                        $fm["CapXHeight"] = $e[13];
                    }
                }
                if ($gn == ".notdef") {
                    $fm["MissingWidth"] = $w;
                }
            } else {
                if ($code == "FontName") {
                    $fm["FontName"] = $param;
                } else {
                    if ($code == "Weight") {
                        $fm["Weight"] = $param;
                    } else {
                        if ($code == "ItalicAngle") {
                            $fm["ItalicAngle"] = (double) $param;
                        } else {
                            if ($code == "Ascender") {
                                $fm["Ascender"] = (int) $param;
                            } else {
                                if ($code == "Descender") {
                                    $fm["Descender"] = (int) $param;
                                } else {
                                    if ($code == "UnderlineThickness") {
                                        $fm["UnderlineThickness"] = (int) $param;
                                    } else {
                                        if ($code == "UnderlinePosition") {
                                            $fm["UnderlinePosition"] = (int) $param;
                                        } else {
                                            if ($code == "IsFixedPitch") {
                                                $fm["IsFixedPitch"] = $param == "true";
                                            } else {
                                                if ($code == "FontBBox") {
                                                    $fm["FontBBox"] = [$e[1], $e[2], $e[3], $e[4]];
                                                } else {
                                                    if ($code == "CapHeight") {
                                                        $fm["CapHeight"] = (int) $param;
                                                    } else {
                                                        if ($code == "StdVW") {
                                                            $fm["StdVW"] = (int) $param;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
    if (!isset($fm["FontName"])) {
        exit("FontName not found");
    }
    if (!empty($map)) {
        if (!isset($widths[".notdef"])) {
            $widths[".notdef"] = 600;
        }
        if (!isset($widths["Delta"]) && isset($widths["increment"])) {
            $widths["Delta"] = $widths["increment"];
        }
        for ($i = 0; $i <= 255; $i++) {
            if (!isset($widths[$map[$i]])) {
                echo "<B>Warning:</B> character " . $map[$i] . " is missing<BR>";
                $widths[$i] = $widths[".notdef"];
            } else {
                $widths[$i] = $widths[$map[$i]];
            }
        }
    }
    $fm["Widths"] = $widths;
    return $fm;
}
function MakeFontDescriptor($fm, $symbolic)
{
    $asc = isset($fm["Ascender"]) ? $fm["Ascender"] : 1000;
    $fd = "array('Ascent'=>" . $asc;
    $desc = isset($fm["Descender"]) ? $fm["Descender"] : -200;
    $fd .= ",'Descent'=>" . $desc;
    if (isset($fm["CapHeight"])) {
        $ch = $fm["CapHeight"];
    } else {
        if (isset($fm["CapXHeight"])) {
            $ch = $fm["CapXHeight"];
        } else {
            $ch = $asc;
        }
    }
    $fd .= ",'CapHeight'=>" . $ch;
    $flags = 0;
    if (isset($fm["IsFixedPitch"]) && $fm["IsFixedPitch"]) {
        $flags += 1;
    }
    if ($symbolic) {
        $flags += 4;
    }
    if (!$symbolic) {
        $flags += 32;
    }
    if (isset($fm["ItalicAngle"]) && $fm["ItalicAngle"] != 0) {
        $flags += 64;
    }
    $fd .= ",'Flags'=>" . $flags;
    if (isset($fm["FontBBox"])) {
        $fbb = $fm["FontBBox"];
    } else {
        $fbb = [0, $des - 100, 1000, $asc + 100];
    }
    $fd .= ",'FontBBox'=>'[" . $fbb[0] . " " . $fbb[1] . " " . $fbb[2] . " " . $fbb[3] . "]'";
    $ia = isset($fm["ItalicAngle"]) ? $fm["ItalicAngle"] : 0;
    $fd .= ",'ItalicAngle'=>" . $ia;
    if (isset($fm["StdVW"])) {
        $stemv = $fm["StdVW"];
    } else {
        if (isset($fm["Weight"]) && preg_match("/(bold|black)/i", $fm["Weight"])) {
            $stemv = 120;
        } else {
            $stemv = 70;
        }
    }
    $fd .= ",'StemV'=>" . $stemv;
    if (isset($fm["MissingWidth"])) {
        $fd .= ",'MissingWidth'=>" . $fm["MissingWidth"];
    }
    $fd .= ")";
    return $fd;
}
function MakeWidthArray($fm)
{
    $s = "array(\n\t";
    $cw = $fm["Widths"];
    for ($i = 0; $i <= 255; $i++) {
        if (chr($i) == "'") {
            $s .= "'\\''";
        } else {
            if (chr($i) == "\\") {
                $s .= "'\\\\'";
            } else {
                if (32 <= $i && $i <= 126) {
                    $s .= "'" . chr($i) . "'";
                } else {
                    $s .= "chr(" . $i . ")";
                }
            }
        }
        $s .= "=>" . $fm["Widths"][$i];
        if ($i < 255) {
            $s .= ",";
        }
        if (($i + 1) % 22 == 0) {
            $s .= "\n\t";
        }
    }
    $s .= ")";
    return $s;
}
function MakeFontEncoding($map)
{
    $ref = readmap("cp1252");
    $s = "";
    $last = 0;
    for ($i = 32; $i <= 255; $i++) {
        if ($map[$i] != $ref[$i]) {
            if ($i != $last + 1) {
                $s .= $i . " ";
            }
            $last = $i;
            $s .= "/" . $map[$i] . " ";
        }
    }
    return rtrim($s);
}
function SaveToFile($file, $s, $mode = "t")
{
    $f = fopen($file, "w" . $mode);
    if (!$f) {
        exit("Can't write to file " . $file);
    }
    fwrite($f, $s, strlen($s));
    fclose($f);
}
function ReadShort($f)
{
    $a = unpack("n1n", fread($f, 2));
    return $a["n"];
}
function ReadLong($f)
{
    $a = unpack("N1N", fread($f, 4));
    return $a["N"];
}
function CheckTTF($file)
{
    $f = fopen($file, "rb");
    if (!$f) {
        exit("<B>Error:</B> Can't open " . $file);
    }
    fseek($f, 4, SEEK_CUR);
    $nb = readshort($f);
    fseek($f, 6, SEEK_CUR);
    $found = false;
    $i = 0;
    while ($i < $nb) {
        if (fread($f, 4) == "OS/2") {
            $found = true;
        } else {
            fseek($f, 12, SEEK_CUR);
            $i++;
        }
    }
    if (!$found) {
        fclose($f);
    } else {
        fseek($f, 4, SEEK_CUR);
        $offset = readlong($f);
        fseek($f, $offset, SEEK_SET);
        fseek($f, 8, SEEK_CUR);
        $fsType = readshort($f);
        $rl = ($fsType & 2) != 0;
        $pp = ($fsType & 4) != 0;
        $e = ($fsType & 8) != 0;
        fclose($f);
        if ($rl && !$pp && !$e) {
            echo "<B>Warning:</B> font license does not allow embedding";
        }
    }
}
function MakeFont($fontfile, $afmfile, $enc = "cp1252", $patch = [], $type = "TrueType")
{
    set_magic_quotes_runtime(0);
    ini_set("auto_detect_line_endings", "1");
    if ($enc) {
        $map = readmap($enc);
        foreach ($patch as $cc => $gn) {
            $map[$cc] = $gn;
        }
    } else {
        $map = [];
    }
    if (!file_exists($afmfile)) {
        exit("<B>Error:</B> AFM file not found: " . $afmfile);
    }
    $fm = readafm($afmfile, $map);
    if ($enc) {
        $diff = makefontencoding($map);
    } else {
        $diff = "";
    }
    $fd = makefontdescriptor($fm, empty($map));
    if ($fontfile) {
        $ext = strtolower(substr($fontfile, -3));
        if ($ext == "ttf") {
            $type = "TrueType";
        } else {
            if ($ext == "pfb") {
                $type = "Type1";
            } else {
                exit("<B>Error:</B> unrecognized font file extension: " . $ext);
            }
        }
    } else {
        if ($type != "TrueType" && $type != "Type1") {
            exit("<B>Error:</B> incorrect font type: " . $type);
        }
    }
    $s = "<?php\n";
    $s .= "\$type='" . $type . "';\n";
    $s .= "\$name='" . $fm["FontName"] . "';\n";
    $s .= "\$desc=" . $fd . ";\n";
    if (!isset($fm["UnderlinePosition"])) {
        $fm["UnderlinePosition"] = -100;
    }
    if (!isset($fm["UnderlineThickness"])) {
        $fm["UnderlineThickness"] = 50;
    }
    $s .= "\$up=" . $fm["UnderlinePosition"] . ";\n";
    $s .= "\$ut=" . $fm["UnderlineThickness"] . ";\n";
    $w = makewidtharray($fm);
    $s .= "\$cw=" . $w . ";\n";
    $s .= "\$enc='" . $enc . "';\n";
    $s .= "\$diff='" . $diff . "';\n";
    $basename = substr(basename($afmfile), 0, -4);
    if ($fontfile) {
        if (!file_exists($fontfile)) {
            exit("<B>Error:</B> font file not found: " . $fontfile);
        }
        if ($type == "TrueType") {
            checkttf($fontfile);
        }
        $f = fopen($fontfile, "rb");
        if (!$f) {
            exit("<B>Error:</B> Can't open " . $fontfile);
        }
        $file = fread($f, filesize($fontfile));
        fclose($f);
        if ($type == "Type1") {
            $header = ord($file[0]) == 128;
            if ($header) {
                $file = substr($file, 6);
            }
            $pos = strpos($file, "eexec");
            if (!$pos) {
                exit("<B>Error:</B> font file does not seem to be valid Type1");
            }
            $size1 = $pos + 6;
            if ($header && ord($file[$size1]) == 128) {
                $file = substr($file, 0, $size1) . substr($file, $size1 + 6);
            }
            $pos = strpos($file, "00000000");
            if (!$pos) {
                exit("<B>Error:</B> font file does not seem to be valid Type1");
            }
            $size2 = $pos - $size1;
            $file = substr($file, 0, $size1 + $size2);
        }
        if (function_exists("gzcompress")) {
            $cmp = $basename . ".z";
            savetofile($cmp, gzcompress($file), "b");
            $s .= "\$file='" . $cmp . "';\n";
            echo "Font file compressed (" . $cmp . ")<BR>";
        } else {
            $s .= "\$file='" . basename($fontfile) . "';\n";
            echo "<B>Notice:</B> font file could not be compressed (zlib extension not available)<BR>";
        }
        if ($type == "Type1") {
            $s .= "\$size1=" . $size1 . ";\n";
            $s .= "\$size2=" . $size2 . ";\n";
        } else {
            $s .= "\$originalsize=" . filesize($fontfile) . ";\n";
        }
    } else {
        $s .= "\$file='';\n";
    }
    $s .= "?>\n";
    savetofile($basename . ".php", $s);
    echo "Font definition file generated (" . $basename . ".php" . ")<BR>";
}

?>