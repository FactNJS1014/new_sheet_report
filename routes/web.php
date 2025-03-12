<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportSheetController;

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

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');


Route::post('/send/zone',[ReportSheetController::class, 'sendDataZone'])->name('send.zone');
Route::post('/send/show',[ReportSheetController::class, 'showTableData'])->name('show.table');
Route::post('/send/report',[ReportSheetController::class, 'showReportData'])->name('show.report');