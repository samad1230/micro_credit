<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class SavingAccount extends Model
{
    protected $fillable =['saving_id','member_id','date','amount'];


    public function saveingac()
    {
        return $this->belongsTo('App\Member_model\Saving');
    }



}
