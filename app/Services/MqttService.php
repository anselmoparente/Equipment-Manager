<?php

namespace App\Services;

use App\Models\Alerta;
use App\Models\Equipamento;
use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\MqttClient;

class MqttService
{
    protected $mqtt;

    public function __construct()
    {
        $this->mqtt = new MqttClient(env('MQTT_HOST', '127.0.0.1'), env('MQTT_PORT', 1883), env('MQTT_CLIENT_ID', 'laravel_client'));
    }

    public function publish($topic, $message)
    {

        try {
            $this->mqtt->connect();
            $this->mqtt->publish($topic, $message, 0);
            $this->mqtt->disconnect();
        } catch (\Exception $e) {
            Log::error("Erro ao publicar no MQTT: " . $e->getMessage());
        }
    }

    public function subscribe()
    {
        try {
            $this->mqtt->connect();

            $this->mqtt->subscribe('equipamento/#', function ($topic, $message) {
                $parts = explode('/', $topic);

                $equipamentoId = $parts[1];
                $evento = $parts[2];

                switch ($evento) {
                    case 'turnOn':
                        $equipamento = Equipamento::find($equipamentoId);
                        $equipamento->status = true;
                        $equipamento->save();
                        $equipamento->sensor->generateValue($equipamento);
                        break;

                    case 'turnOff':
                        $equipamento = Equipamento::find($equipamentoId);
                        $equipamento->status = false;
                        $equipamento->save();
                        $equipamento->sensor->generateValue($equipamento);
                        break;

                    case 'alert':
                        $equipamento = Equipamento::find($equipamentoId);
                        Alerta::create([
                            'equipamento_id' => $equipamento->id,
                            'mensagem' => $message,
                        ]);
                        break;

                    default:
                        break;
                }
            }, 0);

            $this->mqtt->loop(true);
        } catch (\Exception $e) {
            Log::error("Erro ao ouvir os tópicos MQTT: " . $e->getMessage());
        }
    }
}
