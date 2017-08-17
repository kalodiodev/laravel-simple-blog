<?php

use App\Comment;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class EditCommentsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $comment;

    // Data used to update comment
    protected $update_data = [
        'body' => 'New comment',
    ];

    public function setUp()
    {
        parent::setUp();

        $this->comment = factory(\App\Comment::class)->create();
    }

    /** @test */
    public function an_authorized_user_can_edit_comment_that_owns_when_has_permission()
    {
        $user = $this->comment->user;
        // author user
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $response = $this->get(route('comment.edit', ['comment' => $this->comment->id]));

        $response->assertSee($this->comment->body);
    }

    /** @test */
    public function an_authorized_user_can_update_comment_that_own_when_has_permission()
    {
        $user = $this->comment->user;
        // author user
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $this->patchComment($this->comment, $this->update_data)->assertStatus(302);

        $this->assertUpdated();
    }

    /** @test */
    public function an_authorized_user_can_edit_any_comment_when_has_permission()
    {
        $user = factory(User::class)->create();
        // admin user
        $this->giveUserRole($user, 'admin');
        $this->signIn($user);

        $response = $this->get(route('comment.edit', ['comment' => $this->comment->id]));

        $response->assertSee($this->comment->body);
    }

    /** @test */
    public function an_authorized_user_can_update_any_comment_when_has_permission()
    {
        $user = factory(User::class)->create();
        // Admin user
        $this->giveUserRole($user, 'admin');
        $this->signIn($user);

        $this->patchComment($this->comment, $this->update_data)->assertStatus(302);

        $this->assertUpdated();
    }

    /** @test */
    public function an_authenticated_user_cannot_edit_other_users_comment_when_has_no_permission()
    {
        $user = factory(User::class)->create();
        // author user
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $this->get(route('comment.edit', ['comment' => $this->comment->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_other_users_comment_when_has_no_permission()
    {
        $user = factory(User::class)->create();
        // author user
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $this->patchComment($this->comment, $this->update_data)->assertStatus(403);

        $this->assertNotUpdated();
    }

    /** @test */
    public function an_authorized_user_can_edit_other_users_comment_in_article_that_owns()
    {
        $user = $this->comment->article->user;
        // author user
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $response = $this->get(route('comment.edit', ['comment' => $this->comment->id]));

        $response->assertSee($this->comment->body);
    }

    /** @test */
    public function an_authorized_user_can_update_other_users_comment_in_article_that_owns()
    {
        $user = $this->comment->article->user;
        // author user
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $this->patchComment($this->comment, $this->update_data)->assertStatus(302);

        $this->assertUpdated();
    }

    /** @test */
    public function an_authenticated_user_cannot_edit_comment_that_owns_when_has_no_permission()
    {
        $user = $this->comment->user;
        // guest user
        $this->giveUserRole($user, 'guest');
        $this->signIn($user);

        $this->get(route('comment.edit', ['comment' => $this->comment->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_comment_that_owns_when_has_no_permission()
    {
        $user = $this->comment->user;
        // guest user
        $this->giveUserRole($user, 'guest');
        $this->signIn($user);

        $this->patchComment($this->comment, $this->update_data)->assertStatus(403);

        $this->assertNotUpdated();
    }

    /** @test */
    public function an_unauthenticated_user_cannot_edit_comment()
    {
        $this->get(route('comment.edit', ['comment' => $this->comment->id]))
            ->assertRedirect("/login");
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_comment()
    {
        $this->patchComment($this->comment, $this->update_data)
            ->assertRedirect("/login");

        $this->assertNotUpdated();
    }

    private function patchComment(Comment $comment, array $newData)
    {
        return $this->patch(route('comment.update', ['comment' => $comment->id]), $newData);
    }

    private function assertUpdated()
    {
        $this->assertDatabaseHas('comments', [
            'id' => $this->comment->id,
            'body' => $this->update_data['body']
        ]);
    }

    private function assertNotUpdated()
    {
        $this->assertDatabaseHas('comments', [
            'id' => $this->comment->id,
            'body' => $this->comment->body
        ]);
    }
}