<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase;

    // If you want to reset your database after each test

    public function setUp(): void
    {
        parent::setUp();
        // Setup code here (e.g., create users or roles in database)
    }

    /** @test */
    public function an_admin_or_operator_can_retrieve_users_list()
    {
        // Assuming you have a method to create users or an admin
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Act as the created admin
        $response = $this->actingAs($admin, 'sanctum')->json('GET', 'api/v1/users');
        // Assert the request was successful and a 200 status code was returned
        $response->assertStatus(200);
        // check page 2
        $response = $this->actingAs($admin, 'sanctum')->json('GET', 'api/v1/users?page=2');
        // Assert the request was successful and a 200 status code was returned
        $response->assertStatus(200);

        // all the same but for operator
        // Assuming you have a method to create users or an admin
        $operator = User::factory()->create([
            'role' => 'operator',
        ]);

        // Act as the created admin
        $response = $this->actingAs($operator, 'sanctum')->json('GET', 'api/v1/users');
        // Assert the request was successful and a 200 status code was returned
        $response->assertStatus(200);
        // check page 2
        $response = $this->actingAs($operator, 'sanctum')->json('GET', 'api/v1/users?page=2');
        // Assert the request was successful and a 200 status code was returned
        $response->assertStatus(200);
    }

    /** @test */
    public function an_customer_can_not_retrieve_users_list()
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        // Act as the created admin
        $response = $this->actingAs($customer, 'sanctum')->json('GET', 'api/v1/users');
        // Assert the request was successful and a 200 status code was returned
        $response->assertStatus(403);
    }


    /** @test */
    public function an_operator_cannot_create_an_admin()
    {
        $operator = User::factory()->create([
            'role' => 'operator',
        ]);

        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'mobile' => '1234567890',
            'role' => 'admin', // Attempt to create an admin user
            'password' => 'password',
        ];
        // Act as the operator
        $response = $this->actingAs($operator, 'sanctum')->json('POST', 'api/v1/users', $userData);

        // Assert the request was invalid date
        $response->assertStatus(422); // invalid date status
    }

    /** @test */
    public function an_operator_cannot_create_anything()
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'mobile' => '1234567890',
            'role' => 'customer',
            'password' => 'password',
        ];
        // Act as the operator
        $response = $this->actingAs($customer, 'sanctum')->json('POST', 'api/v1/users', $userData);

        // Assert the request was invalid date
        $response->assertStatus(403); // invalid date status
    }

    /** @test */
    public function a_user_can_be_updated_by_an_admin_or_operator()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $user = User::factory()->create();

        $updateData = [
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'janedoe@example.com',
            'role' => 'customer',
            'mobile' => '+1234567890',
        ];

        // Act as the admin
        $response = $this->actingAs($admin, 'sanctum')->json('PUT', "api/v1/users/{$user->id}", $updateData);

        // Assert the user was successfully updated
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'Jane',
            'last_name' => 'Doe',
            'email' => 'janedoe@example.com',
        ]);

        $operator = User::factory()->create([
            'role' => 'operator',
        ]);

        $user = User::factory()->create();

        $updateData = [
            'first_name' => 'john',
            'last_name' => 'watson',
            'email' => 'watson@gmail.com',
            'role' => 'operator',
            'mobile' => '+1234567891',
        ];

        // Act as the operator
        $response = $this->actingAs($operator, 'sanctum')->json('PUT', "api/v1/users/{$user->id}", $updateData);
        // Assert the user was successfully updated
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'first_name' => 'john',
            'last_name' => 'watson',
            'email' => 'watson@gmail.com',
        ]);
    }


    /** @test */
    public function a_user_can_be_deleted_by_an_admin_or_operator()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $user = User::factory()->create();

        // Act as the admin
        $response = $this->actingAs($admin, 'sanctum')->json('DELETE', "api/v1/users/{$user->id}");

        // Assert the user was successfully deleted
        $response->assertStatus(200);
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);

        $operator = User::factory()->create([
            'role' => 'operator',
        ]);

        $user = User::factory()->create();

        // Act as the operator
        $response = $this->actingAs($operator, 'sanctum')->json('DELETE', "api/v1/users/{$user->id}");

        // Assert the user was successfully deleted
        $response->assertStatus(200);
        $this->assertSoftDeleted('users', [
            'id' => $user->id,
        ]);
    }


    /** @test */
    public function a_operator_cant_delete_admin()
    {
        $operator = User::factory()->create([
            'role' => 'operator',
        ]);

        $user = User::factory()->create([
            'role'=>'admin'
        ]);

        // Act as the admin
        $response = $this->actingAs($operator, 'sanctum')->json('DELETE', "api/v1/users/{$user->id}");

        // Assert the user was successfully deleted
        $response->assertStatus(403);

    }
}
