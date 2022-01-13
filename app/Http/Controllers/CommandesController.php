<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommandeCollection;
use App\Http\Resources\CommandeResource;
use App\Models\Commandes;
use App\Models\Payee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;


class CommandesController extends Controller
{
    public function create(Request $request)
    {
        $lastCom = Commandes::select('noCommande')
            ->latest('noCommande')
            ->take(1)
            ->get('noCommande');

        $commande = new Commandes();

        foreach ($lastCom as $last) {
            $commande->noCommande = $last->noCommande +1;
        }

            $commande->dateCommande = $request->dateCommande;
            $commande->refClient = $request->refClient;
            if ($commande->refClient != 0){
                $commande->valClient = 1;
            }
            else {
                $commande->valClient = 0;
            }

        $commande = Commandes::create([
            'noCommande'=>$commande->noCommande,
            'dateCommande'=> Carbon::now()->toDateTimeString(),
            'dateExpd'=>$request->dateExpd,
            'refClient'=>$request->refClient,
            'entCli' => $request->entCli,
            'ad1'=>$request->ad1,
            'ad2'=>$request->ad2,
            'ad3'=>$request->ad3,
            'produits'=>$request->produitsCom,
            'mpaiement'=>$request->moyenPaiement,
            'mail' => $request->mailCom,
            'livCli' => $request->livCli,
            'livad1' => $request->livAd1,
            'livad2' => $request->livAd2,
            'livad3' => $request->livAd3,
            'reduction' => $request->reduction,
            'pxttc' => $request->pxttc,
            'BAT' => $request->BAT,
            'adrSuivi' => $request->adrSuivi,
            'momentPaiement' => $request->momentPaiement,
            'commentaire' => $request->commentaire,
            'transporteurClient' => $request->transporteurClient,
            'expertise' => $request->expertiseCommande,
            'pxTransporteur' => $request->pxTransporteur,
            'noDevis' => $request->noDevisCommande,
            'refTransporteur' => $request->refTransporteurs,
            'id_commission' => $request->id_commission,
            'id_NomPdf' => 0,
        ]);
            return response()->json($commande,201);
    }

    public function getOne(Request $request)
    {
        $result = Commandes::with(['client','teleprospecteur'])
            ->where('noCommande',$request->noCommande)->get()[0];
//        $result = DB::table('commande')
//            ->where('noCommande', $request->noCommande)->get()[0];
        return response()->json($result);
    }


    public function getLast()
    {
        $result = Commandes::with(['client','teleprospecteur'])
            ->select('commande.*')
            ->latest('noCommande')
            ->take(10)
            ->get();
        return response()->json($result);

        /*$commandes = Commandes::all()
            ->latest('noCommande')
            ->take(1)
            ->get();

        return response()->json($commandes);
        */
    }

    public function getAllCommandes()
    {
        $result = Commandes::with(['client','teleprospecteur'])
            ->latest('noCommande')
            ->limit(100)
            ->latest('dateCommande')
        ->get();//->lastPage();
        return response()->json($result, 200);
    }


    public function getByClient(Client $client)
    {
        //dd($client->input);
        $result = DB::table('commande')
            ->join('client', 'commande.refClient', '=', 'client.refClient')
            ->where('commande.refClient', '=', $client->refClient)->get(['commande.*']);
        return response()->json($result);
    }


    public function edit(Commandes $commande, Request $request)
    {
        $result = DB::table('commande')->where('noCommande', $commande->noCommande)->update([
            'dateCommande' => $request->dateCommande,
            'refClient' => $request->refClient,
            'entCli' => $request->entCli,
            'ad1' => $request->adCom1,
            'ad2' => $request->adCom2,
            'ad3' => $request->adCom3,
            'tel' => $request->tel,
            'mail' => $request->mailCom,
            'livCli' => $request->livCli,
            'livad1' => $request->livAdrCom1,
            'livad2' => $request->livAdrCom2,
            'livad3' => $request->livAdrCom3,
            'produits' => $request->produitsCom,
            'mpaiement' => $request->moyenPaiement,
            'reduction' => $request->reduction,
            'pxttc' => $request->pxttc,
            'BAT' => $request->BAT,
            'valClient' => $request->validationClient,
            'validee' => $request->commandeValidee,
            'expediee' => $request->expeditionCommande,
            'dateExpd' => $request->dateExpedition,
            'facturee' => $request->facturee,
            'nomPdf' => $request->nomPdf,
            'envoyee' => $request->commandeEnvoyee,
            'noColissimo' => $request->noColissimo,
            'adrSuivi' => $request->lienSuivi,
            'momentPaiement' => $request->momentPaiement,
            'optionT' => $request->optionT,
            'impressions_numeriques' => $request->impressions_numeriques,
            'commentaire' => $request->commentaire,
            'transporteurClient' => $request->transporteurClient,
            'expertise' => $request->expertiseCommande,
            'pxTransporteur' => $request->pxTransporteur,
            'noDevis' => $request->noDevisCommande,
            'envoiSuivi' => $request->envoiSuiviCommande,
            'refTransporteur' => $request->refTransporteurs,
            'teleprospecteur' => $request->teleprospecteur,
            'id_commission' => $request->id_commission,
            'id_NomPdf' => $request->id_NomPdf,
        ]);
        return response()->json($result);
    }

    public function genereFact(Request $request, $noCommande)
    {
        $commande = Commandes::find($noCommande);

        $dateMois = date('m');
        $dateAnnee=substr(date('Y'),2,2);
        $client = $commande->refClient;
        $num = Commandes::select('nomPdf')
            ->where('like','=','f%.pdf')
            ->latest('nomPdf');

        $num += substr($num,1,4)+1;

        dd($num);

        $noFact = 'f'.$num.$dateMois.$dateAnnee.$client;


        if (!$commande) {
            return response()->json([
                'success' => false,
                'message' => 'Commande introuvable'
            ], 400);
        }

        $updated = $commande->fill($request->nomPdf=$noFact)->save();
        $updated += $commande->fill($request->facturee=1)->save();

        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => "La commande n'a pas été modifiée"
            ], 500);
    }


    public function destroy(Commandes $commande)
    {
        return response()->json($commande->delete());
    }

    public function getAValider()
    {
        return response()->json(\App\Models\Commandes::aValider()->get());
    }

    public function getClientAValider()
    {
        return response()->json(Commandes::clientAValider()->get());
    }

    public function getAExpedier()
    {
        return response()->json(Commandes::aExpedier()->get());
    }

    public function getAFacturer()
    {
        return response()->json(Commandes::aFacturer()->get());
    }

    public function getAEnvoyer()
    {
        return response()->json(Commandes::aEnvoyer()->get());
    }

    public function getAPayer()
    {
        return response()->json(Payee::aPayer()->has('commande')->get(), 200);
    }

    public function validerClient(Request $request)
    {
        $commande = Commandes::find($request->noCommande);
        if($commande)
        {
            $commande->valClient = 1;
            $commande->save();
        }
        return response()->json($commande,200);
    }
}
