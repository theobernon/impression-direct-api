<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pays;
use Illuminate\Support\Facades\DB;


class PaysController extends Controller
{
    public function create(Request $request)
    {
        $result = DB::table('devis')->insert([
            'nom_pays' => $request->nomPays
        ]);

        return response()->json($result);
    }

    public function getOne(Pays $pays)
    {
        $result = DB::table('pays')
            ->where('id_pays', $pays->id_pays)->get();
        return response()->json($result);
    }



    public function getAllPays()
    {
        $result = DB::table('pays')
            ->select('pays.*')->get();
        return response()->json($result);
    }



    public function destroy(Pays $pays)
    {
        return response()->json($pays->delete());
    }
}
