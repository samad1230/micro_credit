<?php

namespace App\Member_model;

use App\Loan_Investment\GuardianImage;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    protected $fillable = [
        'member_id','name','father_name','phone','nid_no','relational_status','present_address','permanent_address','investment_for'

    ];

    public function member(){
        return $this->belongsTo(Member::class);
    }

    public function guardianimages(){
        return $this->hasOne(GuardianImage::class);
    }
}
