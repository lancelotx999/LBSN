<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Contract extends Eloquent {

    protected $fillable = ['providerID', 'receiverID', 'locationID', 'contractType', 'contractContent', 'contractValue', 'contractStatus', 'providerSignature', 'receiverSignature'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // relationship should be polymorphic
    // public function location()
    // {
    //     return $this->hasOne('App\Location');
    // }

    // public function user() {
    //     return $this->hasMany(User::class);
    // }
}
