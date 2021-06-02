<?php

namespace App\Product_model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        'product_name','product_details','buy_price','sell_price','warranty','purchase_date','sell_date','investment_no','member_id','status','user_id'
    ];

    public function member()
    {
        return $this->belongsTo('App\Member_model\Member');
    }

    public function user()
    {
        return $this->belongsTo('App\Users');
    }
}
