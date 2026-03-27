<?php

namespace Tests\Feature;

use App\Models\TrackingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TrackingApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('tracking.internal.hmac_secret', 'test-shared-secret');
        config()->set('tracking.internal.require_https', false);
        config()->set('tracking.internal.allowed_ips', ['127.0.0.1']);
        config()->set('tracking.internal.clock_skew_seconds', 300);
    }

    public function test_it_accepts_valid_internal_tracking_event(): void
    {
        $payload = $this->makePayload([
            'event_uid' => 'evt-100',
            'event_type' => 'loading_started',
            'status' => 'loading',
            'occurred_at' => '2026-03-24T12:35:20Z',
        ]);

        $response = $this->postSignedEvent($payload);

        $response->assertOk()
            ->assertJson([
                'ok' => true,
                'duplicate' => false,
            ]);

        $this->assertDatabaseHas('tracking_events', [
            'event_uid' => 'evt-100',
            'tracking_number' => 'TRK-7K4M-Q9T2',
            'status' => 'loading',
        ]);
    }

    public function test_it_is_idempotent_for_duplicate_event_uid(): void
    {
        $payload = $this->makePayload([
            'event_uid' => 'evt-200',
            'event_type' => 'loading_done',
            'status' => 'in_transit',
            'occurred_at' => '2026-03-24T12:45:20Z',
        ]);

        $first = $this->postSignedEvent($payload);
        $second = $this->postSignedEvent($payload);

        $first->assertOk();
        $second->assertOk()->assertJson([
            'ok' => true,
            'duplicate' => true,
        ]);

        $this->assertSame(1, TrackingEvent::query()->where('event_uid', 'evt-200')->count());
    }

    public function test_it_rejects_invalid_hmac_signature(): void
    {
        $payload = $this->makePayload([
            'event_uid' => 'evt-300',
        ]);

        $rawBody = json_encode($payload, JSON_THROW_ON_ERROR);
        $timestamp = (string) Carbon::now('UTC')->timestamp;

        $response = $this->call('POST', '/api/internal/tracking/events', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_TIMESTAMP' => $timestamp,
            'HTTP_X_SIGNATURE' => 'bad-signature',
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTPS' => 'on',
        ], $rawBody);

        $response->assertStatus(401);
    }

    public function test_old_event_does_not_override_latest_status_projection(): void
    {
        $newerPayload = $this->makePayload([
            'event_uid' => 'evt-400',
            'event_type' => 'unloading_done',
            'status' => 'completed',
            'occurred_at' => '2026-03-24T13:15:20Z',
        ]);

        $olderPayload = $this->makePayload([
            'event_uid' => 'evt-401',
            'event_type' => 'loading_started',
            'status' => 'loading',
            'occurred_at' => '2026-03-24T12:15:20Z',
        ]);

        $this->postSignedEvent($newerPayload)->assertOk();
        $this->postSignedEvent($olderPayload)->assertOk();

        $latestEvent = TrackingEvent::query()
            ->where('tracking_number', 'TRK-7K4M-Q9T2')
            ->orderByDesc('occurred_at')
            ->orderByDesc('id')
            ->firstOrFail();

        $this->assertSame('completed', $latestEvent->status);
        $this->assertSame('unloading_done', $latestEvent->event_type);
        $this->assertTrue(
            $latestEvent->occurred_at?->equalTo(Carbon::parse('2026-03-24T13:15:20Z')) ?? false
        );
    }

    public function test_public_tracking_endpoint_returns_aggregate_and_history(): void
    {
        $firstPayload = $this->makePayload([
            'event_uid' => 'evt-500',
            'event_type' => 'loading_started',
            'status' => 'loading',
            'occurred_at' => '2026-03-24T10:00:00Z',
        ]);

        $secondPayload = $this->makePayload([
            'event_uid' => 'evt-501',
            'event_type' => 'departed',
            'status' => 'in_transit',
            'occurred_at' => '2026-03-24T11:00:00Z',
        ]);

        $this->postSignedEvent($firstPayload)->assertOk();
        $this->postSignedEvent($secondPayload)->assertOk();

        $response = $this->getJson('/api/public/tracking/TRK-7K4M-Q9T2');

        $response->assertOk()
            ->assertJsonPath('tracking_number', 'TRK-7K4M-Q9T2')
            ->assertJsonPath('current_status', 'in_transit')
            ->assertJsonCount(2, 'events')
            ->assertJsonPath('events.0.event_type', 'departed')
            ->assertJsonPath('events.1.event_type', 'loading_started')
            ->assertJsonMissingPath('events.0.event_uid');
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function makePayload(array $overrides = []): array
    {
        return array_merge([
            'tracking_number' => 'TRK-7K4M-Q9T2',
            'event_uid' => 'evt-default',
            'event_type' => 'loading_started',
            'status' => 'loading',
            'occurred_at' => '2026-03-24T12:35:20Z',
            'latitude' => 55.755826,
            'longitude' => 37.6173,
            'notes' => 'Shipment update',
            'source_system' => 'avtodostavka-main',
            'sent_at' => '2026-03-24T12:35:21Z',
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function postSignedEvent(array $payload)
    {
        $rawBody = json_encode($payload, JSON_THROW_ON_ERROR);
        $timestamp = (string) Carbon::now('UTC')->timestamp;
        $signature = hash_hmac('sha256', $timestamp.$rawBody, (string) config('tracking.internal.hmac_secret'));

        return $this->call('POST', '/api/internal/tracking/events', [], [], [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_X_TIMESTAMP' => $timestamp,
            'HTTP_X_SIGNATURE' => $signature,
            'REMOTE_ADDR' => '127.0.0.1',
            'HTTPS' => 'on',
        ], $rawBody);
    }
}
