<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsrRole extends Model
{
    use HasFactory;
    protected $connection = 'syndicates';
    protected $table = 'usr_role';

    public function detail()
    {
        return $this->hasOne(RefRole::class,'code_','role');
    }
}
