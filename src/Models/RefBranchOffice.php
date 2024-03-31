<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefBranchOffice extends Model
{
    use HasFactory;

    protected $table = "REF_BRANCH_OFFICE";
    protected $primaryKey = "CODE_";
    public $incrementing = false;
    protected $keyType = "string";
}
