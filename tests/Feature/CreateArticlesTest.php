<?php

namespace Tests\Feature;

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateArticlesTest extends TestCase
{

    use DatabaseMigrations;

    protected $article;

    /** @test */
    function an_authenticated_user_can_create_an_article() {

        // TODO: Authenticate user
        
        $article = factory(Article::class)->make();
        
        $response = $this->post('/articles', $article->toArray());
        
        $this->get($response->headers->get('Location'))
            ->assertSee($article->title)
            ->assertSee($article->body);
    }

    /** @test */
    function an_article_requires_a_title() {

        $response = $this->publish_article([ 'title' => null ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    function an_article_requires_a_description() {

        $response = $this->publish_article([ 'description' => null ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    function an_article_requires_a_body() {

        $response = $this->publish_article([ 'body' => null ]);

        $response->assertSessionHasErrors('body');
    }

    /** @test */
    function an_article_has_a_title_of_limited_length() {

        $response = $this->publish_article([ 'title' => str_random(101) ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    function an_article_has_a_description_of_limited_length() {

        $response = $this->publish_article([ 'description' => str_random(151) ]);

        $response->assertSessionHasErrors('description');
    }

    /** @test */
    function an_article_can_have_keywords_of_limited_length() {

        $response = $this->publish_article([ 'keywords' => str_random(61) ]);

        $response->assertSessionHasErrors('keywords');
    }

    private function publish_article($overrides = [])
    {
        // TODO: Authenticate user

        $article = factory(Article::class)->make($overrides);

        return $this->post('/articles', $article->toArray());
    }
}