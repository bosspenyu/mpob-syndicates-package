<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relationship extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = "id_";
    public const CREATED_AT = 'create_dt';
    public const UPDATED_AT = 'update_dt';

    public function syndicate()
    {
        return $this->hasOne(Network::class,'relationship_id','id_');
    }

    public function trc_acc()
    {
        return $this->hasOne(Network::class,'relationship_id','id_');
    }

}
