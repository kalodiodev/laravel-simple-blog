<?php

use App\Article;
use Tests\IntegrationTestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EditArticlesTest extends IntegrationTestCase
{

    use DatabaseMigrations;

    protected $article;

    // Data used to update article
    protected $update_data = [
        'title' => 'New Title',
        'description' => 'New description',
        'keywords' => 'Test',
        'body' => 'New article body',
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
        $this->signInAuthor();

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
        $this->signInGuest();

        $this->get('/article/' . $this->article->slug . '/edit')
            ->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_guest_cannot_update_other_users_article()
    {
        $this->signInGuest();

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
        $this->signInAdmin();

        $response = $this->get('/article/' . $this->article->slug . '/edit');

        $response->assertSee($this->article->title);
    }

    /** @test */
    public function an_admin_user_can_update_other_users_article()
    {
        $this->signInAdmin();

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
    function an_authorized_user_can_update_articles_featured_image()
    {
        Storage::fake('testfs');

        $this->createFakeFeaturedImage('image.jpg', true);
        $new_image = $this->createFakeFeaturedImage('new_image.jpg');

        $article = factory(Article::class)->create(['image' => 'image.jpg']);

        $this->signInAdmin();

        $this->patch('/article/' . $article->slug, [
            'title' => 'New title',
            'description' => 'New description',
            'body' => 'New body ...............',
            'image' => $new_image
        ])->assertStatus(302);

        $updated = Article::whereId($article->id)->first();

        $this->assertStringEndsWith('new_image.jpg',
            $updated->image, 'New image filename must end with new_image.jpg after timestamp');

        Storage::disk('testfs')->assertExists('images/featured/' . $updated->image);
        
        // Old image must be deleted
        Storage::disk('testfs')->assertMissing('images/featured/image.jpg');
    }

    /** @test */
    function an_authorized_user_can_delete_article_featured_image()
    {
        Storage::fake('testfs');
        $this->createFakeFeaturedImage('image.jpg', true);

        // An article with featured image, article must contain image filename
        $article = factory(Article::class)->create(['image' => 'image.jpg']);

        $this->signInAdmin();

        $this->patch('/article/' . $article->slug, [
            'title' => 'New title',
            'description' => 'New description',
            'body' => 'New body .................',
            'removeimage' => 'on'
        ])->assertStatus(302);

        $updated = Article::whereId($article->id)->first();

        $this->assertNull($updated->image, 'Article image filename must be null');

        Storage::disk('testfs')->assertMissing('images/featured/image.jpg');
    }

    protected function createFakeFeaturedImage($filename, bool $save = false)
    {
        $image = UploadedFile::fake()->image($filename);

        if($save)
        {
            $image->storeAs('images/featured/', $filename);
        }

        return $image;
    }
}