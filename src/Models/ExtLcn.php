<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtLcn extends Model
{
    use HasFactory;

    protected $primaryKey = "ID_";
    protected $table = "EXT_LCN";
}
