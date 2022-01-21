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
        'entCli',
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
        'noColissimo',
        'mpaiement',
        'momentPaiement',
        'adrSuivi',
        'pxTransporteur',
        'reduction',
        'transporteurClient',
        'teleprospecteur',
        'noDevis',
        'nomPdf',
        'id_commission',
        'expertise',
        'commentaire'
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

    public function payee()
    {
        return $this->hasMany(Payee::class, 'noCommande');
    }

    public function devis()
    {
        return $this->belongsTo(Devis::class,'noDevis');
    }
    public function facture()
    {
        return $this->hasMany(Facture::class,'noCommande');
    }

    public function scopeClientAValider($query)
    {
        return $query->where('valClient',0);
    }

    public function scopeAValider($query)
    {
        return $query
            ->where('valClient',1)
            ->where('validee',0)
            ->where('expediee',0)
            ->where('envoyee',0);
    }

    public function scopeAExpedier($query)
    {
        return $query->where('valClient',1)
            ->where('validee',1)
            ->where('expediee',0)
            ->where('facturee',0);
    }

    public function scopeAFacturer($query)
    {
        return $query
            ->where('valClient',1)
            ->where('validee',1)
            ->where('expediee', 1)
            ->where('facturee',0)
            ->where('envoyee', 0);
    }

    public function scopeAEnvoyer($query)
    {
        return $query
            ->where('valClient',1)
            ->where('validee',1)
            ->where('expediee', 1)
             ->where('facturee', 1)
            ->where('envoyee',0);
    }

}
