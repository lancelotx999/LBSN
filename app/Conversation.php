<?php

namespace App;

use Moloquent;

class Conversation extends Moloquent
{
    protected $table = 'conversations';

    protected $guarded =
    [
    	'sender_id','receiver_id','title','messages','read',
    ];
}
