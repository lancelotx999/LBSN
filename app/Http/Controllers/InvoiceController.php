<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use App\Invoice;
use App\Receipt;
use App\Contract;
use App\User;

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
			//user provides item and gets paid
			$provided_invoices = Invoice::where('receiver_id','=', Auth::user()->id)->get();

            //user receives item and pays
			$received_invoices = Invoice::where('provider_id','=', Auth::user()->id)->get();

			// dd($received_invoices);
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
		$provided_invoices = Invoice::where('receiver_id','=', $user_id)->get();
		$received_invoices = Invoice::where('provider_id','=', $user_id)->get();

		return view('invoices.index', compact('provided_invoices','received_invoices'));
	}

	public function showInvoiceReceipt($invoice_id)
	{
		$receipt = Receipt::where('invoice_id','=', $invoice_id)->get();
	}

	public function test()
	{
		$cids = ['5be59efe339b574ea07c0ea9', '5be59efe339b574ea07c0eaa'];
		$pid = array(); $rid = array();
		$total = 0;

		foreach ($cids as $cid)
		{
			$contract = Contract::where('_id','=',$cid)->get()->first();
			$total = $total + $contract->price;
			// dd($contract);
			array_push($pid,$contract->provider_id);
			array_push($rid,$contract->receiver_id);
			unset($cid);
		}

		$taxed = $total * 0.25;
		$grandTotal = $total + $taxed;

		$invoice = new Invoice;
		$invoice->provider_id = $pid[0];
		$invoice->receiver_id = $rid[0];
		$invoice->contract_id = $cids;
		$invoice->total_price = $total;
		$invoice->tax = $taxed;
		$invoice->grand_total = $grandTotal;
		$invoice->outstanding_payment = $grandTotal;
		$invoice->paid = false;

		$invoice->save();
	}

	public function create($id)
	{
		$contract = Contract::findOrFail($id);

		return view('invoices.create', compact('contract'));
	}


	public function store(Request $request)
	{
        // Validation Logic
		$this->validate($request,
			[
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
		$total = 0;
		foreach ($cids as $cid)
		{
			$contract = Contract::where('_id','=',$cid)->get()->first();
			$total = $total + $contract->price;
			// dd($contract);
			array_push($pid,$contract->provider_id);
			array_push($rid,$contract->receiver_id);
			unset($cid);
		}

		// if ((count(array_unique($pid))) && (count(array_unique($rid))))
		// {
        //
		// }
		// else
		// {
		// 	$counter++;
		// }
		// if ($counter == 0)
		if((count(array_unique($pid)) && count(array_unique($rid)))==1)
		{
			$taxed = $total * 0.25;
			$grandTotal = $total + $taxed;

			$invoice = new Invoice;
			$invoice->provider_id = $pid[0];
			$invoice->receiver_id = $rid[0];
			$invoice->contract_id = $cids;
			$invoice->total_price = $total;
			$invoice->tax = $taxed;
			$invoice->grand_total = $grandTotal;
			$invoice->outstanding_payment = $grandTotal;
			$invoice->paid = false;

			$invoice->save();
		}
		else
		{
			dd("ERROR");
		}

		// dd($invoice);
		return redirect()->route('invoice.index');
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

		$invoice->provider_id = $request->provider_id;
		$invoice->receiver_id = $request->receiver_id;
		$invoice->contract_id = $request->contract_id;

		$request->paid = $request->paid == 'true' ? true : false;

		$cids = $request->contract_id;

		$pid = array(); $rid = array();
		$total = 0;

		foreach ($cids as $cid)
		{
			$contract = Contract::where('_id','=',$cid)->get()->first();
			$total = $total + $contract->price;
			// dd($contract);
			array_push($pid,$contract->provider_id);
			array_push($rid,$contract->receiver_id);
			unset($cid);
		}

		$taxed = $total * 0.25;
		$grandTotal = $total + $taxed;

		$invoice->total_price = $total;
		$invoice->tax = $taxed;
		$invoice->grand_total = $grandTotal;
		$invoice->outstanding_payment = $grandTotal;

		$invoice->paid = $request->paid;

		$invoice->save();

		return redirect()->route('invoice.index');
	}

	public function destroy($id)
	{
		Invoice::findOrFail($id)->delete();

		return redirect()->back();
	}

}
