<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class EditArticlesTest extends TestCase
{

    use DatabaseMigrations;

    protected $article;

    public function setUp()
    {
        parent::setUp();

        $this->article = factory(\App\Article::class)->create();
    }

    /** @test */
    public function an_authenticated_user_can_edit_article()
    {
        // TODO: Authenticate user

        $response = $this->get('/article/' . $this->article->slug . '/edit');

        $response->assertSee($this->article->title);
    }

    /** @test */
    public function an_authenticated_user_can_update_article()
    {
        // TODO: Authenticate user

        $data = [
            'title' => 'New Title',
            'description' => 'New description',
            'keywords' => 'Test',
            'body' => 'New article body'
        ];

        $this->patch('/article/' . $this->article->slug, $data)
            ->assertStatus(302);

        $this->assertDatabaseHas('articles', [
            'id' => $this->article->id,
            'title' => $data['title'],
            'description' => $data['description'],
            'keywords' => $data['keywords'],
            'body' => $data['body']
        ]);
    }
}