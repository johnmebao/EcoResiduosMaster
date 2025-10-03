<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectionDetail extends Model
{
    use HasFactory;

    protected $table = 'collection_details';

    protected $fillable = [
        'collection_id',
        'tipo_residuo',
        'peso_kg',
        'observaciones'
    ];

    // Relación con la recolección
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}