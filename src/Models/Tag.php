<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Tag extends Model
{
    use HasFactory, HasUuids;

    protected $primaryKey = "id_";
    public const CREATED_AT = 'create_dt';
    public const UPDATED_AT = 'update_dt';

    /**
     * @return MorphToMany
     */
    public function syndicate(): MorphToMany
    {
        return $this->morphedByMany(Syndicate::class, 'model');
    }

    /**
     * @return MorphToMany
     */
    public function member(): MorphToMany
    {
        return $this->morphedByMany(Member::class, 'model');
    }
}
