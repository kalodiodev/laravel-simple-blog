<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadArticlesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $article;

    public function setUp() {
        parent::setUp();

        $this->article = factory('App\Article')->create();
    }

    /** @test */
    public function a_user_can_view_all_articles()
    {
        $response = $this->get('/');

        $response->assertSee($this->article->title);
    }

    /** @test */
    public function a_user_can_view_an_article()
    {
        $response = $this->get('/article/' . $this->article->slug);

        $response->assertSee($this->article->title);
    }
}
