<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMake extends Model
{
    use HasFactory;

    protected $primaryKey = "ID_";
    protected $keyType = "string";

    protected $table = 'REF_VEHICLE_MAKE';
}
