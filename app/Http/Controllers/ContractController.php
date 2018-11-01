<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Contract;

class ContractController extends Controller
{
    // Apply auth middleware so only authenticated users have access
	public function __construct() 
    {
		$this->middleware('auth');
	}

    // List all contracts if user is admin 
    // Shows only user contracts if user is a user/merchant
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $contracts = Contract::all();
        }
        else
        {
            $contracts = Contract::where('provider_id','=', Auth::user()->id)-> orWhere('receiver_id','=', Auth::user()->id)->get();
        }
        
        return view('contracts.index', compact('contracts'));
    }

    public function showAll()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }

    // Gets all the Contracts associated with specified user
    public function showUserContracts($user_id)
    {
        $user_contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();
        return view('contracts.index', compact('user_contracts'));
    }

    public function create()
    {
        $user_contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();
        $contracts = $user_contracts->take(10)->get();

        return view('contracts.create', compact('contracts'));
    }

    public function store(Request $request)
    {
        // Validation Logic
 		$this->validate($request, [
            'provider_id' => 'required',
			'receiver_id' => 'required',
            'item_id' => 'required',
			'type' => 'required',
            'description' => 'required',
            'price' => 'required',
 		]);

        $contract = new Contract;

        $contract->provider_id = $request->provider_id;
        $contract->receiver_id = $request->receiver_id;
        $contract->item_id = $request->item_id;
        $contract->type = $request->type;
        $contract->description = $request->description;
        $contract->price = $request->price;
        $contract->paid = false;

        $contract->save();
        return redirect()->back();
    }

    public function show($id)
    {
        $contract = Contract::findOrFail($id);

        return view('contracts.show', compact('contract'));
    }

    public function edit($id)
    {
        $contract = Contract::findOrFail($id);

        return view('contracts.edit', compact('contract'));
    }

    public function update(Request $request, $id)
    {
        $contract = Contract::findOrFail($id);
        
        $contract->provider_id = $request->provider_id;
        $contract->receiver_id = $request->receiver_id;
        $contract->item_id = $request->item_id;
        $contract->type = $request->type;
        $contract->description = $request->description;
        $contract->price = $request->price;
        $contract->paid = $request->paid;

        $contract->save();  

        return redirect()->route('contracts.edit', ['contract' => $contract ]);
    }

    public function destroy($id)
    {
        Contract::findOrFail($id)->delete();

        return redirect()->back();
    }
}
