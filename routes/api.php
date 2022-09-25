<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientsInvoicesController;
use App\Http\Controllers\ClientsInvoicesItemsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\PayMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
Route::resource('companies', CompanyController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('clients', ClientController::class);
    Route::get('clients/balance/{id}',[ClientController::class,'getBalance']);
    Route::resource('users', AuthController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('products', ProductController::class);
    Route::resource('units', UnitController::class);
    Route::resource('config', ConfigController::class);
    Route::resource('cities', CityController::class);
    Route::resource('pay_methods', PayMethodController::class);
    Route::resource('clients_invoices', ClientsInvoicesController::class);
    Route::resource('clients_invoices_items', ClientsInvoicesItemsController::class);
    Route::get('clients_invoices_items/items/{id}', [ClientsInvoicesItemsController::class,'getInvoiceItems']);
    Route::post('companies/store_imgs', [CompanyController::class,'store_imgs']);

});
