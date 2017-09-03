<?php

namespace App;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageTrait {
    
    /**
     * Load image file helper method
     *
     * @param $filename
     * @param $path
     * @return null
     */
    public function loadImage($filename, $path)
    {
        if(! Storage::has($path . $filename))
        {
            return null;
        }

        return Storage::path($path . $filename);
    }

    /**
     * Upload resized image
     * 
     * <p>Image is resized before saved</p>
     * 
     * @param $file
     * @param $folder
     * @param $width
     * @param $height
     * @param $quality
     * @return string
     */
    protected function uploadResizedImage($file, $folder, $width, $height, $quality)
    {
        $filename = time() . '-' . $file->getClientOriginalName();

        // Resize
        $resized = Image::make($file)->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpeg', $quality);

        // Save
        Storage::put($folder . $filename, (string) $resized);

        return $filename;
    }

    /**
     * Upload image
     * 
     * @param $file
     * @param $folder
     * @param $quality
     * @return string
     */
    protected function uploadImage($file, $folder, $quality)
    {
        $filename = time() . '-' . $file->getClientOriginalName();

        // Encode
        $image = Image::make($file)->encode('jpeg', $quality);

        // Save
        Storage::put($folder . $filename, (string) $image);
        
        return $filename;
    }

    /**
     * Store image thumbnail
     * 
     * @param $file
     * @param $filename
     * @param $folder
     * @return string
     */
    protected function storeThumbnail($file, $filename, $folder)
    {
        // Resize
        $thumbnail = Image::make($file)->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpeg', 50);
        
        $filename = 'thumbnail-' . $filename;

        Storage::put($folder . $filename, (string) $thumbnail);
        
        return $filename;
    }

    /**
     * Delete image from storage
     *
     * @param $filename
     */
    private function deleteImage($filename, $path)
    {
        if(($filename == null) || ($filename == ''))
        {
            return;
        }

        if(Storage::has($path . $filename))
        {
            Storage::delete($path . $filename);
        }
    }

    /**
     * Update image
     * 
     * @param $old
     * @param $new
     * @param $path
     * @param $width
     * @param $height
     * @param $quality
     * @return string
     */
    private function replaceImage($old, $new, $path, $width, $height, $quality)
    {
        $newFilename = $this->uploadResizedImage($new, $path, $width, $height, $quality);
        
        $this->deleteImage($old, $path);
        
        return $newFilename;
    }
}