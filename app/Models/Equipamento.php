<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';

    protected $fillable = [
        'nome',
        'status',
        'parametro',
        'limite_min',
        'limite_max',
        'topic'
    ];

    public function sensor()
    {
        return $this->hasOne(Sensor::class);
    }
}
