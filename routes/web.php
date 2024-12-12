<?php

use App\Http\Controllers\HighchartController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HighchartController::class, 'dashboard'])->name('dashboard');
Route::get('/data-pelanggan', [HighchartController::class, 'dataPelanggan'])->name('data-pelanggan');
Route::post('/search-data-pelanggan', [HighchartController::class, 'searchDataPelanggan'])->name('search-data-pelanggan');
Route::get('/pie-chart', [HighchartController::class, 'pieChart'])->name('pieChart');
Route::get('/bar-chart', [HighchartController::class, 'barChart'])->name('barChart');
