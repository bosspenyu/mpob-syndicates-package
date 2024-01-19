<?php

namespace Mpob\Syndicates\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrcTxrptTrade extends Model
{
    use HasFactory;
    protected $connection = 'syndicates';
    protected $table = "trc_txrpt_trade";
}
