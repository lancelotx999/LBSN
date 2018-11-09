<?php

namespace App;

use Moloquent;

class Invoice extends Moloquent
{
    protected $table = 'invoices';

    protected $guarded =
    [
       'provider_id','receiver_id','contract_id', 'tax','total_price', 'grand_total', 'paid',
    ];

}
