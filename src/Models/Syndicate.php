<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Syndicate extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes, HasUuids;

    protected $primaryKey = 'ID_';
    protected $keyType = "string";

    public const CREATED_AT = 'CREATE_DT';
    public const UPDATED_AT = 'UPDATE_DT';
    public const DELETED_AT = 'DELETED_DT';

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'SYNDICATE_TAGS');
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
        return $this->morphedByMany(Syndicate::class,'from',Network::class,'TO_ID')
            ->withPivot('RELATIONSHIP_ID')->using(RelationshipContent::class);
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(SyndicateType::class,'SYNDICATE_TYPE_ID');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(SyndicateCategory::class,'SYNDICATE_CATEGORY_ID');
    }

    /**
     * @return BelongsTo
     */
    public function confirmation(): BelongsTo
    {
        return $this->belongsTo(RefStrSts::class,'REF_STR_STS_CODE_','CODE_');
    }

    /**
     * @return HasMany
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'SYNDICATE_ID_');
    }

    /**
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'SYNDICATE_ID_');
    }

    /**
     * @param $query
     * @param $request
     * @return mixed
     */
    public function scopeSearchNetwork($query, $request)
    {
        $syndicates = $query->selectRaw(
            '
            ID_,
            NAME_,
            null AS LCN_NO,
            ID_NO,
            (SELECT NAME_ FROM REF_STR_STS WHERE SYNDICATES.REF_STR_STS_CODE_ = REF_STR_STS.CODE_) AS STATUS,
            (SELECT NAME from SYNDICATE_TYPES WHERE SYNDICATE_TYPES.ID = SYNDICATES.SYNDICATE_TYPE_ID) AS TYPE,
            CREATE_DT,
            "' . class_basename(Syndicate::class) . '" AS MODEL
            '
        );

        if (!is_null($request->input('name'))) {
            $bindings = explode(" ", $request->input('name'));
            foreach ($bindings as $binding) {
                $syndicates->Orwhere('NAME_', 'LIKE', '%' . $binding . '%');
            }
        }

        if(!is_null($request->input('REG_NO'))){
            $reg_no = $request->input('REG_NO');
            $syndicates->whereHas('vehicles', function($query)use($reg_no){
                return $query->where('REG_NO','LIKE','%'.$reg_no.'%');
            });
        }

        return $syndicates;
    }

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(RefDistrict::class,'CITY_CODE_','CODE_');
    }

    /**
     * @return BelongsTo
     */
    public function status_record()
    {
        return $this->belongsTo(RefStrSts::class, 'REF_STR_STS_CODE_','CODE_');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'CREATED_BY','ID');
    }

    /**
     * @return MorphToMany
     */
    public function networks(): MorphToMany
    {
        return $this->morphToMany(TrcAcc::class,'FROM', Network::class,'FROM_ID','TO_ID','');
    }

    /**
     * @return MorphToMany
     */
    public function searchNetwork(): MorphToMany
    {
        return $this->morphToMany(
            Syndicate::class,'FROM',
            Network::class,
            'FROM_ID',
            'TO_ID');
    }

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();
//        static::addGlobalScope('order', function (Builder $builder) {
//            $builder
//                ->orderBy('CREATE_DT', 'DESC');
//
//            if(!Auth::user()->staff->division->CODE_ == "EU"){
//                $builder->where('REGION_CODE', Auth::user()->region);
//            }
//
//            if(!in_array(["KU","KW"], Auth::user()->staff->role->toArray())) {
//                $builder->where('CREATED_BY', Auth::id());
//            }
//        });
    }
}
