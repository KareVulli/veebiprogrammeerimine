<?php

class PhotoValidator
{
    /**
     * @var int
     */
    private $maxSize;

    /**
     * @var array
     */
    private $allowedTypes;

    /**
     * @var string
     */
    private $lastError = null;

    function __construct($maxSize = 2500000, $allowedTypes = ['png' => IMAGETYPE_PNG, 'jpg' => IMAGETYPE_JPEG, 'gif' => IMAGETYPE_GIF])
    {
        $this->maxSize = $maxSize;
        $this->allowedTypes = $allowedTypes;
    }

    public function validate($fileName)
    {
        $isValidImage = getimagesize($fileName);
        if (!$isValidImage) {
            $this->lastError = 'File is not an image';
            return false;
        }

        $fileSize = filesize($fileName);
        if ($fileSize > $this->maxSize) {
            $this->lastError = 'File size is too big';
			return false;
        }

        $fileType = exif_imagetype($fileName);
        if (!in_array($fileType, $this->allowedTypes)) {
            $this->lastError = 'Only ';
            $this->lastError .= implode(', ', array_keys($this->allowedTypes));
            $this->lastError .= ' images are allowed';
            return false;
        }

        return true;
    }

    /**
     * Get the value of maxSize
     *
     * @return int
     */ 
    public function getMaxSize()
    {
        return $this->maxSize;
    }

    /**
     * Set the value of maxSize
     *
     * @param int $maxSize
     *
     * @return self
     */ 
    public function setMaxSize($maxSize)
    {
        $this->maxSize = $maxSize;

        return $this;
    }

    /**
     * Get the value of allowedTypes
     *
     * @return array
     */ 
    public function getAllowedTypes()
    {
        return $this->allowedTypes;
    }

    /**
     * Set the value of allowedTypes
     *
     * @param array $allowedTypes
     *
     * @return self
     */ 
    public function setAllowedTypes($allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;

        return $this;
    }

    /**
     * Get Last Error
     *
     * @return string
     */ 
    public function getLastError()
    {
        return $this->lastError;
    }
}