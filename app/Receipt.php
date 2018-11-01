<?php

namespace App;

use Moloquent;

class Receipt extends Moloquent
{
    protected $table = 'receipts';

    protected $guarded = 
    [
       'contract_id', 'payment_method','price'
    ];
}
