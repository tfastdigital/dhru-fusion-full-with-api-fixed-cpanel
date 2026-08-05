<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

define("E_NO_ERROR", -1);
define("E_NOOPEN", 0);
define("E_NOTZIP", 1);
define("E_UNEXPECTED_END", 2);
define("E_EMPTY", 3);
define("E_DATA_ERROR", 4);
define("E_FILE_ENCRYPTED", 5);
define("E_CRC_MISMATCH", 6);
define("E_METHOD_NOT_SUPPORTED", 7);
define("E_INFLATE_ERROR", 8);
define("E_BZIP_ERROR", 9);
define("E_NO_FILE", 10);
define("ZIPOPT_FILE_OUTPUT", 1);
define("ZIPOPT_OVERWRITE_EXISTING", 2);
define("ZIPOPT_OUTPUT_PATH", 3);
define("S_FILE_HEADER", 1);
define("S_FILE_HEADER_DATA", 2);
define("S_FILE_FILENAME", 3);
define("S_FILE_EXTRA", 4);
define("S_FILE_DATA", 5);
define("S_DATA_DESCRIPTOR", 6);
define("S_FILE_PROCESSED", 7);
define("S_CENTRAL_DIRECTORY", 8);
define("S_CD_FILENAME", 9);
define("S_CD_EXTRA", 10);
define("S_CD_FCOMMENT", 11);
define("S_END_CENTRAL", 12);
define("S_EOF", 13);
define("S_ERROR", 14);
/**
 * A stream based PHP 4 class for reading the contents of a ZIP Archive.<br />
 * Supports no compression, deflate, and bzip storage modes.<br />
 * Inspiration derived from the SimpleUnzip class contributed to phpMyAdmin by Holger Boskugel <vbwebprofi@gmx.de>
 *
 * @version    1.0
 * @author     Drew Phillips <drew@drew-phillips.com>
 * @package    PHPUnzip
 * @subpackage Unzip
 * @uses       ZipFileEntry
 *
 */
class PHPUnzip
{
    /**
     * Indicates if a zip file was successfully opened for reading
     *
     * @var boolean
     */
    public $open = NULL;
    /**
     * Array of {@link ZipFileEntry} objects representing the files and directories in the archive
     *
     * @var array
     */
    public $files = NULL;
    /**
     * The ZIP file comment text, if any
     *
     * @var string
     */
    public $comment = NULL;
    /**
     * The error encountered while parsing the file
     *
     * @var int
     */
    public $error = NULL;
    /**
     * The error message associated with the error
     *
     * @var unknown_type
     */
    public $error_str = NULL;
    public $createdDirectories = NULL;
    public $createdFiles = NULL;
    /**
     * The ZIP file to open
     *
     * @access private
     * @var string
     */
    public $zip_file = NULL;
    /**
     * File pointer to the current location in the zip file
     *
     * @access private
     * @var resource
     */
    public $fp = NULL;
    /**
     * The current state of file processing
     *
     * @access private
     * @var int
     */
    public $state = NULL;
    /**
     * If in a break state and should break from the current operation. Means an error was encountered
     *
     * @access private
     * @var boolean
     */
    public $break = NULL;
    /**
     * Minimum version required to extract
     *
     * @access private
     * @var unknown_type
     */
    public $min_version = NULL;
    /**
     * Output contents to file or leave in file object
     *
     * @access private
     * @var boolean
     */
    public $read_to_file = NULL;
    /**
     * Overwrite existing files
     *
     * @var boolean
     */
    public $overwrite_existing_files = NULL;
    /**
     * Where to output the files
     *
     * @var string
     */
    public $output_file_path = NULL;
    /**
     * PKZip encryption keys
     *
     * @access private
     * @var unknown_type
     */
    public $key = NULL;
    /**
     * CRC polynomials
     *
     * @access private
     * @var array
     */
    public $crc_table = NULL;
    public function PHPUnzip()
    {
        $this->open = false;
        $this->files = [];
        $this->comment = "";
        $this->break = false;
        $this->error = E_NO_ERROR;
        $this->error_str = "";
        $this->key = [];
        $this->read_to_file = false;
        $this->overwrite_existing_files = false;
        $this->output_file_path = "./";
        $this->createdDirectories = [];
        $this->createdFiles = [];
    }
    public function SetOption($long_option, $value)
    {
        switch ($long_option) {
            case ZIPOPT_READSIZE:
                $this->read_chunk_size = $value;
                break;
            case ZIPOPT_FILE_OUTPUT:
                $this->read_to_file = $value;
                break;
            case ZIPOPT_OVERWRITE_EXISTING:
                $this->overwrite_existing_files = $value;
                break;
            case ZIPOPT_OUTPUT_PATH:
                $this->output_file_path = $value;
                return true;
                break;
            default:
                return false;
        }
    }
    public function Open($file)
    {
        $this->fp = fopen($file, "rb");
        if (!$this->fp) {
            trigger_error("Failed to open file \"" . $file . "\"", 512);
            $this->open = false;
            $this->error = E_NOOPEN;
            $this->error_str = "Failed to open file";
            return false;
        }
        $this->open = true;
        return true;
    }
    public function Read()
    {
        while (!$this->open) {
            $this->state = S_FILE_HEADER;
            $p =& $this->fp;
            $file = NULL;
            $first_read = true;
            while (!feof($p) && $this->state != S_EOF) {
                switch ($this->state) {
                    case S_FILE_HEADER:
                        $header = fread($p, 4);
                        $this->check_end($p, 4);
                        if (!$this->break) {
                            if (strcmp($header, "PK\3\4") == 0) {
                                $this->state = S_FILE_HEADER_DATA;
                            } else {
                                if (strcmp($header, "PK\1\2") == 0) {
                                    $this->state = S_CENTRAL_DIRECTORY;
                                } else {
                                    if (strcmp($header, "PK\5\6") == 0) {
                                        $this->state = S_END_CENTRAL;
                                    } else {
                                        if ($first_read) {
                                            $this->error = E_NOTZIP;
                                            $this->error_str = "File does not appear to be a zipfile";
                                        } else {
                                            $this->error = E_DATA_ERROR;
                                            $this->error_str = "Unexpected data encountered while reading file";
                                        }
                                        $this->state = S_EOF;
                                    }
                                }
                            }
                            $first_read = false;
                            $file = new ZipFileEntry();
                        }
                        break;
                    case S_FILE_HEADER_DATA:
                        $data = fread($p, 26);
                        $this->check_end($data, 26);
                        if (!$this->break) {
                            $fields = unpack("vVER/vGPF/vCM/vMTIME/vMDATE/VCRC/VCSIZE/VUSIZE/vFNLEN/vEFLEN", $data);
                            $file->crc = sprintf("%u", $fields["CRC"]);
                            $file->time = mktime($fields["MTIME"] >> 11 & 15, $fields["MTIME"] >> 5 & 31, $fields["MTIME"] & 15, $fields["MDATE"] >> 5 & 15, $fields["MDATE"] & 31, ($fields["MDATE"] >> 9 & 127) + 1980);
                            $file->size = $fields["USIZE"];
                            $file->compressed_size = $fields["CSIZE"];
                            $this->min_version = $fields["VER"];
                            if ($fields["USIZE"] == 0) {
                                $file->compression_ratio = 0;
                            } else {
                                $file->compression_ratio = number_format($fields["CSIZE"] / $fields["USIZE"] * 100, 2);
                            }
                            $this->state = S_FILE_FILENAME;
                        }
                        break;
                    case S_FILE_FILENAME:
                        $fname = fread($p, $fields["FNLEN"]);
                        $this->check_end($fname, $fields["FNLEN"]);
                        if (!$this->break) {
                            $file->name = basename($fname);
                            $file->path = dirname($fname) == "." || dirname($fname) == "" ? "" : dirname($fname);
                            $this->state = S_FILE_EXTRA;
                        }
                        break;
                    case S_FILE_EXTRA:
                        if (0 < $fields["EFLEN"]) {
                            $extra = fread($p, $fields["EFLEN"]);
                            $this->check_end($extra, $fields["EFLEN"]);
                            if (!$this->break) {
                            }
                        } else {
                            $extra = "";
                        }
                        $this->state = S_FILE_DATA;
                        break;
                    case S_FILE_DATA:
                        if (0 < $fields["CSIZE"]) {
                            $file->data = fread($p, $fields["CSIZE"]);
                            $this->check_end($file->data, $fields["CSIZE"]);
                            if ($fields["GPF"] & 1) {
                                $file->error = E_FILE_ENCRYPTED;
                                $tmp = substr($file->data, 0, 12);
                                for ($i = 0; $i < 12; $i++) {
                                    echo dechex(ord($tmp[$i])) . " ";
                                }
                                echo "encrypted buffer\n";
                                $this->InitPassword("password");
                                $this->PKEncDecryptHeader(substr($file->data, 0, 12));
                                echo dechex($file->crc + 0) . " file crc\n";
                                echo "\n";
                                $file->data = substr($file->data, 12);
                                for ($i = 0; $i < strlen($file->data); $i++) {
                                    $c = $file->data[$i];
                                    $tmp = ord($c) ^ $this->PKEncDecryptByte();
                                    $this->PKEncUpdateKeys($tmp);
                                    $file->data[$i] = chr($tmp);
                                }
                                echo $file->data;
                                exit;
                            }
                            if ($fields["CM"] == 8) {
                                if (extension_loaded("zlib")) {
                                    $file->data = gzinflate($file->data);
                                    if ($file->data === false) {
                                        $file->data = NULL;
                                        $file->error = E_INFLATE_ERROR;
                                    }
                                } else {
                                    $file->error = E_METHOD_NOT_SUPPORTED;
                                }
                            } else {
                                if ($fields["CM"] == 12) {
                                    if (extension_loaded("bz2")) {
                                        $file->data = bzdecompress($file->data);
                                        if (!is_string($file->data)) {
                                            $file->data == NULL;
                                            $file->error = E_BZIP_ERROR;
                                        }
                                    } else {
                                        $file->error = E_METHOD_NOT_SUPPORTED;
                                    }
                                }
                            }
                            if ($file->error == E_NO_ERROR && sprintf("%u", crc32($file->data)) != sprintf("%u", $fields["CRC"])) {
                                $file->error = E_CRC_MISMATCH;
                            }
                            if ($this->read_to_file) {
                                $this->WriteDataToFile($file->data, $file->name, $file->path, $file->time);
                                $file->data = NULL;
                            }
                        } else {
                            $file->data = "";
                        }
                        if (!$this->break) {
                            $this->state = S_DATA_DESCRIPTOR;
                        }
                        break;
                    case S_DATA_DESCRIPTOR:
                        if ($fields["GPF"] & true) {
                            $desc_data = fread($p, 4);
                            $this->check_end($desc_data, 4);
                            if (!$this->break) {
                                if (strcmp($desc_data, "PK\7\10") == 0) {
                                    $desc_data = fread($p, 12);
                                    $this->check_end($desc_data, 12);
                                    if (!$this->break) {
                                    }
                                } else {
                                    $desc_data .= fread($p, 8);
                                    $this->check_end($desc_data, 8);
                                    if (!$this->break) {
                                    }
                                }
                                $desc_fields = unpack("VCRC/VCSIZE/VUSIZE", $desc_data);
                            }
                        } else {
                            $desc_data = "";
                        }
                        $this->state = S_FILE_PROCESSED;
                        break;
                    case S_FILE_PROCESSED:
                        $this->files[] = $file;
                        $this->state = S_FILE_HEADER;
                        break;
                    case S_CENTRAL_DIRECTORY:
                        $cd_fields = fread($p, 42);
                        $this->check_end($cd_fields, 42);
                        if (!$this->break) {
                            $cd_fields = unpack("vVER/vVEXT/vGPF/vCM/vMTIME/vMDATE/VCRC/VCSIZE/VUSIZE/vFNLEN/vEFLEN/vFCLEN/vDSTART/vFATTR/vEATTR/VOFFSET", $cd_fields);
                            if (0 < $cd_fields["FNLEN"]) {
                                $tmp = fread($p, $cd_fields["FNLEN"]);
                                $this->check_end($tmp, $cd_fields["FNLEN"]);
                                if (!$this->break) {
                                }
                            }
                            if (0 < $cd_fields["EFLEN"]) {
                                $tmp = fread($p, $cd_fields["EFLEN"]);
                                $this->check_end($tmp, $cd_fields["EFLEN"]);
                                if (!$this->break) {
                                }
                            }
                            if (0 < $cd_fields["FCLEN"]) {
                                $tmp = fread($p, $cd_fields["FCLEN"]);
                                $this->check_end($tmp, $cd_fields["FCLEN"]);
                                if (!$this->break) {
                                }
                            }
                            $this->state = S_FILE_HEADER;
                        }
                        break;
                    case S_END_CENTRAL:
                        $ecd_fields = fread($p, 18);
                        $this->check_end($ecd_fields, 18);
                        if (!$this->break) {
                            $ecd_fields = unpack("vDNUM/vDNUMSCD/vNUMENTRIES/vTNUMENTRIES/VCDSIZE/VOFFSET/vCLEN", $ecd_fields);
                            if (0 < $ecd_fields["CLEN"]) {
                                $this->comment = fread($p, $ecd_fields["CLEN"]);
                            }
                            $this->state = S_EOF;
                        }
                        break;
                }
            }
            fclose($this->fp);
            if ($this->error != E_NO_ERROR) {
                return false;
            }
            return true;
        }
        $this->error = E_NO_FILE;
        $this->error = "No ZIP file has been opened";
        return false;
    }
    public function check_end($str, $length)
    {
        if (strlen($str) < $length) {
            $this->error = E_UNEXPECTED_END;
            $this->error_str = "Unexpected end of file";
            $this->state = S_EOF;
            $this->break = true;
        }
    }
    public function WriteDataToFile($data, $name, $path, $time = NULL)
    {
        if (substr($this->output_file_path, -1) != "/" && $this->output_file_path != "") {
            $this->output_file_path .= "/";
        }
        if (!is_writeable($this->output_file_path)) {
            trigger_error("Unable to write to output file path \"" . $this->output_file_path . "\"", 512);
            return false;
        }
        $directory_string = "";
        if ($path != "") {
            clearstatcache();
            $directories = explode("/", $path);
            foreach ($directories as $directory) {
                $directory_string .= $directory;
                if (!file_exists($this->output_file_path . $directory_string) && !mkdir($this->output_file_path . $directory_string, 509)) {
                    trigger_error("Unable to create directory \"" . $this->output_file_path . $directory_string . "\"", 512);
                    return false;
                }
                array_push($this->createdDirectories, $directory_string);
                $directory_string .= "/";
            }
        }
        $filename = $this->output_file_path . $directory_string . $name;
        if (file_exists($filename) && !$this->overwrite_existing_files) {
            trigger_error("File \"" . $filename . "\" already exists", 512);
            return false;
        }
        $fp = fopen($filename, "w+b");
        if (!$fp) {
            trigger_error("Failed to open \"" . $this->output_file_path . $directory_string . "\" for writing", 512);
            return false;
        }
        fwrite($fp, $data);
        fclose($fp);
        array_push($this->createdFiles, ["filename" => $name, "path" => $directory_string]);
        if ($time != NULL) {
            touch($filename, $time);
        }
        return true;
    }
}
/**
 * Object for a file in the ZIP archive
 *
 * @package Classes
 * @subpackage Unzip
 *
 */
class ZipFileEntry
{
    /**
     * The stored CRC32 from the archive in hex format
     *
     * @var string
     */
    public $crc = NULL;
    /**
     * The uncompressed size of the file
     *
     * @var int
     */
    public $size = NULL;
    /**
     * The compressed size of the file
     *
     * @var int
     */
    public $compressed_size = NULL;
    /**
     * The compression ratio for compressed files
     *
     * @var float
     */
    public $compression_ratio = NULL;
    /**
     * Any error encountered while processing the file
     *
     * @var int
     */
    public $error = NULL;
    /**
     * The decompressed file data or null if outputting to files
     *
     * @var string
     */
    public $data = NULL;
    /**
     * The file name
     *
     * @var string
     */
    public $name = NULL;
    /**
     * The path of the file
     *
     * @var string
     */
    public $path = NULL;
    /**
     * The file modification timestamp
     *
     * @var int
     */
    public $time = NULL;
    public function ZipFileEntry()
    {
        $this->crc = "";
        $this->size = 0;
        $this->compressed_size = 0;
        $this->compression_ratio = 0;
        $this->error = E_NO_ERROR;
        $this->data = "";
        $this->name = "";
        $this->path = "";
        $this->time = 0;
    }
}

?>