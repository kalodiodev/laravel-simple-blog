<?php

namespace Tests\Feature;

use App\Article;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ArchivesTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        factory('App\Article', 3)->create();
    }

    /** @test */
    public function a_user_can_view_archives_of_year_month()
    {
        $article = Article::latest()->first();

        $response = $this->get('/archives/' .
            $article->created_at->year . '/' .
            $article->created_at->month);

        $response->assertSee($article->title);
    }

    /** @test */
    public function a_user_can_view_archives_of_year()
    {
        $article = Article::latest()->first();

        $response = $this->get('/archives/' . $article->created_at->year);

        $response->assertSee($article->title);
    }

    /** @test */
    public function a_user_should_not_view_archives_of_different_month()
    {
        $article = Article::latest()->first();

        $response = $this->get('/archives/' .
            $article->created_at->year . '/' .
            $article->created_at->submonth(1)->month);

        $response->assertDontSee($article->title);
    }

    /** @test */
    public function a_user_should_not_view_archives_of_different_year()
    {
        $article = Article::latest()->first();

        $response = $this->get('/archives/' .
            $article->created_at->subyear(1)->year . '/' .
            $article->created_at->month);

        $response->assertDontSee($article->title);
    }

    /** @test */
    public function a_user_should_be_redirected_to_homepage_when_no_date()
    {
        $this->get('/archives/')
            ->assertRedirect(route('home'));
    }
}