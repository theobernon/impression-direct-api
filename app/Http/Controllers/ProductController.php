<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $result = DB::table('product')->insert([
           'productCatId'  => $request->productCatId,
            'reference'    => $request->productReference,
            'nomProduit'   => $request->nomProduct,
            'codePrix'     => $request->codePrix,
            'gauffrage'    => $request->gauffrageProduct,
            'impression'   => $request->productImpression,
            'finition'     => $request->ProductFinition,
            'paper'        => $request->productPaper,
            'px'           => $request->productPrix,
            'qte'          => $request->productQuantite,
            'size'         => $request->productSize,
            'color'        => $request->prodctColor,
            'comment'      => $request->comment,
            'cte'          => $request->cte,
            'pld'          => $request->pld,
            'typ'          => $request->typ,
            'image'        => $request->image,
        ]);
        return response()->json($result);
    }

    public function getOne(Product $product)
    {
        $result = DB::table('product')
            ->where('id', $product->id)->get();
        return response()->json($result);
    }

    public function getAllProduct()
    {
        $result = DB::table('product')
            ->join('productCat', 'productCat.id', '=', 'product.productCatId')
            ->select('product.*')
            ->whereNotNull('cte')
            ->get();
        return response()->json($result);
    }

    public function edit(Product $product, Request $request)
    {
        $result = DB::table('product')->where('id', $product->id)->update([
            'productCatId'  => $request->productCatId,
            'reference'    => $request->productReference,
            'nomProduit'   => $request->nomProduct,
            'codePrix'     => $request->codePrix,
            'gauffrage'    => $request->gauffrageProduct,
            'impression'   => $request->productImpression,
            'finition'     => $request->ProductFinition,
            'paper'        => $request->productPaper,
            'px'           => $request->productPrix,
            'qte'          => $request->productQuantite,
            'size'         => $request->productSize,
            'color'        => $request->prodctColor,
            'comment'      => $request->comment,
            'cte'          => $request->cte,
            'pld'          => $request->pld,
            'typ'          => $request->typ,
            'image'        => $request->image,
        ]);
        return response()->json($result);
    }

    public function destroy(Product $product)
    {
        return response()->json($product->delete());
    }

}
