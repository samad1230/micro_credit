<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $fillable =[
        'voucher_no','member_id','date','installment_amount'
    ];
}
