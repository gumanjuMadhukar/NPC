<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait StoreImageTrait
{

    //$folder = '/folder_name/'
    public function StoreImage(UploadedFile $file, $folder, $disk = 'public')
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs($folder, $fileName, $disk);
        return $fileName;
    }

    public function StoreResizeImage(UploadedFile $file, $folder, $width, $height, $disk = 'public')
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $img = Image::make($file->getRealPath());
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->stream();
        Storage::disk($disk)->put($folder . $fileName, $img);
        return $fileName;
    }

    public function StoreResizeImageWithThumb(UploadedFile $file, $folder, $width, $height, $thumb_width, $thumb_height, $disk = 'public')
    {
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $img = Image::make($file->getRealPath());
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->stream();
        Storage::disk($disk)->put($folder . $fileName, $img);
        //for thumb
        $img = Image::make($file->getRealPath());
        $img->resize($thumb_width, $thumb_height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->stream();
        Storage::disk($disk)->put($folder . 'thumb/' . $fileName, $img);
        return $fileName;
    }

    public function StoreBase64Image($file, $folder, $disk = 'public')
    {
        $ext = explode('/', mime_content_type($file))[1];
        $extension = explode('+', $ext)[0];
        $filename = Str::uuid() . '.' . $extension;
        if ($extension == 'svg') {
            $base64_string = str_replace('data:image/svg+xml;base64', '', $file);
            $image = base64_decode($base64_string);
        } else {
            $image = Image::make($file)->stream($extension, 80);
        }
        Storage::disk($disk)->put($folder . $filename, $image);
        return $filename;
    }

    public function StoreBase64ImageWithThumb($file, $folder, $thumb_width, $thumb_height, $disk = 'public')
    {
        $ext = explode('/', mime_content_type($file))[1];
        $extension = explode('+', $ext)[0];
        $filename = Str::uuid() . '.' . $extension;
        if ($extension == 'svg') {
            $base64_string = str_replace('data:image/svg+xml;base64', '', $file);
            $image = base64_decode($base64_string);
        } else {
            $image = Image::make($file)->stream($extension, 80);
            $thumb_image = Image::make($file)->resize($thumb_width, $thumb_height, function ($constraint) {
                $constraint->aspectRatio();
            })->stream($extension, 80);
            Storage::disk($disk)->put($folder . 'thumb/' . $filename, $thumb_image);
        }
        Storage::disk($disk)->put($folder . $filename, $image);
        return $filename;
    }
}
