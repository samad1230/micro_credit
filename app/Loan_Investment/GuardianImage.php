<?php

namespace App\Loan_Investment;

use App\Member_model\Guardian;
use Illuminate\Database\Eloquent\Model;

class GuardianImage extends Model
{
    protected $fillable=[
        'image','nid_no','guardian_id'
    ];

    public function guardian(){
        return $this->belongsTo(Guardian::class);
    }
}
