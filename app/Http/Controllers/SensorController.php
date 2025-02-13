<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipamento;

class SensorController extends Controller
{
    public function update()
    {
        $equipamentos = Equipamento::with('sensor')->where('status', true)->get();

        foreach ($equipamentos as $equipamento) {
            $equipamento->sensor->generateValue($equipamento);
        }

        return response()->json(['message' => 'Sensores atualizados com sucesso!']);
    }
}
