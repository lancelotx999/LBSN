<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ReceiptPDF;
use Moloquent;

class ReceiptGenerator extends Controller
{
    public function createReceipt()
    {
        ReceiptPDF::SetCreator('LBSN');
    	ReceiptPDF::SetTitle('Invoice');
        ReceiptPDF::SetSubject('LBSN Invoice');

        ReceiptPDF::AddPage();
            
 		
  		ReceiptPDF::Write(1, 'Hello World');
  		ReceiptPDF::Output('Invoice.pdf', 'I');

    }

    public function genHTML($sender , $receiver , $price , $service)
    {
        $html =
        '

        ';

        return $html;
    }

    public function store($sender_id , $receiver_id , $price , $service)
    {
        $invoice = new Invoice;


        $invoice->save();
    }

}
