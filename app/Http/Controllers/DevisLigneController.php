<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use Illuminate\Http\Request;
use App\Models\DevisLigne;
use App\Models\Devis;
use Illuminate\Support\Facades\DB;


class DevisLigneController extends Controller
{
    public function create(Request $request)
    {
        $result = DB::table('dligne')->insert([
            'noDevis' => $request->noDevis,
            'Produit' => $request->produitDevis,
            'TypePapier' => $request->typePapierDevis,
            'couleurPapier' => $request->couleurPapierDevis,
            'DimPapier' => $request->dimPapierDevis,
            'ImpRecto' => $request->impRecto,
            'ImpVerso' => $request->impVerso,
            'Options' => $request->optionDevis,
            'Finitions' => $request->finitionDevis,
            'SousTraitant' => $request->sousTraitantDevis,
            'Supplier' => $request->supplierDevis,
            'ComCli' => $request->comCliDevis,
            'ComEnt' => $request->comEntDevis,
            'Qte' => $request->qteDevis,
            'Prix' => $request->prixDevis,
            'Envoye' => $request->envoiDevis,
            'prixUnit' => $request->prixUnit
        ]);

        return response()->json($result);
    }

    public function getOne(DevisLigne $devisLigne)
    {
        $result = DB::table('dligne')
            ->where('noLigne', $devisLigne->noLigne)->get();
        return response()->json($result);
    }


    public function getAllDevisLigne()
    {
        $result = DB::table('dligne')
            ->join('devis','dligne.noDevis','=','devis.noDevis')
            ->select('dligne.*')
            ->latest('noDevis')
            ->take(10)
            ->get();
        return response()->json($result);
    }

    public function getByDevis(Devis $devis)
    {
        //dd($user->input);
        //dd($devis->devisLigne());
        $result = $devis->devisLigne;
        //dd($result);
        return response()->json($result);
    }

    public function edit(DevisLigne $devisLigne, Request $request)
    {
        $result = DB::table('dligne')->where('noLigne', $devisLigne->noLigne)->update([
            'noDevis' => $request->noDevis,
            'Produit' => $request->produitDevis,
            'TypePapier' => $request->typePapierDevis,
            'couleurPapier' => $request->couleurPapierDevis,
            'DimPapier' => $request->dimPapierDevis,
            'ImpRecto' => $request->impRecto,
            'ImpVerso' => $request->impVerso,
            'Option' => $request->optionDevis,
            'Finitions' => $request->finitionDevis,
            'SousTraitant' => $request->sousTraitantDevis,
            'ComCli' => $request->comCliDevis,
            'ComEnt' => $request->comEntDevis,
            'Qte' => $request->qteDevis,
            'Prix' => $request->prixDevis
        ]);
        return response()->json($result);
    }

    public function destroy(DevisLigne $devisLigne)
    {
        return response()->json($devisLigne->delete());
    }
}
