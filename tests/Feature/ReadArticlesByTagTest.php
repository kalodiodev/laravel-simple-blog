<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadArticlesByTagTest extends TestCase
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
        $response = $this->get('/tags/' . $this->tag->name);

        $response->assertSee($this->article->title);
    }
}