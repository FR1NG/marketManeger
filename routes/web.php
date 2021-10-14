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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('test', function () {
    $file = '1633348589_download.jpeg';
    File::Delete('/storage/app/public/uploads/' . $file);
    return 'hello';
});

Route::get('/', function () {
    return view('welcome');
    // return redirect()->route('home');
});
Route::middleware(['auth'])->group(function () {
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
    Route::get('branchements/filter', [BranchementController::class, 'filter']);
    Route::post('branchements/charges/store', [BranchementChargersController::class, 'store']);
    Route::post('branchements/images/store', [BranchementImageController::class, 'store']);
    Route::get('branchements/images/index', [BranchementImageController::class, 'index']);


    // warehouse routes
    Route::get('/warehouses/index', [WarehouseController::class, 'index']);

    // dashboard routes
    Route::get('/dashboard/index', [DashboardController::class, 'index']);
    Route::get('/dashboard/getAccomlishment', [DashboardController::class, 'getAccomlishment']);
});
//  =============[MANAGER routes:END]======================
// 
// 
// 
// =============[admin routes:BEGIN]======================
Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'role:admin']], function () {
    // markets routes
    Route::group(['prefix' => '/markets'], function () {
        Route::get('/', [MarketController::class, 'index']);
        Route::post('/store', [MarketController::class, 'store']);
        Route::get('/info', [MarketController::class, 'info']);
        Route::patch('/update', [MarketController::class, 'update']);
        Route::delete('/delete', [MarketController::class, 'delete']);


        Route::post('/categories/store', [MarketCategoryController::class, 'store']);
        Route::get('/categories/getData', [MarketCategoryController::class, 'getData']);
        Route::delete('/categories/delete', [MarketCategoryController::class, 'delete']);


        Route::post('/articles/store', [MarketArticleController::class, 'store']);

        Route::post('/cities/store', [MarketCityController::class, 'store']);
        Route::get('/cities/get', [MarketCityController::class, 'get']);
        Route::delete('/cities/delete', [MarketCityController::class, 'delete']);
    }); // end of market groupe


    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'adminDash']);

    // articles routes
    Route::get('articles/index', [ArticleController::class, 'index']);
    Route::post('articles/store', [ArticleController::class, 'store']);
    Route::delete('articles/delete', [ArticleController::class, 'delete']);
    Route::patch('articles/update', [ArticleController::class, 'update']);
});
// =============[admin routes:END]=======================================================
// 
// 
// 
// =============[MARKET routes:END]=======================================================
Route::group(['prefix' => 'market/{market_id}', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('/', [HomeController::class, 'market']);
    //    ========={START normal routes for market}
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
    Route::get('branchements/filter', [BranchementController::class, 'filter']);
    Route::post('branchements/charges/store', [BranchementChargersController::class, 'store']);
    Route::post('branchements/images/store', [BranchementImageController::class, 'store']);
    Route::get('branchements/images/index', [BranchementImageController::class, 'index']);


    // warehouse routes
    Route::get('/warehouses/index', [WarehouseController::class, 'index']);

    // dashboard routes
    Route::get('/dashboard/index', [DashboardController::class, 'index']);
    Route::get('/dashboard/getAccomlishment', [DashboardController::class, 'getAccomlishment']);
    //    ========={END normal routes for market}
});

Auth::routes(['register' => false]);


Route::middleware(['role:admin'])->get('/admin', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin');
Route::middleware(['role:manager'])->get('/manager', [App\Http\Controllers\HomeController::class, 'manager'])->name('manager');
