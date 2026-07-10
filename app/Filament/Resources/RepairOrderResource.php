<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepairOrderResource\Pages;
use App\Filament\Resources\RepairOrderResource\RelationManagers\StatusHistoryManager;
use App\Models\RepairOrder;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RepairOrderResource extends Resource
{
    protected static ?string $model = RepairOrder::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wrench';
    protected static string | \UnitEnum | null $navigationGroup = 'Reparaciones';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Información del equipo')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('device_type')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('brand')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('model')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('serial')
                                    ->maxLength(255),
                            ]),
                    ]),
                Forms\Components\Section::make('Diagnóstico')
                    ->schema([
                        Forms\Components\Textarea::make('issue_description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('diagnosed_problem')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Costos y asignación')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('technician_id')
                                    ->relationship('technician', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\TextInput::make('estimated_cost')
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('final_cost')
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                            ]),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'received' => 'Recibido',
                                        'in_diagnosis' => 'En diagnóstico',
                                        'quote_pending' => 'Cotización pendiente',
                                        'in_repair' => 'En reparación',
                                        'ready' => 'Listo',
                                        'delivered' => 'Entregado',
                                        'cancelled' => 'Cancelado',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('warranty_months')
                                    ->numeric()
                                    ->suffix('meses'),
                                Forms\Components\DateTimePicker::make('received_at'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('ready_at'),
                                Forms\Components\DateTimePicker::make('delivered_at'),
                            ]),
                    ]),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Técnico')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'received' => 'gray',
                        'in_diagnosis' => 'warning',
                        'quote_pending' => 'warning',
                        'in_repair' => 'info',
                        'ready' => 'success',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'received' => 'Recibido',
                        'in_diagnosis' => 'En diagnóstico',
                        'quote_pending' => 'Cotización pendiente',
                        'in_repair' => 'En reparación',
                        'ready' => 'Listo',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                        default => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'received' => 'Recibido',
                        'in_diagnosis' => 'En diagnóstico',
                        'quote_pending' => 'Cotización pendiente',
                        'in_repair' => 'En reparación',
                        'ready' => 'Listo',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            StatusHistoryManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepairOrders::route('/'),
            'create' => Pages\CreateRepairOrder::route('/create'),
            'edit' => Pages\EditRepairOrder::route('/{record}/edit'),
        ];
    }
}
