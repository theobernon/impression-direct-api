<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table='product';
    protected $fillable = [
        'productCatId',
        'reference',
        'nomProduit',
        'codePrix',
        'gauffrage',
        'impression',
        'finition',
        'paper',
        'px',
        'qte',
        'size',
        'color',
        'comment',
        'cte',
        'pld'
    ];

    public $timestamps = false;


}
