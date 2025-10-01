<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personals';

    protected $fillable = [
        'usuario_id',
        'nombres',
        'documento',
        'email',
        'telefono',
        'direccion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
