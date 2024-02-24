<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefDistrict extends Model
{
    use HasFactory;

    protected $table = 'REF_DISTRICT';
    protected $primaryKey = 'CODE_';

    /**
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(RefCountryState::class, 'COUNTRY_STATE_CODE','CODE_');
    }
}
