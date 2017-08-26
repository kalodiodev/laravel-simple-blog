<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;


class ViewImagesTest extends TestCase
{
    /** @test */
    public function a_user_can_view_a_featured_image()
    {
        Storage::fake('testfs');

        UploadedFile::fake()->image('image.png')
            ->storeAs('images/featured/', 'image.png');

        $response = $this->get('/images/featured/image.png')
           ->assertStatus(200);
        
        $response->assertHeader('Content-Type', 'image/png');
    }
    
    /** @test */
    public function a_user_can_view_an_avatar_image()
    {
        Storage::fake('testfs');

        UploadedFile::fake()->image('avatar.png')
            ->storeAs('images/avatar/', 'avatar.png');

        $response = $this->get('/images/avatar/avatar.png')
            ->assertStatus(200);

        $response->assertHeader('Content-Type', 'image/png');
    }

    /** @test */
    public function should_respond_404_when_featured_image_does_not_exist()
    {
        Storage::fake('testfs');
        
        $this->get('/images/featured/missing.png')
            ->assertStatus(404);
    }

    /** @test */
    public function should_respond_404_when_avatar_image_does_not_exist()
    {
        Storage::fake('testfs');

        $this->get('/images/avatar/missing.png')
            ->assertStatus(404);
    }
}