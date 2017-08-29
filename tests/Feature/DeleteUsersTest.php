<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteUsersTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    public function tearDown()
    {
        $this->beforeApplicationDestroyed(function () {
            DB::disconnect();
        });

        parent::tearDown();
    }


    /** @test */
    public function an_authorized_user_can_delete_a_user()
    {
        Storage::fake('testfs');
        UploadedFile::fake()->image('avatar.jpg')->storeAs('images/avatar/', 'avatar.jpg');

        $user = factory(User::class)->create(['avatar' => 'avatar.jpg']);

        $this->signInAdmin();

        $this->delete(route('users.delete', ['user' => $user->id]))
            ->assertRedirect(route('users.index'));

        $this->assertDatabaseMissing('users', [
            'id' => $user->id
        ]);

        Storage::disk('testfs')->assertMissing('images/avatar/avatar.jpg');
    }

    /** @test */
    public function an_unauthorized_user_cannot_delete_a_user()
    {
        $user = factory(User::class)->create();

        $this->signInGuest();

        $this->delete(route('users.delete', ['user' => $user->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_user()
    {
        $user = factory(User::class)->create();

        $this->delete(route('users.delete', ['user' => $user->id]))
            ->assertRedirect('/login');
    }
}