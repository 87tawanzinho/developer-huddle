<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importando o Log
use Illuminate\Support\Facades\Auth; // Importando o Auth

class AsaasWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Log para verificar os dados recebidos
        Log::info("Webhook do Asaas recebido", $request->all());

        // Verifique se os dados recebidos têm o formato correto
        $data = $request->all();

        // Verifique se o evento é o esperado
        if ($data["event"] === "PAYMENT_CONFIRMED") {
            // Atualizar o 'customerId' do usuário autenticado
            Auth::user()->update([
                "customerId" => $data["payment"]["customer"],
            ]);

            // Comparar o valor do pagamento e atualizar o plano do usuário
            $paymentValue = $data["payment"]["value"];

            if (abs($paymentValue - 29.99) < 0.01) {
                Auth::user()->update([
                    "plan_id" => 1,
                ]);
            } elseif (abs($paymentValue - 59.99) < 0.01) {
                Auth::user()->update([
                    "plan_id" => 2,
                ]);
            } elseif (abs($paymentValue - 99.99) < 0.01) {
                Auth::user()->update([
                    "plan_id" => 3,
                ]);
            }
        }

        // Retorne a resposta com os dados recebidos
        return response()->json($data);
    }
}
