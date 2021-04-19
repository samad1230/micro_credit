<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class MemberAccount extends Model
{
   protected $fillable = [
       'member_id','saving_id','dps_id','return_investment','investment_pay','discount_payment','rest_investment','saving_amount','dps_amount'
   ];

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
