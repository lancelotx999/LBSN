<?php

namespace App;

use Moloquent;

class Transaction extends Moloquent
{
	protected $table = 'transactions';

	protected $guarded =
	[
		'merchant_id','customer_id','invoice_id', 'payment_method', 'amount_paid', 'grand_total', 'merchant_acknowledgement','customer_acknowledgement',
	];

	public function setAmountPaidAttribute($value)
	{
		$this->attributes['amount_paid'] = floatval($value);
	}

	public function setGrandTotalAttribute($value)
	{
		$this->attributes['grand_total'] = floatval($value);
	}

}
