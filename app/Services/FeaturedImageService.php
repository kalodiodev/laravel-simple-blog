<?php

namespace App\Services;


use App\User;

class FeaturedImageService extends ImageService {

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


    /**
     * Update Featured image
     *
     * @param $old
     * @param $new
     * @param $user
     * @param bool $noImage
     * @return null|string
     */
    public function update($old, $new, User $user, bool $noImage)
    {
        if($noImage)
        {
            $this->delete($old);
            
            return null;
        }

        // Update image
        if(isset($new))
        {
            return $this->performUpdate($old, $new, $user);
        }

        return $old;
    }

    /**
     * Perform image update
     * 
     * @param $old
     * @param $new
     * @param $user
     * @return null|string
     */
    private function performUpdate($old, $new, $user)
    {
        $newFilename = $this->store($new, $user, false, false);

        $this->delete($old);

        return $newFilename;
    }
}