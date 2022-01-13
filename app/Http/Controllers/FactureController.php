<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use App\Models\Facture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FactureController extends Controller
{
    //Voir la génération noFacture
    public function create(Request $request, $commande)
    {

        $dateFact = date('m')+substr(date('Y'),2,2);
        $client = $commande->refClient;
        $num = Commandes::select('nomPdf')
        ->like('f%.pdf')
        ->latest('nomPdf');

        $num += substr($num,1,4)+1;

        $noFact = 'f'.$num.$dateFact.$client;

        $facture = new Facture();

        $facture->noFacture = $noFact;
        $facture->noCommande = $request->noCommande;
        $facture->dateFacture = $request->dateFacture;


        return response()->json($facture);
    }

    public function getOne(Facture $facture)
    {
        $result = DB::table('facture')
            ->where('noFacture', $facture->noFacture)->get();
        return response()->json($result);
    }

    public function getAllFacture()
    {
        $result = DB::table('facture')
            ->join('commande','commande.noCommande','=','facture.noCommande')
            ->select('facture.*')->get();
        return response()->json($result);
    }

    public function destroy(Facture $facture)
    {
        return response()->json($facture->delete());
    }
}
