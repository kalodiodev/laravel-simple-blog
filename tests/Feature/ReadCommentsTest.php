<?php

namespace Tests\Feature;

use App\Comment;
use Tests\IntegrationTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadCommentsTest extends IntegrationTestCase
{
    use DatabaseMigrations;

    protected $comment;

    public function setUp() {
        parent::setUp();

        $this->comment = factory(Comment::class)->create();
    }

    /** @test */
    public function a_user_can_view_comments()
    {
        $response = $this->get(route('article', ['slug' => $this->comment->article->slug]));

        $response->assertSee($this->comment->body);
    }
}