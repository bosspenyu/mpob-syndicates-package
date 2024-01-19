<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Note extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasUuids;

    protected $primaryKey = "id_";
    public const CREATED_AT = 'create_dt';
    public const UPDATED_AT = 'update_dt';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by','id');
    }
}
