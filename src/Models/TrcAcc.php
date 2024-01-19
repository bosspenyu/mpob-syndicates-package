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

    protected $table = 'trc_acc';
    protected $primaryKey = "id_";
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
        return $this->morphToMany(Syndicate::class,'from', Network::class,'from_id','to_id');
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
                id_,
                name_,
                lcn_no,
                id_no,
                ( SELECT name_ FROM ref_str_sts WHERE trc_acc.sts_code = ref_str_sts.code_  ) AS status,
                (
                  CASE
                    WHEN id_type = "NRIC" THEN (SELECT name FROM syndicate_types WHERE id = 1)
                    WHEN id_type = "ROC" THEN (SELECT name FROM syndicate_types WHERE id = 3)
                  ELSE (SELECT name FROM syndicate_types WHERE id = 4)
                  END
                ) AS type,
                create_dt,
                "' . class_basename(TrcAcc::class) . '" AS model
            '
        );

        if ($request->input('name')) {
            $bindings = explode(" ", $request->input('name'));
            foreach ($bindings as $binding) {
                $trc_acc->Orwhere('name_', 'LIKE', '%' . $binding . '%');
            }
        }

        if(!is_null($request->input('reg_no'))){
            $reg_no = $request->input('reg_no');
            $trc_acc->whereHas('vehicles', function($query)use($reg_no){
                return $query->where('reg_no','LIKE','%'.$reg_no.'%');
            });
        }

        if(!is_null($request->input('license_no'))){
            $lcn_no = $request->input('license_no');
            $trc_acc->where('lcn_no','LIKE','%'.$lcn_no.'%');
        }

        return $trc_acc;
    }

    public function status_record()
    {
       return $this->belongsTo(RefStsCmn::class, 'sts_code','code_');
    }

    /**
     * @return MorphToMany
     */
    public function trc_acc_skeleton(): MorphToMany
    {
        return $this->morphedByMany(TrcAcc::class,'from',Network::class,'to_id')
            ->withPivot('relationship_id')->using(RelationshipContent::class);
    }

    /**
     * @return MorphToMany
     */
    public function syndicate_skeleton(): MorphToMany
    {
        return $this->morphedByMany(Syndicate::class,'from',Network::class,'to_id')
            ->withPivot('relationship_id')->using(RelationshipContent::class);
    }

    /**
     * @return HasMany
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(TrcAccVehicle::class, 'acc_id','id_');
    }

    /**
     * @return HasOne
     */
    public function location(): HasOne
    {
        return $this->hasOne(ExtLcn::class,'id_');
    }
}
