<?php

namespace App;

use Moloquent;

class Receipt extends Moloquent
{
    protected $table = 'receipts';

    protected $guarded = 
    [
       'provider_id','receiver_id','invoice_id', 'payment_method',
    ];

}
