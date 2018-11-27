<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Moloquent;
use Illuminate\Support\Facades\Hash;

use App\Invoice;
use App\Transaction;
use App\User;
use App\Contract;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role === 'admin')
        {
            $transactions = Transaction::all();
            return view('transactions.index', compact('transactions'));
        }
        else
        {
            //user provides item and gets paid
            $provided_transactions = Transaction::where('customer_id','=', Auth::user()->id)->get();

            //user receives item and pays
            $received_transactions = Transaction::where('merchant_id','=', Auth::user()->id)->get();

            foreach ($received_transactions as $transaction) {
                $transaction->invoice = Invoice::find($transaction->invoice_id);

                $transaction->customer = User::findOrFail($transaction->customer_id);
                $transaction->merchant = User::findOrFail($transaction->merchant_id);
            }

            foreach ($provided_transactions as $transaction) {
                $transaction->invoice = Invoice::find($transaction->invoice_id);

                $transaction->customer = User::findOrFail($transaction->customer_id);
                $transaction->merchant = User::findOrFail($transaction->merchant_id);
            }

            // dd($received_transactions);

            return view('transactions.index', compact('provided_transactions','received_transactions'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $invoice = Invoice::find($id);

        $customer = User::findOrFail($invoice->customer_id);
        $merchant = User::findOrFail($invoice->merchant_id);

        $invoice->customer = $customer;
        $invoice->merchant = $merchant;

        $contracts = array();
		foreach ($invoice->contract_id as $id)
		{
			// $contract = Contract::where('_id','=',$id)->get()->first();
            $contract = Contract::findOrFail($id);
			// dd($contract);
            array_push($contracts,$contract);
		}

        $invoice->contracts = $contracts;

        // dd($invoice);

        return view('transactions.create', compact('invoice'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        // Validation Logic
        $this->validate($request,
            [
                'customer_id' => 'required',
                'merchant_id' => 'required',
                'invoice_id' => 'required',

                'amount_paid' => 'required',
                'payment_method' => 'required',
            ]);

        $invoice = Invoice::findOrFail($request->invoice_id);
        $transaction = new Transaction;

        if ($request->amount_paid > $invoice->outstanding_payment) {

            dd("Error: Too Much Paid!");
            //too much paid. return to enter valid amount
            return redirect()->back();
        }

        $customer = User::findOrFail($request->customer_id);
        $merchant = User::findOrFail($request->merchant_id);

        if (((Hash::check($request->merchant_acknowledgement, $merchant->password))&&(Hash::check($request->customer_acknowledgement, $customer->password))) == true) {
            $invoice->outstanding_payment = $invoice->outstanding_payment - $request->amount_paid;
            $transaction->acknowledged = true;
        }
        elseif ($request->acknowledged == true) {
            $invoice->outstanding_payment = $invoice->outstanding_payment - $request->amount_paid;
            $transaction->acknowledged = true;
        }

        // $invoice->outstanding_payment = $invoice->outstanding_payment - $request->amount_paid;

        if (($invoice->outstanding_payment == 0) && ($transaction->acknowledged == true)) {

            // dd("Success: Outstanding Payment Clear!");
            $transaction->customer_id = $request->customer_id;
            $transaction->merchant_id = $request->merchant_id;
            $transaction->invoice_id = $request->invoice_id;

            $transaction->payment_method = $request->payment_method;
            $transaction->amount_paid = $request->amount_paid;

            $transaction->customer_acknowledgement = $request->customer_acknowledgement;
            $transaction->merchant_acknowledgement = $request->merchant_acknowledgement;

            $invoice->paid = true;

            // dd($invoice);

            $invoice->save();
            $transaction->save();

            //direct to receipt generation
            return redirect()->route('transaction.index');
        }


        $transaction->customer_id = $request->customer_id;
        $transaction->merchant_id = $request->merchant_id;
        $transaction->invoice_id = $request->invoice_id;

        $transaction->payment_method = $request->payment_method;
        $transaction->amount_paid = $request->amount_paid;

        $transaction->customer_acknowledgement = $request->customer_acknowledgement;
        $transaction->merchant_acknowledgement = $request->merchant_acknowledgement;


        // dd($invoice);
        // dd($transaction);
        // dd($request);

        $invoice->save();
        $transaction->save();

        return redirect()->route('transaction.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->invoice = Invoice::find($transaction->invoice_id);

        $transaction->customer = User::findOrFail($transaction->customer_id);

        $transaction->merchant = User::findOrFail($transaction->merchant_id);


        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->invoice = Invoice::find($transaction->invoice_id);

        $transaction->customer = User::findOrFail($transaction->customer_id);

        $transaction->merchant = User::findOrFail($transaction->merchant_id);

        // dd($transaction);
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $invoice = Invoice::findOrFail($transaction->invoice_id);

        if ($request->amount_paid > $invoice->outstanding_payment) {

            dd("Error: Too Much Paid!");
            //too much paid. return to enter valid amount
            return redirect()->route('transaction.index');
        }

        $customer = User::findOrFail($transaction->customer_id);
        $merchant = User::findOrFail($transaction->merchant_id);

        if (((Hash::check($request->merchant_acknowledgement, $merchant->password))&&(Hash::check($request->customer_acknowledgement, $customer->password))) == true) {
            $invoice->outstanding_payment = $invoice->outstanding_payment - $transaction->amount_paid;
            $transaction->acknowledged = true;
        }
        elseif ($request->acknowledged == true) {
            $invoice->outstanding_payment = $invoice->outstanding_payment - $transaction->amount_paid;
            $transaction->acknowledged = true;
        }

        // $invoice->outstanding_payment = $invoice->outstanding_payment - $request->amount_paid;

        if (($invoice->outstanding_payment == 0) && ($transaction->acknowledged == true)) {

            // dd("Success: Outstanding Payment Clear!");

            $transaction->customer_acknowledgement = $request->customer_acknowledgement;
            $transaction->merchant_acknowledgement = $request->merchant_acknowledgement;

            $invoice->paid = true;

            // dd($invoice);

            $invoice->save();
            $transaction->save();

            //direct to receipt generation
            return redirect()->route('transaction.index');
        }


        $transaction->merchant_acknowledgement = $request->merchant_acknowledgement;
        $transaction->customer_acknowledgement = $request->customer_acknowledgement;

        // dd($invoice);
        // dd($transaction);
        // dd($request);

        $invoice->save();
        $transaction->save();

        // $transaction = Transaction::findOrFail($id);
        //
        // $transaction->invoice_id = $request->invoice_id;
        // $transaction->payment_method = $request->payment_method;
        //
        // dd($transaction);
        // $transaction->save();
        //
        //
        //
        //
        // return redirect()->route('transactions.edit', ['transaction' => $transaction ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();

        return redirect()->back();
    }
}
