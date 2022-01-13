<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
    use HasFactory;

    protected $table='payee';
    protected $primaryKey='id';
    protected $fillable = [
        'id_commande',
        'date',
        'datePaiement',
        'paiement',
        'typePaiement',
        'payee',
        'mailInf',
        'dateMailInf',
        'mailDir',
        'dateMailDir'
    ];

    public function commande()
    {
        return $this->belongsTo(Commandes::class, 'id_commande', 'noCommande');
    }

    public function scopeAPayer($query)
    {
        return $query->with(['commande' => function($q) {
            $q->where('valClient',1)
                ->where('validee',1)
                ->where('expediee',1)
                ->where('facturee',1)
                ->where('envoyee',1);
        }])->where('payee', 'non');
    }
}
