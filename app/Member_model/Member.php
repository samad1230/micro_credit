<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable =[
        'member_no','name','mobile','father_name','mother_name','occupation','age','gender','religion','marital_status','present_address','permanent_address','join_date','status','user_id','slag'
    ];

}
