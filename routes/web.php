<?php

use App\Exports\UsersExport;
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
use App\Http\Controllers\historyApi;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\positionApi;
use App\Models\menu;
use App\Models\position;
use App\Models\store;
use App\Models\User;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Hash;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\ErrorHandler\Error\FatalError;


Route::get('test/{store_id}/{member_id}/{position}', [positionApi::class, 'checkPositionRoute']);

Route::get('/t', function () {
    return Route::currentRouteName();
})->name('teasd');

Route::get('/pdf/view/{store_id}', [HomeController::class, 'pdfView']);
Route::get('/pdf/download', [HomeController::class, 'download'])->name('download');

Route::get('/invoice', [HomeController::class, 'invoice']);

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () { //...
    Auth::routes();
    Route::get('/',                     [HomeController::class, 'index'])->name('home');
    Route::get('/home',                 [HomeController::class, 'index'])->name('home');
    Route::get('/casher-program',       [HomeController::class, 'casherProgram'])->name('casher.program');
    Route::get('/digital-menu',         [HomeController::class, 'digitalMenu'])->name('digital.menu');
    Route::get('/create-store',         [HomeController::class, 'createStore'])->name('home.create-store');
    Route::get('store/{store_id}',      [HomeController::class, 'store'])->name('store')->middleware('checkmember');
    Route::get('store/menu/{store_id}', [HomeController::class, 'menu'])->name('store.menu');
    Route::get('store/{store_id}/invoice/print/{invoice_id}', [HomeController::class, 'printInvoice'])->name('invoice.print')->middleware('checkmember');
    Route::get('store/menu/download/qrcode/{store_id}', [HomeController::class, 'downloadQrCode'])->name('download.qrcode');
    Route::get('error',                 [HomeController::class, 'error'])->name('error');
});

Route::post('api/add-new-store',    [storeApi::class, 'addNewStore']);

Route::group(['middleware' => []], function () {
    // Route::group(['middleware' => ['checkMemberPosition']], function () {
    // ================================================================
    // ========================== Store API ===========================
    // ================================================================
    Route::get('api/storeinfo',         [storeApi::class, 'storeinfo']);
    Route::get('api/store_d',           [storeApi::class, 'store_d']);
    Route::post('api/updateinfo',       [storeApi::class, 'updateinfo']);

    // ================================================================
    // ========================== INVOICES API ========================
    // ================================================================
    Route::get('api/dailyinvoice',      [invoiceApi::class, 'dailyinvoice']);
    Route::get('api/deleteinvoice',     [invoiceApi::class, 'deleteinvoice']);
    Route::post('api/payinvoice',        [invoiceApi::class, 'payInvoice']);
    Route::get('api/invoice/settings',    [invoiceApi::class, 'settings']);
    Route::post('api/invoice/settings/edit',    [invoiceApi::class, 'settingsEdit']);
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
    Route::get('api/member/position',   [membersApi::class, 'position']);

    // ================================================================
    // ========================== TABLES API ==========================
    // ================================================================
    Route::get('api/gettables',         [tableApi::class, 'gettables']);
    Route::get('api/gettable',          [tableApi::class, 'gettable']);
    Route::post('api/addtable',         [tableApi::class, 'addtable']);
    Route::post('api/updatetable',      [tableApi::class, 'updatetable']);
    Route::get('api/deletetable',       [tableApi::class, 'deletetable']);

    // ================================================================
    // ========================== Menu API ==========================
    // ================================================================
    Route::get('api/store/menu',        [menuApi::class, 'index']);
    Route::post('api/store/menu',       [menuApi::class, 'edit']);


    // ================================================================
    // ========================== Store BOX API ==========================
    // ================================================================
    Route::get('api/store/getboxinfo',  [boxApi::class, 'getboxinfo']);
    Route::post('api/store/addtobox',   [boxApi::class, 'addtobox']);


    // ================================================================
    // ========================== Store HISTORY API ===================
    // ================================================================
    Route::get('api/gethistory',  [historyApi::class, 'index']);
    // Route::post('api/store/addtobox',   [historyApi::class, 'addtobox']);

    // ================================================================
    // ========================== Store Audience API ==================
    // ================================================================
    Route::get('api/audience/get',      [audienceApi::class, 'index']);
    Route::get('api/audience/add',      [audienceApi::class, 'add']);
    Route::get('api/audience/delete',   [audienceApi::class, 'delete']);
});
