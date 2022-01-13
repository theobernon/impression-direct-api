<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    public function create(Request $request)
    {
        $result = DB::table('commission')->insert([
            'taux' => $request->taux,
        ]);

        return response()->json($result);
    }

    public function getOne(Commission $commission)
    {
        $result = DB::table('commission')
            ->where('id', $commission->id)->get();
        return response()->json($result);
    }

    public function getCommissionByCommande()
    {
        $commissions = Commission::with([])
            ->take();
    }

    public function getAllCommission()
    {
        $commissions = Commission::select('taux','id')
            ->orderBy('taux','ASC')
            ->get();

        return $commissions;
        /*
        $result = DB::table('commission')
            ->select('commission.*')->get();
        return response()->json($result);*/
    }

    public function edit(Commission $commission, Request $request)
    {
        $result = DB::table('commission')->where('id', $commission->id)->update([
            'taux' => $request->taux,
        ]);
        return response()->json($result);
    }

    public function destroy(Commission $commission)
    {
        return response()->json($commission->delete());
    }
}
