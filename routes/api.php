<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchedulerController;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/updatestatussip', [AdminController::class, 'updatestatussip']);
Route::post('/updatestatussipdinkes', [AdminController::class, 'updatestatussipdinkes']);

Route::get('/getjadwalnakes/{id_nakes}/{salinan}', [AdminController::class, 'getjadwalnakes']);
Route::get('/setkadaluarsa', [SchedulerController::class, 'setkadaluarsa']);
Route::get('/getqueuenotif', [SchedulerController::class, 'getqueuenotif']);
Route::post('/testdocx', [SchedulerController::class, 'testdocx']);
Route::post('/getreportesip', [SchedulerController::class, 'getreportesip']);
Route::post('/getallnakes', [SchedulerController::class, 'nakescontext']);
Route::get('/getallmaster', [SchedulerController::class, 'getallmaster']);
Route::get('/getfakta/{jenis}', [SchedulerController::class, 'getfakta']);
Route::post('/delaymessage', [SchedulerController::class, 'delaymessage']);
Route::post('/setreminder', [AdminController::class, 'setreminder']);
Route::post('/getallnakestest', [SchedulerController::class, 'nakescontexttest']);
Route::post('/getdatasekitar', [SchedulerController::class, 'getdatasekitar']);
Route::post('/detailfaskessekitar', [SchedulerController::class, 'detailfaskessekitar']);
Route::get('/getpuskesmas', [SchedulerController::class, 'getpuskesmas']);
Route::post('/updatepuskesmas', [SchedulerController::class, 'updatepuskesmas']);

