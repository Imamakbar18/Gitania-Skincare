<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase; // <-- Tambahkan ini
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase; // <-- Aktifkan trait ini di sini

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
