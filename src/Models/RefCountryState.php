<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefCountryState extends Model
{
    use HasFactory;

    protected $table = 'REF_COUNTRY_STATE';
    protected $primaryKey = "CODE_";
    protected $keyType = "string";
    public $incrementing = false;


    /**
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(RefDistrict::class, 'COUNTRY_STATE_CODE');
    }
}
