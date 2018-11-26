<?php

namespace App;

use Moloquent;

class Contract extends Moloquent 
{           
    protected $table = 'contracts';

    protected $guarded = 
    [
        'name', 'merchant_id', 'customer_id', 'item_id', 'invoice_id' , 'type', 'description', 'price', 'merchant_accepted', 'customer_accepted' , 'paid_fully', 'fulfilled' ,
    ];

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = floatval($value);
    }

}
