<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\history;
use App\Models\invoice;
use App\Models\invoicedet;
use App\Models\product;
use App\Models\section;
use App\Models\store;
use App\Models\table;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function __construct()
    {
        // $historyApi = new historyApi;
        // $history = $historyApi->createHistory('إنشاء مرجع من كلاس اخر ', ' Create History from another class', $store->id, Auth::id());
    }
}
