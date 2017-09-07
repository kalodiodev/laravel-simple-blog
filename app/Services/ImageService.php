<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageService  {

    /**
     * The images folder
     *
     * @var string
     */
    protected $folder = 'images/';

    /**
     * Images quality
     *
     * @var int
     */
    protected $quality = 60;

    /**
     * Images width
     *
     * @var int
     */
    protected $width = 120;

    /**
     * Images height
     *
     * @var int
     */
    protected $height = 120;

    /**
     * Get images folder
     * 
     * @return string
     */
    public function folder()
    {
        return $this->folder;
    }
    
    /**
     * Load image
     *
     * @param $filename
     * @return null|
     */
    public function load($filename)
    {
        return $this->loadImage($filename, $this->folder);
    }

    /**
     * Store Image file
     *
     * @param $file
     * @param $user
     * @param bool $thumbnail_enabled
     * @param bool $storeToDB
     * @return null|string
     */
    public function store($file, User $user, $thumbnail_enabled = true, $storeToDB = true)
    {
        if(isset($file))
        {
            $filename = $this->performUpload($file);

            // Thumbnail
            $thumbnail = $thumbnail_enabled ? $this->createThumbnail($file, $filename, $this->folder) : $filename;

            if($storeToDB)
            {
                // Database
                $this->storeImageInfoToDB($user, $filename, $this->folder, $thumbnail);
            }

            return $filename;
        }

        return null;
    }

    /**
     * Delete Image
     *
     * @param $image
     */
    public function delete($image)
    {
        $filename = $image instanceof \App\Image ? $image->filename : $image;

        $this->deleteImage($filename, $this->folder);

        if($image instanceof \App\Image)
        {
            $this->deleteImage($image->thumbnail, $image->folder);
            $image->delete();
        }
    }

    /**
     * Create image thumbnail
     * 
     * @param $file
     * @param $filename
     * @param $folder
     * @return string
     */
    protected function createThumbnail($file, $filename, $folder)
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
     * Store image info to database
     * 
     * @param $user
     * @param $filename
     * @param $path
     * @param $thumbnail
     */
    protected function storeImageInfoToDB($user, $filename, $path, $thumbnail)
    {
        $user->images()->create([
            'filename' => $filename,
            'path' => $path,
            'thumbnail' => $thumbnail
        ]);
    }

    /**
     * Perform Image upload
     * 
     * @param $file
     * @return string
     */
    protected function performUpload($file)
    {
        if (($this->width != null) && ($this->height != null))
        {
            return $this->uploadResizedImage($file, $this->folder, 
                $this->width, $this->height, $this->quality);
        }

        return $this->uploadImage($file, $this->folder, $this->quality);
    }

    /**
     * Load image file helper method
     *
     * @param $filename
     * @param $path
     * @return null
     */
    protected function loadImage($filename, $path)
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
        $filename = $this->produceFilename($file);

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
        $filename = $this->produceFilename($file);

        // Encode
        $image = Image::make($file)->encode('jpeg', $quality);

        // Save
        Storage::put($folder . $filename, (string) $image);

        return $filename;
    }

    /**
     * Delete image from storage
     *
     * @param $filename
     * @param $path
     */
    protected function deleteImage($filename, $path)
    {
        if(isset($filename) && Storage::has($path . $filename))
        {
            Storage::delete($path . $filename);
        }
    }

    /**
     * @param $file
     * @return string
     */
    protected function produceFilename($file)
    {
        return time() . '-' . $file->getClientOriginalName();
    }
}