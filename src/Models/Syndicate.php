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

    protected $primaryKey = 'id_';
    protected $keyType = "string";

    public const CREATED_AT = 'create_dt';
    public const UPDATED_AT = 'update_dt';

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'syndicate_tags');
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
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(SyndicateType::class,'syndicate_type_id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(SyndicateCategory::class,'syndicate_category_id');
    }

    /**
     * @return BelongsTo
     */
    public function confirmation(): BelongsTo
    {
        return $this->belongsTo(RefStrSts::class,'ref_str_sts_code_','code_');
    }

    /**
     * @return HasMany
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class, 'syndicate_id_');
    }

    /**
     * @return HasMany
     */
    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'syndicate_id_');
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
            id_,
            name_,
            null AS lcn_no,
            id_no,
            (SELECT name_ FROM ref_str_sts WHERE syndicates.ref_str_sts_code_ = ref_str_sts.code_) AS status,
            (SELECT name from syndicate_types WHERE syndicate_types.id = syndicates.syndicate_type_id) AS type,
            create_dt,
            "' . class_basename(Syndicate::class) . '" AS model
            '
        );

        if (!is_null($request->input('name'))) {
            $bindings = explode(" ", $request->input('name'));
            foreach ($bindings as $binding) {
                $syndicates->Orwhere('name_', 'LIKE', '%' . $binding . '%');
            }
        }

        if(!is_null($request->input('reg_no'))){
            $reg_no = $request->input('reg_no');
            $syndicates->whereHas('vehicles', function($query)use($reg_no){
                return $query->where('reg_no','LIKE','%'.$reg_no.'%');
            });
        }

//        if(!is_null($request->input('license_no'))){
//            $lcn_no = $request->input('license_no');
//            $syndicates->where(DB::raw()'lcn_no','LIKE','%'.$lcn_no.'%');
//        }

        return $syndicates;
    }

    /**
     * @return BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(RefDistrict::class,'city_code_','code_');
    }

    /**
     * @return BelongsTo
     */
    public function status_record()
    {
        return $this->belongsTo(RefStrSts::class, 'ref_str_sts_code_','code_');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }

    /**
     * @return MorphToMany
     */
    public function networks(): MorphToMany
    {
        return $this->morphToMany(TrcAcc::class,'from', Network::class,'from_id','to_id','');
    }

    /**
     * @return MorphToMany
     */
    public function searchNetwork(): MorphToMany
    {
        return $this->morphToMany(
            Syndicate::class,'from',
            Network::class,
            'from_id',
            'to_id');
    }

    /**
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder
                ->orderBy('create_dt', 'desc');

            if(!Auth::user()->staff->division->code_ == "EU"){
                $builder->where('region_code', Auth::user()->region);
            }

            if(!in_array(["KU","KW"], Auth::user()->staff->role->toArray())) {
                $builder->where('created_by', Auth::id());
            }
        });
    }
}
