<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ReceiptPDF;
use Moloquent;

class InvoiceController extends Controller
{
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

    public function store($sender_id , $receiver_id , $price , $service)
    {
        $invoice = new Invoice;
        $invoice->sender = $sender_id;
        $invoice->receiver = $receiver_id;
        $invoice->price = $price;
        $invoice->service = $service;


        $invoice->save();
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
