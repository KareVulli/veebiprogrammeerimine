<?php

/**
 * An helper class to refactor images before storing them.
 */
class PhotoManager
{
    /**
     * @var int
     */
    private $width;
    
    /**
     * @var int
     */
    private $height;

    /**
     * @var bool
     */
    private $crop = false;

    /**
     * @var int
     */
    private $watermarkPadding = 10;

    /**
     * @var string
     */
    private $watermark;

    /**
     * @var string
     */
    private $font;

    /**
     * @var bool
     */
    private $printDate = false;

    /**
     * @var string
     */
    private $text;

    /**
     * @var int
     */
    private $textSize = 10;

    function __construct($width, $height, $watermark = null, $font = null)
    {
        $this->width = $width;
        $this->height = $height;
        $this->watermark = $watermark;
        $this->font = $font;
    }

    public function build($sourcePath)
    {
        $src = $this->createImageFromPath($sourcePath);

        return $this->buildFromImage($src, $sourcePath);
    }

    public function buildFromImage($src, $sourcePath = null)
    {
        if ($src) {
            $width = imagesx($src);
            $height = imagesy($src);

            if ($this->crop) {
                $originalAspect = $width / $height;
                $thumbAspect = $this->width / $this->height;

                if ( $originalAspect >= $thumbAspect )
                {
                    // If image is wider than thumbnail (in aspect ratio sense)
                    $imageNewHeight = $this->height;
                    $imageNewWidth = $width / ($height / $this->height);
                }
                else
                {
                    // If the thumbnail is wider than the image
                    $imageNewWidth = $this->width;
                    $imageNewHeight = $height / ($width / $this->width);
                }
                $locX = 0 - ($imageNewWidth - $this->width) / 2;
                $locY = 0 - ($imageNewHeight - $this->height) / 2;

                $dest = imagecreatetruecolor($this->width, $this->height);
            } else {
                if ($width > $height) {
                    $sizePercent = $width / $this->width;
                } else {
                    $sizePercent = $height / $this->height;
                }
                $imageNewWidth = $width / $sizePercent;
                $imageNewHeight = $height / $sizePercent;
                $locX = 0;
                $locY = 0;
                $dest = imagecreatetruecolor($imageNewWidth, $imageNewHeight);
            }
            
            imagesavealpha($dest, true);
            $transColor = imagecolorallocatealpha($dest, 0, 0, 0, 127);
            imagefill($dest, 0, 0, $transColor);
            imagecopyresampled(
                $dest,
                $src,
                $locX,
                $locY,
                0,
                0,
                $imageNewWidth,
                $imageNewHeight,
                $width,
                $height
            );
            $this->addWatermark($dest);
            $this->addTextToImage($dest);
            if ($sourcePath) {
                $this->addDateToImage($dest, $sourcePath);
            }
            return $dest;
        }

        return false;
    }

    private function addWatermark($image)
    {
        if (!$this->watermark) {
            return $image;
        }

        $watermark = $this->createImageFromPath($this->watermark);

        if ($watermark) {
            $watermarkWidth = imagesx($watermark);
            $watermarkHeight = imagesy($watermark);

            $imageWidth = imagesx($image);
            $imageHeight = imagesy($image);

            $posX = $imageWidth - $watermarkWidth - $this->watermarkPadding;
            $posY = $imageHeight - $watermarkHeight - $this->watermarkPadding;
            imagecopyresampled($image, $watermark, $posX, $posY, 0, 0, $watermarkWidth, $watermarkHeight, $watermarkWidth, $watermarkHeight);
        }

        return $image;
    }

    private function addTextToImage($image)
    {
        if (!$this->font || !$this->text) {
            return $image;
        }

        $white = imagecolorallocatealpha($image, 255, 255, 255, 0);
        $fontPath = $this->font;

        $typeSpace = imagettfbbox($this->textSize, 0, $fontPath, $this->text);
        $textWidth = abs($typeSpace[4] - $typeSpace[0]);
        $textHeight = abs($typeSpace[5] - $typeSpace[1]);

        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);

        $this->printText(
            $image,
            $fontPath,
            $this->textSize,
            $this->text,
            ($imageWidth / 2) - ($textWidth / 2),
            ($imageHeight / 2) - ($textHeight / 2)
        );

        return $image;
    }

    private function addDateToImage($image, $sourcePath, $x = 10, $y = 15)
    {
        if (!$this->font || !$this->printDate) {
            return $image;
        }

        $white = imagecolorallocatealpha($image, 255, 255, 255, 50);

        $exif = $this->readExif($sourcePath);
        
        if (array_key_exists('DateTimeOriginal', $exif)) {
            $text = $exif['DateTimeOriginal'];
            $this->printText($image, $this->font, $this->textSize, $text, $x, $y);
        }

        return $image;
    }

    private function printText($image, $font, $textSize, $text, $x, $y)
    {
        $white = imagecolorallocatealpha($image, 255, 255, 255, 0);
        imagettftext($image, $textSize, 0, $x, $y, $white, $font, $text);
        return $image;
    }

    private function createImageFromPath($sourcePath)
    {
        $ext = exif_imagetype($sourcePath);

        switch ($ext) {
            case IMAGETYPE_PNG:
                return imagecreatefrompng($sourcePath);
            break;
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($sourcePath);
            break;
            case IMAGETYPE_GIF:
                return imagecreatefromgif($sourcePath);
            break;
            default:
                return imagecreatefromjpeg($sourcePath);
            break;
        }

        return null;
    }

    public function readExif($filename)
    {
        $exif = @exif_read_data($filename, 'EXIF', false);
        return ( $exif === false ? [] : $exif );
    }

    /**
     * Get the value of width
     *
     * @return int
     */ 
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set the value of width
     *
     * @param int $width
     *
     * @return self
     */ 
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get the value of height
     *
     * @return int
     */ 
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set the value of height
     *
     * @param int $height
     *
     * @return self
     */ 
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get the value of crop
     *
     * @return bool
     */ 
    public function getCrop()
    {
        return $this->crop;
    }

    /**
     * Set the value of crop
     *
     * @param bool $crop
     *
     * @return self
     */ 
    public function setCrop($crop)
    {
        $this->crop = $crop;

        return $this;
    }

    /**
     * Get the value of watermarkPadding
     *
     * @return int
     */ 
    public function getWatermarkPadding()
    {
        return $this->watermarkPadding;
    }

    /**
     * Set the value of watermarkPadding
     *
     * @param int $watermarkPadding
     *
     * @return self
     */ 
    public function setWatermarkPadding($watermarkPadding)
    {
        $this->watermarkPadding = $watermarkPadding;

        return $this;
    }

    /**
     * Get the value of font
     *
     * @return string
     */ 
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Set the value of font
     *
     * @param string $font
     *
     * @return self
     */ 
    public function setFont($font)
    {
        $this->font = $font;

        return $this;
    }

    /**
     * Get the value of text
     *
     * @return string
     */ 
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set the value of text
     *
     * @param string $text
     *
     * @return self
     */ 
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get the value of watermark
     *
     * @return string
     */ 
    public function getWatermark()
    {
        return $this->watermark;
    }

    /**
     * Set the value of watermark
     *
     * @param string $watermark
     *
     * @return self
     */ 
    public function setWatermark($watermark)
    {
        $this->watermark = $watermark;

        return $this;
    }

    /**
     * Get the value of textSize
     *
     * @return int
     */ 
    public function getTextSize()
    {
        return $this->textSize;
    }

    /**
     * Set the value of textSize
     *
     * @param int $textSize
     *
     * @return self
     */ 
    public function setTextSize($textSize)
    {
        $this->textSize = $textSize;

        return $this;
    }

    /**
     * Get the value of printDate
     *
     * @return bool
     */ 
    public function getPrintDate()
    {
        return $this->printDate;
    }

    /**
     * Set the value of printDate
     *
     * @param bool $printDate
     *
     * @return self
     */ 
    public function setPrintDate($printDate)
    {
        $this->printDate = $printDate;

        return $this;
    }
}