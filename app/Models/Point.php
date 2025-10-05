<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Point extends Model
{
    use HasFactory;

    protected $table = 'points';


    protected $fillable = [
        'usuario_id', 
        'puntos',
        'puntos_canjeados',
        'codigo_canje'
    ];

    protected $appends = ['available_points'];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Get the available points
     */
    public function getAvailablePointsAttribute()
    {
        return $this->puntos - $this->puntos_canjeados;
    }

    // Método para agregar puntos
    public static function addPoints($userId, $pointsToAdd)
    {
        $pointRecord = self::firstOrCreate(
            ['usuario_id' => $userId],
            ['puntos' => 0]
        );

        $pointRecord->increment('puntos', $pointsToAdd);
        return $pointRecord;
    }
}
