<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Jika home meng-redirect, ikuti redirect sampai halaman akhir dan pastikan status 200.
        $response = $this->followingRedirects()->get('/');
        $response->assertStatus(200);
    }
}