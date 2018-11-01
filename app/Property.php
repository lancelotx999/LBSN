<?php

namespace App;

use Moloquent;

class Property extends Moloquent
{
    protected $table = 'properties';

    protected $guarded = 
    [
    	'owner_id','name','address','description','status', 'rating', 'latitude', 'longitude',
    ];
}
