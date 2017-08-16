<?php

namespace Tests\Feature;

use App\Role;
use App\User;
use App\Article;
use App\Comment;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCommentsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_authorized_user_can_create_comment()
    {
        $user = factory(User::class)->create();
        $user = $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->make(['article_id' => $article->id]);


        $this->post(route('comment.store', ['slug' => $article->slug]), $comment->toArray())
            ->assertRedirect(route('article', ['slug' => $article->slug]));

        $this->assertDatabaseHas('comments', [
            'body' => $comment->body,
            'article_id' => $article->id
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_comment()
    {
        $article = factory(Article::class)->create();

        $this->post(route('comment.store', ['slug' => $article->slug]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_unauthorized_user_cannot_create_comment()
    {
        // Creating a new role with no permissions
        $role = Role::create(['name' => 'test']);

        $user = factory(User::class)->create(['role_id' => $role->id]);
        $this->signIn($user);

        $article = factory(Article::class)->create();
        $comment = factory(Comment::class)->make(['article_id' => $article->id]);

        $this->post(route('comment.store', ['slug' => $article->slug]), $comment->toArray())
            ->assertStatus(403);
    }

    /** @test */
    function a_comment_requires_a_body()
    {
        $response = $this->post_comment(['body' => '']);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    function a_comment_requires_a_body_with_min_length()
    {
        $response = $this->post_comment(['body' => 'a']);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    function a_comment_requires_a_body_with_max_length()
    {
        $response = $this->post_comment(['body' => str_random(351)]);

        $response->assertSessionHasErrors('body');
    }

    private function post_comment(array $overrides)
    {
        $this->signIn();

        $comment = factory(Comment::class)->make($overrides);
        $article = factory(Article::class)->create();

        return $this->post(route('comment.store',['slug' => $article->slug]), $comment->toArray());
    }
}