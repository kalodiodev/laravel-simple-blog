<?php

namespace Tests\Feature;

use App\Article;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteArticlesTest extends IntegrationTestCase
{

    use DatabaseMigrations;

    protected $article;

    public function setUp()
    {
        parent::setUp();

        $this->article = factory(Article::class)->create();
    }

    /** @test */
    public function an_authenticated_author_can_delete_an_article_that_owns()
    {
        $user = $this->article->user;
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $this->delete('/article/' . $this->article->slug)
            ->assertStatus(302);

        $this->assertDatabaseMissing('articles', [
            'id' => $this->article->id
        ]);
    }

    /** @test */
    public function an_authenticated_author_cannot_delete_other_users_article()
    {
        $this->signInAuthor();

        $this->delete('/article/' . $this->article->slug)
            ->assertStatus(403);

        $this->assertDatabaseHas('articles', [
            'id' => $this->article->id
        ]);
    }

    /** @test */
    public function an_authenticated_guest_cannot_delete_articles()
    {
        $this->signInGuest();

        $this->delete('/article/' . $this->article->slug)
            ->assertStatus(403);

        $this->assertDatabaseHas('articles', [
            'id' => $this->article->id
        ]);
    }

    /** @test */
    public function an_admin_can_delete_other_users_articles()
    {
        $this->signInAdmin();

        $this->delete('/article/' . $this->article->slug)
            ->assertStatus(302);

        $this->assertDatabaseMissing('articles', [
            'id' => $this->article->id
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_delete_an_article()
    {
        $this->delete('/article/' . $this->article->slug)
            ->assertRedirect('/login');
    }
}