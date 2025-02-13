<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index(Request $request)
    {
        $query = Alerta::query();

        if ($request->has('equipamento_id')) {
            $query->where('equipamento_id', $request->equipamento_id);
        }

        $alerts = $query->get();
        return response()->json($alerts);
    }
}
