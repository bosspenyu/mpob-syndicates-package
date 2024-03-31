<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyndicateCategory extends Model
{
    use HasFactory;

    public const CREATED_AT = 'CREATE_DT';
    public const UPDATED_AT = 'UPDATE_DT';

    protected $table = "SYNDICATE_CATEGORIES";
}
