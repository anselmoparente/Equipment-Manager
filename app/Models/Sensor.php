<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipamento_id',
        'valor_atual'
    ];

    /**
     * Relação: Um sensor pertence a um equipamento.
     */
    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
