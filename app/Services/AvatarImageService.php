<?php

namespace App\Services;


class AvatarImageService extends ImageService {

    /**
     * Images folder
     * 
     * @var string
     */
    public static $folder = 'images/avatar/';

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
}