<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipamentoController extends Controller
{
    // Lista todos os equipamentos para o Gerenciador
    public function index()
    {
        $equipments = Equipamento::all();
        return response()->json($equipments);
    }

    // Altera o status (ligar/desligar) do equipamento
    public function toggle(Request $request, $id)
    {
        $equipment = Equipamento::findOrFail($id);
        $equipment->status = $request->input('status');
        $equipment->save();

        return response()->json($equipment);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'parametro' => 'required|string|max:255',
            'limite_min' => 'required|numeric',
            'limite_max' => 'required|numeric',
        ]);

        $equipamento = Equipamento::create([
            'nome' => $request->nome,
            'status' => false,
            'parametro' => $request->parametro,
            'limite_min' => $request->limite_min,
            'limite_max' => $request->limite_max,
            'topic' => 'equipamento/' . Str::slug($request->nome),
        ]);

        $sensor = Sensor::create([
            'equipamento_id' => $equipamento->id,
            'valor_atual' => null,
        ]);

        return response()->json([
            'message' => 'Equipamento criado com sucesso!',
            'equipamento' => $equipamento,
        ], 201);
    }
}
