<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class SavingCollection extends Model
{
    protected $fillable =['member_id','date','amount'];

    public function member()
    {
        return $this->belongsTo('App\Member_model\Member');
    }

    public function saving()
    {
        return $this->belongsTo('App\Member_model\Saving');
    }


}
