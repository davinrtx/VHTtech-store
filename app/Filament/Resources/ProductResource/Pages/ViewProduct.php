<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('storePreview')
                ->label('Ver en tienda')
                ->icon('heroicon-o-eye')
                ->color('success')
                ->url(fn (Product $record) => route('products.show', $record->slug))
                ->openUrlInNewTab()
                ->visible(fn () => true),
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
