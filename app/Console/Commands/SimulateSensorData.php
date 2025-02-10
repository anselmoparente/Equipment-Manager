<?php

// app/Console/Commands/SimulateSensorData.php
namespace App\Console\Commands;

use App\Models\Equipamento;
use Illuminate\Console\Command;
use App\Models\Equipment;
use App\Services\MqttService;
use Carbon\Carbon;

class SimulateSensorData extends Command
{
    protected $signature = 'simulate:sensor-data';
    protected $description = 'Simula a geração de dados dos sensores de equipamentos ligados';

    public function handle()
    {
        // Busque todos os equipamentos que estão ligados
        $equipments = Equipamento::with('sensor')->where('status', 'on')->get();

        foreach ($equipments as $equipment) {
            $sensor = $equipment->sensor;
            if (!$sensor) {
                continue;
            }

            // Gere um valor aleatório (você pode usar rand() ou mt_rand(), adaptando para float se necessário)
            $value = mt_rand($sensor->min_value * 100, $sensor->max_value * 100) / 100;

            // Verifique se o valor gera alarme
            if ($value >= $sensor->max_value || $value <= $sensor->min_value) {
                // Registre o alarme no banco (crie ou utilize o model Alarm)
                $equipment->alarms()->create([
                    'value'     => $value,
                    'created_at' => Carbon::now(),
                ]);

                // Publique no broker MQTT
                $topic   = $equipment->mqtt_topic; // ex.: "equipamento/{id}"
                $message = json_encode([
                    'equipment_id' => $equipment->id,
                    'value'        => $value,
                    'timestamp'    => Carbon::now()->toDateTimeString()
                ]);

                // Utilize o serviço MQTT (veja o próximo item)
                $mqttService = new MqttService();
                $mqttService->publish($topic, $message);
            }
        }

        return 0;
    }
}
