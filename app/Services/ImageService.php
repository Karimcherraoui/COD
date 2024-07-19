<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    public function uploadImage($image, $path = 'products')
    {
        if ($image instanceof UploadedFile) {
            return $image->store($path, 'public');
        } elseif (is_string($image) && file_exists($image)) {
            $fileName = basename($image);
            $newFileName = uniqid() . '_' . $fileName;
            $storedPath = $path . '/' . $newFileName;
            
            if (Storage::disk('public')->put($storedPath, file_get_contents($image))) {
                return $storedPath;
            }
        }
        
        return null;
    }
}