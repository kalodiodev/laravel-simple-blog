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

    /** @test */
    public function an_admin_user_can_filter_images_by_filename()
    {
        $this->signInAdmin();

        $image1 = $this->addFakeImage(null, 'article.png');
        $image2 = $this->addFakeImage(null, 'filter.png');

        $response = $this->get(route('images.admin.index', ['search' => 'filter']))
            ->assertStatus(200);

        $response
            ->assertSee($image2->filename)
            ->assertDontSee($image1->filename);
    }

    /** @test */
    public function an_admin_user_can_filter_images_by_user_name()
    {
        $this->signInAdmin();

        $user1 = factory(User::class)->create(['name' => 'Username']);
        $user2 = factory(User::class)->create(['name' => 'Filter']);

        $image1 = $this->addFakeImage($user1, 'article.png');
        $image2 = $this->addFakeImage($user2, 'filter.png');

        $response = $this->get(route('images.admin.index', ['search' => 'Filter']))
            ->assertStatus(200);

        $response
            ->assertSee($image2->filename)
            ->assertDontSee($image1->filename);
    }

    /** @test */
    public function an_admin_user_can_filter_images_by_user_email()
    {
        $this->signInAdmin();

        $user1 = factory(User::class)->create(['email' => 'user@example.com']);
        $user2 = factory(User::class)->create(['email' => 'filter@example.com']);

        $image1 = $this->addFakeImage($user1, 'article.png');
        $image2 = $this->addFakeImage($user2, 'filter.png');

        $response = $this->get(route('images.admin.index', ['search' => 'filter@example.com']))
            ->assertStatus(200);

        $response
            ->assertSee($image2->filename)
            ->assertDontSee($image1->filename);
    }
}