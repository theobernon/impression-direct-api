<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $row = array();
        $commandes = DB::table('facture')
            ->join('commande','facture.noCommande','=','commande.noCommande')
            ->join('client','client.refClient','=','commande.refClient')
            ->select('dateFacture','facture.noCommande','facture.noFacture',DB::raw("CONCAT(nom,' ',prenom) AS nom_prenom"),'societe','pxttc')
            ->whereNotNull('noFacture')
            ->whereBetween('dateFacture',[$request->dateDebut,$request->dateFin])
            ->get();

            //$montantHT = array(intval($commande->pxttc)/1.196);
            //array_push($row, $commande);
        foreach ($commandes as $commande) {
            array_push($row,
                array('dateFacture'=>$commande->dateFacture, 'VEN'=>'VEN', 'code'=>706600,'noCommande'=>$commande->noCommande,'nom_prenom'=>$commande->nom_prenom, 'societe'=>$commande->societe,'noFacture'=>$commande->noFacture,'montant'=>round(intval($commande->pxttc)/1.196,1)), // Montant HT avec le code compta
                    array('dateFacture'=>$commande->dateFacture, 'VEN'=>'VEN','code'=>445714 ,'noCommande'=>$commande->noCommande,'nom_prenom'=>$commande->nom_prenom, 'societe'=>$commande->societe,'noFacture'=>$commande->noFacture,'montant'=>round(intval($commande->pxttc)-intval($commande->pxttc)/1.196,1)), // Montant de la tva avec le code compta
                    array('dateFacture'=>$commande->dateFacture, 'VEN'=>'VEN','code'=>411000 ,'noCommande'=>$commande->noCommande,'nom_prenom'=>$commande->nom_prenom, 'societe'=>$commande->societe,'noFacture'=>$commande->noFacture, 'montant'=>intval($commande->pxttc)) // Montant TTC avec le code compta
            );
        }
        // Renvoi les commandes avec 3 ligne dans le tableau $row qui contient le prix HT,TVA,TTC
        //dd($row);
        return response()->json($row);
    }
}
