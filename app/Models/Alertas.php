<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipamento_id',
        'valor',
        'mensagem'
    ];

    /**
     * Relação: Um alerta pertence a um equipamento.
     */
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
