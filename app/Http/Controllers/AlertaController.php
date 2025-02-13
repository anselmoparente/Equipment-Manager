<?php

namespace App\Http\Controllers;

use App\Models\Alerta;
use Illuminate\Http\Request;

class AlertaController extends Controller
{
    public function index()
    {
        $alerts = Alerta::with(['equipamentos'])->get();
        return response()->json($alerts);
    }
}
