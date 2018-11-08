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
            $provided_receipts = Receipt::where('provider_id','=', Auth::user()->id)->get();
            $received_receipts = Receipt::where('receiver_id','=', Auth::user()->id)->get();

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
    public function ShowUserReceipts($user_id)
    {
        $provided_receipts = Receipt::where('provider_id','=', $user_id)->get();
        $received_receipts = Receipt::where('receiver_id','=', $user_id)->get();

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
            if ($request->invoice_id == $receipts->invoice_id) {
                $counter++;
            }
        }

        if ($counter == 0)
        {
            $invoice = Invoice::find($request->invoice_id);

            $receipt = new Receipt;

            $receipt->provider_id = $invoice->provider_id;
            $receipt->receiver_id = $invoice->receiver_id;

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

    public function test()
    {
        // $cons[0] = "5be3e44384220c1da3213b27";
        // $cons[1] = "5be3e44384220c1da3213b28";
        // $cons[2] = "swag";
        // $cons[3] = "dad";
        $request = new class{};

        $request->invoice_id = "5be439b2339b573fff297eb9";
        $request->payment_method = "cash";

        $allReceipts = Receipt::all();
        $counter = 0;

        // create a new Receipt based on input
        $allReceipts = Receipt::all();
        $counter = 0;

        foreach ($allReceipts as $receipts)
        {
            // dd($receipts);
            // if (in_array($request->invoice_id, $receipts->invoice_id))
            // {
            //     $counter++;
            // }

            if ($request->invoice_id == $receipts->invoice_id) {
                $counter++;
            }

        }

        // foreach ($allReceipts as $receipts)
        // {
        //     foreach ($cons as $con)
        //     {
        //         if (in_array($con, $receipts->contract_id))
        //         {
        //             $counter++;
        //         }
        //     }
        // }
        // dd($counter);

        if ($counter == 0)
        {
            $invoice = Invoice::find($request->invoice_id);

            $receipt = new Receipt;

            $receipt->provider_id = $invoice->provider_id;
            $receipt->receiver_id = $invoice->receiver_id;

            $receipt->invoice_id = $request->invoice_id;
            $receipt->payment_method = $request->payment_method;

            // $receipt = new Receipt;
            // $receipt->contract_id = $cons;
            // $receipt->payment_method = "Cash";
            // $receipt->price = 500;
            // $receipt->save();

            $receipt->save();
        }
        else
        {
            dd("ERROR");
        }

        dd($receipt);
    }

}
