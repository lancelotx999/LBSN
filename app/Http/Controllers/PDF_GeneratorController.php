<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Invoice;
use App\Receipt;
use App\Contract;
use PDF;

class PDF_GeneratorController extends Controller
{
	public function getContract($contract_id)
	{
		$contract = Contract::findOrFail($contract_id)->getAttributes();
	}

    public function generateReceipt($customer , $merchant_id , $price , $service)
    {

    }

    public function generateHTML($customer , $merchant_id , $price , $service)
    {
        $html =
        '

        ';

        return $html;
    }

	public function invoiceGenerator($id) {
		$data = Invoice::findOrFail($id);

		$data->provider = User::findOrFail($data->customer_id);
		$data->merchant = User::findOrFail($data->merchant_id);
		$data->contracts = Contract::where('merchant_id','=', $data->merchant_id)->where('customer','=', $data->customer)->get();

		// dd($data);
		$pdf = PDF::loadView('PDF.invoice',  compact('data'));
		$pdf->setPaper('A4', 'landscape');

		return $pdf->download('invoice.pdf');
	}

	public function receiptGenerator(){
		$data = Receipt::findOrFail('5be44aa1339b5708955603b4');

		$data->provider = User::findOrFail($data->customer);
		$data->merchant = User::findOrFail($data->merchant_id);
		$data->invoice = Invoice::findOrFail($data->invoice_id);
		$data->contracts = Contract::where('merchant_id','=', $data->merchant_id)->where('customer','=', $data->customer)->get();

		// dd($data);
		$pdf = PDF::loadView('PDF.receipt',  compact('data'));
		$pdf->setPaper('A4', 'landscape');

		return $pdf->download('receipt.pdf');
	}


	public function test(){
		$cons[0] = "5bdfec8f84220c106b2bb5a7";
		$cons[1] = "5bdfec8f84220c106b2bb5a8";
		$receipt = new Receipt;

		$receipt->contract_id = $cons;
		$receipt->payment_method = "Cash";
		$receipt->price = 500;

		$receipt->save();

		dd($receipt);

	}

}
