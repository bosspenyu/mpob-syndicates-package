<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;
    protected $connection = 'syndicates';
    protected $table = 'ref_vehicle_type';
    protected $primaryKey = 'code_';
}
