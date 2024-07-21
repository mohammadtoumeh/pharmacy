<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\StatusMedicineController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

\Illuminate\Support\Facades\DB::listen(function (\Illuminate\Database\Events\QueryExecuted $query){
    logger($query->sql, $query->bindings);
});

Route::group(['prefix' => '/auth', 'controller' => UserAuthController::class], function (){

    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
});

Route::group(['prefix' => '/pharmacist', 'controller' => PharmacistController::class], function (){

    Route::post('/store', 'store');
    Route::put('/update', 'update');
    Route::delete('/delete', 'destroy');
});

Route::group(['prefix' => '/order', 'controller' => OrderController::class], function (){

    Route::get('/indexForPharmacist','indexForPharmacist');
    Route::get('/indexForWarehouse','indexForWarehouse');
    Route::get('/indexArchivedForPharmacist','indexArchivedForPharmacist');
    Route::get('/indexArchivedForWarehouse','indexArchivedForWarehouse');
    Route::post('/store','store');
    Route::get('/showForPharmacist/{id}','showForPharmacist');
    Route::get('/showForWarehouse/{id}','showForWarehouse');
    Route::get('/acceptOrder/{id}','acceptOrder');

});

Route::group(['prefix' => '/warehouse','controller' => WarehouseController::class], function (){

    Route::get('/index', 'index');
    Route::get('/indexByState/{id}', 'indexByState');
    Route::post('/store', 'store');
    Route::get('/show/{id}', 'show');
    Route::put('/update', 'update');
    Route::delete('/delete', 'destroy');
});

Route::group(['prefix' => '/employee','controller' => EmployeeController::class], function (){

    Route::get('/index', 'index');
    Route::post('/store', 'store');
    Route::get('/show/{id}', 'show');
    Route::put('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
});

Route::group(['prefix' => '/medicine','controller' => MedicineController::class], function (){

    Route::get('/index', 'index');
    Route::get('/indexForWarehouse', 'indexForWarehouse');
    Route::get('/indexByWarehouse/{id}', 'indexByWarehouse');
    Route::get('/indexByCategory/{id}', 'indexByCategory');
    Route::get('/indexByFavorit', 'indexByFavorit');

    Route::post('/store', 'store');

    Route::get('/show/{id}', 'show');
    Route::get('/showForWarehouse/{id}', 'showForWarehouse');

    Route::put('/update/{id}', 'update');
    Route::delete('/delete/{id}', 'destroy');
    Route::get('/search/{search}', 'search');

    Route::get('/addToFavorit/{id}', 'addToFavorit');

        Route::group(['prefix' => '/status-medicine','controller' => StatusMedicineController::class], function (){
            Route::post('/store', 'store');
        });
});

Route::group(['prefix' => '/category','controller' => CategoryController::class], function (){
    Route::get('/index', 'index');
});
