<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_stores_quote_request(): void
    {
        $response = $this->post(route('quote-requests.store'), [
            'name' => 'Иван',
            'phone' => '+7 999 123-45-67',
            'route' => 'Москва → Казань',
            'cargo_type' => 'Сборный груз',
            'comment' => 'Тестовая заявка',
            'consent' => 'on',
            'source_page' => 'http://localhost/',
        ]);

        $response->assertSessionHas('quote_success');

        $this->assertDatabaseHas('quote_requests', [
            'name' => 'Иван',
            'route' => 'Москва → Казань',
            'status' => 'new',
            'consent' => true,
        ]);
    }
}
