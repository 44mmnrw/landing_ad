<?php

namespace Database\Seeders;

use App\Models\Shipment;
use Illuminate\Database\Seeder;

class ShipmentSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rows = [
            [
                'code' => 'TRK001',
                'route' => 'Китай → Новосибирск',
                'cargo_type' => 'Промышленное оборудование',
                'weight_kg' => 2500,
                'statuses' => [
                    ['title' => 'В пути на загрузку', 'place' => 'Отправлено из Москвы', 'happened_at' => '2026-03-01 10:00:00', 'is_done' => true],
                    ['title' => 'Загрузка', 'place' => 'Шанхай, Китай', 'happened_at' => '2026-03-05 14:30:00', 'is_done' => true],
                    ['title' => 'В пути на разгрузку', 'place' => 'В дороге', 'happened_at' => '2026-03-08 09:15:00', 'is_done' => true],
                    ['title' => 'Разгрузка', 'place' => 'Ожидается', 'happened_at' => null, 'is_done' => false],
                    ['title' => 'Завершено', 'place' => 'Ожидается', 'happened_at' => null, 'is_done' => false],
                ],
            ],
            [
                'code' => 'TRK002',
                'route' => 'Турция → Москва',
                'cargo_type' => 'Сборный груз',
                'weight_kg' => 1200,
                'statuses' => [
                    ['title' => 'В пути на загрузку', 'place' => 'Отправлено из Стамбула', 'happened_at' => '2026-03-03 08:45:00', 'is_done' => true],
                    ['title' => 'Загрузка', 'place' => 'Стамбул, Турция', 'happened_at' => '2026-03-04 17:20:00', 'is_done' => true],
                    ['title' => 'В пути на разгрузку', 'place' => 'В дороге', 'happened_at' => '2026-03-09 11:10:00', 'is_done' => true],
                    ['title' => 'Разгрузка', 'place' => 'Москва', 'happened_at' => '2026-03-12 09:00:00', 'is_done' => false],
                    ['title' => 'Завершено', 'place' => 'Ожидается', 'happened_at' => null, 'is_done' => false],
                ],
            ],
            [
                'code' => 'TRK003',
                'route' => 'Казахстан → Екатеринбург',
                'cargo_type' => 'Негабаритный груз',
                'weight_kg' => 3800,
                'statuses' => [
                    ['title' => 'В пути на загрузку', 'place' => 'Отправлено из Астаны', 'happened_at' => '2026-03-02 07:30:00', 'is_done' => true],
                    ['title' => 'Загрузка', 'place' => 'Астана, Казахстан', 'happened_at' => '2026-03-03 12:15:00', 'is_done' => true],
                    ['title' => 'В пути на разгрузку', 'place' => 'Екатеринбург', 'happened_at' => '2026-03-07 18:40:00', 'is_done' => true],
                    ['title' => 'Разгрузка', 'place' => 'Разгружено', 'happened_at' => '2026-03-08 10:05:00', 'is_done' => true],
                    ['title' => 'Завершено', 'place' => 'Доставка завершена', 'happened_at' => '2026-03-08 12:00:00', 'is_done' => true],
                ],
            ],
        ];

        foreach ($rows as $row) {
            $shipment = Shipment::query()->updateOrCreate(
                ['code' => $row['code']],
                [
                    'route' => $row['route'],
                    'cargo_type' => $row['cargo_type'],
                    'weight_kg' => $row['weight_kg'],
                    'is_active' => true,
                ]
            );

            $shipment->statuses()->delete();

            foreach ($row['statuses'] as $index => $status) {
                $shipment->statuses()->create([
                    'title' => $status['title'],
                    'place' => $status['place'],
                    'happened_at' => $status['happened_at'],
                    'is_done' => $status['is_done'],
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }
}
