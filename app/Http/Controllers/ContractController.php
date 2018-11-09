<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Contract;
use App\Receipt;
use App\Invoice;

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
            return view('contracts.index', compact('contracts'));
        }
        else
        {
            $sent_contracts = Contract::where('provider_id','=',Auth::user()->id)->get();
            $received_contracts = Contract::where('receiver_id','=',Auth::user()->id)->get();
            return view('contracts.index', compact('sent_contracts','received_contracts'));
        }    
    }

    public function showAll()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }

    // Gets all the Contracts associated with specified user
    public function showAllUserContracts($user_id)
    {
        $user_contracts = Contract::where('provider_id','=', $user_id)-> orWhere('receiver_id','=', $user_id)->get();
        return view('contracts.index', compact('user_contracts'));
    }

    public function showAcceptedReceivedContracts($user_id)
    {
        $accepted_contracts = Contract::where('receiver_id','=', $user_id)->where('accepted', '=', true)->get();
        return view('contracts.index', compact('accepted_contracts'));
    }

    public function showUnacceptedReceivedContracts($user_id)
    {
        $unaccepted_contracts = Contract::where('receiver_id','=', $user_id)->where('accepted', '=', false)->get();
        return view('contracts.index', compact('unaccepted_contracts'));
    }

    public function showAcceptedProvidedContracts($user_id)
    {
        $accepted_contracts = Contract::where('provider_id','=', $user_id)->where('accepted', '=', true)->get();
        return view('contracts.index', compact('accepted_contracts'));
    }

    public function showUnacceptedProvidedContracts($user_id)
    {
        $unaccepted_contracts = Contract::where('provider_id','=', $user_id)->where('accepted', '=', false)->get();
        return view('contracts.index', compact('unaccepted_contracts'));
    }

    public function showProviderContracts($user_id)
    {
        $contracts = Contract::where('provider_id','=', $user_id)->get();
        return view('contracts.index', compact('contracts'));
    }

    public function showReceiverContracts($user_id)
    {
        $contracts = Contract::where('receiver_id','=', $user_id)->get();
        return view('contracts.index', compact('contracts'));
    }

    public function showContractReceipt($contract_id)
    {
        $receipt = Receipt::whereIn('contract_id',[$contract_id])->get()->first();
    }

    public function showContractInvoice($contract_id)
    {
        $invoice = Invoice::whereIn('contract_id',[$contract_id])->get()->first();
    }

    public function create()
    {
        return view('contracts.create');
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
        $contract->accepted = false;
        $contract->fulfilled = false;

        $contract->save();
        return redirect()->route('contract.index');
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
        $contract->accepted = $request->accepted;
        $contract->fulfilled = $request->fulfilled;

        $contract->save();  

        return redirect()->back();
    }

    public function acceptContract($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->accepted = true;
    }

    public function fulfilledContract($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->fulfilled = true;
    }

    public function destroy($id)
    {
        Contract::findOrFail($id)->delete();

        return redirect()->back();
    }
}
