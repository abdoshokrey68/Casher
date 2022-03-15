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


Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
});

// Route::post('login', [AuthController::class, 'login']);

// Route::post('tokens/create', function (Request $request) {
//     $credentials = request(['email', 'password']);
//     if (!$token = auth()->attempt($credentials)) {
//         return response()->json(['error' => 'Unauthorized'], 401);
//     }

//     $credentials = request(['email', 'password']);
//     if (!$token = auth()->attempt($credentials)) {
//         return response()->json(['error' => 'Unauthorized'], 401);
//     }
//     return $this->respondWithToken($token);
//     return $user = auth()->user();
//     $token = auth()->user()->createToken("token");
//     return ['token' => $token->plainTextToken];
// });

// Route::group(['middleware' => ['api']], function () {
//     // Route::group(['middleware' => ['checkMemberPosition', 'checkPassword', 'api']], function () {
//     // ================================================================
//     // ========================== Store API ===========================
//     // ================================================================
//     Route::get('/storeinfo',         [storeApi::class, 'storeinfo']);
//     Route::post('/updateinfo',       [storeApi::class, 'updateinfo']);

//     // ================================================================
//     // ========================== INVOICES API ========================
//     // ================================================================
//     Route::get('/dailyinvoice',      [invoiceApi::class, 'dailyinvoice']);
//     Route::get('/invoice/notpaid',      [invoiceApi::class, 'notpaid']);
//     Route::get('/invoice/all/notpaid',      [invoiceApi::class, 'allnotpaid']);
//     Route::post('/deleteinvoice',     [invoiceApi::class, 'deleteinvoice']);
//     Route::post('/payinvoice',        [invoiceApi::class, 'payInvoice']);
//     Route::get('/invoice/settings',    [invoiceApi::class, 'settings']);
//     Route::post('/invoice/settings/edit',    [invoiceApi::class, 'settingsEdit']);
//     Route::get('/invoice/export',    [invoiceApi::class, 'export']);

//     // ================================================================
//     // ====================== INVOICE DETAILS API =====================
//     // ================================================================
//     Route::post('/addtodetails',     [invoiceDetailsApi::class, 'addtodetails']);
//     Route::get('/deletedetails',     [invoiceDetailsApi::class, 'deletedetails']);

//     // ================================================================
//     // ========================== SECTIONS API ========================
//     // ================================================================
//     Route::get('/sectiondet',        [sectionApi::class, 'sectiondet']);
//     Route::get('/getsections',       [sectionApi::class, 'getsections']);
//     Route::get('/getsection',        [sectionApi::class, 'getsection']);
//     Route::get('/deletesection',     [sectionApi::class, 'deletesection']);
//     Route::post('/createnewsection', [sectionApi::class, 'createnewsection']);
//     Route::post('/updatesection',    [sectionApi::class, 'updatesection']);

//     // ================================================================
//     // ========================== PRODUCTS API ========================
//     // ================================================================
//     Route::get('/getproducts',       [productApi::class, 'getproducts']);
//     Route::get('/getproduct',        [productApi::class, 'getproduct']);
//     Route::get('/productdetails',    [productApi::class, 'productdetails']);
//     Route::post('/addnewproduct',    [productApi::class, 'addnewproduct']);
//     Route::post('/updateproduct',    [productApi::class, 'updateproduct']);
//     Route::get('/deleteproduct',     [productApi::class, 'deleteproduct']);
//     Route::get('/product/export',    [productApi::class, 'export']);

//     // ================================================================
//     // ========================== MEMBERS API =========================
//     // ================================================================
//     Route::get('/getmembers',        [membersApi::class, 'index']);
//     Route::get('/getmember',         [membersApi::class, 'getmember']);
//     Route::post('/addnewmember',     [membersApi::class, 'add']);
//     Route::post('/editmember',       [membersApi::class, 'edit']);
//     Route::get('/deletemember',      [membersApi::class, 'delete']);
//     Route::get('/member/position',   [membersApi::class, 'position']);

//     // ================================================================
//     // ========================== TABLES API ==========================
//     // ================================================================
//     Route::get('/gettables',         [tableApi::class, 'gettables']);
//     Route::get('/gettable',          [tableApi::class, 'gettable']);
//     Route::post('/addtable',         [tableApi::class, 'addtable']);
//     Route::post('/updatetable',      [tableApi::class, 'updatetable']);
//     Route::get('/deletetable',       [tableApi::class, 'deletetable']);

//     // ================================================================
//     // ========================== Menu API ==========================
//     // ================================================================
//     Route::get('/store/menu',        [menuApi::class, 'index']);
//     Route::post('/store/menu',       [menuApi::class, 'edit']);


//     // ================================================================
//     // ========================== Store BOX API ==========================
//     // ================================================================
//     Route::get('/store/getboxinfo',  [boxApi::class, 'getboxinfo']);
//     Route::post('/store/addtobox',   [boxApi::class, 'addtobox']);


//     // ================================================================
//     // ========================== Store HISTORY API ===================
//     // ================================================================
//     Route::get('/gethistory',  [historyApi::class, 'index']);
//     // Route::post('/store/addtobox',   [historyApi::class, 'addtobox']);

//     // ================================================================
//     // ========================== Store Audience API ==================
//     // ================================================================
//     Route::get('/audience/get',      [audienceApi::class, 'index']);
//     Route::get('/audience/add',      [audienceApi::class, 'add']);
//     Route::get('/audience/delete',   [audienceApi::class, 'delete']);
// });
