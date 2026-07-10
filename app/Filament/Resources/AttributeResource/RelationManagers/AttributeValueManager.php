<?php

namespace App\Filament\Resources\AttributeResource\RelationManagers;

use App\Models\AttributeValue;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Actions;
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
                    ->label('Valor')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(AttributeValue::class, 'slug', ignoreRecord: true),
                Forms\Components\TextInput::make('swatch')
                    ->label($isColor ? 'Color (hex)' : 'Muestra')
                    ->maxLength(255)
                    ->visible(fn () => $isColor),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor'),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug'),
                Tables\Columns\ColorColumn::make('swatch')
                    ->label('Color')
                    ->visible(fn () => $this->getOwnerRecord()->type === 'color'),
            ])
            ->filters([])
            ->headerActions([
                Actions\CreateAction::make(),
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
}
