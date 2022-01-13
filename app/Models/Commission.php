<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;

    protected $table='commission';
    protected $primaryKey='id';
    protected $fillable = [
        'taux',
        ];

    public $timestamps = false;
    public function commande()
    {
        return $this->hasMany(Commandes::class);
    }

}


