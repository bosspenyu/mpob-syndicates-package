<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TrcAccStaff extends Model
{
    use HasFactory;

    protected $table = 'TRC_ACC_STAFF';
    protected $primaryKey = "ID_";


    public function branch()
    {
        return $this->belongsTo(RefBranchOffice::class,'BRANCH_CODE','CODE_');
    }

    public function division()
    {
        return $this->belongsTo(RefDivisionUnit::class,'DIVISION_UNIT_CODE','CODE_');
    }

    public function role()
    {
        return $this->hasMany(TrcAccRole::class,'STAFF_ID','ID_');
    }

}
