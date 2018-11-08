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

	public function invoiceGenerator(){
		//provider_id & receiver_id is loaded from POST
		$provider_id = "5be2c26f339b5754de60b392";
		$receiver_id = "5be2e673339b57708e1ab802";

		$provider = User::findOrFail($provider_id);
		$receiver = User::findOrFail($receiver_id);

		$contracts = Contract::where('receiver_id','=', $receiver_id)->where('provider_id','=', $provider_id)->get();

		$total = 0;

		foreach ($contracts as $contract) {
			$total = $total + $contract->price;
		}

		$taxed = $total*0.25;
		$grandTotal = $taxed + $total;

		$data = new class{};

		$data->receiver = $receiver;
		$data->provider = $provider;
		$data->total = $total;
		$data->taxed = $taxed;
		$data->grandTotal = $grandTotal;
		$data->contracts = $contracts;

		// return view('PDF.invoice',  compact('data'));

		$pdf = PDF::loadView('PDF.invoice',  compact('data'));
		$pdf->setPaper('A4', 'landscape');


		return $pdf->download('invoice.pdf');
	}
}
