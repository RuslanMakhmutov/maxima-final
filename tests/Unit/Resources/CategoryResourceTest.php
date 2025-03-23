<?php

namespace Tests\Unit\Resources;

use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Tests\TestCase;

class CategoryResourceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->category = Category::factory()->makeOne();
        $this->resource = CategoryResource::make($this->category);
    }

    public function test_toArray(): void
    {
        $result = $this->resource->toArray(new Request());

        $this->assertIsArray($result);
    }

    public function test_equals(): void
    {
        $this->assertEquals($this->category->title, $this->resource['title']);
    }
}
