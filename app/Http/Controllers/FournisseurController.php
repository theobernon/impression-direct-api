<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FournisseurController extends Controller
{
    public function getOne(Fournisseur $fournisseurs)
    {
        $result = DB::table('fournisseur')
            ->where('reference', $fournisseurs->reference)->get();
        return response()->json($result);
    }



    public function getAllFournisseur()
    {
        $result = DB::table('fournisseur')
            ->select('fournisseur.*')
            ->latest('appellation')
            ->get();
        return response()->json($result);
    }



    public function destroy(Fournisseur $fournisseurs)
    {
        return response()->json($fournisseurs->delete());
    }
}
