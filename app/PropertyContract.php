<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyContract extends Model
{
    protected $fillable = ['providerID', 'receiverID', 'locationID', 'contractContent', 'contractValue', 'contractStatus', 'providerSignature', 'receiverSignature'];

}
