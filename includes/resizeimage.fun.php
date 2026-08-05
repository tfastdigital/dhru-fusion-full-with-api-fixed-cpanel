<?php
/*
 * @ https://EasyToYou.eu - IonCube v11 Decoder Online
 * @ PHP 7.2 & 7.3
 * @ Decoder version: 1.0.6
 * @ Release: 10/08/2022
 */

class SimpleImage
{
    public $image = NULL;
    public $image_type = NULL;
    public function load($filename)
    {
        if (!function_exists('getimagesize')) return;
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            if (function_exists('imagecreatefromjpeg'))
                $this->image = imagecreatefromjpeg($filename);
        } else {
            if ($this->image_type == IMAGETYPE_GIF) {
                if (function_exists('imagecreatefromgif'))
                    $this->image = imagecreatefromgif($filename);
            } else {
                if ($this->image_type == IMAGETYPE_PNG) {
                    if (function_exists('imagecreatefrompng'))
                        $this->image = imagecreatefrompng($filename);
                }
            }
        }
    }
    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = NULL)
    {
        if (!$this->image) return;
        if ($image_type == IMAGETYPE_JPEG) {
            if (function_exists('imagejpeg'))
                imagejpeg($this->image, $filename, $compression);
        } else {
            if ($image_type == IMAGETYPE_GIF) {
                if (function_exists('imagegif'))
                    imagegif($this->image, $filename);
            } else {
                if ($image_type == IMAGETYPE_PNG) {
                    if (function_exists('imagepng'))
                        imagepng($this->image, $filename);
                }
            }
        }
        if ($permissions != NULL) {
            chmod($filename, $permissions);
        }
    }
    public function output($image_type = IMAGETYPE_JPEG)
    {
        if (!$this->image) return;
        if ($image_type == IMAGETYPE_JPEG) {
            if (function_exists('imagejpeg'))
                imagejpeg($this->image);
        } else {
            if ($image_type == IMAGETYPE_GIF) {
                if (function_exists('imagegif'))
                    imagegif($this->image);
            } else {
                if ($image_type == IMAGETYPE_PNG) {
                    if (function_exists('imagepng'))
                        imagepng($this->image);
                }
            }
        }
    }
    public function getWidth()
    {
        if (!$this->image) return 0;
        return imagesx($this->image);
    }
    public function getHeight()
    {
        if (!$this->image) return 0;
        return imagesy($this->image);
    }
    public function resizeToHeight($height)
    {
        if (!$this->image) return;
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }
    public function resizeToWidth($width)
    {
        if (!$this->image) return;
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }
    public function scale($scale)
    {
        if (!$this->image) return;
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }
    public function resize($width, $height)
    {
        if (!$this->image || !function_exists('imagecreatetruecolor')) return;
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
}

?>