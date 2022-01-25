<?php

namespace App\Http\Controllers;


use App\Http\Resources\CommandeResource;
use App\Models\Commandes;
use App\Models\Devis;
use App\Models\Teleprospecteur;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Pagination\LengthAwarePaginator;

class ClientController extends Controller
{
    public function create(Request $request)
    {
        $client = Client::create([
            'email' => $request->email,
            'type' => '1',
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'societe' => $request->societe,
            'tel' => $request->tel,
            'mobile' => $request->mobile,
            'fax' => $request->fax,
            'factAdr1' => $request->factAdr1,
            'factAdr2' => $request->factAdr2,
            'factAdr3' => $request->factAdr3,
            'factPays' => $request->factPays,
            'livAdr1' => $request->livAdr1,
            'livAdr2' => $request->livAdr2,
            'livAdr3' => $request->livAdr3,
            'livPays' => $request->livPays,
            'remarques' => $request->remarques,
            'id_teleprospecteur' => $request->id_teleprospecteur
        ]);
//dd($request);
        if ($client->save())
            return response()->json([
                'success' => true,
                'message' => 'client bien ajouté'
            ]);
        else
            return response()->json([
                'error' => true,
                'message' => 'Client non ajouté'
            ], 500);

    }
    public function getOne(Client $client)
    {
        $result = DB::table('client')->where('refClient', $client->refClient)->get();
        return response()->json($result);
    }
    public function getByTele(Teleprospecteur $teleprospecteur)
    {
        //dd($user->input);
        $result = DB::table('client')
            ->join('teleprospecteur', 'teleprospecteur.num', '=', 'client.id_teleprospecteur')
            ->where('client.id_teleprospecteur', '=', $teleprospecteur->num)->get(['client.*']);
        return response()->json($result);
    }

    public function getClientByCom(Commandes $commande)
    {
        //dd($user->input);
        //$result = Client::with('commande')
            //->get();
        //dd($result);
        $result = $commande->client;
        return response()->json($result);
    }

    public function getClientByDevis(Devis $devis)
    {
        //dd($user->input);
        //$result = Client::with('commande')
        //->get();
        //dd($result);
        $result = $devis->client;
        return response()->json($result);
    }



    public function getAllClient(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $perpage = (int)$request->query('perpage', 10);
        $total = Client::all()->count();
        $clients = Client::with(['pays','teleprospecteur'])
            ->skip(($page-1)*$perpage)
            ->take($perpage)
            ->latest('refClient')
            ->get();

        return response()->json(['total'=>$total,'clients'=>$clients,'current_page'=>$page,'total_page'=>ceil($total/$perpage),'perpage'=>$perpage], 200);
    }

    public function search(Request $request)
    {
        $page = (int)$request->query('page', 1);
        $perpage = (int)$request->query('perpage', 10);
        $total = Client::with(['pays','teleprospecteur'])
            ->latest('refClient')
            ->where(DB::raw('CONCAT_WS(refClient,email,nom,prenom,societe,tel,mobile)'), 'LIKE', "%{$request->search}%")
            ->count();
        $clients = Client::with(['pays','teleprospecteur'])
            ->skip(($page-1)*$perpage)
            ->take($perpage)
            ->latest('refClient')
            ->where(DB::raw('CONCAT_WS(refClient,email,nom,prenom,societe,tel,mobile)'), 'LIKE', "%{$request->search}%")
            ->get();
        return response()->json(['total'=>$total,'clients'=>$clients,'current_page'=>$page,'total_page'=>ceil($total/$perpage),'perpage'=>$perpage], 200);
    }

    public function edit(Request $request)
    {
//        dd($request);
//        $client = Client::where('refClient', $request->refClient);
        $client = Client::where('refClient',$request->refClient)->update([
            'email' => $request->emailClient,
            'typeClient' => '1',
            'nom' => $request->nomClient,
            'prenom' => $request->prenomClient,
            'societe' => $request->societeClient,
            'tel' => $request->telClient,
            'mobile' => $request->mobileClient,
            'fax' => $request->faxClient,
            'factAdr1' => $request->factAdr1,
            'factAdr2' => $request->factAdr2,
            'factAdr3' => $request->factAdr3,
            'factPays' => $request->factPays,
            'livNom' => $request->livNom,
            'livAdr1' => $request->livAdr1,
            'livAdr2' => $request->livAdr2,
            'livAdr3' => $request->livAdr3,
            'livPays' => $request->livPays,
            'remarques' => $request->remarques,
            'id_teleprospecteur' => $request->id_teleprospecteur
        ]);
//        dd($request);
//        $client = Client::update($request->all([]));
        return response()->json($client, 200);
    }



    public function destroy(Client $client)
    {
        return response()->json($client->delete());
    }

//    public function update(Request $request)
//    {
//        dd($request);
//        $client = Client::update($request->all());
//        return response()->json($client, 200);
//    }
}

