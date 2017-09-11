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
    public static $folder = 'images/';

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
     * Store image details to database
     * 
     * @var bool
     */
    protected $storeToDB = false;

    /**
     * Store image thumbnail
     * 
     * @var bool
     */
    protected $hasThumbnail = false;

    /**
     * Get images folder
     * 
     * @return string
     */
    public static function folder()
    {
        return static::$folder;
    }
    
    /**
     * Load image
     *
     * @param $filename
     * @return null|
     */
    public function load($filename)
    {
        return $this->loadImage($filename, static::$folder);
    }

    /**
     * Store Image file
     *
     * @param $file
     * @param $user
     * @return null|string
     */
    public function store($file, User $user)
    {
        if(isset($file))
        {
            $filename = $this->performUpload($file);

            // Thumbnail
            $thumbnail = $this->hasThumbnail ? $this->createThumbnail($file, $filename, static::$folder) : $filename;

            if($this->storeToDB)
            {
                // Database
                $this->storeImageInfoToDB($user, $filename, static::$folder, $thumbnail);
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
        if((! ($image instanceof \App\Image)) && (($img = $this->retrieveImageFromDB($image)) != null))
        {
            $image = $img;
        }

        $this->deleteImage($this->retrieveImageFilename($image), static::$folder);

        if($image instanceof \App\Image)
        {
            // Thumbnail
            $this->deleteImage($image->thumbnail, $image->path);
            
            // Database
            $image->delete();
        }
    }

    /**
     * Update Featured image
     *
     * @param $old
     * @param $new
     * @param User $user
     * @param bool $noImage
     * @param bool $removeOld
     * @return null|string
     */
    public function update($old, $new, User $user, bool $noImage, bool $removeOld = false)
    {
        if($noImage)
        {
            $this->removeOld($removeOld, $old);

            return null;
        }

        // Update image
        if(isset($new))
        {
            return $this->performUpdate($old, $new, $user, $removeOld);
        }

        return $old;
    }

    /**
     * Remove old image
     *
     * @param bool $remove
     * @param $image
     */
    private function removeOld(bool $remove, $image)
    {
        if($remove)
        {
            $this->delete($image);
        }
    }

    /**
     * Perform image update
     *
     * @param $old
     * @param $new
     * @param $user
     * @param bool $removeOld
     * @return null|string
     */
    private function performUpdate($old, $new, $user, bool $removeOld)
    {
        $newFilename = $this->store($new, $user);

        $this->removeOld($removeOld, $old);

        return $newFilename;
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
            return $this->uploadResizedImage($file, static::$folder, 
                $this->width, $this->height, $this->quality);
        }

        return $this->uploadImage($file, static::$folder, $this->quality);
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

    /**
     * Retrieve Image from database
     *
     * @param $filename
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    protected function retrieveImageFromDB($filename)
    {
        return \App\Image::where('filename', $filename)->first();
    }

    /**
     * Retrieve image filename from image model
     *
     * @param $image
     * @return mixed
     */
    protected function retrieveImageFilename($image)
    {
        $filename = $image instanceof \App\Image ? $image->filename : $image;

        return $filename;
    }
}