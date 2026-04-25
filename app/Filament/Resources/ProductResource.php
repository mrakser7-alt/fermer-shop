<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

// === Ресурс: Товары ===
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationLabel = 'Товары';
    protected static ?string $modelLabel = 'Товар';
    protected static ?string $pluralModelLabel = 'Товары';

    // === БЛОК: Форма товара ===
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('category_id')
                ->label('Категория')
                ->options(Category::pluck('name', 'id'))
                ->required(),

            TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(200),

            TextInput::make('price')
                ->label('Цена (₽)')
                ->numeric()
                ->required()
                ->prefix('₽'),

            Textarea::make('description')
                ->label('Описание')
                ->rows(3)
                ->nullable(),

            Toggle::make('in_stock')
                ->label('В наличии')
                ->default(true),
        ]);
    }

    // === БЛОК: Таблица товаров ===
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('name')->label('Название')->searchable(),
                TextColumn::make('category.name')->label('Категория'),
                TextColumn::make('price')->label('Цена')->money('RUB')->sortable(),
                IconColumn::make('in_stock')->label('В наличии')->boolean(),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Категория')
                    ->options(Category::pluck('name', 'id')),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
