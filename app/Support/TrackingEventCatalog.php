<?php

namespace App\Support;

class TrackingEventCatalog
{
    public const EVENT_TO_STATUS = [
        'loading_started' => 'loading',
        'loading_done' => 'in_transit',
        'departed' => 'in_transit',
        'arrived' => 'in_transit',
        'unloading_started' => 'unloading',
        'unloading_done' => 'completed',
    ];

    /**
     * @return array<int, string>
     */
    public static function knownEventTypes(): array
    {
        return array_keys(self::EVENT_TO_STATUS);
    }

    /**
     * @return array<int, string>
     */
    public static function statusValues(): array
    {
        return ['assigned', 'loading', 'in_transit', 'unloading', 'completed'];
    }

    /**
     * @return array<int, string>
     */
    public static function inboundStatusValues(): array
    {
        return ['loading', 'in_transit', 'unloading', 'completed'];
    }

    public static function statusFromEventType(string $eventType): ?string
    {
        return self::EVENT_TO_STATUS[$eventType] ?? null;
    }

    /**
     * @return array<string, string>
     */
    public static function statusLabels(): array
    {
        return [
            'assigned' => 'Назначено',
            'loading' => 'Погрузка',
            'in_transit' => 'В пути',
            'unloading' => 'Разгрузка',
            'completed' => 'Завершено',
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function eventLabels(): array
    {
        return [
            'loading_started' => 'Погрузка началась',
            'loading_done' => 'Погрузка завершена',
            'departed' => 'Отправлено',
            'arrived' => 'Прибыло в пункт назначения',
            'unloading_started' => 'Разгрузка началась',
            'unloading_done' => 'Разгрузка завершена',
        ];
    }
}
