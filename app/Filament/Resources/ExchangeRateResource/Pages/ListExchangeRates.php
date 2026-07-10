<?php

namespace App\Filament\Resources\ExchangeRateResource\Pages;

use App\Filament\Resources\ExchangeRateResource;
use App\Services\DolarApiService;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListExchangeRates extends ListRecords
{
    protected static string $resource = ExchangeRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('syncDolarApi')
                ->label('Sincronizar tasas')
                ->icon('heroicon-o-arrow-path')
                ->color('success')
                ->action(function () {
                    try {
                        $service = app(DolarApiService::class);
                        $results = $service->syncToDatabase();

                        $summary = collect($results)
                            ->groupBy('action')
                            ->map(fn ($items, $action) => count($items) . ' ' . ($action === 'created' ? 'creadas' : 'actualizadas'))
                            ->implode(', ');

                        Notification::make()
                            ->title('Tasas sincronizadas desde DolarApi.com')
                            ->body($summary)
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error al sincronizar')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
