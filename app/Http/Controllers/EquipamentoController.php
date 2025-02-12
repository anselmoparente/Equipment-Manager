<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipamentoController extends Controller
{
    public function index()
    {
        $equipments = Equipamento::with(['sensor', 'alertas'])->get();
        return response()->json($equipments);
    }

    public function toggle(Request $request, $id)
    {
        $equipment = Equipamento::findOrFail($id);
        $status = $request->input('status');
        $equipment->status = $status;
        $equipment->save();

        if ($status) {
            $range = $equipment->limite_max - $equipment->limite_min;
            $offset = round($range * 0.2);
            $min = $equipment->limite_min - $offset;
            $max = $equipment->limite_max + $offset;
            $value = mt_rand($min, $max);

            $equipment->sensor->valor_atual = $value;
        } else {
            $equipment->sensor->valor_atual = null;
        }

        $equipment->sensor->save();

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
            'equipamento' => $equipamento->load('sensor', 'alertas'),
        ], 201);
    }
}
