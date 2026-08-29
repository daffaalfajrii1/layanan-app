<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        DB::table('identity')->insert([
            'description' => 'Test identity',
            'google_maps' => 'Test map',
            'vision_mission' => 'Test vision',
            'task_function' => 'Test function',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
