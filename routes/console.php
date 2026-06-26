<?php

use App\Models\ConfiguracionMercadoPago;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('mp:crear-caja', function () {
    $config = ConfiguracionMercadoPago::first();

    if (! $config || ! $config->access_token_encriptado) {
        $this->error('Primero cargá y guardá el Access Token en Configuración.');
        return 1;
    }

    $accessToken = Crypt::decryptString($config->access_token_encriptado);

    $userId = $this->ask('Pegá el User ID de la cuenta VENDEDORA de prueba');

    if (! $userId) {
        $this->error('El User ID es obligatorio.');
        return 1;
    }

    /*
     |--------------------------------------------------------------------------
     | IMPORTANTE
     |--------------------------------------------------------------------------
     | Mercado Pago solo acepta letras y números en external_id.
     | Nada de espacios, guiones ni guiones bajos.
     */
    $externalStoreId = 'MORASTORE002';
    $externalPosId = $config->pos_external_id ?: 'MORACAJA001';

    $externalStoreId = preg_replace('/[^A-Za-z0-9]/', '', $externalStoreId);
    $externalPosId = preg_replace('/[^A-Za-z0-9]/', '', $externalPosId);

    if (! $externalPosId) {
        $externalPosId = 'MORACAJA001';
    }

    $this->info('Creando tienda/sucursal en Mercado Pago...');

    $storeResponse = Http::withToken($accessToken)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post("https://api.mercadopago.com/users/{$userId}/stores", [
            'name' => 'Mora Producciones',
            'external_id' => $externalStoreId,
            'location' => [
                'street_number' => '1000',
                'street_name' => 'Formosa',
                'city_name' => 'Formosa',
                'state_name' => 'Formosa',
                'latitude' => -26.1849,
                'longitude' => -58.1731,
                'reference' => 'Mora Producciones',
            ],
        ]);

    $storeId = null;

    if ($storeResponse->successful()) {
        $store = $storeResponse->json();

        $storeId = $store['id'] ?? $store['store_id'] ?? null;

        $this->info('Tienda creada correctamente.');

        if ($storeId) {
            $this->line('Store ID: ' . $storeId);
        }
    } else {
        $body = $storeResponse->body();

        if (str_contains($body, 'already assigned') || str_contains($body, 'already exists')) {
            $this->warn('La tienda ya existe. Continuamos usando external_store_id: ' . $externalStoreId);
        } else {
            $this->error('No se pudo crear la tienda/sucursal.');
            $this->line($body);
            return 1;
        }
    }

    $this->info('Creando caja/POS...');

    $payloadPos = [
        'name' => 'Caja Mora 001',
        'fixed_amount' => true,
        'external_store_id' => $externalStoreId,
        'external_id' => $externalPosId,
    ];

    if ($storeId) {
        $payloadPos['store_id'] = $storeId;
    }

    $posResponse = Http::withToken($accessToken)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post('https://api.mercadopago.com/pos', $payloadPos);

    if (! $posResponse->successful()) {
        $body = $posResponse->body();

        if (str_contains($body, 'already assigned') || str_contains($body, 'already exists')) {
            $this->warn('La caja/POS ya existe. Continuamos usando POS External ID: ' . $externalPosId);

            $config->update([
                'pos_external_id' => $externalPosId,
                'nombre_receptor' => $config->nombre_receptor ?: 'Mora Producciones',
            ]);

            $this->info('Listo. Ya podés volver a Eventos y guardar para generar QR reales.');
            return 0;
        }

        $this->error('No se pudo crear la caja/POS.');
        $this->line($body);
        return 1;
    }

    $pos = $posResponse->json();

    $config->update([
        'pos_external_id' => $externalPosId,
        'nombre_receptor' => $config->nombre_receptor ?: 'Mora Producciones',
    ]);

    $this->info('Caja/POS creada correctamente.');
    $this->line('POS External ID: ' . $externalPosId);

    if (isset($pos['qr']['image'])) {
        $this->line('QR estático de la caja: ' . $pos['qr']['image']);
    }

    $this->info('Listo. Ahora podés volver a Eventos y guardar para generar QR reales.');

    return 0;
})->purpose('Crear tienda y caja POS de Mercado Pago para Mora Producciones');