<?php

namespace Tests\Feature;

use App\User;
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

        $image = $this->addFakeImage($user);

        $response = $this->get(route('images.index'))->assertStatus(200);

        $response->assertViewIs('images.index')->assertSee($image->filename);
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

    /** @test */
    public function an_authorized_user_can_view_image_that_owns()
    {
        $user = $this->signInAuthor();

        $image = $this->addFakeImage($user);

        $response = $this->get(route('images.show', ['image' => $image->id]))
            ->assertStatus(200);

        $response->assertViewIs('images.show');
        $response->assertSee($image->filename);
    }
    
    /** @test */
    public function an_unauthenticated_user_cannot_view_image()
    {
        $user = factory(User::class)->create();

        $image = $this->addFakeImage($user);

        $this->get(route('images.show', ['image' => $image->id]))
            ->assertRedirect('/login');
    }

    protected function addFakeImage($user, $filename = 'article.png')
    {
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