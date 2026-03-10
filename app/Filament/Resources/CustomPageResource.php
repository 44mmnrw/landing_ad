<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomPageResource\Pages;
use App\Models\CustomPage;
use App\Support\LandingContentCatalog;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class CustomPageResource extends Resource
{
    protected static ?string $model = CustomPage::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Пользовательские страницы';

    protected static ?string $modelLabel = 'Пользовательская страница';

    protected static ?string $pluralModelLabel = 'Пользовательские страницы';

    protected static string | UnitEnum | null $navigationGroup = 'Контент лендинга';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, callable $set, callable $get): void {
                        if ($operation === 'edit') {
                            return;
                        }

                        if (filled($get('slug'))) {
                            return;
                        }

                        $set('slug', Str::slug((string) $state));
                    }),
                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Будет доступно по адресу /pages/{slug}, например /pages/privacy-policy'),
                Select::make('icon')
                    ->label('Иконка страницы (sprite)')
                    ->searchable()
                    ->native(false)
                    ->options(LandingContentCatalog::spriteIconOptions())
                    ->helperText('Иконка будет показана рядом с заголовком страницы.'),
                RichEditor::make('content')
                    ->label('Содержимое страницы')
                    ->helperText('HTML-редактор для контента страницы. Рекомендуется использовать только доверенный контент.')
                    ->columnSpanFull(),
                TextInput::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->default(0)
                    ->required(),
                Toggle::make('is_published')
                    ->label('Опубликовано')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),
                TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->since()
                    ->sortable(),
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
            'index' => Pages\ListCustomPages::route('/'),
            'create' => Pages\CreateCustomPage::route('/create'),
            'edit' => Pages\EditCustomPage::route('/{record}/edit'),
        ];
    }
}
