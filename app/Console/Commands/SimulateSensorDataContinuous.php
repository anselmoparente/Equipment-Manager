<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipamento;
use Carbon\Carbon;
use App\Services\MqttService; // se você utilizar para publicar no MQTT

class SimulateSensorDataContinuous extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'simulate:sensor-data-continuous';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Simula continuamente os dados dos sensores sem usar o cron';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando simulação contínua dos sensores...');
        
        while (true) {
            // Busca todos os equipamentos ligados e carrega o sensor
            $equipamentos = Equipamento::with('sensor')->where('status', true)->get();

            foreach ($equipamentos as $equipamento) {
                $sensor = $equipamento->sensor;
                if (!$sensor) {
                    continue;
                }

                // Gera um valor aleatório dentro da faixa (ajustando para float)
                $min = $equipamento->limite_min * 100;
                $max = $equipamento->limite_max * 100;
                $value = mt_rand($min, $max) / 100;

                // Atualiza o valor do sensor
                $sensor->valor_atual = $value;
                $sensor->save();

                // Se o valor estiver nos limites críticos, dispare uma ação (criar alerta, publicar no MQTT, etc.)
                if ($value >= $equipamento->limite_max || $value <= $equipamento->limite_min) {
                    // Exemplo: cria um alerta (supondo que você tenha a model Alerta configurada)
                    $equipamento->alertas()->create([
                        'valor'    => $value,
                        'mensagem' => "Valor crítico: {$value} em " . Carbon::now()->toDateTimeString(),
                    ]);

                    // Se usar MQTT:
                    // $mqttService = new MqttService();
                    // $mqttService->publish($equipamento->topic, json_encode([
                    //     'equipamento_id' => $equipamento->id,
                    //     'valor' => $value,
                    //     'timestamp' => Carbon::now()->toDateTimeString()
                    // ]));
                }
            }

            // Aguarda 5 segundos antes de atualizar novamente
            sleep(5);
        }
    }
}
