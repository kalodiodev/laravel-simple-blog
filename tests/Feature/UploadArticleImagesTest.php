<?php

namespace Tests\Feature;

use App\Image;
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
        $this->signInAuthor();

        $response = $this->upload_image('image.jpg');

        $response->assertSeeText('image.jpg');
    }

    /** @test */
    public function posting_no_file_should_return_400()
    {
        Storage::fake('testfs');

        $this->signInAuthor();

        $this->post('/images/article', [])->assertStatus(400);
    }

    /** @test */
    public function image_filename_should_be_stored_to_database()
    {
        $user = $this->signInAuthor();

        $this->upload_image('image.jpg');

        $image = Image::where('user_id', $user->id)->first();

        $this->assertStringEndsWith('image.jpg', $image->filename);
    }

    /** @test */
    public function uploading_image_should_store_also_a_thumbnail()
    {
        $user = $this->signInAuthor();

        $this->upload_image('image.jpg');

        $image = Image::where('user_id', $user->id)->first();

        $this->assertStringEndsWith('image.jpg', $image->thumbnail);
        $this->assertStringStartsWith('thumbnail-', $image->thumbnail);
        Storage::disk('testfs')->assertExists($image->path . $image->thumbnail);
    }

    protected function upload_image($filename = 'image.jpg')
    {
        Storage::fake('testfs');
        $image = UploadedFile::fake()->image($filename);

        return $this->post('/images/article', [
            'file' => $image
        ]);
    }
}