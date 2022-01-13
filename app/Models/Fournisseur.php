<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;


    protected $table = 'fournisseur';

    protected $primaryKey = 'reference';

    protected $fillable = [
        'appellation',
        'commentaire',
        'prix',
        'photo',
        'voir',
        'ordre',
        'voir',
        'ordre',
        'revendeur',
        'numColis',
        'adresseSuivi',
        'telephone',
    ];

    public $timestamps = false;

}
