<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HelloAssoWebhookController extends Controller
{
    public function handlePayment(Request $request)
    {
        $payload = $request->all();

        // LOG 1 : On écrit TOUT le JSON reçu dans storage/logs/laravel.log
        Log::info('--- WEBHOOK HELLOASSO REÇU ---', $payload);

        if (isset($payload['eventType']) && $payload['eventType'] === 'Payment') {
            $state = $payload['data']['state'] ?? null;

            Log::info('Statut du paiement détecté : ' . $state);

            if ($state === 'Authorized') {
                // Recherche du jeton dans les metadata transmises
                $sessionToken = $payload['data']['meta']['session_brute'] ?? null;

                if ($sessionToken) {
                    Log::info('Jeton de session trouvé ! Sauvegarde en cache pour : ' . $sessionToken);
                    Cache::put('helloasso_success_' . $sessionToken, true, now()->addMinutes(10));
                } else {
                    Log::warning('Paiement autorisé mais impossible de trouver [data][meta][session_brute] dans le JSON.');
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
