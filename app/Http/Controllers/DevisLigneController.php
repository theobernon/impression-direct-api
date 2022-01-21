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

    public function getOne(Request $request)
    {
        $result = DevisLigne::with('devis')->where('noLigne',$request->noLigne)->first();
        return response()->json($result, 200);
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

    public function edit(Request $request)
    {
        $result = DB::table('dligne')->where('noLigne', $request->noLigne)->update([
            'noDevis' => $request->noDevis,
            'Produit' => $request->Produit,
            'TypePapier' => $request->TypePapier,
            'couleurPapier' => $request->couleurPapier,
            'DimPapier' => $request->DimPapier,
            'ImpRecto' => $request->ImpRecto,
            'ImpVerso' => $request->ImpVerso,
            'Options' => $request->Options,
            'Finitions' => $request->Finitions,
            'SousTraitant' => $request->SousTraitant,
            'Supplier'=> $request->Supplier,
            'ComCli' => $request->ComCli,
            'ComEnt' => $request->ComEnt,
            'Qte' => $request->Qte,
            'Prix' => $request->Prix,
            'prixUnit'=>$request->prixUnit,
            'Envoye'=> $request->envoye
        ]);
        return response()->json($result);
    }

    public function destroy(DevisLigne $devisLigne)
    {
        return response()->json($devisLigne->delete());
    }
}
