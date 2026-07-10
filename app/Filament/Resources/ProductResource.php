<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\ProductImageManager;
use App\Filament\Resources\ProductResource\RelationManagers\ProductVariantManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $modelLabel = 'Producto';
    protected static ?string $pluralModelLabel = 'Productos';
    protected static ?string $navigationLabel = 'Productos';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cpu-chip';
    protected static string | \UnitEnum | null $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Tabs::make('Product')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nombre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('brand_id')
                                    ->label('Marca')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('categories')
                                    ->label('Categorías')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Textarea::make('short_description')
                                    ->label('Descripción corta')
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('description')
                                    ->label('Descripción')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('base_price')
                                    ->label('Precio base')
                                    ->required()
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Toggle::make('is_active')
                                            ->label('Activo')
                                            ->default(true),
                                        Forms\Components\Toggle::make('is_featured')
                                            ->label('Destacado')
                                            ->default(false),
                                        Forms\Components\Toggle::make('is_refurbished')
                                            ->label('Reacondicionado')
                                            ->default(false)
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                if (!$state) {
                                                    $set('refurbish_grade', null);
                                                }
                                            }),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('refurbish_grade')
                                            ->label('Grado')
                                            ->options([
                                                'A' => 'Grado A — Como nuevo',
                                                'B' => 'Grado B — Buen estado',
                                                'C' => 'Grado C — Funcional',
                                            ])
                                            ->visible(fn (Forms\Get $get) => $get('is_refurbished')),
                                        Forms\Components\TextInput::make('warranty_months')
                                            ->numeric()
                                            ->label('Garantía (meses)')
                                            ->suffix('meses'),
                                    ]),
                                Forms\Components\Textarea::make('condition_notes')
                                    ->label('Notas de condición')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Producto')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Marca')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->label('Precio base')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacado')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('refurbish_grade')
                    ->label('Grado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'warning',
                        'C' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Activo'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Destacado'),
                Tables\Filters\TernaryFilter::make('is_refurbished')
                    ->label('Reacondicionado'),
                Tables\Filters\SelectFilter::make('brand_id')
                    ->label('Marca')
                    ->relationship('brand', 'name'),
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

    public static function getRelations(): array
    {
        return [
            ProductImageManager::class,
            ProductVariantManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
