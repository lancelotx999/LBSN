<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Location extends Eloquent {
    // protected $connection = 'mongodb';

    protected $fillable = ['locationName', 'locationAddress', 'locationDescription', 'locationStatus', 'locationRating', 'locationLatitude', 'locationLongitude'];
    // protected $fillable = ['locationOwnerID'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // relationship should be polymorphic
    // public function contract() {
    //     return $this->belongsTo(Contract::class);
    // }

    // protected $collection = 'location';
    // protected $table = 'location';

}
