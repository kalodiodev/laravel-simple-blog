<?php

namespace Tests\Feature;

use App\Article;
use App\Comment;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteCommentsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $article;
    protected $comment;

    public function setUp()
    {
        parent::setUp();

        $this->article = factory(Article::class)->create();
        $this->comment = factory(Comment::class)->create(['article_id' => $this->article->id]);
    }

    /** @test */
    public function a_user_can_delete_a_comment_that_owns_when_has_permission()
    {
        $user = $this->signInAuthor();

        $comment = factory(Comment::class)->create([
            'user_id' => $user->id,
            'article_id' => $this->article->id
        ]);

        $this->delete(route('comment.delete', ['comment' => $comment->id]))
            ->assertStatus(302);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }

    /** @test */
    public function a_user_can_delete_a_comment_in_article_that_owns_when_has_permission()
    {
        $user = $this->signInAuthor();

        $article = factory(Article::class)->create(['user_id' => $user->id]);
        $comment = factory(Comment::class)->create(['article_id' => $article->id]);

        $this->delete(route('comment.delete', ['comment' => $comment->id]))
            ->assertStatus(302);

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }

    /** @test */
    public function an_authorized_user_cannot_delete_a_comment_in_article_that_does_not_own()
    {
        $this->signInAuthor();

        $this->delete(route('comment.delete', ['comment' => $this->comment->id]))
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', [
            'id' => $this->comment->id
        ]);
    }

    /** @test */
    public function an_authenticated_user_cannot_delete_comments_when_has_no_permission()
    {
        $this->signInGuest();

        $this->delete(route('comment.delete', ['comment' => $this->comment->id]))
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', [
            'id' => $this->comment->id
        ]);
    }

    /** @test */
    public function an_authenticated_user_cannot_delete_comment_that_owns_when_has_no_permission()
    {
        $user = $this->signInGuest();

        $comment = factory(Comment::class)->create(['user_id' => $user->id]);

        $this->delete(route('comment.delete', ['comment' => $comment->id]))
            ->assertStatus(403);

        $this->assertDatabaseHas('comments', [
            'id' => $this->comment->id
        ]);
    }

    /** @test */
    public function a_user_can_delete_any_comment_when_has_permission()
    {
        $this->signInAdmin();

        $this->delete(route('comment.delete', ['comment' => $this->comment->id]))
            ->assertStatus(302);

        $this->assertDatabaseMissing('comments', [
            'id' => $this->comment->id
        ]);
    }
}