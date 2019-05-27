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
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function getMedia(Request $request, int $id)
    {
        $media = Media::find($id);
        
        if (!$media) {
            throw new ModelNotFoundException('Media not found', 404);
        }

        return new MediaResource($media);
    }

    public function getMedias(Request $request)
    {
        $medias = Media::get();

        return MediaResource::collection($medias);
    }

    public function createImageMedia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image'
        ]);

        if ($validator->fails()) {
            throw new ValidationException('Validation failed');
        }

        $file = $request->file;
        $fileHash = str_replace('.' . $file->extension(), '', $file->hashName());
        $fileOriginalExtension = strtolower($file->getClientOriginalExtension());
        $fileName = $fileHash . '.' . $fileOriginalExtension; // create unique name

        if (!File::exists(public_path('uploads/'))) {
            File::makeDirectory(public_path('uploads/'), 0775);
        }

        $fileUploaded = File::move($file, public_path('uploads/' . $fileName));

        if (!$fileUploaded) {
            throw new HttpException(500, 'Error uploading image media');
        }

        if (!File::exists(public_path('uploads/thumbnails/'))) {
            File::makeDirectory(public_path('uploads/thumbnails/'), 0775);
        }

        Image::make(public_path('uploads/' . $fileName))
            ->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path('/uploads/thumbnails/' . $fileName));
    
        $newMedia = Media::create([
            'name' => strip_tags(trim($file->getClientOriginalName())),
            'content' => public_path('uploads/' . $fileName),
            'type' => 'image',
        ]);

        if (!$newMedia) {
            throw new HttpException(500, 'Error creating new media');
        }

        return response()->json([
            'data' => [],
            'message' => 'Media has been successfully created',
            'status_code' => 200
        ], 200);
    }

    /* Used to create all other types of media that don't need upload - youtube, twitter, etc. */
    public function createGenericMedia(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string', // type of media to determine what html to add when adding it to article on frontend
            'content' => 'required|string', // link to external source - youtube link, twitter link etc.
        ]);

        if ($validator->fails()) {
            throw new ValidationException('Validation failed');
        }

        $newMedia = new Media;

        $newMedia->type = strip_tags(trim($request->type));
        $newMedia->content = strip_tags(trim($request->content)); 
        $newMedia->save();

        if (!$newMedia) {
            throw new HttpException(500, 'Error creating new media');
        }

        return response()->json([
            'data' => [],
            'message' => 'Media has been successfully created',
            'status_code' => 200
        ], 200);
    }
}
