<?php

namespace Tests\Unit\Resources;
use App\Http\Resources\Post\PostsListResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Tests\TestCase;

class PostsListResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->post = Post::factory()->makeOne();
        $this->resource = PostsListResource::make($this->post);
    }

    public function test_toArray(): void
    {
        $result = $this->resource->toArray(new Request());

        $this->assertIsArray($result);
    }

    public function test_equals(): void
    {
        $this->assertEquals($this->post->title, $this->resource['title']);
        $this->assertEquals($this->post->description, $this->resource['description']);
    }
}
