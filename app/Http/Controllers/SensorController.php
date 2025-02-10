<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamento;

class SensorController extends Controller
{
    /**
     * Atualiza os valores dos sensores para os equipamentos ligados.
     *
     * @return \Illuminate\Http\Response
     */
    public function atualizar(Request $request)
    {
        // Obtém todos os equipamentos que estão ligados (status == true)
        $equipamentos = Equipamento::with('sensor')->where('status', true)->get();

        foreach ($equipamentos as $equipamento) {
            // Gera um valor aleatório dentro do intervalo permitido para o sensor
            $min = $equipamento->limite_min * 100; // multiplicando por 100 para trabalhar com inteiros
            $max = $equipamento->limite_max * 100;
            $valor = mt_rand($min, $max) / 100; // voltando a ser float

            // Atualiza o valor do sensor
            $equipamento->sensor->valor_atual = $valor;
            $equipamento->sensor->save();

            // Se o valor do sensor ultrapassar os limites, cria um alerta
            if ($valor >= $equipamento->limite_max || $valor <= $equipamento->limite_min) {
                $equipamento->alertas()->create([
                    'valor' => $valor,
                    'mensagem' => 'Valor fora do limite!'
                ]);
            }
        }

        return response()->json(['message' => 'Sensores atualizados com sucesso!']);
    }
}
