<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    use RefreshDatabase; // <-- Tambahkan baris ini

    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
