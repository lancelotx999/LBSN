<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Contract;
use App\Receipt;
use App\Invoice;
use App\Property;
use App\Business;
use APp\User;

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
			$sent_contracts = Contract::where('customer_id','=',Auth::user()->id)->get();
			$received_contracts = Contract::where('merchant_id','=',Auth::user()->id)->get();

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
		$contracts = Contract::where('customer_id','=', $user_id)-> orWhere('merchant_id','=', $user_id)->get();
		return $contracts;
	}

	public function showSentContracts($user_id)
	{
		$query = Contract::query();
		$query->where('customer_id',$user_id);
		$contracts = $query->get();

		return $contracts;
	}

	public function showReceivedContracts($user_id)
	{
		$query = Contract::query();
		$query->where('merchant_id',$user_id);
		$contracts = $query->get();
		
		return $contracts;
	}

	public function showContractInvoice($contract_id)
	{
		$invoice = Invoice::whereIn('contract_id',[$contract_id])->get()->first();
		return $invoice;
	}

	public function searchContracts(Request $request)
	{
		$filters = array();
		$name = $request->name;
		$invoice = $request->invoice_id;

		$filters['type'] = $request->type;
		$filters['price'] = $request->price;
		$filters['merchant_accepted'] = $request->merchant_accepted;
		$filters['customer_accepted'] = $request->customer_accepted;
		$filters['paid_fully'] = $request->paid_fully;
		$filters['fulfilled'] = $request->fulfilled;

		$query = Contract::query();

		if (isset($name))
		{
			$query->where('name', 'like', '%'.$name.'%');
		}

		if (isset($invoice))
		{
			$query->where('name', 'like', '%'.$name.'%');
		}


		foreach ($filters as $filter => $value)
		{
			if (isset($value) && (empty($value) == FALSE))
			{   
				if (is_array($value))
				{
					$query->whereIn($filter, $value);
				}
				else
				{
					$query->where($filter,$value);

				}
			}           
		}

		$contracts = $query->get();
	}

	public function create($id)
	{
		$item_id = $id;

		if (Property::find($item_id))
		{
			$item = Property::find($item_id);
		} 
		else
		{
			$item = Business::findOrFail($item_id);
		}

		return view('contracts.create', compact('item_id', 'item'));
	}

	public function store(Request $request)
	{
		// Validation Logic
		$this->validate($request, [
			'customer_id' => 'required',
			'merchant_id' => 'required',
			'item_id' => 'required',
			'type' => 'required',
			'description' => 'required',
			'price' => 'required',
		]);

		$contract = new Contract;

		$contract->name = $request->name;
		$contract->customer_id = $request->customer_id;
		$contract->merchant_id = $request->merchant_id;


		$merchant_name = User::find($request->merchant_id)->name;
		$customer_name = User::find($request->customer_id)->name;

		$contract->customer_name = $customer_name;
		$contract->merchant_name = $merchant_name;

		$contract->item_id = $request->item_id;
		$contract->invoice_id = null;

		$contract->type = $request->type;
		$contract->description = $request->description;
		$contract->price = $request->price;

		$contract->merchant_accepted = false;
		$contract->customer_accepted = true;
		$contract->paid_fully = false;
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

		$contract->name = $request->name;
		// $contract->customer_id = $request->customer_id;
		// $contract->merchant_id = $request->merchant_id;

		// $contract->item_id = $request->item_id;
		$contract->invoice_id = $request->invoice_id;

		// $contract->type = $request->type;
		$contract->description = $request->description;
		$contract->price = $request->price;
		$contract->accepted = $request->accepted == 'true' ? true : false;
		$contract->fulfilled = $request->fulfilled == 'true' ? true : false;

		if (Auth::user()->id == $contract->merchant_id)
		{
			if ($contract->accepted) $contract->merchant_accepted = true;

		}
		else if (Auth::user()->id == $contract->customer_id)
		{
			if ($contract->accepted) $contract->customer_accepted = true;
		}

		$contract->paid_fully = $request->paid_fully;
		// $contract->fulfilled = $request->fulfilled;

		$contract->save();  

		return redirect()->route('contract.index');
	}

	public static function acceptContract($id)
	{
		$contract = Contract::findOrFail($id);
		if (Auth::user()->id == $contract->merchant_id)
		{
			$contract->merchant_accepted = true;
			$contract->save(); 
		}
		else if (Auth::user()->id == $contract->customer_id)
		{
			$contract->customer_accepted = true;
			$contract->save(); 
		}

		if (($contract->customer_accepted = true) && ($contract->merchant_accepted = true))
		{
			
		}
	}

	public static function fulfillContract($id)
	{
		$contract = Contract::findOrFail($id);
		if (Auth::user()->id == $contract->customer_id)
		{
			$contract->fulfilled = true;
			$contract->save(); 
		}
	}

	public static function findInvoice($id)
	{
		$invoice = Invoice::where('contract_id','=', $id)->get();
		return $invoice;
	}

	public function destroy($id)
	{
		Contract::findOrFail($id)->delete();

		return redirect()->back();
	}

	public function test()
	{

	}
}
