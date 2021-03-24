<?php

namespace App\Loan_Investment;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $fillable = [
        'member_id','investment_no','investment_type_id','investment_behaviour','investment_amount','installment_count','downpayment','savings_per_installment','interest_rate','investment_return_amount','installment_amount','sanction_date','disburse_date','status'
    ];
}
