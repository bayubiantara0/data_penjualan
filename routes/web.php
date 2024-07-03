<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataPenjualan;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\TransaksiController;
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
    return view('dashboard.dashboard');
});

Route::controller(DataPenjualan::class)->group(function(){
    Route::get('/datapenjualan', 'index')->name('datapenjualan.index');
    Route::get('/datapenjualan/add', 'index_add');
    Route::get('/datapenjualan/show/{id}', 'show');
    Route::post('/datapenjualan/store', 'store')->name('datapenjualan.store');
    Route::get('/datapenjualan/edit/{id}', 'edit')->name('datapenjualan.edit');
    Route::post('/datapenjualan/update', 'update')->name('datapenjualan.update');
    Route::delete('/datapenjualan/delete/{id}', 'destroy')->name('datapenjualan.delete');
});


Route::resource('barangs', BarangController::class);
Route::resource('transaksis', TransaksiController::class);
Route::resource('jenis-barangs', JenisBarangController::class);
