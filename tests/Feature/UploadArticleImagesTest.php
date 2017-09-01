<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UploadArticleImagesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authorized_user_can_upload_an_article_image()
    {
        Storage::fake('testfs');
        $image = UploadedFile::fake()->image('image.jpg');

        $this->signInAuthor();

        $response = $this->post('/images/article', [
            'file' => $image
        ]);

        $response->assertSeeText('image.jpg');
    }

    /** @test */
    public function posting_no_file_should_return_400()
    {
        Storage::fake('testfs');
       // $image = UploadedFile::fake()->image('image.jpg');

        $this->signInAuthor();

        $this->post('/images/article', [])->assertStatus(400);
    }
}