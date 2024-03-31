<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class TrcAcc extends Model
{
    use HasFactory;

    protected $table = 'TRC_ACC';
    protected $primaryKey = "ID_";
    protected $keyType = "string";
    protected $appends = ['type'];

    /**
     * @return string[]
     */
    public function getTypeAttribute()
    {
        switch ($this->attributes['id_type']){
            case "ROC":
                $type = "Syarikat";
                break;
            case "NRIC":
                $type = "Warganegara";
                break;
            default:
                $type= "Bukan Warganegara";
        }
        return ["name"=>$type];
    }

    /**
     * @return MorphToMany
     */
    public function networks(): MorphToMany
    {
        return $this->morphToMany(Syndicate::class,'FROM', Network::class,'FROM_ID','TO_ID');
    }


    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeSearchNetwork($query, $request)
    {
        $trc_acc = $query->selectRaw(
            '
                ID_,
                NAME_,
                LCN_NO,
                ID_NO,
                ( SELECT NAME_ FROM REF_STR_STS WHERE TRC_ACC.STS_CODE = REF_STR_STS.CODE_  ) AS STATUS,
                (
                  CASE
                    WHEN ID_TYPE = "NRIC" THEN (SELECT NAME_ FROM SYNDICATE_TYPES WHERE id = 1)
                    WHEN ID_TYPE = "ROC" THEN (SELECT NAME_ FROM SYNDICATE_TYPES WHERE id = 3)
                  ELSE (SELECT NAME_ FROM SYNDICATE_TYPES WHERE ID_ = 4)
                  END
                ) AS TYPE,
                CREATE_DT,
                "' . class_basename(TrcAcc::class) . '" AS model
            '
        );

        if ($request->input('name')) {
            $bindings = explode(" ", $request->input('name'));
            foreach ($bindings as $binding) {
                $trc_acc->Orwhere('NAME_', 'LIKE', '%' . $binding . '%');
            }
        }

        if(!is_null($request->input('reg_no'))){
            $reg_no = $request->input('reg_no');
            $trc_acc->whereHas('vehicles', function($query)use($reg_no){
                return $query->where('REG_NO','LIKE','%'.$reg_no.'%');
            });
        }

        if(!is_null($request->input('license_no'))){
            $lcn_no = $request->input('license_no');
            $trc_acc->where('LCN_NO','LIKE','%'.$lcn_no.'%');
        }

        return $trc_acc;
    }

    public function status_record()
    {
       return $this->belongsTo(RefStsCmn::class, 'STS_CODE','CODE_');
    }

    /**
     * @return MorphToMany
     */
    public function trc_acc_skeleton(): MorphToMany
    {
        return $this->morphedByMany(TrcAcc::class,'FROM',Network::class,'TO_ID')
            ->withPivot('RELATIONSHIP_ID')->using(RelationshipContent::class);
    }

    /**
     * @return MorphToMany
     */
    public function syndicate_skeleton(): MorphToMany
    {
        return $this->morphedByMany(Syndicate::class,'FROM',Network::class,'TO_ID')
            ->withPivot('RELATIONSHIP_ID')->using(RelationshipContent::class);
    }

    /**
     * @return HasMany
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(TrcAccVehicle::class, 'ACC_ID','ID_');
    }

    /**
     * @return HasOne
     */
    public function location(): HasOne
    {
        return $this->hasOne(ExtLcn::class,'ID_');
    }
}
