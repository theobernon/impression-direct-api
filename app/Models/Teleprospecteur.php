<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teleprospecteur extends Model
{
    use HasFactory;

    protected $table = 'teleprospecteur';

    protected $primaryKey = 'num';


    protected $fillable = [
        'nom',
        'prenom',
        'numEntreprise',
        'email',
        'tel',
        'mobile',
        'commission',
    ];

    public $timestamps = false;

    public function client(){
        return $this->hasMany(Client::class);
    }
    public function commande(){
        return $this->hasMany(Commandes::class);
    }
}
