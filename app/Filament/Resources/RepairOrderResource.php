<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepairOrderResource\Pages;
use App\Filament\Resources\RepairOrderResource\RelationManagers\StatusHistoryManager;
use App\Models\RepairOrder;
use Filament\Forms;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class RepairOrderResource extends Resource
{
    protected static ?string $model = RepairOrder::class;

    protected static ?string $modelLabel = 'Reparación';
    protected static ?string $pluralModelLabel = 'Reparaciones';
    protected static ?string $navigationLabel = 'Reparaciones';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-wrench';
    protected static string | \UnitEnum | null $navigationGroup = 'Reparaciones';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Información del equipo')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->label('Reparación #')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('customer_id')
                            ->label('Cliente')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('device_type')
                            ->label('Tipo de equipo')
                            ->required()
                            ->maxLength(255),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('brand')
                                    ->label('Marca')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('model')
                                    ->label('Modelo')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('serial')
                                    ->label('Serial')
                                    ->maxLength(255),
                            ]),
                    ]),
                Section::make('Diagnóstico')
                    ->schema([
                        Forms\Components\Textarea::make('issue_description')
                            ->label('Descripción del problema')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('diagnosed_problem')
                            ->label('Diagnóstico')
                            ->columnSpanFull(),
                    ]),
                Section::make('Costos y asignación')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('technician_id')
                                    ->label('Técnico')
                                    ->relationship('technician', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\TextInput::make('estimated_cost')
                                    ->label('Costo estimado')
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('final_cost')
                                    ->label('Costo final')
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                            ]),
                        Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Estado')
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
                                    ->label('Garantía (meses)')
                                    ->numeric()
                                    ->suffix('meses'),
                                Forms\Components\DateTimePicker::make('received_at')
                                    ->label('Recibido el'),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('ready_at')
                                    ->label('Listo el'),
                                Forms\Components\DateTimePicker::make('delivered_at')
                                    ->label('Entregado el'),
                            ]),
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
                    ->label('Reparación #')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device_type')
                    ->label('Equipo')
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
                    ->label('Creado')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Estado')
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
                Actions\EditAction::make(),
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
