<?php

namespace App;

use Moloquent;

class Business extends Moloquent
{
    protected $table = 'businesses';

    protected $guarded = 
    [
    	'owner_id', 'name', 'description', 'services', 'contact_number','images', 'verified',
    ];
}