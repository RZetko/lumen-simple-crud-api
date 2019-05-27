<?php

namespace App\Http\Controllers\Content;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;
use App\Models\Content\Media;
use App\Http\Resources\Content\MediaResource;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function getMedia(Request $request, int $id)
    {
        $media = Media::find($id);
        
        if (!$media) {
            throw new ModelNotFoundException('Media not found', 404);
        }

        return new MEdiaResource($media);
    }

    public function getMedias(Request $request)
    {
        $medias = Media::get();

        return MediaResource::collection($medias);
    }

    public function createMedia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException('Validation failed');
        }


    }
}
