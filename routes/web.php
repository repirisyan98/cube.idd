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
Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('kelola-kategori', function () {
        return view('admin.kelola_kategori');
    })->name('kelola.kategori');

    Route::get('kelola-produk', function () {
        return view('admin.kelola_produk');
    })->name('kelola.produk');

    Route::get('katalog', function () {
        return view('user.katalog');
    })->name('katalog');
});