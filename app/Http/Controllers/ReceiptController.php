<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Invoice;
use App\Receipt;
use App\Contract;

class ReceiptController extends Controller
{
  // Apply auth middleware so only authenticated users have access
    public function __construct() 
    {
        $this->middleware('auth');
    }

    // List all receipts if user is admin 
    // Shows only user receipts if user is a merchant / normal user
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $receipts = Receipt::all();
            return view('receipts.index', compact('receipts'));
        }
        else
        {




            return view('receipts.index', compact('provided_receipts','received_receipts'));
        }          
    }

    // Gets all reviews
    public function showAll()
    {
        $receipts = Receipt::all();
        return view('receipts.index', compact('receipts'));
    }

    // ShowUserReceipts
    public function test()
    {
        $user_id = "5bdfe2db84220c09e56acd44";
        $user_id2 = "5bdfe2db84220c09e56acd43";
        $provided_receipts = collect();
        $received_receipts = collect();
        $allInvoices = Invoice::all();

        $provided_invoices = collect();
        $received_invoices = collect();

        $provided_contracts = Contract::where('provider_id','=', $user_id)->get();
        $received_contracts = Contract::where('receiver_id','=', $user_id)->get();

        foreach ($provided_contracts as $p_contract)
        {
            $p_invoice = Invoice::whereIn('contract_id',[$p_contract->id])->get()->first();
            $provided_invoices->push($p_invoice);
        }

        foreach ($received_contracts as $r_contract)
        {
            $invoice = Invoice::whereIn('contract_id',[$r_contract->id])->get()->first();
            $received_invoices->push($r_invoice);
        }

        dd($provided_invoices);


        return view('receipts.index', compact('provided_receipts','received_receipts'));
    }

    public function create()
    {
        return view('receipts.create', compact('receipts'));
    }


    public function store(Request $request)
    {
        // Validation Logic
        $this->validate($request, 
            [
                'invoice_id' => 'required',
                'payment_method' => 'required',
            ]);

        // create a new Receipt based on input
        $allReceipts = Receipt::all();
        $counter = 0;

        foreach ($allReceipts as $receipts)
        {
            if (in_array($request->invoice_id, $receipts->invoice_id))
            {
                $counter++;
            }
        }

        if ($counter == 0)
        {
            $receipt = new Receipt;
            $receipt->invoice_id = $request->invoice_id;
            $receipt->payment_method = $request->payment_method;

            $receipt->save();  
        }
        else
        {
            dd("ERROR");
        }

        return redirect()->back();
    }


    public function show($id)
    {
        $receipt = Receipt::findOrFail($id);

        return view('receipts.show', compact('receipt'));
    }

    public function edit($id)
    {
        $receipt = Receipt::findOrFail($id);

        return view('receipts.edit', compact('receipt'));
    }

    public function update(Request $request, $id)
    {
        $receipt = Receipt::findOrFail($id);

        $receipt->invoice_id = $request->invoice_id;
        $receipt->payment_method = $request->payment_method;

        $receipt->save();     


        return redirect()->route('receipts.edit', ['receipt' => $receipt ]);
    }

    public function destroy($id)
    {
        Receipt::findOrFail($id)->delete();

        return redirect()->back();
    }

}
