<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

// === Ресурс: Категории товаров ===
// Позволяет добавлять/редактировать/удалять категории в /admin
class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Категории';
    protected static ?string $modelLabel = 'Категория';
    protected static ?string $pluralModelLabel = 'Категории';

    // === БЛОК: Форма создания/редактирования ===
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(100)
                ->live(onBlur: true)
                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),

            TextInput::make('slug')
                ->label('URL-имя (slug)')
                ->required()
                ->unique(Category::class, 'slug', ignoreRecord: true)
                ->maxLength(100),
        ]);
    }

    // === БЛОК: Таблица со списком категорий ===
    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('#')->sortable(),
            TextColumn::make('name')->label('Название')->searchable(),
            TextColumn::make('slug')->label('Slug'),
            TextColumn::make('products_count')
                ->label('Товаров')
                ->counts('products'),
        ])->defaultSort('id');
    }

    // === БЛОК: Страницы ресурса ===
    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
