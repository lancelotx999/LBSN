<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Invoice;
use App\Receipt;
use App\Contract;

class InvoiceController extends Controller
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
			$invoices = Invoice::all();
			return view('invoices.index', compact('invoices'));
		}
		else
		{
			$provided_invoices = collect();
			$received_invoices = collect();

			$provided_contracts = Contract::where('provider_id','=', Auth::user()->id)->get();
			$received_contracts = Contract::where('receiver_id','=', Auth::user()->id)->get();

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

			unset($r_contract);
			unset($p_contract);

			return view('invoices.index', compact('provided_invoices','received_invoices'));
		}          
	}

    // Gets all reviews
	public function showAll()
	{
		$invoices = Invoice::all();
		return view('invoices.index', compact('invoices'));
	}

    // Gets all the receipts associated with specified user
	public function showUserInvoices($user_id)
	{
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

		return view('invoices.index', compact('provided_invoices','received_invoices'));
	}

	public function test()
	{
		$cids[0] = "5be3fc5284220c351e62aa69";
		$cids[1] = "5be3fc5284220c351e62aa6a";
		$pid = array(); $rid = array();
		foreach ($cids as $cid)
		{
			$contract = Contract::where('_id','=',$cid)->get()->first();
			array_push($pid,$contract->provider_id);
			array_push($rid,$contract->receiver_id);
		}

    		if ((count(array_unique($pid))) && (count(array_unique($rid))))
    		{

    		}

	}

	public function create()
	{
		$provided_invoices = collect();
		$provided_contracts = Contract::where('provider_id','=', $user_id)->get();

		foreach ($provided_contracts as $p_contract)
		{
			$p_invoice = Invoice::whereIn('contract_id',[$p_contract->id])->get()->first();
			$provided_invoices->push($p_invoice);
		}

		return view('invoices.create', compact('provided_invoices'));
	}


	public function store(Request $request)
	{
        // Validation Logic
		$this->validate($request, 
			[
				'provider_id' => 'required',
				'receiver_id' => 'required',
				'contract_id' => 'required',
				'tax' => 'required',
				'total_price' => 'required',
			]);

        // create a new Receipt based on input

		$allInvoices = Invoice::all();
		$cids = $request->contract_id;
		$counter = 0;

		// Checking for existing invoices which hold the same contracts
		foreach ($allInvoices as $invoices)
		{
			foreach ($cids as $cid)
			{
				if (in_array($cid, $invoices->contract_id))
				{
					$counter++;
					unset($cid);
				}
			}
		}

		// Ensuring all provider and receiver ids are consistent in contracts
		$pid = array(); $rid = array();
		foreach ($cids as $cid)
		{
			$contract = Contract::where('_id','=',$cid)->get()->first();
			dd($contract);
			array_push($pid,$contract->provider_id);
			array_push($rid,$contract->receiver_id);
		}

    	if ((count(array_unique($pid))) && (count(array_unique($rid))))
    	{
			
    	}
    	else
    	{
    		$counter++;
    	}

		if ($counter == 0)
		{
			$invoice = new Invoice;
			$invoice->contract_id = $request->contract_id;
			$invoice->tax = $request->tax;
			$invoice->total_price = $request->total_price;
			$invoice->paid = false;

			$invoice->save();   
		}
		else
		{
			dd("ERROR");
		}

		return redirect()->back();
	}


	public function show($id)
	{
		$invoice = Invoice::findOrFail($id);

		return view('invoices.show', compact('invoice'));
	}

	public function edit($id)
	{
		$invoice = Invoice::findOrFail($id);

		return view('invoices.edit', compact('invoice'));
	}

	public function update(Request $request, $id)
	{
		$invoice = Invoice::findOrFail($id);

		$invoice->contract_id = $request->contract_id;
		$invoice->tax = $request->tax;
		$invoice->total_price = $request->total_price;
		$invoice->paid = $request->paid;

		$invoice->save();     


		return redirect()->route('invoices.edit', ['invoice' => $invoice ]);
	}

	public function destroy($id)
	{
		Invoice::findOrFail($id)->delete();

		return redirect()->back();
	}

}
