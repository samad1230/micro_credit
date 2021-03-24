<?php

namespace App\Loan_Investment;

use Illuminate\Database\Eloquent\Model;

class InvestmentReturnInstallment extends Model
{
    protected $fillable = [
        'investment_id','date','voucher_no','installment_amount','collection_amount','rest_amount','installment_profit','status'
    ];
}
