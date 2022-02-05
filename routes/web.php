<?php

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\storeApi;
use App\Http\Controllers\API\membersApi;
use App\Http\Controllers\API\invoiceApi;
use App\Http\Controllers\API\invoiceDetailsApi;
use App\Http\Controllers\API\sectionApi;
use App\Http\Controllers\API\productApi;
use App\Http\Controllers\API\tableApi;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/home',                 [HomeController::class, 'index'])->name('home');
Route::get('store/{store_id}',      [HomeController::class, 'store'])->name('store');
Route::get('store/menu/{store_id}', [HomeController::class, 'menu'])->name('store.menu');

// ================================================================
// ========================== Store API ===========================
// ================================================================
Route::get('api/storeinfo',         [storeApi::class, 'storeinfo']);
Route::get('api/store_d',           [storeApi::class, 'store_d']);
Route::post('api/updateinfo',       [storeApi::class, 'updateinfo']);
Route::get('api/store/addaudience',       [storeApi::class, 'addaudience']);

// ================================================================
// ========================== INVOICES API ========================
// ================================================================
Route::get('api/dailyinvoice',      [invoiceApi::class, 'dailyinvoice']);
Route::get('api/deleteinvoice',     [invoiceApi::class, 'deleteinvoice']);
Route::get('api/invoice/export',    [invoiceApi::class, 'export']);

// ================================================================
// ====================== INVOICE DETAILS API =====================
// ================================================================
Route::get('api/invoicedetails',    [invoiceDetailsApi::class, 'invoicedetails']);
Route::post('api/addtodetails',     [invoiceDetailsApi::class, 'addtodetails']);
Route::get('api/deletedetails',     [invoiceDetailsApi::class, 'deletedetails']);

// ================================================================
// ========================== SECTIONS API ========================
// ================================================================
Route::get('api/sectiondet',        [sectionApi::class, 'sectiondet']);
Route::get('api/getsections',       [sectionApi::class, 'getsections']);
Route::get('api/getsection',        [sectionApi::class, 'getsection']);
Route::get('api/deletesection',     [sectionApi::class, 'deletesection']);
Route::post('api/createnewsection', [sectionApi::class, 'createnewsection']);
Route::post('api/updatesection',    [sectionApi::class, 'updatesection']);

// ================================================================
// ========================== PRODUCTS API ========================
// ================================================================
Route::get('api/getproducts',       [productApi::class, 'getproducts']);
Route::get('api/getproduct',        [productApi::class, 'getproduct']);
Route::get('api/productdetails',    [productApi::class, 'productdetails']);
Route::post('api/addnewproduct',    [productApi::class, 'addnewproduct']);
Route::post('api/updateproduct',    [productApi::class, 'updateproduct']);
Route::get('api/deleteproduct',     [productApi::class, 'deleteproduct']);
Route::get('api/product/export',    [productApi::class, 'export']);

// ================================================================
// ========================== MEMBERS API =========================
// ================================================================
Route::get('api/getmembers',        [membersApi::class, 'index']);
Route::get('api/getmember',         [membersApi::class, 'getmember']);
Route::post('api/addnewmember',     [membersApi::class, 'add']);
Route::post('api/editmember',       [membersApi::class, 'edit']);
Route::get('api/deletemember',      [membersApi::class, 'delete']);

// ================================================================
// ========================== TABLES API ==========================
// ================================================================
Route::get('api/gettables',         [tableApi::class, 'gettables']);
Route::get('api/gettable',          [tableApi::class, 'gettable']);
Route::post('api/addtable',         [tableApi::class, 'addtable']);
Route::post('api/updatetable',      [tableApi::class, 'updatetable']);
Route::get('api/deletetable',       [tableApi::class, 'deletetable']);
