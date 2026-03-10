<?php

namespace Tests\Feature;

use Database\Seeders\ShipmentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_tracking_page_shows_shipment_from_database(): void
    {
        $this->seed(ShipmentSeeder::class);

        $response = $this->get(route('tracking', ['code' => 'TRK001']));

        $response->assertOk();
        $response->assertSee('TRK001');
        $response->assertSee('Китай → Новосибирск');
    }
}
