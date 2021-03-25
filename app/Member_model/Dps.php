<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class Dps extends Model
{
    protected  $fillable = [
        'member_id','dps_type','dps_no','dps_installment','dps_amount','dps_profit','total_amount','dps_windrow','dps_blanch','status','opening_date'

    ];
}
