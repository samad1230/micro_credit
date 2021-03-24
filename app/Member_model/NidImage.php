<?php

namespace App\Member_model;

use Illuminate\Database\Eloquent\Model;

class NidImage extends Model
{
    protected $fillable = [
        'member_id','nuid_no','nuid_image','member_image'
    ];
}
