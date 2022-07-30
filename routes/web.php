<?php

use Illuminate\Support\Facades\Auth;
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


Route::redirect('/', '/login');
Auth::routes(['verify' => true]);

Route::group(['middleware' => 'verified'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::middleware('is_admin')->group(function () {
        Route::get('kelola-kategori', function () {
            return view('admin.kelola_kategori');
        })->name('kelola.kategori');

        Route::get('kelola-produk', function () {
            return view('admin.kelola_produk');
        })->name('kelola.produk');

        Route::get('kelola-transaksi', function () {
            return view('admin.kelola_transaksi');
        })->name('kelola.transaksi');

        Route::get('detail-transaksi/{id}', function ($id) {
            return view('admin.detail_transaksi', ['id' => $id]);
        })->name('detail.transaksi');
    });

    Route::middleware('is_user')->group(function () {
        Route::get('katalog', function () {
            return view('user.katalog');
        })->name('katalog');

        Route::get('katalog/{id}/detail', function ($id) {
            return view('user.product_detail', ['id' => $id]);
        })->name('detail.product');

        Route::get('keranjang', function () {
            return view('user.keranjang');
        })->name('keranjang');

        Route::get('pembelian', function () {
            return view('user.pembelian');
        })->name('pembelian');

        Route::get('pembayaran/{id}', function ($id) {
            return view('user.pembayaran', ['id' => $id]);
        })->name('pembayaran');

        Route::get('ulasan', function () {
            return view('user.ulasan');
        })->name('ulasan');
    });
});