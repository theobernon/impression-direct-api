<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $table='facture';
    protected $primaryKey='noFacture';
    protected $fillable = [
        'noFacture',
        'noCommande',
        'dateFacture',
    ];

    public $timestamps = false;


    public function commande()
    {
        return $this->belongsTo(Commandes::class,'noCommande');
    }

}
