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
        $this->signIn($this->article->user);

        $response = $this->get('/article/' . $this->article->slug . '/edit');

        $response->assertSee($this->article->title);
    }

    /** @test */
    public function an_authenticated_user_can_update_article()
    {
        $this->signIn($this->article->user);

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

    /** @test */
    public function a_guest_may_not_edit_articles()
    {
        $this->get('/article/' . $this->article->slug . '/edit')
            ->assertRedirect('/login');

        $this->patch('/article/' . $this->article->slug)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_cannot_edit_other_users_article()
    {
        $this->signIn();

        $this->get('/article/' . $this->article->slug . '/edit')
            ->assertStatus(404);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_other_users_article()
    {
        $this->signIn();

        $data = [
            'title' => 'New Title'
        ];

        $this->patch('/article/' . $this->article->slug, $data);

        $this->assertDatabaseMissing('articles', [
            'id' => $this->article->id,
            'title' => $data['title'],
        ]);
    }
}