<?php

namespace App;

use Moloquent;

class Receipt extends Moloquent
{
    protected $table = 'receipts';

    protected $guarded = 
    [
       'invoice_id', 'payment_method',
    ];

}
