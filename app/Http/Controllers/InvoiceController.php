<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Invoice;
use Auth;
use ReceiptPDF;
use Moloquent;

class InvoiceController extends Controller
{
    // apply auth middleware so only authenticated users have access
    public function __construct() {
        $this->middleware('auth');
    }

    public function getCurrentUserRole()
    {
        $role = Auth::user()->role;
        dd($role);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('user')->get();
        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Invoice $invoice)
    {
        // get all the locations based on current user id
        $allInvoices = $invoice->whereIn('user_id', $request->user())->with('user');
        // $locations = $allLocations->orderBy('created_at', 'desc')->take(10)->get();
        $invoices = $allInvoices->take(10)->get();
        return view('invoices.create', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation Logic
        $this->validate($request, [
            'sender' => 'required',
            'receiver' => 'required',
            'price' => 'required',
            'service' => 'required',
            'paid' => 'required',
        ]);

        // create a new Invoice based on input
        $invoice = new Invoice;
        $invoice->sender = $request->sender;
        $invoice->receiver = $request->receiver;
        $invoice->price = $request->price;
        $invoice->service = $request->service;
        $invoice->paid = $request->paid;

        $invoice->save();

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
        $invoice = Invoice::with('user')->findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::with('user')->findOrFail($id);

        return view('invoices.edit', compact('invoice'));
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
        $input = $request->all();
        $invoice = Invoice::with('user')->findOrFail($id);
        $invoice->update($input);
        return redirect()->route('invoice.edit', ['invoice' => $invoice ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();

        return redirect()->back();
    }

    public function generateInvoice($sender_id , $receiver_id , $price , $service)
    {
        ReceiptPDF::SetCreator('LBSN');
        ReceiptPDF::SetTitle('Invoice');
        ReceiptPDF::SetSubject('LBSN Invoice');

        ReceiptPDF::AddPage();
            
        
        ReceiptPDF::Write(1, 'Hello World');
        ReceiptPDF::Output('Invoice.pdf', 'I');

        $this->store($sender_id , $receiver_id , $price , $service);

    }

    public function genHTML($sender_id , $receiver_id , $price , $service)
    {
        $html =
        '

        ';

        return $html;
    }

    public function showInvoicebyID($user_id)
    {
        $invoices = Invoice::where('sender','=',$user_id)-> orWhere('receiver','=',$user_id)->get();

        return $invoices;
    }

    public function showInvoicebyService($service)
    {

    }

    public function deleteInvoicebyID($invoice_id)
    {

    }

}
