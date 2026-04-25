<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

// === Ресурс: Заказы — просмотр и смена статуса ===
class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'Заказы';
    protected static ?string $modelLabel = 'Заказ';
    protected static ?string $pluralModelLabel = 'Заказы';

    // === БЛОК: Форма смены статуса ===
    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')
                ->label('Статус заказа')
                ->options(Order::$statusLabels)
                ->required(),
        ]);
    }

    // === БЛОК: Детальный просмотр заказа ===
    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            TextEntry::make('id')->label('№ заказа'),
            TextEntry::make('name')->label('Покупатель'),
            TextEntry::make('phone')->label('Телефон'),
            TextEntry::make('address')->label('Адрес'),
            TextEntry::make('total')->label('Сумма')->money('RUB'),
            TextEntry::make('status')
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
            TextEntry::make('created_at')->label('Дата')->dateTime('d.m.Y H:i'),
        ]);
    }

    // === БЛОК: Таблица заказов с кнопкой смены статуса ===
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('№')->sortable(),
                TextColumn::make('name')->label('Покупатель')->searchable(),
                TextColumn::make('phone')->label('Телефон'),
                TextColumn::make('address')->label('Адрес')->limit(30),
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
            // === Кнопки действий в каждой строке ===
            ->actions([
                // Кнопка "Статус" — открывает модальное окно со Select прямо в таблице
                Action::make('changeStatus')
                    ->label('Статус')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        Select::make('status')
                            ->label('Новый статус')
                            ->options(Order::$statusLabels)
                            ->required(),
                    ])
                    ->fillForm(fn(Order $record) => ['status' => $record->status])
                    ->action(fn(Order $record, array $data) => $record->update(['status' => $data['status']])),

                // Кнопка просмотра деталей заказа
                ViewAction::make()->label('Детали'),
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
