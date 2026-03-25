<?php

namespace Tests\Feature;

use App\Models\TrackingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_tracking_page_shows_tracking_data_from_real_tables(): void
    {
        TrackingEvent::query()->create([
            'event_uid' => 'page-test-evt-1',
            'tracking_number' => 'TRK-7K4M-Q9T2',
            'event_type' => 'departed',
            'status' => 'in_transit',
            'occurred_at' => '2026-03-24 12:40:00',
            'latitude' => 55.755826,
            'longitude' => 37.6173,
            'notes' => 'Отправлено',
            'source_system' => 'avtodostavka-main',
            'received_at' => now()->utc(),
        ]);

        $response = $this->get(route('tracking', ['code' => 'TRK-7K4M-Q9T2']));

        $response->assertOk();
        $response->assertSee('TRK-7K4M-Q9T2');
        $response->assertSee('В пути');
        $response->assertSee('Отправлено');
    }
}
