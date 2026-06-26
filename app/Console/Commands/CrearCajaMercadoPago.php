<?php

use App\Models\ConfiguracionMercadoPago;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

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

    $externalStoreId = 'MORA_STORE_001';
    $externalPosId = $config->pos_external_id ?: 'MORA_CAJA_001';

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

    if (! $storeResponse->successful()) {
        $this->error('No se pudo crear la tienda/sucursal.');
        $this->line($storeResponse->body());
        return 1;
    }

    $store = $storeResponse->json();
    $storeId = $store['id'] ?? null;

    if (! $storeId) {
        $this->error('Mercado Pago no devolvió el ID de la tienda.');
        $this->line(json_encode($store, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return 1;
    }

    $this->info('Tienda creada correctamente.');
    $this->line('Store ID: ' . $storeId);

    $this->info('Creando caja/POS...');

    $posResponse = Http::withToken($accessToken)
        ->withHeaders([
            'Content-Type' => 'application/json',
        ])
        ->post('https://api.mercadopago.com/pos', [
            'name' => 'Caja Mora 001',
            'fixed_amount' => true,
            'store_id' => $storeId,
            'external_store_id' => $externalStoreId,
            'external_id' => $externalPosId,
        ]);

    if (! $posResponse->successful()) {
        $this->error('No se pudo crear la caja/POS.');
        $this->line($posResponse->body());
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
