<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    protected $fillable = ['date', 'description', 'dr', 'cr'];
}
