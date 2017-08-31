<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateUsersTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $data;

    public function setUp()
    {
        parent::setUp();

        $this->data = [
            'name' => 'New name',
            'email' => 'user@example.com',
            'about' => 'New user about info',
            'country' => 'Country',
            'profession' => 'My profession',
            'password' => '123456',
            'password_confirmation' => '123456',
            'role' => 2
        ];
    }

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        parent::tearDown();
    }

    /** @test */
    public function an_authorized_user_can_create_a_user()
    {
        $this->signInAdmin();

        $response = $this->get(route('users.create'))
            ->assertStatus(200);

        $response->assertViewIs('users.create');
    }

    /** @test */
    public function an_unauthorized_user_cannot_create_a_user()
    {
        $this->signInGuest();

        $this->get(route('users.create'))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_user()
    {
        $this->get(route('users.create'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authorized_user_can_store_a_new_user()
    {
        Storage::fake('testfs');
        $avatar = UploadedFile::fake()->image('image.png');

        $this->signInAdmin();

        $this->data['avatar'] = $avatar;

        $this->post(route('users.store'), $this->data)->assertStatus(302);


        $user = User::whereEmail($this->data['email'])->first();

        $this->assertDatabaseHas('users', [
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'about' => $this->data['about'],
            'country' => $this->data['country'],
            'profession' => $this->data['profession'],
        ]);

        $this->assertNotNull($user, 'User cannot be null');
        $this->assertNotNull($user->avatar, 'User avatar cannot be null');
        Storage::disk('testfs')->assertExists('images/avatar/' . $user->avatar);
    }

    /** @test */
    public function an_unauthorized_user_cannot_store_a_new_user()
    {
        $this->signInGuest();

        $this->post(route('users.store'), $this->data)
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_store_a_new_user()
    {
        $this->post(route('users.store'), $this->data)
            ->assertRedirect('/login');
    }
}