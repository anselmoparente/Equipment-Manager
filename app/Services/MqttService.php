<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpMqtt\Client\MqttClient;

class MqttService
{
    protected $host;
    protected $port;
    protected $clientId;

    public function __construct()
    {
        $this->host     = env('MQTT_HOST', '127.0.0.1');
        $this->port     = env('MQTT_PORT', 1883);
        $this->clientId = env('MQTT_CLIENT_ID', 'laravel_client');
    }

    public function publish($topic, $message)
    {
        $mqtt = new MqttClient($this->host, $this->port, $this->clientId);

        try {
            $mqtt->connect();
            $mqtt->publish($topic, $message, 0);
            $mqtt->disconnect();
        } catch (\Exception $e) {
            Log::error("Erro ao publicar no MQTT: " . $e->getMessage());
        }
    }

    public function subscribe()
    {
        $mqtt = new MqttClient($this->host, $this->port, $this->clientId);

        try {
            $mqtt->connect();
            Log::info("Conectado ao broker MQTT e ouvindo todos os tópicos...");

            $mqtt->subscribe('#', function ($topic, $message) {
                Log::info("Mensagem recebida do tópico {$topic}: {$message}");
            }, 0);

            $mqtt->loop();

            $mqtt->disconnect();
        } catch (\Exception $e) {
            Log::error("Erro ao ouvir os tópicos MQTT: " . $e->getMessage());
        }
    }
}
