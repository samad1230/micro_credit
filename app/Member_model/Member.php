<?php

namespace App\Member_model;

use App\Loan_Investment\Investment;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable =[
        'member_no','name','ledgerid','mobile','father_name','husband_name','mother_name','occupation','age','gender','religion','marital_status','present_address','permanent_address','join_date','status','user_id','slag'
    ];

    public function nidImage()
    {
        return $this->hasOne('App\Member_model\NidImage');
    }

    public function saveingmem()
    {
        return $this->hasOne('App\Member_model\Saving');
    }

    public function Loans(){
        return $this->hasMany(Investment::class);
    }


    public function guardians(){
        return $this->hasMany(Guardian::class);
    }

    public function memberAccount()
    {
        return $this->hasOne('App\Member_model\MemberAccount');
    }

    public function accounts()
    {
        return $this->hasMany('App\Collection\Accounts');
    }

    public function saveingac()
    {
        return $this->hasOne('App\Member_model\Saving');
    }

    public function savingAccounts()
    {
        return $this->hasMany('App\Member_model\SavingAccount');
    }

    public function penaltys()
    {
        return $this->hasMany('App\Accounts\Penalty');
    }

    public function nominee()
    {
        return $this->hasOne('App\Member_model\Nominee');
    }

    public function memberCloseLoans()
    {
        return $this->hasMany('App\Member_model\MemberCloseLoan');
    }

    public function product()
    {
        return $this->hasOne('App\Product_model\Product');
    }

}
