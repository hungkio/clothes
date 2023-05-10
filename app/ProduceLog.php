<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProduceLog extends Model
{
    protected $table = "produce_log";
    protected $fillable = ['produce_id', 'increase'];
}
