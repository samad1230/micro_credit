<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class MemberCloseLoan extends Model
{
   protected $fillable = [
       'member_id',
'invest_no',
'return_investment',
'investment_pay',
'discount_payment',
'penalty',
'saving_close',
   ];

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
