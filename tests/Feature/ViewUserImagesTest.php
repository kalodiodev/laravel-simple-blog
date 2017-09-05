<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ViewUserImagesTest extends IntegrationTestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function an_authorized_user_can_view_images_that_owns()
    {
        $user = $this->signInAuthor();

        Storage::fake('testfs');

        UploadedFile::fake()->image('article.png')
            ->storeAs('images/article/', 'article.png');

        UploadedFile::fake()->image('thumbnail-article.png')
            ->storeAs('images/article/', 'thumbnail-article.png');

        factory(\App\Image::class)->create([
            'user_id' => $user->id,
            'filename' => 'article.png',
            'path' => 'images/article/',
            'thumbnail' => 'thumbnail-article.png'
        ]);

        $response = $this->get(route('images.index'))->assertStatus(200);

        $response->assertViewIs('images.index')->assertSee('article.png');
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_user_images()
    {
        $this->get(route('images.index'))
            ->assertRedirect("/login");
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_user_images()
    {
        $this->signInGuest();

        $this->get(route('images.index'))
            ->assertStatus(403);
    }
}