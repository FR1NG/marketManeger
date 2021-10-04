<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BranchementChargersController;
use App\Http\Controllers\BranchementController;
use App\Http\Controllers\BranchementImageController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivraisonController;
use App\Http\Controllers\MarketArticleController;
use App\Http\Controllers\MarketCategoryController;
use App\Http\Controllers\MarketCityController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WarehouseController;
use GuzzleHttp\Middleware;
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
    // return redirect()->route('home');
});
Route::middleware(['auth'])->group(function () {
    Route::get('test', function () {
        $this->middleware(function ($request, $next) {
            // $this->projects = Auth::user()->projects;
            // ==
            if (Auth::user()->hasRole('manager')) {
                return $request->id;
                return $next($request);
            }
        });
    });
    // user routes
    Route::post('/user/update', [UserController::class, 'updateInfo']);
    Route::post('/user/password/update', [UserController::class, 'updatePassword']);


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
    Route::get('/branchements/create', [BranchementController::class, 'create']);
    Route::get('/branchements/getBranchementArticles', [BranchementController::class, 'getBranchementArticles']);
    Route::post('branchements/charges/store', [BranchementChargersController::class, 'store']);
    Route::post('branchements/images/store', [BranchementImageController::class, 'store']);
    Route::get('branchements/images/index', [BranchementImageController::class, 'index']);


    // warehouse routes
    Route::get('/warehouses/index', [WarehouseController::class, 'index']);

    // dashboard routes
    Route::get('/dashboard/index', [DashboardController::class, 'index']);
    Route::get('/dashboard/getAccomlishment', [DashboardController::class, 'getAccomlishment']);
});
// =============[admin routes:BEGIN]======================
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'role:admin']], function () {
    // markets routes
    Route::group(['prefix' => '/markets'], function () {
        Route::get('/', [MarketController::class, 'index']);
        Route::post('/store', [MarketController::class, 'store']);
        Route::get('/info', [MarketController::class, 'info']);
        Route::patch('/update', [MarketController::class, 'update']);


        Route::post('/categories/store', [MarketCategoryController::class, 'store']);
        Route::get('/categories/getData', [MarketCategoryController::class, 'getData']);
        Route::post('/articles/store', [MarketArticleController::class, 'store']);
        Route::post('/cities/store', [MarketCityController::class, 'store']);
        Route::get('/cities/get', [MarketCityController::class, 'get']);
    });
});
// =============[admin routes:END]======================

Route::group(['prefix' => 'market/{market_id}', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', [HomeController::class, 'market']);
    // >>>>>>>>>>test:START
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
    Route::get('/branchements/create', [BranchementController::class, 'create']);
    Route::get('/branchements/getBranchementArticles', [BranchementController::class, 'getBranchementArticles']);
    Route::post('branchements/charges/store', [BranchementChargersController::class, 'store']);



    // warehouse routes
    Route::get('/warehouses/index', [WarehouseController::class, 'index']);

    // dashboard routes
    Route::get('/dashboard/index', [DashboardController::class, 'index']);
    Route::get('/dashboard/getAccomlishment', [DashboardController::class, 'getAccomlishment']);
    // >>>>>>>>>>test:END

});

Auth::routes(['register' => false]);


Route::middleware(['role:admin'])->get('/admin', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin');
Route::middleware(['role:manager'])->get('/manager', [App\Http\Controllers\HomeController::class, 'manager'])->name('manager');
