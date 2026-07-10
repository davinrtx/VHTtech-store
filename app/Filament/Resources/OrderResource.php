<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $modelLabel = 'Pedido';
    protected static ?string $pluralModelLabel = 'Pedidos';
    protected static ?string $navigationLabel = 'Pedidos';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-shopping-bag';
    protected static string | \UnitEnum | null $navigationGroup = 'Ventas';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Información del pedido')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Pedido #')
                            ->disabled(),
                        Forms\Components\Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->label('Estado')
                            ->options([
                                'pending' => 'Pendiente',
                                'paid' => 'Pagado',
                                'shipping' => 'En envío',
                                'delivered' => 'Entregado',
                                'cancelled' => 'Cancelado',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax')
                            ->label('Impuesto')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_cost')
                            ->label('Envío')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('usd_to_ves_rate')
                                    ->label('Tasa USD/VES')
                                    ->numeric()
                                    ->disabled(),
                                Forms\Components\TextInput::make('ves_total')
                                    ->label('Total en VES')
                                    ->numeric()
                                    ->prefix('VES')
                                    ->disabled(),
                            ]),
                        ]),
                Forms\Components\Section::make('Direcciones')
                    ->schema([
                        Forms\Components\KeyValue::make('billing_address')
                            ->label('Dirección de facturación')
                            ->disabled(),
                        Forms\Components\KeyValue::make('shipping_address')
                            ->label('Dirección de envío')
                            ->disabled(),
                    ]),
                Forms\Components\Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->label('Pedido #')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'paid' => 'success',
                        'shipping' => 'info',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pendiente',
                        'paid' => 'Pagado',
                        'shipping' => 'En envío',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ves_total')
                    ->label('VES')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
                    ->options([
                        'pending' => 'Pendiente',
                        'paid' => 'Pagado',
                        'shipping' => 'En envío',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            OrderItemManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
