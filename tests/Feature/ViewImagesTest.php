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
    public function should_respond_404_when_file_does_not_exist()
    {
        Storage::fake('testfs');
        
        $this->get('/images/featured/missing.png')
            ->assertStatus(404);
    }
}