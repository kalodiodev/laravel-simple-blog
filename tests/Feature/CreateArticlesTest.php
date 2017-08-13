<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateArticlesTest extends IntegrationTestCase
{

    use DatabaseMigrations;

    protected $article;
    
    /** @test */
    function an_author_user_can_create_an_article()
    {
        $user = factory(User::class)->create();
        $user = $this->giveUserRole($user, 'author');
        $article = factory(Article::class)->make(['user_id' => $user->id]);

        $this->signIn($user);
                
        $response = $this->post('/articles', $article->toArray());
        
        $this->get($response->headers->get('Location'))
            ->assertSee($article->title)
            ->assertSee($article->body);
    }

    /** @test */
    function an_authenticated_guest_cannot_create_an_article()
    {
        $user = factory(User::class)->create();
        $user = $this->giveUserRole($user, 'guest');

        $this->signIn($user);

        $this->get('/articles/create')
            ->assertStatus(403);
    }

    /** @test */
    function an_authenticated_guest_cannot_store_an_article()
    {
        $user = factory(User::class)->create();
        $user = $this->giveUserRole($user, 'guest');
        $article = factory(Article::class)->make(['user_id' => $user->id]);

        $this->signIn($user);

        $this->post('/articles', $article->toArray())
            ->assertStatus(403);
    }

    /** @test */
    function an_unauthenticated_user_cannot_create_an_article()
    {
        $this->get('/articles/create')
            ->assertRedirect('/login');

        $this->post('/articles')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_article_requires_a_title()
    {
        $response = $this->publish_article([ 'title' => null ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    function an_article_requires_a_description()
    {
        $response = $this->publish_article([ 'description' => null ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    function an_article_requires_a_body()
    {
        $response = $this->publish_article([ 'body' => null ]);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    function an_article_has_a_title_of_limited_length()
    {
        $response = $this->publish_article([ 'title' => str_random(101) ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    function an_article_has_a_description_of_limited_length()
    {
        $response = $this->publish_article([ 'description' => str_random(151) ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    function an_article_can_have_keywords_of_limited_length()
    {
        $response = $this->publish_article([ 'keywords' => str_random(61) ]);

        $response->assertSessionHasErrors('keywords');
    }

    private function publish_article($overrides = [])
    {
        $this->signIn();

        $article = factory(Article::class)->make($overrides);

        return $this->post('/articles', $article->toArray());
    }
}