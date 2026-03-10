<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuoteRequestResource\Pages;
use App\Models\QuoteRequest;
use BackedEnum;
use UnitEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QuoteRequestResource extends Resource
{
    protected static ?string $model = QuoteRequest::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Заявки на расчет';

    protected static ?string $modelLabel = 'Заявка на расчет';

    protected static ?string $pluralModelLabel = 'Заявки на расчет';

    protected static string | UnitEnum | null $navigationGroup = 'Операции';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->required()
                    ->maxLength(255),
                TextInput::make('route')
                    ->label('Маршрут')
                    ->required()
                    ->maxLength(255),
                TextInput::make('cargo_type')
                    ->label('Тип груза')
                    ->required()
                    ->maxLength(255),
                Textarea::make('comment')
                    ->label('Комментарий')
                    ->rows(4)
                    ->maxLength(2000),
                TextInput::make('source_page')
                    ->label('Страница-источник')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Статус')
                    ->required()
                    ->options([
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Завершена',
                        'rejected' => 'Отклонена',
                    ]),
                Toggle::make('consent')
                    ->label('Согласие на обработку'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Дата')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                TextColumn::make('route')
                    ->label('Маршрут')
                    ->searchable()
                    ->limit(36),
                TextColumn::make('cargo_type')
                    ->label('Тип груза')
                    ->badge(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options([
                        'new' => 'Новая',
                        'in_progress' => 'В работе',
                        'done' => 'Завершена',
                        'rejected' => 'Отклонена',
                    ]),
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
            'index' => Pages\ListQuoteRequests::route('/'),
            'edit' => Pages\EditQuoteRequest::route('/{record}/edit'),
        ];
    }
}
