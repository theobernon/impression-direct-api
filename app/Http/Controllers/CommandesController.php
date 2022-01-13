<?php

namespace App\Http\Controllers;

use App\Models\Commandes;
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
            $commande->entCli = $request->entCli;
            $commande->ad1 = $request->adCom1;
            $commande->ad2 = $request->adCom2;
            $commande->ad3 = $request->adCom3;
            $commande->tel = $request->tel;
            $commande->mail = $request->mailCom;
            $commande->livCli = $request->livCli;
            $commande->livad1 = $request->livAdrCom1;
            $commande->livad2 = $request->livAdrCom2;
            $commande->livad3 = $request->livAdrCom3;
            $commande->produits = $request->produitsCom;
            $commande->mpaiement = $request->moyenPaiement;
            $commande->reduction = $request->reduction;
            $commande->pxttc = $request->pxttc;
            $commande->BAT = $request->BAT;
            $commande->dateExpd = $request->dateExpedition;
            $commande->adrSuivi = $request->lienSuivi;
            $commande->momentPaiement = $request->momentPaiement;
            $commande->commentaire = $request->commentaire;
            $commande->transporteurClient = $request->transporteurClient;
            $commande->expertise = $request->expertiseCommande;
            $commande->pxTransporteur = $request->pxTransporteur;
            $commande->noDevis = $request->noDevisCommande;
            $commande->refTransporteur = $request->refTransporteurs;
            $commande->id_commission = $request->id_commission;
            $commande->id_NomPdf = 0;


        $commande->save();
    }

    public function getOne(Commandes $commande)
    {
        $result = DB::table('commande')
            ->where('noCommande', $commande->noCommande)->get();
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
            ->select('commande.*')
            ->latest('noCommande')
            //->take(10)
            ->paginate(10);//->lastPage();
        return response()->json($result);
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
}
