<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $modelLabel = 'Método de Pago';
    protected static ?string $pluralModelLabel = 'Métodos de Pago';
    protected static ?string $navigationLabel = 'Métodos de Pago';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-credit-card';
    protected static string | \UnitEnum | null $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Código')
                    ->required()
                    ->maxLength(255)
                    ->unique(PaymentMethod::class, 'code', ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gateway')
                    ->label('Pasarela')
                    ->options([
                        'manual' => 'Manual',
                        'pago_movil' => 'Pago Móvil',
                        'binance' => 'Binance',
                        'transfer' => 'Transferencia',
                        'zelle' => 'Zelle',
                        'card' => 'Tarjeta',
                        'cash' => 'Efectivo',
                    ])
                    ->default('manual')
                    ->required(),
                Forms\Components\KeyValue::make('instructions')
                    ->label('Instrucciones'),
                Forms\Components\Toggle::make('is_active')
                    ->label('Activo')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('Código')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gateway')
                    ->label('Pasarela')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activo'),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
