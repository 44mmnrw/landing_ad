<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use App\Support\LandingContentCatalog;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Настройки сайта';

    protected static ?string $modelLabel = 'Настройка сайта';

    protected static ?string $pluralModelLabel = 'Настройки сайта';

    protected static string | UnitEnum | null $navigationGroup = 'Контент лендинга';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->native(false)
                    ->options(LandingContentCatalog::siteSettingOptions())
                    ->required()
                    ->helperText('Выберите понятный ключ из списка. Для нестандартных параметров оставьте отдельный технический ресурс.'),
                RichEditor::make('value')
                    ->label('Значение')
                    ->columnSpanFull(),
                Toggle::make('is_public')
                    ->label('Публично')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('key')
            ->columns([
                TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => LandingContentCatalog::siteSettingOptions()[$state] ?? $state)
                    ->sortable(),
                TextColumn::make('value')
                    ->label('Значение')
                    ->html()
                    ->wrap(),
                IconColumn::make('is_public')
                    ->label('Публично')
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
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}
