<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $commande = DB::table('facture')
            ->join('commande','facture.noCommande','=','commande.noCommande')
            ->join('client','client.refClient','=','commande.refClient')
            ->select('dateFacture','facture.noCommande','facture.noFacture',DB::raw("CONCAT(nom,' ',prenom) AS nom_prenom"),'societe','pxttc')
            ->whereNotNull('noFacture')
            ->whereBetween('dateFacture',[$request->dateDebut,$request->dateFin])
            ->get();

        return response()->json($commande);
    }
}
