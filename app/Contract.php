<?php

namespace App;

use Moloquent;

class Contract extends Moloquent 
{
    protected $table = 'contracts';

    protected $guarded = 
    [
        'name', 'customer_id', 'merchant_id', 'item_id', 'type', 'description', 'price', 'paid',
    ];



}
