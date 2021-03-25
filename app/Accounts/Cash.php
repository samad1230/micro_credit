<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class Cash extends Model
{
    protected $fillable = ['date', 'description', 'dr', 'cr'];
}
