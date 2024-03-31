<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDivisionUnit extends Model
{
    use HasFactory;

    protected $table="REF_DIVISION_UNIT";
    protected $primaryKey="CODE_";
    public $incrementing = false;
    protected $keyType = "string";
}
