<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Company;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    protected const uri = '/companies';

    /**
     * Get all companies
     */
    public function test_get_all_companies(): void
    {
        Company::factory()->count(5)->create();
        $response = $this->getJson(self::uri);
        $response->assertJsonCount(5, 'data');
        $response->assertStatus(200);
    }

    /**
     * Error get single company
     */
    public function test_error_get_one_company(): void
    {
        $company = "fake-url";
        $response = $this->getJson(self::uri . "/$company");
        $response->assertStatus(404);
    }

    /**
     * get single company
     */
    public function test_get_one_company(): void
    {
        $company = Company::factory()->create();
        $response = $this->getJson(self::uri . "/$company->uuid");
        $response->assertStatus(200);
    }

    /**
     * validation store company
     */
    public function test_validation_store_company(): void
    {
        $response = $this->postJson(self::uri, [
            'title' => '',
            'description' => '',
        ]);
        $response->assertStatus(422);
    }

    /**
     * store company
     */
    public function test_store_company(): void
    {
        $category = Category::factory()->create();
        $response = $this->postJson(self::uri, [
            'category_id'   => $category->id,
            'name'          => 'Nossos Avessos',
            'email'         => 'nossosavessos@gmail.com',
            'phone'         =>  '85982695887',
            'whatsapp'      =>  '85982695887',
        ]);
        $response->assertStatus(201);
    }

    /**
     * update company
     */
    public function test_update_company(): void
    {
        $company = Company::factory()->create();
        $category = Category::factory()->create();

        $data = [
            'category_id' => $category->id,
            'name' => 'Nossos Avessos update',
            'email'         => 'nossosavessos@gmail.com',
            'phone'         =>  '85982695887',
            'whatsapp'      =>  '85982695887',
        ];

        $response = $this->putJson(self::uri . "/fake-company", $data);
        $response->assertStatus(404);

        $response = $this->putJson(self::uri . "/{$company->uuid}", []);
        $response->assertStatus(422);

        $response = $this->putJson(self::uri . "/{$company->uuid}", $data);
        $response->assertStatus(200);
    }

    /**
     * delete company
     */
    public function test_delete_company(): void
    {
        $company = Company::factory()->create();

        $response = $this->deleteJson(self::uri . "/fake-company");
        $response->assertStatus(404);

        $response = $this->deleteJson(self::uri . "/{$company->uuid}");
        $response->assertStatus(204);
    }
}
