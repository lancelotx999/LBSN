<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ServiceContract extends Eloquent
{
    protected $fillable = ['providerID', 'receiverID', 'serviceID', 'contractContent', 'contractValue', 'contractStatus', 'providerSignature', 'receiverSignature'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
