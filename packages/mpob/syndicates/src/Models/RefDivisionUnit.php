<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefDivisionUnit extends Model
{
    use HasFactory;

    protected $table="ref_division_unit";
    protected $primaryKey="code_";
    public $incrementing = false;
    protected $keyType = "string";
}
