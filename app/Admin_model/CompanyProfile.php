<?php

namespace App\Admin_model;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $fillable =[
        'name','address','contact','license','owner','vat','image'
    ];


}
