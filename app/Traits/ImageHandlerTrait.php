<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait ImageHandlerTrait
{
    public function uploadAndCompressImage($image, $folder = 'uploads', $targetSizeKB = 500, $quality = 80)
    {
        try {
            
            set_time_limit(60);

            $originalSizeKB = $image->getSize() / 1024;
            $fileName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path($folder);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $tempPath = $folder . '/' . $fileName;
            $fullPath = public_path($tempPath);
            $ext = strtolower($image->getClientOriginalExtension());

            if ($originalSizeKB <= $targetSizeKB) {
                $image->move($destinationPath, $fileName);
                return $tempPath;
            }
         switch ($ext) {
                case 'jpg':
                case 'jpeg':
                    $img = imagecreatefromjpeg($image->getRealPath());
                    break;
                case 'png':
                    $img = imagecreatefrompng($image->getRealPath());
                    break;
                case 'gif':
                    $img = imagecreatefromgif($image->getRealPath());
                    break;
                default:
                    return null;
            }

            $width = imagesx($img);
            $height = imagesy($img);

            $maxDimension = 1600;
            if ($width > $maxDimension || $height > $maxDimension) {
                $ratio = $maxDimension / max($width, $height);
                $newWidth = intval($width * $ratio);
                $newHeight = intval($height * $ratio);

                $tmpImg = imagecreatetruecolor($newWidth, $newHeight);

                if ($ext == 'png' || $ext == 'gif') {
                    imagecolortransparent($tmpImg, imagecolorallocatealpha($tmpImg, 0, 0, 0, 127));
                    imagealphablending($tmpImg, false);
                    imagesavealpha($tmpImg, true);
                }

                imagecopyresampled($tmpImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($img);
                $img = $tmpImg;
            }

            if ($ext == 'jpg' || $ext == 'jpeg') {
                imagejpeg($img, $fullPath, $quality);
            } elseif ($ext == 'png') {
                imagepng($img, $fullPath, 7);
            } else {
                imagegif($img, $fullPath);
            }

            imagedestroy($img);
            return $tempPath;

        } catch (\Exception $e) {
            Log::error('Image compression error: ' . $e->getMessage());
            return null;
        }
    }

    public function deleteImage($path)
    {
        $fullPath = public_path($path);
        if ($path && file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
