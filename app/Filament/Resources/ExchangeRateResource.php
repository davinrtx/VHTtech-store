<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExchangeRateResource\Pages;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExchangeRateResource extends Resource
{
    protected static ?string $model = ExchangeRate::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';
    protected static string | \UnitEnum | null $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('base')
                    ->default('USD')
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                Forms\Components\TextInput::make('quote')
                    ->default('VES')
                    ->disabled()
                    ->dehydrated(true)
                    ->required(),
                Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric()
                    ->step(0.0001),
                Forms\Components\Select::make('source')
                    ->options([
                        'manual' => 'Manual',
                        'bcv' => 'BCV',
                    ])
                    ->default('manual')
                    ->required(),
                Forms\Components\DateTimePicker::make('fetched_at')
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('base')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quote')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rate')
                    ->numeric(4)
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')
                    ->badge(),
                Tables\Columns\TextColumn::make('fetched_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
