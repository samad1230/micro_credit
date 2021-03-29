<?php

namespace App\Accounts;

use App\Member_model\Member;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable =[
        'voucher_no','member_id','date','installment_amount'
    ];

    public function member(){
        return $this->belongsTo(Member::class);
    }
}
