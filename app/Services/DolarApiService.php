<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DolarApiService
{
    private string $baseUrl = 'https://ve.dolarapi.com/v1';

    public function fetchRates(): array
    {
        $response = Http::timeout(10)->get("{$this->baseUrl}/cotizaciones");

        if ($response->failed()) {
            throw new \RuntimeException('Error al consultar DolarApi.com: ' . $response->status());
        }

        return $response->json();
    }

    public function getRateFor(string $currency): ?float
    {
        $rates = $this->fetchRates();

        foreach ($rates as $rate) {
            if ($rate['moneda'] === strtoupper($currency)) {
                return $rate['promedio'] ?? $rate['venta'] ?? $rate['compra'];
            }
        }

        return null;
    }

    public function syncToDatabase(): array
    {
        $rates = $this->fetchRates();
        $results = [];

        foreach ($rates as $rate) {
            $quote = match ($rate['moneda']) {
                'USD' => 'VES',
                'EUR' => 'VES',
                default => 'VES',
            };

            $rateValue = $rate['promedio'] ?? $rate['venta'] ?? $rate['compra'];
            if ($rateValue === null) {
                continue;
            }

            $exchangeRate = \App\Models\ExchangeRate::updateOrCreate(
                [
                    'base' => $rate['moneda'],
                    'quote' => $quote,
                ],
                [
                    'rate' => $rateValue,
                    'source' => 'dolarapi',
                    'fetched_at' => now(),
                ]
            );

            $results[] = [
                'base' => $exchangeRate->base,
                'quote' => $exchangeRate->quote,
                'rate' => $exchangeRate->rate,
                'action' => $exchangeRate->wasRecentlyCreated ? 'created' : 'updated',
            ];
        }

        return $results;
    }
}
