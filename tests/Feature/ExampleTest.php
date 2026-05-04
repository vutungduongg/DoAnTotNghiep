<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $cat = Category::create([
            'name' => 'Áo đấu',
            'slug' => 'ao-dau',
            'is_active' => true,
        ]);

        Product::create([
            'category_id' => $cat->id,
            'name' => 'Áo test',
            'slug' => 'ao-test',
            'base_price' => 100000,
            'is_active' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
