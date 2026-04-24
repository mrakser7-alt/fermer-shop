<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

// === Ресурс: Заказы ===
// Только просмотр и смена статуса (создавать заказы через сайт)
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Заказы';
    protected static ?string $modelLabel = 'Заказ';
    protected static ?string $pluralModelLabel = 'Заказы';

    // === БЛОК: Форма (только смена статуса) ===
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')
                ->label('Статус заказа')
                ->options(Order::$statusLabels)
                ->required(),
        ]);
    }

    // === БЛОК: Просмотр деталей заказа ===
    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('id')->label('№ заказа'),
            TextEntry::make('name')->label('Имя'),
            TextEntry::make('phone')->label('Телефон'),
            TextEntry::make('address')->label('Адрес'),
            TextEntry::make('total')->label('Сумма')->money('RUB'),
            TextEntry::make('status')
                ->label('Статус')
                ->formatStateUsing(fn($state) => Order::$statusLabels[$state] ?? $state),
            TextEntry::make('created_at')->label('Дата')->dateTime('d.m.Y H:i'),
        ]);
    }

    // === БЛОК: Таблица заказов ===
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('№')->sortable(),
                TextColumn::make('name')->label('Покупатель')->searchable(),
                TextColumn::make('phone')->label('Телефон'),
                TextColumn::make('total')->label('Сумма')->money('RUB')->sortable(),
                TextColumn::make('status')
                    ->label('Статус')
                    ->formatStateUsing(fn($state) => Order::$statusLabels[$state] ?? $state)
                    ->badge()
                    ->color(fn($state) => match($state) {
                        'new'        => 'info',
                        'processing' => 'warning',
                        'completed'  => 'success',
                        'cancelled'  => 'danger',
                        default      => 'gray',
                    }),
                TextColumn::make('created_at')->label('Дата')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(Order::$statusLabels),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view'  => Pages\ViewOrder::route('/{record}'),
            'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
