<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [
    	'sender','receiver','price','service','paid',
    ];

    protected $table = 'invoices';

}
