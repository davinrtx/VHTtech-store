<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExchangeRateResource\Pages;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class ExchangeRateResource extends Resource
{
    protected static ?string $model = ExchangeRate::class;

    protected static ?string $modelLabel = 'Tasa de Cambio';
    protected static ?string $pluralModelLabel = 'Tasas de Cambio';
    protected static ?string $navigationLabel = 'Tasas de Cambio';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string | \UnitEnum | null $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('base')
                    ->label('Moneda base')
                    ->default('USD')
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                Forms\Components\TextInput::make('quote')
                    ->label('Moneda cotizada')
                    ->default('VES')
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                Forms\Components\TextInput::make('rate')
                    ->label('Tasa')
                    ->required()
                    ->numeric()
                    ->step(0.0001),
                Forms\Components\Select::make('source')
                    ->label('Fuente')
                    ->options([
                        'manual' => 'Manual',
                        'bcv' => 'BCV',
                    ])
                    ->default('manual')
                    ->required(),
                Forms\Components\DateTimePicker::make('fetched_at')
                    ->label('Consultada el')
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('base')
                    ->label('Moneda base')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quote')
                    ->label('Moneda cotizada')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rate')
                    ->label('Tasa')
                    ->numeric(4)
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')
                    ->label('Fuente')
                    ->badge(),
                Tables\Columns\TextColumn::make('fetched_at')
                    ->label('Consultada el')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
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
            'index' => Pages\ListExchangeRates::route('/'),
            'create' => Pages\CreateExchangeRate::route('/create'),
            'edit' => Pages\EditExchangeRate::route('/{record}/edit'),
        ];
    }
}
