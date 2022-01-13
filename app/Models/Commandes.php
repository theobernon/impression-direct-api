<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commandes extends Model
{

    use HasFactory;

    protected $table='commande';
    protected $primaryKey='noCommande';
    protected $fillable = [
        'noCommande',
        'dateCommande',
        'refClient',
        'ad1',
        'ad2',
        'ad3',
        'tel',
        'mail',
        'livCli',
        'livad1',
        'livad2',
        'livad3',
        'produits',
        'pxttc',
        'BAT',
        'dateExpd',
        'envoyee',
        'momentPaiement',
        'adrSuivi',
        'transporteurClient',
        'teleprospecteur',
        'noDevis',
        'nomPdf',
    ];

    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Client::class, 'refClient');
    }
    public function commission()
    {
        return $this->belongsTo(Commission::class, 'id_commission');
    }
    public function teleprospecteur()
    {
        return $this->belongsTo(Teleprospecteur::class,'teleprospecteur');
    }

    public function devis()
    {
        return $this->belongsTo(Devis::class,'noDevis');
    }
    public function facture()
    {
        return $this->hasMany(Devis::class,'noCommande');
    }

    public function scopeAValider($query)
    {
        return $query->where('validee',0);
    }


}
