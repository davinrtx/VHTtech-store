<?php

namespace App\Filament\Resources\AttributeResource\RelationManagers;

use App\Models\AttributeValue;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AttributeValueManager extends RelationManager
{
    protected static string $relationship = 'values';

    public function form(Schema $schema): Schema
    {
        $attribute = $this->getOwnerRecord();
        $isColor = $attribute && $attribute->type === 'color';

        return $schema
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(AttributeValue::class, 'slug', ignoreRecord: true),
                Forms\Components\TextInput::make('swatch')
                    ->label($isColor ? 'Color (hex)' : 'Swatch')
                    ->maxLength(255)
                    ->visible(fn () => $isColor),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                Tables\Columns\TextColumn::make('value'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ColorColumn::make('swatch')
                    ->visible(fn () => $this->getOwnerRecord()->type === 'color'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
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
}
