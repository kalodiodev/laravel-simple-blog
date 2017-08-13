<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\IntegrationTestCase;

class EditArticlesTest extends IntegrationTestCase
{

    use DatabaseMigrations;

    protected $article;

    // Data used to update article
    protected $update_data = [
        'title' => 'New Title',
        'description' => 'New description',
        'keywords' => 'Test',
        'body' => 'New article body'
    ];

    public function setUp()
    {
        parent::setUp();

        $this->article = factory(\App\Article::class)->create();
    }

    /** @test */
    public function an_author_user_can_edit_article_that_owns()
    {
        $user = $this->article->user;
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $response = $this->get('/article/' . $this->article->slug . '/edit');

        $response->assertSee($this->article->title);
    }

    /** @test */
    public function an_author_user_can_update_article_that_owns()
    {
        $user = $this->article->user;
        $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $this->patch('/article/' . $this->article->slug, $this->update_data)
            ->assertStatus(302);

        $this->assertDatabaseHas('articles', [
            'id' => $this->article->id,
            'title' => $this->update_data['title'],
            'description' => $this->update_data['description'],
            'keywords' => $this->update_data['keywords'],
            'body' => $this->update_data['body']
        ]);
    }

    /** @test */
    public function an_author_user_cannot_edit_other_users_article()
    {
        $user = factory(App\User::class)->create();
        $user = $this->giveUserRole($user, 'author');
        $this->signIn($user);

        $this->get('/article/' . $this->article->slug . '/edit')
            ->assertStatus(403);
    }

    /** @test */
    public function a_not_authenticated_user_may_not_edit_articles()
    {
        $this->get('/article/' . $this->article->slug . '/edit')
            ->assertRedirect('/login');

        $this->patch('/article/' . $this->article->slug)
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_guest_cannot_edit_articles()
    {
        $user = factory(App\User::class)->create();
        $user = $this->giveUserRole($user, 'guest');
        $this->signIn($user);

        $this->get('/article/' . $this->article->slug . '/edit')
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_guest_cannot_update_other_users_article()
    {
        $user = factory(App\User::class)->create();
        $user = $this->giveUserRole($user, 'guest');
        $this->signIn($user);

        $data = [
            'title' => 'New Title'
        ];

        $this->patch('/article/' . $this->article->slug, $data);

        $this->assertDatabaseMissing('articles', [
            'id' => $this->article->id,
            'title' => $data['title'],
        ]);
    }

    /** @test */
    public function an_admin_can_edit_other_users_articles()
    {
        $user = factory(App\User::class)->create();
        $this->giveUserRole($user, 'admin');
        $this->signIn($user);

        $response = $this->get('/article/' . $this->article->slug . '/edit');

        $response->assertSee($this->article->title);
    }

    /** @test */
    public function an_admin_user_can_update_other_users_article()
    {
        $user = factory(App\User::class)->create();
        $this->giveUserRole($user, 'admin');
        $this->signIn($user);

        $this->patch('/article/' . $this->article->slug, $this->update_data)
            ->assertStatus(302);

        $this->assertDatabaseHas('articles', [
            'id' => $this->article->id,
            'title' => $this->update_data['title'],
            'description' => $this->update_data['description'],
            'keywords' => $this->update_data['keywords'],
            'body' => $this->update_data['body']
        ]);
    }
}