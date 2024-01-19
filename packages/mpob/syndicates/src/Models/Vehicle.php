<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, HasUuids;
    protected $connection = 'syndicates';
    protected $primaryKey = "id_";
    public const CREATED_AT = 'create_dt';
    public const UPDATED_AT = 'update_dt';

}
