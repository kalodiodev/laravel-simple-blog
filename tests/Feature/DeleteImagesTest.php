<?php

namespace Tests\Feature;

use App\Image;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteImagesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $image;

    public function setUp()
    {
        parent::setUp();

        Storage::fake('testfs');
        UploadedFile::fake()->image('image.jpg')->storeAs('images/article/', 'image.jpg');
        UploadedFile::fake()->image('thumbnail-image.jpg')->storeAs('images/article/', 'thumbnail-image.jpg');

        $this->image = factory(Image::class)->create([
            'filename' => 'image.jpg',
            'path' => 'images/article/',
            'thumbnail' => 'thumbnail-image.jpg']);
    }

    /** @test */
    public function an_authorized_user_can_delete_image()
    {
        $this->signInAdmin();

        $this->delete(route('images.delete', ['image' => $this->image->filename]))
            ->assertStatus(302);

        Storage::disk('testfs')->assertMissing($this->image->path . $this->image->filename);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_image()
    {
        $this->delete(route('images.delete', ['image' => $this->image->filename]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_image()
    {
        $this->signInGuest();

        $this->delete(route('images.delete', ['image' => $this->image->filename]))
            ->assertStatus(403);
    }

    /** @test */
    public function deleting_image_should_also_delete_thumbnail()
    {
        $this->signInAdmin();

        $this->delete(route('images.delete', ['image' => $this->image->filename]))
            ->assertStatus(302);

        Storage::disk('testfs')->assertMissing($this->image->path . $this->image->thumbnail);
    }

    /** @test */
    public function deleting_image_should_also_remove_image_from_database()
    {
        $this->signInAdmin();

        $this->delete(route('images.delete', ['image' => $this->image->filename]))
            ->assertStatus(302);

        $image = Image::where('id', $this->image->id)->first();

        $this->assertNull($image);
    }
}