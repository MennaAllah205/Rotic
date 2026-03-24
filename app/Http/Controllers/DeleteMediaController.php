<?php

namespace App\Http\Controllers;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

class DeleteMediaController extends Controller
{
    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        if (! $media) {
            return backWithError('Image not found', 404);
        }

        $media->delete();

        return backWithSuccess();
    }
}
