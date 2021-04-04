<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
   protected $fillable = [
       'member_id','voucher_no','investment_id','penalty','date','user_id'
   ];

    public function member()
    {
        return $this->belongsTo('App\Member_model\Member');
    }



}
