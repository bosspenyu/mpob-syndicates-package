<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RefCountryState extends Model
{
    use HasFactory;

    protected $table = 'ref_country_state';
    protected $primaryKey = "code_";
    protected $keyType = "string";
    public $incrementing = false;


    /**
     * @return HasMany
     */
    public function cities(): HasMany
    {
        return $this->hasMany(RefDistrict::class, 'country_state_code');
    }
}
