<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/404');

        $response->assertStatus(404);
    }

    public function test_post_index(): void
    {
        $response = $this->get('/post');

        $response->assertStatus(200);
    }
}
