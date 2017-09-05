<?php

namespace Tests\Feature;

use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadArticlesByTagTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $article;
    protected $tag;

    public function setUp()
    {
        parent::setUp();

        $this->article = factory('App\Article')->create();
        $this->tag = factory('App\Tag')->create();
        
        $this->article->tags()->attach($this->tag);
    }
    
    /** @test */
    public function a_user_can_view_all_articles_with_tag() 
    {
        $response = $this->get('/tag/' . $this->tag->name);

        $response->assertSee($this->article->title);
    }
}