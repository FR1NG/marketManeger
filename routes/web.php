<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BranchementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\UnitController;
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
    // return view('welcome');
    return redirect()->route('login');
});
Route::middleware(['auth'])->group(function () {
    //fournisseur routes
    Route::post('/fournisseur/store', [FournisseurController::class, 'store']);
    Route::get('/fournisseur/get', [FournisseurController::class, 'getData']);
    Route::get('/fournisseur/details', [FournisseurController::class, 'details']);
    Route::delete('/fournisseur/delete', [FournisseurController::class, 'delete']);
    Route::patch('/fournisseur/update', [FournisseurController::class, 'update']);

    // employe routes
    Route::post('/employe/store', [EmployeController::class, 'store']);
    Route::get('/employe/index', [EmployeController::class, 'index']);
    Route::get('/employe/details', [EmployeController::class, 'details']);
    Route::patch('/employe/update', [EmployeController::class, 'update']);
    Route::delete('/employe/delete', [EmployeController::class, 'delete']);

    // categories routes
    Route::post('/categories/store', [CategorieController::class, 'store']);
    Route::patch('/categories/update', [CategorieController::class, 'update']);
    Route::delete('/categories/delete', [CategorieController::class, 'delete']);

    // units routes
    Route::post('/units/store', [UnitController::class, 'store']);
    Route::patch('/units/update', [UnitController::class, 'update']);
    Route::delete('/units/delete', [UnitController::class, 'delete']);


    // articles routes
    Route::get('articles/index', [ArticleController::class, 'index']);
    Route::post('articles/store', [ArticleController::class, 'store']);


    // achats routes
    Route::get('/achats/index', [AchatController::class, 'index']);
    Route::get('/achats/create', [AchatController::class, 'create']);
    Route::post('/achats/store', [AchatController::class, 'store']);
    Route::get('/achats/details', [AchatController::class, 'details']);

    // livraison routes
    Route::post('/livraisons/store', [LivraisonController::class, 'store']);
    Route::get('/livraisons/details', [LivraisonController::class, 'details']);

    // branchements routes
    Route::get('/branchements/index', [BranchementController::class, 'index']);
    Route::post('/branchements/store', [BranchementController::class, 'store']);
    Route::get('/branchements/details', [BranchementController::class, 'details']);
    Route::get('/branchements/getArticles', [BranchementController::class, 'getArticles']);
    Route::post('/branchements/addArticles', [BranchementController::class, 'addArticles']);
    Route::get('/branchements/getEmployees', [BranchementController::class, 'getEmployees']);
    Route::post('/branchements/addEmployees', [BranchementController::class, 'addEmployees']);
    Route::get('/branchements/getItemPrice', [BranchementController::class, 'getItemPrice']);

    // dashboard routes
    Route::get('/dashboard/index', [DashboardController::class, 'index']);
});

Auth::routes(['register' => false]);

Route::get('/App', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
