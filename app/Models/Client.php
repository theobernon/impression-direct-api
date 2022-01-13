<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table='client';
    protected $primaryKey = 'refClient';

    protected $fillable = [
        'email',
        'typeClient',
        'nom',
        'prenom',
        'societe',
        'tel',
        'mobile',
        'fax',
        'factAdr1',
        'factAdr2',
        'factAdr3',
        'factPays',
        'livAdr1',
        'livAdr2',
        'livAdr3',
        'livPays',
        'remarques',
        'id_teleprospecteur',
    ];

    public $timestamps = false;

    public function teleprospecteur(){
        return $this->belongsTo(Teleprospecteur::class,'id_teleprospecteur');
    }

    public function pays(){
        return $this->belongsTo(Pays::class,'factPays');
    }
    public function commande(){
        return $this->hasMany(Commandes::class);
    }

    public function devis(){
        return $this->hasMany(Devis::class);
    }
}
