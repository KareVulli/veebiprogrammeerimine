<?php
require_once(__DIR__ . '/../functions.php');

function savePhoto($userid, $filename, $title, $isPrivate)
{
    $db = getDb();
    $stmt = $db->prepare('INSERT INTO vpphotos (file, title, user_id, private) VALUES (:file, :title, :user_id, :private)');
    return $stmt->execute([
        ':file' => $filename,
        ':title' => $title,
        ':user_id' => $userid,
        ':private' => $isPrivate,
    ]);
}

function resizeImage($imagePath, $ext, $newWidth, $newHeight, $crop = false) {
    global $user;

    switch($ext){
        case "png":
            $src = imagecreatefrompng($imagePath);
        break;
        case "jpeg":
        case "jpg":
            $src = imagecreatefromjpeg($imagePath);
        break;
        case "gif":
            $src = imagecreatefromgif($imagePath);
        break;
        default:
            $src = imagecreatefromjpeg($imagePath);
        break;
    }

    if ($src) {
        $width = imagesx($src);
        $height = imagesy($src);

        if ($width > $height) {
            $sizePercent = $width / $newWidth;
        } else {
            $sizePercent = $height / $newHeight;
        }
        $imageNewWidth = $width / $sizePercent;
        $imageNewHeight = $height / $sizePercent;

        $dest = imagecreatetruecolor($imageNewWidth, $imageNewHeight);
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $imageNewWidth, $imageNewHeight, $width, $height);
        addWatermark($dest, 10);
        if ($user != null) {
            addTextToImage($dest, 'Hello ' . $user['firstname'] . ' ' . $user['lastname']);
        }
        return $dest;
    }

    return false;
}

function addWatermark($image, $padding) {
    global $config;

    $watermark = imagecreatefrompng($config['watermark']);

    if ($watermark) {
        $watermarkWidth = imagesx($watermark);
        $watermarkHeight = imagesy($watermark);

        $imageWidth = imagesx($image);
        $imageHeight = imagesy($image);

        $posX = $imageWidth - $watermarkWidth - $padding;
        $posY = $imageHeight - $watermarkHeight - $padding;
        imagecopyresampled($image, $watermark, $posX, $posY, 0, 0, $watermarkWidth, $watermarkHeight, $watermarkWidth, $watermarkHeight);
    }

    return $image;
}

function addTextToImage($image, $text, $size = 25) {
    global $config;

    $white = imagecolorallocatealpha($image, 255, 255, 255, 0);
    $fontPath = $config['font'];

    $typeSpace = imagettfbbox($size, 0, $fontPath, $text);
    $textWidth = abs($typeSpace[4] - $typeSpace[0]);
    $textHeight = abs($typeSpace[5] - $typeSpace[1]);

    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    imagettftext($image, $size, 0, ($imageWidth / 2) - ($textWidth / 2), ($imageHeight / 2) - ($textHeight / 2), $white, $fontPath, $text);

    return $image;
}