<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait ImageHandlerTrait
{
    /**
     * Compress image to ~500KB if larger
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $folder
     * @param int $targetSizeKB
     * @param int $quality
     * @return string|null
     */
    public function uploadAndCompressImage($image, $folder = 'uploads', $targetSizeKB = 500, $quality = 80)
    {
        try {
            $originalSizeKB = $image->getSize() / 1024;
            $fileName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path($folder);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $tempPath = $folder . '/' . $fileName;
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

            $currentSizeKB = $originalSizeKB;

            if ($ext == 'jpg' || $ext == 'jpeg') {
                $currentQuality = $quality;
                do {
                    imagejpeg($img, public_path($tempPath), $currentQuality);
                    clearstatcache();
                    $currentSizeKB = filesize(public_path($tempPath)) / 1024;
                    $currentQuality -= 5;
                } while ($currentSizeKB > $targetSizeKB && $currentQuality > 10);

            } else {
                $maxWidth = imagesx($img);
                $maxHeight = imagesy($img);
                $scale = 0.95;
                do {
                    $newWidth = intval($maxWidth * $scale);
                    $newHeight = intval($maxHeight * $scale);

                    $tmpImg = imagecreatetruecolor($newWidth, $newHeight);

                    if ($ext == 'png' || $ext == 'gif') {
                        imagecolortransparent($tmpImg, imagecolorallocatealpha($tmpImg, 0, 0, 0, 127));
                        imagealphablending($tmpImg, false);
                        imagesavealpha($tmpImg, true);
                    }

                    imagecopyresampled($tmpImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($img), imagesy($img));

                    if ($ext == 'png') {
                        $compression = intval((100 - $quality) / 10);
                        imagepng($tmpImg, public_path($tempPath), $compression);
                    } elseif ($ext == 'gif') {
                        imagegif($tmpImg, public_path($tempPath));
                    }

                    imagedestroy($tmpImg);
                    clearstatcache();
                    $currentSizeKB = filesize(public_path($tempPath)) / 1024;

                    $maxWidth = $newWidth;
                    $maxHeight = $newHeight;

                } while ($currentSizeKB > $targetSizeKB && $maxWidth > 50 && $maxHeight > 50);
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
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
