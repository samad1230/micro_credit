<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $fillable = [
        'member_id','savings_no','savings_amount','savings_profit','total_amount','savings_windrow','savings_blanch','status','opening_date'
    ];
}
