<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyndicateCategory extends Model
{
    use HasFactory;

    public const CREATED_AT = 'create_dt';
    public const UPDATED_AT = 'update_dt';
}
