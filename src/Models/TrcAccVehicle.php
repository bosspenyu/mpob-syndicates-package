<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrcAccVehicle extends Model
{
    use HasFactory;
    protected $connection = 'syndicates';
    protected $primaryKey = "id_";
    protected $table ="trc_acc_vehicle";
}
