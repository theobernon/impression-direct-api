<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
use App\Models\DevisLigne;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Devis;

class DevisController extends Controller
{
    public function create(Request $request)
    {
        $result = DB::table('devis')->insert([
            'dateDevis' => $request->dateDevis,
            'refClient' => $request->refClient,
            'tva' => $request->tva,
        ]);

        return response()->json($result);
    }

    public function getOne(Devis $devis)
    {
        $result = DB::table('devis')
            ->where('noDevis', $devis->noDevis)->first();
        return response()->json($result);
    }

    public function getAllDevis()
    {
        $result = DB::table('devis')
            ->join('client','devis.refClient','=','client.refClient')
            ->select('devis.*')
            ->latest('noDevis')
            ->take(10)
            ->get();
        return response()->json($result);
    }

    public function getByClient(Commandes $commande)
    {
        //dd($client->input);
        /*
        $result = DB::table('devis')
            ->join('client', 'devis.refClient', '=', 'client.refClient')
            ->where('devis.refClient', '=', $client->refClient)->get(['devis.*']);
        return response()->json($result);
        */
        //dd($commande->noCommande);
        /*$devis = Devis::all();
        foreach ($devis as $devi){
        dd($devi->client());
        $result = $devi->client()->commandes()->find($commande->noCommande) ? $devi : void;

        }*/

        /*foreach (Devis::all() as $devis){
            dd($devis->client());
        }*/

        $result = Devis::with('client.commande')
            //->join('client','devis.refClient','=','client.refClient')
            //->join('commande','commande.refClient','=','client.refClient')
            //->client()->commandes()->find($commande->noCommande)
            //->where(Commandes::find($commande->noCommande)->)
            ->get();
        //dd($result->model);
        return response()->json($result);

    }
    public function edit(Devis $devis, Request $request)
    {
        $result = DB::table('devis')->where('noDevis', $devis->noDevis)->update([
            'dateDevis' => $request->dateDevis,
            'refClient' => $request->refClient,

        ]);
        return response()->json($result);
    }

    public function getDevisByCom(Commandes $commande)
    {
        //dd($user->input);
        //$result = Client::with('commande')
        //->get();
        //dd($result);
        $result = $commande->devis;
        return response()->json($result);
    }

    public function getByLigne(DevisLigne $devisLigne)
    {
        //dd($user->input);
        //dd($devis->devisLigne());
        $result = $devisLigne->devis;
        //dd($result);
        return response()->json($result);
    }
    public function destroy(Devis $devis)
    {
        return response()->json($devis->delete());
    }
}
