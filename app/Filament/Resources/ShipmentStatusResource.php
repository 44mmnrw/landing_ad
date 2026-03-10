<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentStatusResource\Pages;
use App\Models\Shipment;
use App\Models\ShipmentStatus;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShipmentStatusResource extends Resource
{
    protected static ?string $model = ShipmentStatus::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationLabel = 'Статусы отправлений';

    protected static ?string $modelLabel = 'Статус отправления';

    protected static ?string $pluralModelLabel = 'Статусы отправлений';

    protected static string | UnitEnum | null $navigationGroup = 'Операции';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('shipment_id')
                    ->label('Отправление')
                    ->required()
                    ->searchable()
                    ->options(Shipment::query()->orderBy('code')->pluck('code', 'id')),
                TextInput::make('title')
                    ->label('Статус')
                    ->required()
                    ->maxLength(255),
                TextInput::make('place')
                    ->label('Локация')
                    ->maxLength(255),
                DateTimePicker::make('happened_at')
                    ->label('Дата и время'),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->required()
                    ->default(1)
                    ->minValue(1),
                Toggle::make('is_done')
                    ->label('Выполнено')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('shipment.code')
                    ->label('Трек-код')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Статус')
                    ->searchable(),
                TextColumn::make('place')
                    ->label('Локация')
                    ->limit(28),
                TextColumn::make('happened_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
                IconColumn::make('is_done')
                    ->label('Готово')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipmentStatuses::route('/'),
            'create' => Pages\CreateShipmentStatus::route('/create'),
            'edit' => Pages\EditShipmentStatus::route('/{record}/edit'),
        ];
    }
}
