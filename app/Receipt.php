<?php

namespace App;

use Moloquent;

class Receipt extends Moloquent
{
    protected $table = 'receipts';

    protected $guarded = 
    [
       'merchant_id','customer_id','invoice_id', 'payment_method',
    ];

}
