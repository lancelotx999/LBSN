<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceContract extends Model
{
    protected $fillable = ['providerID', 'receiverID', 'serviceID', 'contractContent', 'contractValue', 'contractStatus', 'providerSignature', 'receiverSignature'];

}
