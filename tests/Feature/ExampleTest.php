<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test home redirects to dashboard.
     */
    public function test_the_application_redirects_to_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/dashboard');
    }

    /**
     * Test dashboard returns 200 OK.
     */
    public function test_dashboard_returns_successful_response(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
    }
}
