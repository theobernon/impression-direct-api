<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $table = 'devis';

    protected $primaryKey = 'noDevis';

    protected $fillable = [
        'noDevis',
        'dateDevis',
        'refClient',
        'envoye',
    ];

    public $timestamps = false;


    public function client(){
        return $this->belongsTo(Client::class,'refClient');
    }

    public function commande(){
        return $this->hasMany(Commandes::class);
    }

    public function devisLigne(){
        return $this->hasMany(DevisLigne::class,'noDevis');
    }
}
