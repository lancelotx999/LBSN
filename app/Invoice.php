<?php

namespace App;

use Moloquent;

class Invoice extends Moloquent
{
	protected $table = 'invoices';

	protected $guarded =
	[
		'merchant_id','customer_id','contract_id', 'tax','total_price', 'grand_total', 'paid',
	];

	public function setTaxAttribute($value)
	{
		$this->attributes['tax'] = floatval($value);
	}

	public function setTotalPriceAttribute($value)
	{
		$this->attributes['total_price'] = floatval($value);
	}

	public function setGrandTotalAttribute($value)
	{
		$this->attributes['grand_total'] = floatval($value);
	}

}
