<?php

namespace App\Accounts;

use Illuminate\Database\Eloquent\Model;

class ExpenseModel extends Model
{
    protected $fillable = ['date', 'description', 'dr', 'cr'];
}
