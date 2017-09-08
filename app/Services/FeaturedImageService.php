<?php

namespace App\Services;


class FeaturedImageService extends ImageService
{

    /**
     * Images folder
     *
     * @var string
     */
    public static $folder = 'images/featured/';

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
    protected $width = 800;

    /**
     * Images height
     *
     * @var null
     */
    protected $height = null;
    
}