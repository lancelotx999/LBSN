<?php

namespace App;

use Moloquent;

class Contract extends Moloquent 
{
    protected $table = 'contracts';

    protected $guarded = 
    [
        'name', 'provider_id', 'receiver_id', 'item_id', 'type', 'description', 'price', 'paid',
    ];



}
