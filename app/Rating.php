<?php

namespace App;

use Moloquent;

class Rating extends Moloquent
{
    protected $table = 'ratings';

    protected $guarded = 
    [
        'rater_id', 'ratee_id', 'rate',
    ];
}
