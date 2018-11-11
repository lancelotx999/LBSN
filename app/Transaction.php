<?php

namespace App;

use Moloquent;

class Transaction extends Moloquent
{
    protected $table = 'transactions';

    protected $guarded =
    [
       'provider_id','receiver_id','invoice_id', 'payment_method', 'amount_paid', 'provider_acknowledgement','receiver_acknowledgement', 'acknowledged'
    ];

}
