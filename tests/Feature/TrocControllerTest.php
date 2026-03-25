<?php

namespace Tests\Feature;

use App\Models\Troc;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrocControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_all_trocs()
    {
        // Arrange
        Troc::factory()->count(3)->create();

        // Act
        $response = $this->getJson('/api/trocs');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonCount(3);
    }

    public function test_can_create_troc()
    {
        // Arrange
        $trocData = [
            'user_id' => 1,
            'title' => 'Test Troc',
            'description' => 'Test Description',
            'type' => 'troc',
            'status' => 'active',
            'product_id_offered' => 1,
            'product_id_wanted' => 2
        ];

        // Act
        $response = $this->postJson('/api/trocs', $trocData);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('trocs', [
            'title' => 'Test Troc'
        ]);
    }

    public function test_can_show_troc()
    {
        // Arrange
        $troc = Troc::factory()->create();

        // Act
        $response = $this->getJson("/api/trocs/{$troc->id}");

        // Assert
        $response->assertStatus(200);
        $response->assertJson([
            'id' => $troc->id,
            'title' => $troc->title
        ]);
    }

    public function test_can_delete_troc()
    {
        // Arrange
        $troc = Troc::factory()->create();

        // Act
        $response = $this->deleteJson("/api/trocs/{$troc->id}");

        // Assert
        $response->assertStatus(200);
        $this->assertDatabaseMissing('trocs', [
            'id' => $troc->id
        ]);
    }
}
