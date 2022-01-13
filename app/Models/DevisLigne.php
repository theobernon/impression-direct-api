<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevisLigne extends Model
{
    use HasFactory;

    protected $table = 'dligne';

    protected $primaryKey = 'noLigne';


    protected $fillable = [
        'noDevis',
        'Produit',
        'TypePapier',
        'couleurPapier',
        'DimPapier',
        'ImpRecto',
        'ImpVerso',
        'Options',
        'Finitions',
        'SousTraitant',
        'ComCli',
        'ComEnt',
        'Qte',
        'Prix',
        'prixUnit',
    ];

    public $timestamps = false;

    public function devis()
    {
        return $this->belongsTo(Devis::class,'noDevis');
    }
}
