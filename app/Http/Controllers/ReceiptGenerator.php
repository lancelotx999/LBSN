<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ReceiptPDF;
use Moloquent;

class ReceiptGenerator extends Controller
{
    public function createReceipt()
    {
    	ReceiptPDF::SetTitle('Hello World');
 		ReceiptPDF::AddPage();
  		ReceiptPDF::Write(0, 'Hello World');
  		ReceiptPDF::Output('hello_world.pdf');

    }

    public function genHTML($sender , $receiver , $price , $service)
    {

    }

    public function store()
    {

    }

    public function registertoDB()
    {

    }
}
