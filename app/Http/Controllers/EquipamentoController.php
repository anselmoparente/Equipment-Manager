<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use Illuminate\Http\Request;

class EquipamentoController extends Controller
{
    // Lista todos os equipamentos para o Gerenciador
    public function index()
    {
        // Pode-se incluir o sensor e os alarmes se necessário
        $equipments = Equipamento::with('sensor', 'alarms')->get();
        return response()->json($equipments);
    }

    // Altera o status (ligar/desligar) do equipamento
    public function toggle(Request $request, $id)
    {
        $equipment = Equipamento::findOrFail($id);
        // Exemplo: $request->status pode ser 'on' ou 'off'
        $equipment->status = $request->input('status');
        $equipment->save();

        return response()->json($equipment);
    }
}
