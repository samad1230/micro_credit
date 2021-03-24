<?php

namespace App\Loan_Investment;

use Illuminate\Database\Eloquent\Model;

class InvestmentProduct extends Model
{
    protected $fillable = [
        'member_id','investment_no','product','product_details'
    ];
}
