<?php

namespace App;

use Moloquent;

class Review extends Moloquent
{
    protected $table = 'reviews';

    protected $guarded = 
    [
    	'reviewer_id', 'reviewee_id' , 'content',
    ];
}
