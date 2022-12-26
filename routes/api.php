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
use App\Http\Controllers\PosController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportTypesController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorsInvoiceController;
use App\Http\Controllers\VendorsInvoicesItemsController;
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
Route::get('clients_invoices/report_data/{id}',[ClientsInvoicesController::class,'getReportDataWithQuery']);
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
Route::resource('companies', CompanyController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('users', AuthController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('products', ProductController::class);
    Route::resource('units', UnitController::class);
    Route::resource('config', ConfigController::class);
    Route::resource('cities', CityController::class);
    Route::resource('pay_methods', PayMethodController::class);
    Route::resource('clients_invoices', ClientsInvoicesController::class);
    Route::resource('vendors_invoices', VendorsInvoiceController::class);
    Route::resource('clients_invoices_items', ClientsInvoicesItemsController::class);
    Route::resource('vendors_invoices_items', VendorsInvoicesItemsController::class);
    Route::resource('report_types', ReportTypesController::class);
    Route::resource('pos', PosController::class);
    Route::resource('printers', PrinterController::class);

    Route::post('companies/store_imgs', [CompanyController::class,'store_imgs']);

    Route::put('pay_methods/default/{id}', [PayMethodController::class,'makeDefault']);
    Route::put('report_types/default/{id}', [ReportTypesController::class,'makeDefault']);
    Route::put('printers/default/{id}', [PrinterController::class,'makeDefault']);

    Route::get('clients/balance/{id}',[ClientController::class,'getBalance']);
    Route::get('clients_invoices_items/items/{id}', [ClientsInvoicesItemsController::class,'getInvoiceItems']);
    Route::get('vendors_invoices_items/items/{id}', [VendorsInvoicesItemsController::class,'getInvoiceItems']);

    Route::get('clients/items/related_items',[ClientController::class,'relatedItems']);
    Route::get('users/items/related_items',[AuthController::class,'relatedItems']);
    Route::get('vendors/items/related_items',[VendorController::class,'relatedItems']);
    Route::get('products/items/related_items', [ProductController::class,'relatedItems']);
    Route::get('vendors_invoices/items/related_items', [VendorsInvoiceController::class,'relatedItems']);
    Route::get('clients_invoices/items/related_items', [ClientsInvoicesController::class,'relatedItems']);
    Route::get('clients_invoices/items/report_data/{id}', [ClientsInvoicesController::class,'getReportData']);

    //Imports
    Route::post('products/import',[ProductController::class,'importExcel']);

});
