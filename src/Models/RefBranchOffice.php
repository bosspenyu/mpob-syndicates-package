<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefBranchOffice extends Model
{
    use HasFactory;

    protected $table = "ref_branch_office";
    protected $primaryKey = "code_";
    public $incrementing = false;
    protected $keyType = "string";
}
