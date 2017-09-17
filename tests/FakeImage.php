<?php

namespace Tests;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FakeImage {

    protected function addFakeImage($user = null, $filename = 'article.png')
    {
        if(! isset($user))
        {
            $user = factory(User::class)->create();
        }
        
        Storage::fake('testfs');

        UploadedFile::fake()->image($filename)
            ->storeAs('images/article/', $filename);

        UploadedFile::fake()->image('thumbnail-' . $filename)
            ->storeAs('images/article/', 'thumbnail-' . $filename);

        $image = factory(\App\Image::class)->create([
            'user_id' => $user->id,
            'filename' => $filename,
            'path' => 'images/article/',
            'thumbnail' => 'thumbnail-' . $filename
        ]);

        return $image;
    }    
}