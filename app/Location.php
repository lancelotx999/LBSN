<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Location extends Eloquent {
    // protected $connection = 'mongodb';

    protected $fillable = ['locationOwnerID', 'locationName', 'locationAddress', 'locationDescription', 'locationStatus', 'locationRating', 'locationLatitude', 'locationLongitude'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // protected $collection = 'location';
    // protected $table = 'location';

}
