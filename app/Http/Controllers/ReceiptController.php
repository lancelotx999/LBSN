<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
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
            $provided_receipts = collect();
            $received_receipts = collect();

            $provided_contracts = Contract::where('provider_id','=', Auth::user()->id)->get();
            $received_contracts = Contract::where('receiver_id','=', Auth::user()->id)->get();

            foreach ($provided_contracts as $p_contract)
            {
                $p_receipt = Receipt::whereIn('contract_id',[$p_contract->id])->get()->first();
                $provided_receipts->push($p_receipt);
            }

            foreach ($received_contracts as $r_contract)
            {
                $receipt = Receipt::whereIn('contract_id',[$r_contract->id])->get()->first();
                $received_receipts->push($r_receipt);
            }

            return view('receipts.index', compact('provided_receipts','received_receipts'));
        }          
    }

    // Gets all reviews
    public function showAll()
    {
        $receipts = Receipt::all();
        return view('receipts.index', compact('receipts'));
    }

    // Gets all the receipts associated with specified user
    public function showUserReceipts($user_id)
    {
        $provided_receipts = collect();
        $received_receipts = collect();

        $provided_contracts = Contract::where('provider_id','=', $user_id)->get();
        $received_contracts = Contract::where('receiver_id','=', $user_id)->get();

        foreach ($provided_contracts as $p_contract)
        {
            $p_receipt = Receipt::whereIn('contract_id',[$p_contract->id])->get()->first();
            $provided_receipts->push($p_receipt);
        }

        foreach ($received_contracts as $r_contract)
        {
            $receipt = Receipt::whereIn('contract_id',[$r_contract->id])->get()->first();
            $received_receipts->push($r_receipt);
        }

        return view('receipts.index', compact('provided_receipts','received_receipts'));
    }

    public function test()
    {
        $cons[0] = "5be3e44384220c1da3213b27";
        $cons[1] = "5be3e44384220c1da3213b28";
        $cons[2] = "swag";
        $cons[3] = "dad";

        $allReceipts = Receipt::all();
        $counter = 0;

        foreach ($allReceipts as $receipts)
        {
            foreach ($cons as $con)
            {
                if (in_array($con, $receipts->contract_id))
                {
                    $counter++;
                }
            }
        }

        if ($counter == 0)
        {
            $receipt = new Receipt;
            $receipt->contract_id = $cons;
            $receipt->payment_method = "Cash";
            $receipt->price = 500;

            $receipt->save();  
        }
        else
        {
            dd("ERROR");
        }
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
            'contract_id' => 'required',
            'payment_method' => 'required',
            'price' => 'required',
        ]);

        // create a new Receipt based on input
        $allReceipts = Receipt::all();
        $cids = $request->contract_id;
        $counter = 0;

        foreach ($allReceipts as $receipts)
        {
            foreach ($cids as $cid)
            {
                if (in_array($cid, $receipts->contract_id))
                {
                    $counter++;
                }
            }
        }

        if ($counter == 0)
        {
            $receipt = new Receipt;
            $receipt->contract_id = $request->contract_id;
            $receipt->payment_method = $request->payment_method;
            $receipt->price = $request->price;

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

        $receipt->contract_id = $request->contract_id;
        $receipt->payment_method = $request->payment_method;
        $receipt->price = $request->price;

        $receipt->save();     


        return redirect()->route('receipts.edit', ['receipt' => $receipt ]);
    }

    public function destroy($id)
    {
        Receipt::findOrFail($id)->delete();

        return redirect()->back();
    }

}
