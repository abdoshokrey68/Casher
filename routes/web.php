<?php

use App\Exports\UsersExport;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\boxApi;
use App\Http\Controllers\API\membersApi;
use App\Http\Controllers\API\invoiceApi;
use App\Http\Controllers\API\menuApi;
use App\Http\Controllers\API\sectionApi;
use App\Http\Controllers\API\productApi;
use App\Http\Controllers\API\tableApi;
use App\Http\Controllers\audienceApi;
use App\Http\Controllers\historyApi;
use App\Models\menu;
use App\Models\store;
use App\Models\User;
use App\Models\position;
use App\Http\Controllers\API\storeApi;
use App\Http\Controllers\API\invoiceDetailsApi;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\API\positionApi;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Dompdf\Dompdf;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Hash;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\ErrorHandler\Error\FatalError;

Route::get('tokens/create', function (Request $request) {

    $token = $request->user()->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::get('test/{store_id}/{member_id}/{position}', [positionApi::class, 'checkPositionRoute']);

Route::get('/test', function () {
    // return 'test';
    return position::where('member_id', 2)->with('store')->get();
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

    Route::get('/create-store',         [HomeController::class, 'createStore'])->name('home.create-store')->middleware(['auth']);
    Route::get('store/{store_id}',      [HomeController::class, 'store'])->name('store')->middleware(['checkmember', 'auth']);
    Route::get('store/menu/{store_id}', [HomeController::class, 'menu'])->name('store.menu')->middleware(['auth']);
    Route::get('store/{store_id}/invoice/print/{invoice_id}', [HomeController::class, 'printInvoice'])->name('invoice.print')->middleware('checkmember', 'auth');
    // Route::get('store/menu/download/qrcode/{store_id}', [HomeController::class, 'downloadQrCode'])->name('download.qrcode');
    Route::get('error',                 [HomeController::class, 'error'])->name('error');
    Route::post('api/add-new-store',    [storeApi::class, 'addNewStore'])->middleware(['auth']);
});

Route::post('api/invoicedetails',    [invoiceDetailsApi::class, 'invoicedetails']);

Route::post('api/store/menu',        [menuApi::class, 'index']); // store_id != 0

Route::group(['middleware' => ['checkMemberPosition']], function () {
    // Route::group(['middleware' => ['checkMemberPosition']], function () {
    // ================================================================
    // ========================== Store API ===========================
    // ================================================================
    Route::post('api/store_d',         [storeApi::class, 'store_d']); // store_id != 0
    Route::post('api/storeinfo',         [storeApi::class, 'storeinfo']); // store_id != 0
    Route::post('api/updateinfo',       [storeApi::class, 'updateinfo']); // store_id != 0

    // ================================================================
    // ========================== INVOICES API ========================
    // ================================================================
    Route::post('api/dailyinvoice',      [invoiceApi::class, 'dailyinvoice']); // store_id != 0
    Route::post('api/invoice/notpaid',      [invoiceApi::class, 'notpaid']); // store_id != 0
    Route::post('api/invoice/all/notpaid',      [invoiceApi::class, 'allnotpaid']); // store_id != 0
    Route::post('api/deleteinvoice',     [invoiceApi::class, 'deleteinvoice']); // store_id != 0
    Route::post('api/payinvoice',        [invoiceApi::class, 'payInvoice']); // store_id != 0
    Route::post('api/invoice/settings',    [invoiceApi::class, 'settings']); // store_id != 0
    Route::post('api/invoice/settings/edit',    [invoiceApi::class, 'settingsEdit']); // store_id != 0
    Route::post('api/invoice/export',    [invoiceApi::class, 'export']); // store_id != 0

    // ================================================================
    // ====================== INVOICE DETAILS API =====================
    // ================================================================
    Route::post('api/addtodetails',     [invoiceDetailsApi::class, 'addtodetails']); // store_id != 0
    Route::post('api/deletedetails',     [invoiceDetailsApi::class, 'deletedetails']); // store_id != 0

    // ================================================================
    // ========================== SECTIONS API ========================
    // ================================================================
    Route::post('api/sectiondet',        [sectionApi::class, 'sectiondet']); // store_id != 0
    Route::post('api/getsections',       [sectionApi::class, 'getsections']); // store_id != 0
    Route::post('api/getsection',        [sectionApi::class, 'getsection']); // store_id != 0
    Route::post('api/deletesection',     [sectionApi::class, 'deletesection']); // store_id != 0
    Route::post('api/createnewsection', [sectionApi::class, 'createnewsection']); // store_id != 0
    Route::post('api/updatesection',    [sectionApi::class, 'updatesection']); // store_id != 0

    // ================================================================
    // ========================== PRODUCTS API ========================
    // ================================================================
    Route::post('api/getproducts',       [productApi::class, 'getproducts']); // store_id != 0
    Route::post('api/getproduct',        [productApi::class, 'getproduct']); // store_id != 0
    Route::post('api/productdetails',    [productApi::class, 'productdetails']); // store_id != 0
    Route::post('api/addnewproduct',    [productApi::class, 'addnewproduct']); // store_id != 0
    Route::post('api/updateproduct',    [productApi::class, 'updateproduct']); // store_id != 0
    Route::post('api/deleteproduct',     [productApi::class, 'deleteproduct']); // store_id != 0
    Route::post('api/product/export',    [productApi::class, 'export']); // store_id != 0

    // ================================================================
    // ========================== MEMBERS API =========================
    // ================================================================
    Route::post('api/getmembers',        [membersApi::class, 'index']); // store_id != 0
    Route::post('api/getmember',         [membersApi::class, 'getmember']); // store_id != 0
    Route::post('api/addnewmember',     [membersApi::class, 'add']); // store_id != 0
    Route::post('api/editmember',       [membersApi::class, 'edit']); // store_id != 0
    Route::post('api/deletemember',      [membersApi::class, 'delete']); // store_id != 0
    Route::post('api/member/position',   [membersApi::class, 'position']); // store_id != 0

    // ================================================================
    // ========================== TABLES API ==========================
    // ================================================================
    Route::post('api/gettables',         [tableApi::class, 'gettables']); // store_id != 0
    Route::post('api/gettable',          [tableApi::class, 'gettable']); // store_id != 0
    Route::post('api/addtable',         [tableApi::class, 'addtable']); // store_id != 0
    Route::post('api/updatetable',      [tableApi::class, 'updatetable']); // store_id != 0
    Route::post('api/deletetable',       [tableApi::class, 'deletetable']); // store_id != 0

    // ================================================================
    // ========================== Menu API ==========================
    // ================================================================
    Route::post('api/store/menu',       [menuApi::class, 'edit']); // store_id != 0


    // ================================================================
    // ========================== Store BOX API ==========================
    // ================================================================
    Route::post('api/store/getboxinfo',  [boxApi::class, 'getboxinfo']); // store_id != 0
    Route::post('api/store/addtobox',   [boxApi::class, 'addtobox']); // store_id != 0


    // ================================================================
    // ========================== Store HISTORY API ===================
    // ================================================================
    Route::post('api/gethistory',  [historyApi::class, 'index']); // store_id != 0
    // Route::post('api/store/addtobox',   [historyApi::class, 'addtobox']);

    // ================================================================
    // ========================== Store Audience API ==================
    // ================================================================
    Route::post('api/audience/get',      [audienceApi::class, 'index']); // store_id != 0
    Route::post('api/audience/add',      [audienceApi::class, 'add']); // store_id != 0
    Route::post('api/audience/delete',   [audienceApi::class, 'delete']); // store_id != 0
});
