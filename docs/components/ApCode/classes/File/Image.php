<?php
/**
 * @author Anton Pribora <anton.pribora@gmail.com>
 * @copyright Copyright (c) 2018 Anton Pribora
 * @license https://anton-pribora.ru/license/MIT/
 */

namespace ApCode\File;

class Image extends File
{
    private $mimeType     = null;
    private $width        = null;
    private $height       = null;
    
    private $openFunction = null;
    private $saveFunction = null;
    
    private $im;
    
    protected function initialize()
    {
        $imageinfo = getimagesize($this->path());
        
        if ( $imageinfo ) {
            $this->width    = $imageinfo[0];
            $this->height   = $imageinfo[1];
            $this->mimeType = $imageinfo['mime'];
            
            if ( preg_match('~image/(png|gif|jpeg|webp)~', $this->mimeType, $matches) ) {
                $this->openFunction = 'imagecreatefrom'. $matches[1];
                $this->saveFunction = 'image'. $matches[1];
            }
            elseif ( preg_match('~image/jpg~', $this->mimeType) ) {
                $this->openFunction = 'imagecreatefromjpeg';
                $this->saveFunction = 'imagejpeg';
            }
            else {
                // ooops!
            }
        }
    }
    
    public function width()
    {
        return $this->width;
    }
    
    public function height()
    {
        return $this->height;
    }
    
    public function mimeType()
    {
        return $this->mimeType;
    }
    
    public function isValidImage()
    {
        return (bool) $this->openFunction;
    }
    
    public function imageExtention()
    {
        $imageType = exif_imagetype($this->path());
        
        if ($imageType) {
            return image_type_to_extension($imageType);
        }
        
        return false;
    }
    
    public function __destruct()
    {
        $this->close();
    }
    
    public function open()
    {
        $this->im = call_user_func($this->openFunction, $this->path());
    }
    
    public function close()
    {
        if (!empty($this->im)) {
            imagedestroy($this->im);
        }
        
        $this->im = null;
    }
    
    public function inscribe($width, $height, $newPath)
    {
        $k1 = $this->width / $this->height;        // Если больше единицы, значит ширина больше высоты
        $k2 = $width / $height;
        
        // Если коэффициент нового размера меньше старого, значит изображение будет вставляться по ширине
        if ( $k2 < $k1 ) {
            $newWidth  = $width;
            $newHeight = round($width / $k1);
        }
        else {
            $newHeight = $height;
            $newWidth  = round($height * $k1);
        }
        
        $im = $this->im ?: call_user_func($this->openFunction, $this->path());
        $thumb = imagecreatetruecolor($newWidth, $newHeight);
        
        imagesavealpha($thumb, true);
        imagealphablending($thumb, false);
        
        imagecopyresampled($thumb, $im, 0, 0, 0, 0, $newWidth, $newHeight, $this->width, $this->height);
        
        $newPath = strtr($newPath, [
            '{width}'  => $newWidth,
            '{height}' => $newHeight,
        ]);
        
        call_user_func($this->saveFunction, $thumb, $newPath);
        
        imagedestroy($thumb);
        
        if (empty($this->im)) {
            imagedestroy($im);
        }
        
        return new Image($newPath);
    }
    
    public function resizeAndCrop($width, $height, $newPath)
    {
        $k1 = $width / $this->width;
        $k2 = $height / $this->height;
        
        $k = max($k1, $k2);
        
        $centerX = intval($this->width / 2);
        $centerY = intval($this->height / 2);
        
        $s_x = intval($centerX - $width / $k / 2);
        $s_y = intval($centerY - $height / $k / 2);
        $s_w = intval($this->width - $s_x * 2);
        $s_h = intval($this->height - $s_y * 2);
        
        $im = $this->im ?: call_user_func($this->openFunction, $this->path());
        $thumb = imagecreatetruecolor($width, $height);
        
        imagesavealpha($thumb, true);
        imagealphablending($thumb, false);
        
        $newPath = strtr($newPath, [
            '{width}'  => $width,
            '{height}' => $height,
        ]);
        
        imagecopyresampled($thumb, $im, 0, 0, $s_x, $s_y, $width, $height, $s_w, $s_h);
        call_user_func($this->saveFunction, $thumb, $newPath);
        
        imagedestroy($thumb);
        
        if (empty($this->im)) {
            imagedestroy($im);
        }
        
        return new Image($newPath);
    }
}
