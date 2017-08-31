<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersValidationTest extends IntegrationTestCase
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
    public function a_user_cannot_have_an_invalid_avatar_file()
    {
        Storage::fake('testfs');
        $avatar = UploadedFile::fake()->image('image.pdf');

        $this->signInAdmin();

        $this->data['avatar'] = $avatar;

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function user_name_cannot_be_empty()
    {
        $this->signInAdmin();

        $this->data['name'] = '';

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function user_may_have_about_of_limited_length()
    {
        $this->signInAdmin();
        
        $this->data['about'] = str_random(200);

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('about');
    }

    /** @test */
    public function user_may_have_profession_of_limited_length()
    {
        $this->signInAdmin();

        $this->data['profession'] = str_random(51);

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('profession');
    }

    /** @test */
    public function user_may_have_country_of_limited_length()
    {
        $this->signInAdmin();
        
        $this->data['country'] = str_random(26);

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('country');
    }

    /** @test */
    public function user_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'test@example.com']);

        $this->signInAdmin();
        
        $this->data['email'] = 'test@example.com';

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('email');
    }
    
    /** @test */
    public function user_must_have_a_password()
    {
        $this->signInAdmin();

        $this->data['password'] = '';
        $this->data['password_confirmation'] = '';

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function user_password_must_be_at_least_six_characters_long()
    {
        $this->signInAdmin();

        $this->data['password'] = '12345';
        $this->data['password_confirmation'] = '12345';

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('password');
    }
    
    /** @test */
    public function user_password_must_match_password_confirmation()
    {
        $this->signInAdmin();

        $this->data['password'] = '123456';
        $this->data['password_confirmation'] = '000000';

        $response = $this->post(route('users.store'), $this->data);

        $response->assertSessionHasErrors('password');
    }
}