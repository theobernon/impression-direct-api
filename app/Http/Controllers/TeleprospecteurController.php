<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Teleprospecteur;


class TeleprospecteurController extends Controller
{
    public function create(Request $request)
    {
        $result = DB::table('teleprospecteur')->insert([
            'nom' => $request->nomTele,
            'prenom' => $request->prenomTele,
            'numEntreprise' => $request->numEntrepriseTele,
            'email' => $request->emailTele,
            'tel' => $request->telTele,
            'mobile' => $request->mobileTele,
            'commission' => $request->commissionTele
        ]);

        return response()->json($result);
    }

    public function getOne(Teleprospecteur $teleprospecteur)
    {
        $result = DB::table('teleprospecteur')
            ->where('num', $teleprospecteur->num)->get();
        return response()->json($result);
    }

    public function getAllTele()
    {
        $result = DB::table('teleprospecteur')
            ->select('teleprospecteur.*')->get();
        return response()->json($result);
    }

    public function getByClient(Client $client)
    {
        //dd($user->input);
        $result = DB::table('teleprospecteur')
            ->join('client', 'client.id_teleprospecteur', '=', 'teleprospecteur.num')
            ->where('teleprospecteur.num', '=', $client->id_teleprospecteur)->get(['teleprospecteur.*']);
        return response()->json($result);
    }

    public function edit(Teleprospecteur $teleprospecteur, Request $request)
    {
        $result = DB::table('teleprospecteur')->where('num', $teleprospecteur->num)->update([
            'nom' => $request->nomTele,
            'prenom' => $request->prenomTele,
            'numEntreprise' => $request->numEntrepriseTele,
            'email' => $request->emailTele,
            'tel' => $request->telTele,
            'mobile' => $request->mobileTele,
            'commission' => $request->commissionTele
        ]);
        return response()->json($result);
    }

    public function destroy(Teleprospecteur $teleprospecteur)
    {
        return response()->json($teleprospecteur->delete());
    }
}
