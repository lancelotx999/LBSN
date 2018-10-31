<?php

namespace App;

use Moloquent;

class Invoice extends Moloquent
{
    protected $guarded = [
    	'sender','receiver','price','service','paid',
    ];

    protected $table = 'invoices';

}
