<?php

namespace App\Console\Commands;

use App\Services\DolarApiService;
use Illuminate\Console\Command;

class SyncExchangeRates extends Command
{
    protected $signature = 'exchange-rates:sync {--source=dolarapi : Fuente de datos}';
    protected $description = 'Sincroniza tasas de cambio desde DolarApi.com';

    public function handle(DolarApiService $service): int
    {
        $this->info('Consultando DolarApi.com...');

        try {
            $results = $service->syncToDatabase();

            if (empty($results)) {
                $this->warn('No se encontraron tasas para sincronizar.');
                return self::SUCCESS;
            }

            $this->newLine();
            $this->table(
                ['Moneda', 'Cotización', 'Tasa', 'Acción'],
                collect($results)->map(fn ($r) => [$r['base'], $r['quote'], $r['rate'], $r['action']])->toArray()
            );

            $this->newLine();
            $this->info('Sincronización completada: ' . count($results) . ' tasas procesadas.');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }

        return self::SUCCESS;
    }
}
