<?php

namespace App\Services;


class ArticleImageService extends ImageService {

    /**
     * Images folder
     * 
     * @var string
     */
    public static $folder = 'images/article/';

    /**
     * Images quality
     * 
     * @var int
     */
    protected $quality = 60;

    /**
     * Images width
     * 
     * @var null
     */
    protected $width = null;

    /**
     * Images height
     * 
     * @var null
     */
    protected $height = null;
}