<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrcAccRole extends Model
{
    use HasFactory;

    protected $connection = 'syndicates';

    protected $table = "trc_acc_role";
}
