<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\BonEntreeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BonSortieController;
use App\Http\Controllers\StockController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');


Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{id}/edit', [ClientController::class, 'edit'])->name('clients.edit'); // Route pour l'action d'édition
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');
Route::get('/clients/download', 'ClientController@downloadPdf')->name('clients.download');



Route::get('/fournisseurs', [FournisseurController::class, 'index'])->name('fournisseurs.index');
Route::get('/fournisseurs/create', [FournisseurController::class, 'create'])->name('fournisseurs.create');
Route::post('/fournisseurs', [FournisseurController::class, 'store'])->name('fournisseurs.store');
Route::get('/fournisseurs/{fournisseur}', [FournisseurController::class, 'show'])->name('fournisseurs.show');
Route::get('/fournisseurs/{fournisseur}/edit', [FournisseurController::class, 'edit'])->name('fournisseurs.edit');
Route::put('/fournisseurs/{fournisseur}', [FournisseurController::class, 'update'])->name('fournisseurs.update');
Route::delete('/fournisseurs/{fournisseur}', [FournisseurController::class, 'destroy'])->name('fournisseurs.destroy');



Route::get('/bon_entrees', [BonEntreeController::class, 'index'])->name('bon_entrees.index');
Route::get('/bon_entrees/create', [BonEntreeController::class, 'create'])->name('bon_entrees.create');
Route::post('/bon_entrees', [BonEntreeController::class, 'store'])->name('bon_entrees.store');
Route::get('/bon_entrees/{bon_entree}', [BonEntreeController::class, 'show'])->name('bon_entrees.show');
Route::get('/bon_entrees/{bon_entree}/edit', [BonEntreeController::class, 'edit'])->name('bon_entrees.edit');
Route::put('/bon_entrees/{bon_entree}', [BonEntreeController::class, 'update'])->name('bon_entrees.update');
Route::delete('/bon_entrees/{bon_entree}', [BonEntreeController::class, 'destroy'])->name('bon_entrees.destroy');






Route::get('/bon_sorties', [BonSortieController::class, 'index'])->name('bon_sorties.index');
Route::get('/bon_sorties/create', [BonSortieController::class, 'create'])->name('bon_sorties.create');
Route::post('/bon_sorties', [BonSortieController::class, 'store'])->name('bon_sorties.store');
Route::put('/bon_sorties/{id}', [BonSortieController::class, 'update'])->name('bon_sorties.update');
Route::get('/bon_sorties/{id}', [BonSortieController::class, 'show'])->name('bon_sorties.show');
Route::get('/bon_sorties/{id}/edit', [BonSortieController::class, 'edit'])->name('bon_sorties.edit');
Route::delete('/bon_sorties/{id}', [BonSortieController::class, 'destroy'])->name('bon_sorties.destroy');
Route::get('/bon_sorties/{id}/download-pdf', [BonSortieController::class, 'downloadPDF'])->name('bon_sorties.download-pdf');


Route::resource('stocks', StockController::class);
Route::get('/stocks/pdf', [StockController::class, 'downloadPDF'])->name('stocks.download-pdf');







