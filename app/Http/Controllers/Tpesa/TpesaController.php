<?php

namespace App\Http\Controllers\Tpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Exception;

class TpesaController extends Controller
{
    public function callback(Request $request)
    {
        try {
            // Basic request validation
            $payload = $request->only(['reference', 'control_number']);
            if (empty($payload['reference'])) {
                Log::channel('t-pesa-log')->warning('callback-missing-reference', ['payload' => $request->all()]);
                return Response::json(['error' => 'Missing reference'], 400);
            }

            // Get client IP — consider trusting proxies if behind a load balancer
            $clientIp = $request->ip();

            // Config values
            $allowedIps = [Config::get('api.GEPG_IP'),'127.0.0.1'];
            $expectedKey = Config::get('api.TPESA_API_DISBURSEMENT_KEY');

            // Normalize allowed IPs: allow a single string or an array in config
            if (is_string($allowedIps)) {
                $allowedIps = [$allowedIps];
            } elseif (!is_array($allowedIps)) {
                $allowedIps = [];
            }

            // Header value
            $incomingKey = $request->header('tpesa-api-key');

            // IP check
            if (!in_array($clientIp, $allowedIps, true)) {
                Log::channel('t-pesa-log')->info('security', ['message' => 'IP not allowed', 'ip' => $clientIp]);
                return Response::json(['error' => 'IP not allowed'], 403);
            }

            // Header / key check using timing-safe comparison
            if (empty($incomingKey) || empty($expectedKey) || !hash_equals((string)$expectedKey, (string)$incomingKey)) {
                Log::channel('t-pesa-log')->info('security', ['message' => 'Invalid API key', 'ip' => $clientIp]);
                return Response::json(['error' => 'Invalid API key'], 401);
            }

            Log::channel('t-pesa-log')->info('request', ['payload' => $request->all(), 'ip' => $clientIp]);

            $reference = $payload['reference'];
            $controlNumber = $payload['control_number'] ?? null;

            // Find existing tpesa request by reference
            $tpesa = DB::table('tpesa_request')
                ->select('id', 'reference')
                ->where('reference', $reference)
                ->first();

            if ($tpesa) {
                // Use control_number from request (not $ref->control_number)
                $updateData = ['updated_at' => now()];

                if ($controlNumber !== null) {
                    $updateData['account_number'] = $controlNumber;
                }

                $updated = DB::table('tpesa_request')
                    ->where('id', $tpesa->id)
                    ->update($updateData);

                Log::channel('t-pesa-log')->info('db-result', [
                    'is-success' => (bool)$updated,
                    'tpesa_id' => $tpesa->id,
                    'reference' => $reference
                ]);

                return Response::json(['status' => 'ok', 'updated' => (bool)$updated], 200);
            } else {
                Log::channel('t-pesa-log')->info('db-result-not-found', [
                    'message' => 'tpesa_request not found',
                    'reference' => $reference
                ]);
                return Response::json(['error' => 'reference not found'], 404);
            }
        } catch (Exception $e) {
            Log::channel('t-pesa-log')->error('callback-exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);
            return Response::json(['error' => 'server error'], 500);
        }
    }
}
