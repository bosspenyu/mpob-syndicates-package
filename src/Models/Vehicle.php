<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = "ID_";
    protected $keyType = "string";

    public const CREATED_AT = 'CREATE_DT';
    public const UPDATED_AT = 'UPDATE_DT';

}
