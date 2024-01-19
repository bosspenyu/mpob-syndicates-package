<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

class RelationshipContent extends MorphPivot
{
    protected $table = 'relationships';

    /**
     * @return BelongsTo
     */
    public function relationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class,'relationship_id');
    }
}
