<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relationship extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $primaryKey = "ID_";
    public const CREATED_AT = 'CREATE_DT';
    public const UPDATED_AT = 'UPDATE_DT';

    public function syndicate()
    {
        return $this->hasOne(Network::class,'RELATIONSHIP_ID','ID_');
    }

    public function trc_acc()
    {
        return $this->hasOne(Network::class,'RELATIONSHIP_ID','ID_');
    }

}
