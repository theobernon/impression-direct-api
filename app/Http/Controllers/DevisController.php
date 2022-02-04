<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Commandes;
use App\Models\DevisLigne;
use Carbon\Carbon;
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

    public function getAllDevis(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $perpage = (int)$request->query('perpage', 10);
        $total = Devis::latest('dateDevis')
            ->whereNotNull('refClient')->count();
        $devis = Devis::skip(($page-1)*$perpage)
            ->take($perpage)
            ->latest('dateDevis')
            ->whereNotNull('refClient')
            ->get();
        return response()->json(['total'=>$total,'devis'=>$devis,'current_page'=>$page,'total_page'=>ceil($total/$perpage),'perpage'=>$perpage]);
    }

    public function search(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $perpage = (int)$request->query('perpage', 10);
        $total = Devis::latest('dateDevis')
            ->where(DB::raw('CONCAT_WS(noDevis,dateDevis,refClient)'), 'LIKE', "%{$request->search}%")
            ->whereNotNull('refClient')
            ->count();
        $devis = Devis::skip(($page-1)*$perpage)
            ->take($perpage)
            ->latest('refClient')
            ->where(DB::raw('CONCAT_WS(noDevis,dateDevis,refClient)'), 'LIKE', "%{$request->search}%")
            ->whereNotNull('refClient')
            ->get();
        return response()->json(['total'=>$total,'devis'=>$devis,'current_page'=>$page,'total_page'=>ceil($total/$perpage),'perpage'=>$perpage], 200);
    }

    public function getDevisArchivees()
    {
        $now = Carbon::now();
        $startDate = $now->startOfYear()->subYear()->toDateTimeString();
        $devis = Devis::where('dateDevis','<', $startDate)
            ->latest('dateDevis')
            ->get();
        return response()->json($devis, 200);
    }

    public function archiveeSearch(Request $request)
    {
        $now = Carbon::now();
        $startDate = $now->startOfYear()->subYear()->toDateTimeString();
        $devis = Devis::where('dateDevis','<=', $startDate)
            ->where(DB::raw('CONCAT_WS(noDevis,dateDevis,refClient,tva)'), 'LIKE', "%{$request->search}%")
            ->get();
        return response()->json($devis, 200);
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
    public function edit(Request $request)
    {
        $result = DB::table('devis')->where('noDevis', $request->noDevis)->update([
            'dateDevis' => $request->dateDevis,
            'refClient' => $request->refClient,
            'tva' => $request->tva
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

    public function getLigne(Request $request)
    {
        $lignes = DevisLigne::where('noDevis',$request->noDevis)
            ->get();
        $sum = $lignes->sum('Prix');
        return response()->json([$lignes,'total'=>$sum], 200);
    }

    public function destroy(Devis $devis)
    {
        return response()->json($devis->delete());
    }
}
