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
            $receipts = collect();
            $contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();

            foreach ($contracts as $contract)
            {
                $receipt = Receipt::whereIn('contract_id',[$contract->id])->get()->first();
                $receipts->push($receipt);
            }

            return view('receipts.index', compact('receipts'));
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
        $receipts = collect();
        $contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();

        foreach ($contracts as $contract)
        {
            $receipt = Receipt::whereIn('contract_id',[$contract->id])->get()->first();
            $receipts->push($receipt);
        }

        return view('receipts.index', compact('receipts'));
    }

    public function test()
    {

    }

    public function create()
    {
        $receipts = Receipt::where('contract_id','=',Auth::user()->id)->get();

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
        $receipt = new Receipt;

        $receipt->contract_id = $request->contract_id;
        $receipt->payment_method = $request->payment_method;
        $receipt->price = $request->price;

        $receipt->save();     

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
