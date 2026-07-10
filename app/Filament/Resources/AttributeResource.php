<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\RelationManagers\AttributeValueManager;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-list-bullet';
    protected static string | \UnitEnum | null $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Attribute::class, 'slug', ignoreRecord: true),
                Forms\Components\Select::make('type')
                    ->options([
                        'select' => 'Select',
                        'color' => 'Color',
                        'number' => 'Número',
                        'text' => 'Texto',
                    ])
                    ->default('select')
                    ->required(),
                Forms\Components\Toggle::make('is_variant')
                    ->label('¿Es variante?')
                    ->helperText('Define variantes de producto (talla, color, etc.)'),
                Forms\Components\Toggle::make('is_filterable')
                    ->label('¿Filtrable?')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_variant')
                    ->label('Variante')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_filterable')
                    ->label('Filtrable')
                    ->boolean(),
                Tables\Columns\TextColumn::make('values_count')
                    ->counts('values')
                    ->label('Valores'),
            ])
            ->defaultSort('sort_order')
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

    public static function getRelations(): array
    {
        return [
            AttributeValueManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
