<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Contract extends Eloquent {

    protected $fillable = ['providerID', 'receiverID', 'contractContent', 'contractValue', 'contractStatus', 'providerSignature', 'receiverSignature'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function user() {
    //     return $this->hasMany(User::class);
    // }
}
