<?php

namespace App\Filament\Resources\RepairOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class StatusHistoryManager extends RelationManager
{
    protected static string $relationship = 'statusHistories';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('status')
                    ->label('Estado')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('note')
                    ->label('Nota'),
                Forms\Components\Select::make('created_by')
                    ->label('Creado por')
                    ->relationship('creator', 'name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('note')
                    ->label('Nota')
                    ->limit(50),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Creado por'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
