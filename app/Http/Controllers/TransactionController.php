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
            $provided_transactions = Transaction::where('provider_id','=', Auth::user()->id)->get();

            //user receives item and pays
            $received_transactions = Transaction::where('receiver_id','=', Auth::user()->id)->get();

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

        $provider = User::findOrFail($invoice->provider_id);
        $receiver = User::findOrFail($invoice->receiver_id);

        $invoice->provider = $provider;
        $invoice->receiver = $receiver;

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
                'provider_id' => 'required',
                'receiver_id' => 'required',
                'invoice_id' => 'required',

                'amount_paid' => 'required',
                'payment_method' => 'required',

                'provider_acknowledgement' => 'required',
                'receiver_acknowledgement' => 'required',
            ]);


        $invoice = Invoice::findOrFail($request->invoice_id);

        if ($request->amount_paid > $invoice->outstanding_payment) {

            dd("Error: Too Much Paid!");
            //too much paid. return to enter valid amount
            return redirect()->back();
        }

        $provider = User::findOrFail($request->provider_id);
        $receiver = User::findOrFail($request->receiver_id);

        if (((Hash::check($request->receiver_acknowledgement, $receiver->password))&&(Hash::check($request->provider_acknowledgement, $provider->password))) == true) {
            $invoice->outstanding_payment = $invoice->outstanding_payment - $request->amount_paid;
        }
        elseif ($request->acknowledged == true) {
            $invoice->outstanding_payment = $invoice->outstanding_payment - $request->amount_paid;
        }

        $invoice->outstanding_payment = $invoice->outstanding_payment - $request->amount_paid;

        if ($invoice->outstanding_payment == 0) {

            dd("Success: Outstanding Payment Clear!");
            //direct to receipt generation
            return redirect()->back();
        }

        $transaction = new Transaction;

        $transaction->provider_id = $request->provider_id;
        $transaction->receiver_id = $request->receiver_id;
        $transaction->invoice_id = $request->invoice_id;

        $transaction->payment_method = $request->payment_method;
        $transaction->amount_paid = $request->amount_paid;

        $transaction->provider_acknowledgement = $request->provider_acknowledgement;
        $transaction->receiver_acknowledgement = $request->receiver_acknowledgement;

        $transaction->acknowledged = false;

        // dd($invoice);
        // dd($transaction);
        // dd($request);

        $invoice->save();
        $transaction->save();

        return redirect()->back();
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
        $transaction = Receipt::findOrFail($id);

        return view('receipts.edit', compact('receipt'));
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

        $transaction->invoice_id = $request->invoice_id;
        $transaction->payment_method = $request->payment_method;

        $transaction->save();


        return redirect()->route('transactions.edit', ['transaction' => $transaction ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Receipt::findOrFail($id)->delete();

        return redirect()->back();
    }
}
