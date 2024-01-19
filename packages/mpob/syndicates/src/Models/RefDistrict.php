<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefDistrict extends Model
{
    use HasFactory;

    protected $table = 'ref_district';
    protected $primaryKey = 'code_';

    /**
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(RefCountryState::class, 'country_state_code','code_');
    }
}
