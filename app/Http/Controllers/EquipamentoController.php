<?php

namespace App\Http\Controllers;

use App\Jobs\MqttSubscribeJob;
use App\Models\Equipamento;
use App\Models\Sensor;
use App\Services\MqttService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EquipamentoController extends Controller
{
    protected $mqttService;

    public function __construct(MqttService $mqttService)
    {
        $this->mqttService = $mqttService;
    }

    public function index()
    {
        $equipments = Equipamento::with(['sensor', 'alertas'])->get();
        MqttSubscribeJob::dispatch($this->mqttService);
        return response()->json($equipments);
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

    public function turnOn($id)
    {
        if (!$id) {
            return response()->json(["error" => "ID do equipamento é inválido"], 400);
        }

        $equipamento = Equipamento::find($id);
        if (!$equipamento) {
            return response()->json(["error" => "Equipamento não encontrado"], 404);
        }

        $equipamento->status = true;
        $equipamento->save();
        $equipamento->sensor->generateValue($equipamento);

        $topic = "equipamento/{$id}/turnOn";
        $this->mqttService->publish($topic, "Ligar o equipamento");

        return response()->json(["message" => "Equipamento ligado"], 200);
    }

    public function turnOff($id)
    {
        if (!$id) {
            return response()->json(["error" => "ID do equipamento é inválido"], 400);
        }

        $equipamento = Equipamento::find($id);
        if (!$equipamento) {
            return response()->json(["error" => "Equipamento não encontrado"], 404);
        }

        $equipamento->status = false;
        $equipamento->save();
        $equipamento->sensor->eraseValue();

        $topic = "equipamento/{$id}/turnOff";
        $this->mqttService->publish($topic, "Ligar o equipamento");

        return response()->json(["message" => "Equipamento desligado"], 200);
    }
}
