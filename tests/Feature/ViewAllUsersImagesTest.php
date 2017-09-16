<?php

namespace Tests\Feature;

use App\Image;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class ViewAllUsersImagesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authorized_user_can_index_all_users_images()
    {
        $image = factory(Image::class)->create();

        $this->signInAdmin();

        $response = $this->get(route('images.all'))
            ->assertStatus(200);

        $response->assertViewIs('images.all')->assertSee($image->filename);
    }

    /** @test */
    public function an_unauthorized_user_cannot_index_all_users_images()
    {
        $this->signInAuthor();

        $this->get(route('images.all'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_index_all_users_images()
    {
        $this->get(route('images.all'))
            ->assertRedirect('/login');
    }
}