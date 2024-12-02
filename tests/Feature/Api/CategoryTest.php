<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected const uri = '/categories';

    /**
     * Get all categories
     */
    public function test_get_all_categories(): void
    {
        Category::factory()->count(5)->create();
        $response = $this->getJson(self::uri);
        $response->assertJsonCount(5, 'data');
        $response->assertStatus(200);
    }

    /**
     * Error get single category
     */
    public function test_error_get_one_category(): void
    {
        $category = "fake-url";
        $response = $this->getJson(self::uri . "/$category");
        $response->assertStatus(404);
    }

    /**
     * get single category
     */
    public function test_get_one_category(): void
    {
        $category = Category::factory()->create();
        $response = $this->getJson(self::uri . "/$category->url");
        $response->assertStatus(200);
    }

    /**
     * validation store category
     */
    public function test_validation_store_category(): void
    {
        $response = $this->postJson(self::uri, [
            'title' => '',
            'description' => '',
        ]);
        $response->assertStatus(422);
    }

    /**
     * store category
     */
    public function test_store_category(): void
    {
        $response = $this->postJson(self::uri, [
            'title' => 'category 01',
            'description' => 'description category 01',
        ]);
        $response->assertStatus(201);
    }

    /**
     * update category
     */
    public function test_update_category(): void
    {
        $category = Category::factory()->create();
        $data = [
            'title' => 'category update',
            'description' => 'description category update',
        ];

        $response = $this->putJson(self::uri . "/fake-category", $data);
        $response->assertStatus(404);

        $response = $this->putJson(self::uri . "/{$category->url}", []);
        $response->assertStatus(422);

        $response = $this->putJson(self::uri . "/{$category->url}", $data);
        $response->assertStatus(200);
    }

    /**
     * delete category
     */
    public function test_delete_category(): void
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson(self::uri . "/fake-category");
        $response->assertStatus(404);

        $response = $this->deleteJson(self::uri . "/{$category->url}");
        $response->assertStatus(204);
    }
}
