<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DevisLigneController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\CommandesController;
use App\Http\Controllers\TeleprospecteurController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\FactureController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [PassportAuthController::class, 'login']);
//UNIQUEMENT EN DEVELOPMENT
//le code ci dessous permet de modifier le mot de passe d'un user
//Route::post('login',function(Request $request){
//    $user = App\Models\User::firstWhere('email',$request->email);
//    $user->password = Illuminate\Support\Facades\Hash::make('12345678');
//    $user->save();
//});
//FIN UNIQUEMENT EN DEVELOPMENT


Route::post('register', [PassportAuthController::class, 'register']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('commandes')->group(function () {
    Route::post('/create', [CommandesController::class, 'create']);
    Route::get('/aValider', [CommandesController::class, 'getAValider']);
    Route::patch('/validerClient/{noCommande}', [CommandesController::class, 'validerClient']);
    Route::get('/clientAValider', [CommandesController::class, 'getClientAValider']);
    Route::get('/aExpedier', [CommandesController::class, 'getAExpedier']);
    Route::get('/aFacturer', [CommandesController::class, 'getAFacturer']);
    Route::get('/aEnvoyer', [CommandesController::class, 'getAEnvoyer']);
    Route::get('/aPayer', [CommandesController::class, 'getAPayer']);
    Route::patch('/{noCommande}/validerClient', [CommandesController::class, 'validerClient']);
    Route::get('/client/{client}', [CommandesController::class, 'getByClient']);
    Route::get('/', [CommandesController::class, 'getAllCommandes']);
    Route::patch('/edit/{commande}', [CommandesController::class, 'edit']);
    Route::delete('/destroy/{commande}', [CommandesController::class, 'destroy']);
    Route::patch('/nFact/{commande}', [CommandesController::class, 'genereFact']);

    Route::get('/{noCommande}', [CommandesController::class, 'getOne']);



});

Route::prefix('devis')->group(function () {
    Route::post('/create', [DevisController::class, 'create']);
    Route::get('/{devis}', [DevisController::class, 'getOne']);
    Route::get('/', [DevisController::class, 'getAllDevis']);
    Route::get('/client/{commande}', [DevisController::class, 'getByClient']);
    Route::patch('/edit/{devis}', [DevisController::class, 'edit']);
    Route::delete('/destroy/{devis}', [DevisController::class, 'destroy']);
    Route::get('/commande/{commande}', [DevisController::class, 'getDevisByCom']);
    Route::get('/ligne/{devisLigne}', [DevisController::class, 'getLigne']);


});

Route::prefix('ligneDevis')->group(function () {
    Route::post('/create', [DevisLigneController::class, 'create']);
    Route::get('/{devisLigne}', [DevisLigneController::class, 'getOne']);
    Route::get('/', [DevisLigneController::class, 'getAllDevisLigne']);
    Route::patch('/edit/{devisLigne}', [DevisLigneController::class, 'edit']);
    Route::delete('/destroy/{devisLigne}', [DevisLigneController::class, 'destroy']);
    Route::get('/devis/{devis}', [DevisLigneController::class, 'getByDevis']);

});

Route::prefix('client')->group(function () {
    Route::post('/create', [ClientController::class, 'create']);
    Route::get('/{client}', [ClientController::class, 'getOne']);
    Route::get('/', [ClientController::class, 'getAllClient']);
    Route::get('/tele/{teleprospecteur}', [ClientController::class, 'getByTele']);
    Route::patch('/edit/{client}', [ClientController::class, 'edit']);
    Route::delete('/destroy/{client}', [ClientController::class, 'destroy']);
    Route::get('/commande/{commande}', [ClientController::class, 'getClientByCom']);
    Route::get('/devis/{devis}', [ClientController::class, 'getClientByDevis']);


});

Route::prefix('teleprospecteur')->group(function () {
    Route::post('/create', [TeleprospecteurController::class, 'create']);
    Route::get('/{teleprospecteur}', [TeleprospecteurController::class, 'getOne']);
    Route::get('/client/{client}', [TeleprospecteurController::class, 'getByClient']);
    Route::get('/', [TeleprospecteurController::class, 'getAllTele']);
    Route::patch('/edit/{teleprospecteur}', [TeleprospecteurController::class, 'edit']);
    Route::delete('/destroy/{teleprospecteur}', [TeleprospecteurController::class, 'destroy']);
});

Route::prefix('pays')->group(function () {
    Route::post('/create', [PaysController::class, 'create']);
    Route::get('/{pays}', [PaysController::class, 'getOne']);
    Route::get('/', [PaysController::class, 'getAllPays']);
    Route::delete('/destroy/{pays}', [PaysController::class, 'destroy']);
});

Route::prefix('fournisseur')->group(function () {
    Route::get('/{fournisseur}', [FournisseurController::class, 'getOne']);
    Route::get('/', [FournisseurController::class, 'getAllFournisseur']);
    Route::delete('/destroy/{fournisseur}', [FournisseurController::class, 'destroy']);
});

Route::prefix('commission')->group(function () {
    Route::post('/create', [CommissionController::class, 'create']);
    Route::get('/{commission}', [CommissionController::class, 'getOne']);
    Route::get('/', [CommissionController::class, 'getAllCommission']);
    Route::patch('/edit/{commission}', [CommissionController::class, 'edit']);
    Route::delete('/destroy/{commission}', [CommissionController::class, 'destroy']);
});



Route::prefix('facture')->group(function () {
    Route::post('/create', [FactureController::class, 'create']);
    Route::get('/{facture}', [FactureController::class, 'getOne']);
    Route::get('/', [FactureController::class, 'getAllCommission']);
    Route::patch('/edit/{commission}', [FactureController::class, 'edit']);
    Route::delete('/destroy/{commission}', [FactureController::class, 'destroy']);
});


/*.
Route::middleware('auth:api')->group(function () {


});
*/
