<?php

namespace Tests\Feature;

use App\User;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteUsersTest extends IntegrationTestCase
{
    use DatabaseMigrations;
    
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