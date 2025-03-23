<?php

namespace Tests\Unit\Resources;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Tests\TestCase;

class CommentResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->comment = Comment::factory()->makeOne();
        $this->resource = CommentResource::make($this->comment);
    }

    public function test_toArray(): void
    {
        $result = $this->resource->toArray(new Request());

        $this->assertIsArray($result);
    }

    public function test_equals(): void
    {
        $this->assertEquals($this->comment->content, $this->resource['content']);
    }
}
