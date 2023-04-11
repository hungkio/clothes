<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffs extends Model
{

    protected $fillable = ['name', 'phone', 'role'];
    public $guarded = [];


}
