<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\invoice;
use App\Models\invoicedet;
use App\Models\product;
use App\Models\section;
use App\Models\store;
use App\Models\table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{

    public function __construct()
    {
        // date_default_timezone_set("Africa/Cairo");
    }

    public function storeinfo(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return store::where('id', $store_id)->first();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function sectiondet(Request $request)
    {
        $store_id = $request->store_id;
        $section_id = $request->section_id;
        $store = store::find($store_id);
        if ($store->manager_id == Auth::id()) {
            if ($store_id && $section_id && $section_id != 0) {
                return section::where('store_id', $store_id)->where('id', $section_id)->with('products')->first();
            } elseif ($store_id && $section_id == 0) {
                return product::where('store_id', $store_id)->where('stock', '!=', 0)->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function getsections(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return section::where('store_id', $store_id)->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function getsection(Request $request)
    {
        $section_id = $request->section_id;
        $section = section::find($section_id);
        if ($section) {
            $store = store::find($section->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    return $section;
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function getproducts(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return product::where('store_id', $store_id)->with('section')->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function productdetails(Request $request)
    {
        $product_id = $request->product_id;
        $product = product::find($product_id);
        if ($product) {
            $store = store::find($product->store_id);
            if ($store->manager_id == Auth::id()) {
                return $product;
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function dailyinvoice(Request $request)
    {
        $store_id = $request->store_id;
        $validate = $request->validate([
            'getto' => 'required',
            'getfrom' => 'required',
            'store_id' => 'required|integer',
        ]);
        // $getToDate = date('Y-m-d', Time() - (60 * 60 * 24 * $request->getto));
        // $getfromdate = date('Y-m-d', Time() - (60 * 60 * 24 * $request->getfrom));
        $store = store::find($store_id);

        if ($store) {
            if ($store->manager_id == Auth::id()) {
                $invoices = invoice::where('store_id', $store_id)->where('created_at', '>=', $request->getfrom)->where('created_at', '<=', $request->getto)->with('invoicedets')->orderby('created_at', 'DESC')->get();
                $invoiceTotal = 0;
                foreach ($invoices as $invoice) {
                    $invoice->date = $invoice->created_at->diffForHumans();
                    $invoiceTotal = $invoice->total + $invoiceTotal;
                }
                return [
                    'invoices' => $invoices,
                    'invoicetotal' => $invoiceTotal
                ];
            } else {
                return 'false';
            }
        } else {

            return 'false';
        }
    }

    public function getmembers(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return User::where('store_id', $store_id)->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function gettables(Request $request)
    {
        $store_id = $request->store_id;
        $store = store::find($store_id);
        if ($store) {
            if ($store->manager_id == Auth::id()) {
                return table::where('store_id', $store_id)->orderby('status', 'ASC')->get();
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function invoicedetails(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $invoice = invoice::find($invoice_id);
        if ($invoice) {
            $store = store::find($invoice->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $invoiceDetails = invoice::where('id', $invoice_id)->with('invoicedets')->first();
                    $invoiceTotal = 0;
                    foreach ($invoiceDetails->invoicedets as $details) {
                        $invoiceTotal = $invoiceTotal + (($details->price - ($details->price * ($details->discount / 100))) * $details->quantity);
                    }
                    $invoiceDetails->invoiceTotal = $invoiceTotal;
                    return $invoiceDetails;
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    // ================================================================
    // ====================  API To ADD To Store =================
    // ================================================================
    public function createNewSection(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'store_id' => 'required|integer',
            'description' => 'max:255',
            'discount' => 'integer',
        ]);

        $store = store::find($request->store_id);
        if ($store->manager_id == Auth::id()) {
            $section = new section();
            $section->name = $request->name;
            $section->description = $request->description;
            $section->discount = $request->discount;
            $section->store_id = $request->store_id;
            $section->save();
            return "Added successfully";
        } else {
            return 'false';
        }
    }

    // ================================================================
    // ====================  API To DELETE To Store =================
    // ================================================================

    public function deletedetails(Request $request)
    {
        $details_id = $request->invoice_details_id;
        $details = invoicedet::find($details_id);
        if ($details) {
            $store = store::find($details->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $invoice = invoice::with('invoicedets')->find($details->invoice_id);
                    if (!$invoice->invoicedets) {
                        $invoice->total = 0;
                        $invoice->save();
                    }
                    $details->delete();
                    $details->save();
                    return "Deleted successfully";
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }

    public function deletesection(Request $request)
    {
        $section_id = $request->section_id;
        $section = section::find($section_id);
        if ($section) {
            $store = store::find($section->store_id);
            if ($store) {
                if ($store->manager_id == Auth::id()) {
                    $section->delete();
                    return "Deleted successfully";
                } else {
                    return 'false';
                }
            } else {
                return 'false';
            }
        } else {
            return 'false';
        }
    }
}
