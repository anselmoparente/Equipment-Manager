<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use App\Models\Equipamento;
use App\Services\MqttService;

class SensorController extends Controller
{
    protected $mqttService;

    public function __construct(MqttService $mqttService)
    {
        $this->mqttService = $mqttService;
    }

    public function update()
    {
        $equipamentos = Equipamento::with('sensor')->where('status', true)->get();

        foreach ($equipamentos as $equipamento) {
            $sensor = $equipamento->sensor;
            $sensor->generateValue($equipamento);

            if ($sensor->valor_atual < $equipamento->limite_min || $sensor->valor_atual > $equipamento->limite_max) {
                $alert = Alerta::create([
                    'equipamento_id' => $equipamento->id,
                    'valor' => $sensor->valor_atual,
                    'mensagem' => "Valor {$sensor->valor_atual} fora do intervalo permitido (Mín: {$equipamento->limite_min}, Máx: {$equipamento->limite_max})",
                ]);

                $topic = "equipamento/{$alert->equipamento_id}/alert";
                $this->mqttService->publish($topic, $alert->mensagem);
            }
        }

        return response()->json(['message' => 'Sensores atualizados com sucesso!']);
    }
}
