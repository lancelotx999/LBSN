<?php

namespace App;

use Moloquent;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $guarded = 
    [
       'contract_id', 'tax','total_price',
    ];

}
