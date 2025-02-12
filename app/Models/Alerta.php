<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    use HasFactory;

    protected $table = 'alertas';

    protected $fillable = [
        'equipamento_id',
        'valor',
        'mensagem'
    ];

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
