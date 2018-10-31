<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReceiptController extends Controller
{
	public function getContract($contract_id)
	{
		$contract = Contract::findOrFail($contract_id)->getAttributes();
	}

    public function generateReceipt($provider_id , $receiver_id , $price , $service)
    {
        ReceiptPDF::SetCreator('LBSN');
        ReceiptPDF::SetTitle('Invoice');
        ReceiptPDF::SetSubject('LBSN Invoice');

        ReceiptPDF::AddPage();
            
        
        ReceiptPDF::Write(1, 'Hello World');
        ReceiptPDF::Output('Invoice.pdf', 'I');

        $this->store($provider_id , $receiver_id , $price , $service);

    }

    public function generateHTML($provider_id , $receiver_id , $price , $service)
    {
        $html =
        '

        ';

        return $html;
    }
}
