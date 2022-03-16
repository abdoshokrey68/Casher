<?php


use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\boxApi;
use App\Http\Controllers\API\storeApi;
use App\Http\Controllers\API\membersApi;
use App\Http\Controllers\API\invoiceApi;
use App\Http\Controllers\API\invoiceDetailsApi;
use App\Http\Controllers\API\menuApi;
use App\Http\Controllers\API\sectionApi;
use App\Http\Controllers\API\productApi;
use App\Http\Controllers\API\tableApi;
use App\Http\Controllers\audienceApi;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\historyApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {

    Route::post('add-new-store',    [storeApi::class, 'addNewStore'])->middleware(['auth']);

    Route::post('invoicedetails',    [invoiceDetailsApi::class, 'invoicedetails']);

    Route::post('store/menu',        [menuApi::class, 'index']); // store_id != 0
});
Route::group(['middleware' => ['checkMemberPosition', 'api']], function () {
    // Route::group(['middleware' => ['checkMemberPosition']], function () {
    // ================================================================
    // ========================== Store API ===========================
    // ================================================================
    Route::post('store_d',          [storeApi::class, 'store_d']); // store_id != 0
    Route::post('storeinfo',        [storeApi::class, 'storeinfo']); // store_id != 0
    Route::post('updateinfo',       [storeApi::class, 'updateinfo']); // store_id != 0

    // ================================================================
    // ========================== INVOICES API ========================
    // ================================================================
    Route::post('dailyinvoice',      [invoiceApi::class, 'dailyinvoice']); // store_id != 0
    Route::post('invoice/notpaid',      [invoiceApi::class, 'notpaid']); // store_id != 0
    Route::post('invoice/all/notpaid',      [invoiceApi::class, 'allnotpaid']); // store_id != 0
    Route::post('deleteinvoice',     [invoiceApi::class, 'deleteinvoice']); // store_id != 0
    Route::post('payinvoice',        [invoiceApi::class, 'payInvoice']); // store_id != 0
    Route::post('invoice/settings',    [invoiceApi::class, 'settings']); // store_id != 0
    Route::post('invoice/settings/edit',    [invoiceApi::class, 'settingsEdit']); // store_id != 0
    Route::post('invoice/export',    [invoiceApi::class, 'export']); // store_id != 0

    // ================================================================
    // ====================== INVOICE DETAILS API =====================
    // ================================================================
    Route::post('addtodetails',     [invoiceDetailsApi::class, 'addtodetails']); // store_id != 0
    Route::post('deletedetails',     [invoiceDetailsApi::class, 'deletedetails']); // store_id != 0

    // ================================================================
    // ========================== SECTIONS API ========================
    // ================================================================
    Route::post('sectiondet',        [sectionApi::class, 'sectiondet']); // store_id != 0
    Route::post('getsections',       [sectionApi::class, 'getsections']); // store_id != 0
    Route::post('getsection',        [sectionApi::class, 'getsection']); // store_id != 0
    Route::post('deletesection',     [sectionApi::class, 'deletesection']); // store_id != 0
    Route::post('createnewsection', [sectionApi::class, 'createnewsection']); // store_id != 0
    Route::post('updatesection',    [sectionApi::class, 'updatesection']); // store_id != 0

    // ================================================================
    // ========================== PRODUCTS API ========================
    // ================================================================
    Route::post('getproducts',       [productApi::class, 'getproducts']); // store_id != 0
    Route::post('getproduct',        [productApi::class, 'getproduct']); // store_id != 0
    Route::post('productdetails',    [productApi::class, 'productdetails']); // store_id != 0
    Route::post('addnewproduct',    [productApi::class, 'addnewproduct']); // store_id != 0
    Route::post('updateproduct',    [productApi::class, 'updateproduct']); // store_id != 0
    Route::post('deleteproduct',     [productApi::class, 'deleteproduct']); // store_id != 0
    Route::post('product/export',    [productApi::class, 'export']); // store_id != 0

    // ================================================================
    // ========================== MEMBERS API =========================
    // ================================================================
    Route::post('getmembers',        [membersApi::class, 'index']); // store_id != 0
    Route::post('getmember',         [membersApi::class, 'getmember']); // store_id != 0
    Route::post('addnewmember',     [membersApi::class, 'add']); // store_id != 0
    Route::post('editmember',       [membersApi::class, 'edit']); // store_id != 0
    Route::post('deletemember',      [membersApi::class, 'delete']); // store_id != 0
    Route::post('member/position',   [membersApi::class, 'position']); // store_id != 0

    // ================================================================
    // ========================== TABLES API ==========================
    // ================================================================
    Route::post('gettables',         [tableApi::class, 'gettables']); // store_id != 0
    Route::post('gettable',          [tableApi::class, 'gettable']); // store_id != 0
    Route::post('addtable',         [tableApi::class, 'addtable']); // store_id != 0
    Route::post('updatetable',      [tableApi::class, 'updatetable']); // store_id != 0
    Route::post('deletetable',       [tableApi::class, 'deletetable']); // store_id != 0

    // ================================================================
    // ========================== Menu API ==========================
    // ================================================================
    Route::post('store/menu',       [menuApi::class, 'edit']); // store_id != 0


    // ================================================================
    // ========================== Store BOX API ==========================
    // ================================================================
    Route::post('store/getboxinfo',  [boxApi::class, 'getboxinfo']); // store_id != 0
    Route::post('store/addtobox',   [boxApi::class, 'addtobox']); // store_id != 0


    // ================================================================
    // ========================== Store HISTORY API ===================
    // ================================================================
    Route::post('gethistory',  [historyApi::class, 'index']); // store_id != 0
    // Route::post('store/addtobox',   [historyApi::class, 'addtobox']);

    // ================================================================
    // ========================== Store Audience API ==================
    // ================================================================
    Route::post('audience/get',      [audienceApi::class, 'index']); // store_id != 0
    Route::post('audience/add',      [audienceApi::class, 'add']); // store_id != 0
    Route::post('audience/delete',   [audienceApi::class, 'delete']); // store_id != 0
});
