<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsrRole extends Model
{
    use HasFactory;
    protected $table = 'USR_ROLE';

    public function detail()
    {
        return $this->hasOne(RefRole::class,'CODE_','ROLE');
    }
}
