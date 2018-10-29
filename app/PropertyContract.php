<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class PropertyContract extends Eloquent
{
    protected $fillable = ['providerID', 'receiverID', 'locationID', 'provider', 'receiver', 'location', 'contractContent', 'contractValue', 'contractStatus', 'providerSignature', 'receiverSignature'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // public function location() {
    //     return $this->belongsTo(Location::class);
    // }

    public function location() {
        return $this->hasOne(Location::class);
    }
}
