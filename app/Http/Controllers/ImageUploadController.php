<?php

namespace App\Http\Controllers;

use App\ImageTrait;

class ImageUploadController extends Controller 
{
    use ImageTrait;

    /**
     * Images folder
     * 
     * @var string
     */
    public static $image_folder = 'images/';

    /**
     * Image Quality
     * 
     * @var int
     */
    protected $image_quality = 60;

    /**
     * Image Width
     * 
     * @var int
     */
    protected $image_width = 120;

    /**
     * Image Height
     * 
     * @var int
     */
    protected $image_height = 120;

    /**
     * Update image
     * 
     * @param $newImage
     * @param $currentFilename
     * @param bool $remove
     * @return null|string
     */
    protected function updateImage($newImage, $currentFilename, bool $remove)
    {
        // Remove avatar
        if($remove)
        {
            $this->deleteImage($currentFilename, static::$image_folder);
            return null;
        }

        // Update avatar
        if(isset($newImage))
        {
            return $this->replaceImage($currentFilename, $newImage,
                static::$image_folder, $this->image_width, $this->image_height, $this->image_quality);
        }

        return $currentFilename;
    }
}