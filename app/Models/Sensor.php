<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensores';

    protected $fillable = [
        'equipamento_id',
        'valor_atual'
    ];

    public function generateValue()
    {
        $valorMinimo = $this->equipamento->limite_min;
        $valorMaximo = $this->equipamento->limite_max;
        $range =  round(($valorMaximo - $valorMinimo) * 0.2);
        $value = mt_rand($valorMinimo - $range, $valorMaximo + $range);

        $this->valor_atual = $value;
        $this->save();
    }

    public function eraseValue()
    {
        $this->valor_atual = null;
        $this->save();
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class);
    }
}
