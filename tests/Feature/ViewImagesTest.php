<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


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
    public function a_user_can_view_an_article_image()
    {
        Storage::fake('testfs');

        UploadedFile::fake()->image('article.png')
            ->storeAs('images/article/', 'article.png');

        $response = $this->get('/images/article/article.png')
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

    /** @test */
    public function should_respond_404_when_article_image_does_not_exist()
    {
        Storage::fake('testfs');

        $this->get('/images/article/missing.png')
            ->assertStatus(404);
    }
}