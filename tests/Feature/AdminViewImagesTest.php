<?php

namespace Tests\Feature;

use App\User;
use App\Image;
use Tests\FakeImage;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;


class AdminViewImagesTest extends IntegrationTestCase
{
    use DatabaseMigrations, FakeImage;

    /** @test */
    public function an_authorized_user_can_index_all_users_images()
    {
        $image = factory(Image::class)->create();

        $this->signInAdmin();

        $response = $this->get(route('images.admin.index'))
            ->assertStatus(200);

        $response->assertViewIs('images.admin.index')->assertSee($image->filename);
    }

    /** @test */
    public function an_unauthorized_user_cannot_index_all_users_images()
    {
        $this->signInAuthor();

        $this->get(route('images.admin.index'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_index_all_users_images()
    {
        $this->get(route('images.admin.index'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authorized_user_can_view_other_users_images()
    {
        $this->signInAdmin();

        $user = factory(User::class)->create();
        $image = $this->addFakeImage($user);

        $response = $this->get(route('images.admin.show', ['image' => $image->id]))
            ->assertStatus(200);

        $response->assertViewIs('images.admin.show');
        $response->assertSee($image->filename);
    }

    /** test */
    public function an_unauthorized_user_cannot_view_other_users_images()
    {
        $this->signInAuthor();

        $user = factory(User::class)->create();
        $image = $this->addFakeImage($user);

        $this->get(route('images.admin.show', ['image' => $image->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_view_other_users_images()
    {
        $user = factory(User::class)->create();
        $image = $this->addFakeImage($user);

        $this->get(route('images.admin.show', ['image' => $image->id]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_view_own_image_from_admin_route()
    {
        $user = $this->signInAuthor();

        $image = $this->addFakeImage($user);

        $this->get(route('images.admin.show', ['image' => $image->id]))
            ->assertStatus(403);
    }
}