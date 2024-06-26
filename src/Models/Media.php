<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use HasFactory;

    protected $table = "media";
    protected $primaryKey = "ID_";
    protected $keyType = "string";

    public function uploaded_by()
    {
        return $this->belongsTo(User::class, 'CUSTOM_PROPERTIES.UPLOADED_BY');
    }
}
