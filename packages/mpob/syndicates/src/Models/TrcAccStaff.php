<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TrcAccStaff extends Model
{
    use HasFactory;

    protected $table = 'trc_acc_staff';
    protected $primaryKey = "id_";


    public function branch()
    {
        return $this->belongsTo(RefBranchOffice::class,'branch_code','code_');
    }

    public function division()
    {
        return $this->belongsTo(RefDivisionUnit::class,'division_unit_code','code_');
    }

    public function role()
    {
        return $this->hasMany(TrcAccRole::class,'staff_id','id_');
    }

}
