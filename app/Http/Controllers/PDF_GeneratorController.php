<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Contract;
use PDF;

class PDF_GeneratorController extends Controller
{
	public function getContract($contract_id)
	{
		$contract = Contract::findOrFail($contract_id)->getAttributes();
	}

    public function generateReceipt($provider_id , $receiver_id , $price , $service)
    {

    }

    public function generateHTML($provider_id , $receiver_id , $price , $service)
    {
        $html =
        '

        ';

        return $html;
    }

	public function HTMLtoPDF(){
		$users = User::all();
		$contract = Contract::findOrFail('5be2c271339b5754de60b397')->get();
		$contracts = Contract::all();

		$pdf = PDF::loadView('PDF.receipt',  compact('contracts'));


		return $pdf->download('invoice.pdf');
	}
}
