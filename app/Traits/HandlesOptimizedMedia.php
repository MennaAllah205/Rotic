<?php



namespace App\Traits;



use Illuminate\Http\UploadedFile;

use Spatie\Image\Image;



trait HandlesOptimizedMedia
{

    protected function optimizeImage(

        UploadedFile $file,

        int $quality = 70,

        int $maxWidth = 1600,

        int $targetKb = 300

    ): UploadedFile {

        // Create temp file in public directory

        $tempDir = public_path('temp');

        if (!is_dir($tempDir)) {

            mkdir($tempDir, 0755, true);

        }

        

        $filename = uniqid() . '.webp';

        $path = $tempDir . '/' . $filename;

        

        // resize + convert

        Image::load($file->getPathname())

            ->width($maxWidth)

            ->format('webp')

            ->quality($quality)

            ->save($path);

        

        // Reduce quality if file is still too large

        while (filesize($path) / 1024 > $targetKb && $quality > 20) {

            $quality -= 5;

            

            Image::load($file->getPathname())

                ->width($maxWidth)

                ->format('webp')

                ->quality($quality)

                ->save($path);

        }

        

        // Create new UploadedFile with correct path

        return new UploadedFile(

            $path,

            $filename,

            'image/webp',

            null,

            true

        );

    }



    protected function addOptimizedMedia($model, UploadedFile $file, string $collection = 'images')

    {

        $optimized = $this->optimizeImage($file);



        return $model

            ->addMedia($optimized)

            ->toMediaCollection($collection);

    }



    protected function addOptimizedMediaMultiple($model, array $files, string $collection = 'images')
    {

        foreach ($files as $file) {

            $this->addOptimizedMedia($model, $file, $collection);

        }

    }

}

