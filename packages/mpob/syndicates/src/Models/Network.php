<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Network extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = false;
    public $incrementing = false;

    /**
     * @return BelongsTo
     */
    public function relationship(): BelongsTo
    {
        return $this->belongsTo(Relationship::class,'relationship_id');
    }

    public function from()
    {
        return $this->morphTo();
    }

    public function to()
    {
        return $this->morphTo();
    }

}
