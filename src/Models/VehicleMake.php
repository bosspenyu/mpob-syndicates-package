<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMake extends Model
{
    use HasFactory;
    protected $connection = 'syndicates';
    protected $table = 'ref_vehicle_make';
    protected $primaryKey = 'code_';
}
