<?php

use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FournisseurController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function(){
    //fournisseur routes
    Route::post('/fournisseur/store',[FournisseurController::class,'store']);
    Route::get('/fournisseur/get',[FournisseurController::class,'getData']);
    Route::get('/fournisseur/details',[FournisseurController::class,'details']);
    Route::delete('/fournisseur/delete',[FournisseurController::class,'delete']);
    Route::patch('/fournisseur/update',[FournisseurController::class,'update']);

    // employe routes
    Route::post('/employe/store',[EmployeController::class,'store']);
    Route::get('/employe/index',[EmployeController::class,'index']);
    Route::get('/employe/details',[EmployeController::class,'details']);
    Route::patch('/employe/update',[EmployeController::class,'update']);
    Route::delete('/employe/delete',[EmployeController::class,'delete']);



});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
