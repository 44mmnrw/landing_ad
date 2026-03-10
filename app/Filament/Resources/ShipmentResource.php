<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Shipment;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Отправления';

    protected static ?string $modelLabel = 'Отправление';

    protected static ?string $pluralModelLabel = 'Отправления';

    protected static string | UnitEnum | null $navigationGroup = 'Операции';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('code')
                    ->label('Трек-код')
                    ->required()
                    ->maxLength(50),
                TextInput::make('route')
                    ->label('Маршрут')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cargo_type')
                    ->label('Тип груза')
                    ->required()
                    ->maxLength(255),
                TextInput::make('weight_kg')
                    ->label('Вес (кг)')
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01),
                Toggle::make('is_active')
                    ->label('Активно')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('code')
                    ->label('Трек-код')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('route')
                    ->label('Маршрут')
                    ->searchable()
                    ->limit(34),
                TextColumn::make('cargo_type')
                    ->label('Тип груза')
                    ->badge(),
                TextColumn::make('weight_kg')
                    ->label('Вес, кг')
                    ->numeric(decimalPlaces: 2),
                IconColumn::make('is_active')
                    ->label('Активно')
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
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
        ];
    }
}
