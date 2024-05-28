<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Model;

class SyndicateType extends Model
{
    protected $primaryKey = "ID_";
    protected $keyType = "string";

    public const CREATED_AT = 'CREATE_DT';
    public const UPDATED_AT = 'UPDATE_DT';

    protected $table = "SYNDICATE_TYPES";
}
