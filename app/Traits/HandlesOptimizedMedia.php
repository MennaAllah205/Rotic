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



        $path = storage_path('app/tmp/' . uniqid() . '.webp');



        // resize + convert

        Image::load($file->getPathname())

            ->width($maxWidth)

            ->format('webp')

            ->quality($quality)

            ->save($path);




        while (filesize($path) / 1024 > $targetKb && $quality > 20) {



            $quality -= 5;



            Image::load($file->getPathname())

                ->width($maxWidth)

                ->format('webp')

                ->quality($quality)

                ->save($path);

        }



        return new UploadedFile(

            $path,

            basename($path),

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

