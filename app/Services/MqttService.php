<?php

namespace App\Services;

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

            $this->mqtt->subscribe('#', function ($topic, $message) {
                Log::info("Mensagem recebida do tópico {$topic}: {$message}");
            }, 0);

            $this->mqtt->loop(true);
        } catch (\Exception $e) {
            Log::error("Erro ao ouvir os tópicos MQTT: " . $e->getMessage());
        }
    }
}
