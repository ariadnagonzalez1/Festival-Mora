<?php

namespace App\Services;

use App\Models\ConfiguracionMercadoPago;
use App\Models\ConfiguracionProductora;
use App\Models\TipoEntrada;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TipoEntradaQrPagoService
{
    public function generarParaTipoEntrada(TipoEntrada $tipoEntrada): void
    {
        $tipoEntrada->load('evento');

        $config = ConfiguracionMercadoPago::first();

        if (! $config) {
            throw new \Exception('No existe configuración de Mercado Pago.');
        }

        if (! $config->access_token_encriptado) {
            throw new \Exception('Falta configurar el Access Token de Mercado Pago.');
        }

        if (! $config->pos_external_id) {
            throw new \Exception('Falta configurar el POS External ID de Mercado Pago.');
        }

        $accessToken = Crypt::decryptString($config->access_token_encriptado);

        $receptor = $config->nombre_receptor
            ?? ConfiguracionProductora::first()?->nombre_comercial
            ?? 'Mora Producciones';

        $codigo = $tipoEntrada->qr_pago_codigo
            ?: 'QRTIPO' . $tipoEntrada->id . strtoupper(Str::random(8));

        $concepto = 'Entrada ' . $tipoEntrada->nombre . ' - ' . $tipoEntrada->evento->titulo;

        $monto = number_format((float) $tipoEntrada->precio, 2, '.', '');

        $payload = [
            'type' => 'qr',
            'total_amount' => $monto,
            'description' => Str::limit($concepto, 140, ''),
            'external_reference' => $codigo,

            /*
             * La documentación de Mercado Pago usa PT16M en el ejemplo.
             * Dejamos ese valor para evitar respuestas raras con P30D.
             */
            'expiration_time' => 'PT16M',

            'config' => [
            'qr' => [
            'external_pos_id' => $config->pos_external_id,
            'mode' => 'hybrid',
            ],
        ],

            'transactions' => [
                'payments' => [
                    [
                        'amount' => $monto,
                    ],
                ],
            ],

            'items' => [
                [
                    'title' => Str::limit($tipoEntrada->nombre, 140, ''),
                    'unit_price' => $monto,
                    'quantity' => 1,
                    'unit_measure' => 'unit',
                    'external_code' => $codigo,
                ],
            ],
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'X-Idempotency-Key' => (string) Str::uuid(),
            ])
            ->post('https://api.mercadopago.com/v1/orders', $payload);

        if (! $response->successful()) {
            throw new \Exception('Mercado Pago no pudo generar el QR: ' . $response->body());
        }

        $orden = $response->json();

        Log::info('Mercado Pago - respuesta crear order QR', [
            'tipo_entrada_id' => $tipoEntrada->id,
            'response' => $orden,
        ]);

        $orderId = data_get($orden, 'id');

        $qrData = data_get($orden, 'type_response.qr_data')
            ?? data_get($orden, 'qr_data');

        /*
         * Si Mercado Pago creó la orden pero no devolvió qr_data en el POST,
         * consultamos la orden por ID.
         */
        if (! $qrData && $orderId) {
            $consultaResponse = Http::withToken($accessToken)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->get('https://api.mercadopago.com/v1/orders/' . $orderId);

            if ($consultaResponse->successful()) {
                $ordenConsultada = $consultaResponse->json();

                Log::info('Mercado Pago - respuesta consultar order QR', [
                    'tipo_entrada_id' => $tipoEntrada->id,
                    'order_id' => $orderId,
                    'response' => $ordenConsultada,
                ]);

                $qrData = data_get($ordenConsultada, 'type_response.qr_data')
                    ?? data_get($ordenConsultada, 'qr_data');

                $orden = $ordenConsultada;
            }
        }

        if (! $qrData) {
            throw new \Exception(
                'Mercado Pago creó la orden, pero no devolvió qr_data. Respuesta completa: '
                . json_encode($orden, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            );
        }

        $tipoEntrada->update([
            'qr_pago_codigo' => $codigo,
            'qr_pago_data' => $qrData,
            'qr_pago_receptor' => $receptor,
            'qr_pago_concepto' => $concepto,
            'qr_pago_monto' => $tipoEntrada->precio,
            'qr_pago_estado' => 'generado_mp',
            'qr_pago_generado_at' => now(),
        ]);
    }
}