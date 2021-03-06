<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class Nominee extends Model
{
    protected $fillable = [
        'member_id','name','age','relation','father_name'
    ];

    public function member()
    {
        return $this->belongsTo('App\Member_model\Member');
    }
}
