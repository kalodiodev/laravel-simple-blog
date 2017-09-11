<?php

namespace App\Services;


class ArticleImageService extends ImageService 
{

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
    protected $width = 800;

    /**
     * Images height
     * 
     * @var null
     */
    protected $height = null;

    /**
     * Store image details to database
     *
     * @var bool
     */
    protected $storeToDB = true;

    /**
     * Store image thumbnail
     *
     * @var bool
     */
    protected $hasThumbnail = true;
}