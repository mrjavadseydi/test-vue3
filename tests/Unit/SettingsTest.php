<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    // If you want to reset your database after each test

    public function setUp(): void
    {
        parent::setUp();
        // Setup code here (e.g., create users or roles in database)
    }


    /** @test */
    public function get_lists_all_available_settings_options_for_an_admin_user()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'sanctum')->json('GET', "api/v1/settings");
        $response->assertOk()
            ->assertJson(
                [
                    'route' => [
                        'cache',
                        'clear'
                    ],
                    'config' => [
                        'cache',
                        'clear'
                    ],
                    'view' => [
                        'cache',
                        'clear'
                    ],
                    'cache' => [
                        'clear'
                    ],
                    'optimize' => [
                        'optimize',
                        'clear'
                    ]
                ]
            );
    }

    /** @test */
    public function an_admin_user_can_clear_route_cache()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'sanctum')->json('POST', "api/v1/settings", [
            'option' => 'route',
            'action' => 'clear',
        ]);

        $response->assertOk()
            ->assertJson(['message' => 'Operation successful']);
    }

    /** @test */
    public function prevents_unauthorized_access_to_settings_options()
    {
        $nonAdmin = User::factory()->create([
            'role' => 'operator',
        ]);

        $response = $this->actingAs($nonAdmin, 'sanctum')->json('GET', "api/v1/settings");

        $response->assertForbidden();
        $nonAdmin = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($nonAdmin, 'sanctum')->json('GET', "api/v1/settings");

        $response->assertForbidden();
    }

    /** @test */
    public function it_returns_error_for_invalid_settings_option()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin, 'sanctum')->json('POST', "api/v1/settings", [
            'option' => 'invalid',
            'action' => 'invalid',
        ]);

        $response->assertStatus(422);
    }
}
