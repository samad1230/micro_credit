<?php

namespace App\Http\Controllers\Main_Controller;

use App\Accounts\Capital;
use App\Accounts\Cash;
use App\Http\Controllers\Controller;
use App\Member_model\Member;
use Illuminate\Http\Request;

class MainIndexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllMember()
    {
        $members = Member::all();
        return view('Member_pages.all_member',compact('members'));
    }

    public function CapitalDetails()
    {
        $capitalAtDr = Capital::all()->sum('dr');
        $capitalAtCr = Capital::all()->sum('cr');
        $capitals = Capital::orderBy('id','DESC')->paginate(15);
        return view('Register_page.capital_view',compact('capitals','capitalAtDr','capitalAtCr'));
    }

    public function CashDetails()
    {
        $cashDrBalance = Cash::all()->sum('dr');
        $cashcrBalance = Cash::all()->sum('cr');
        $cashAtHand = $cashDrBalance - $cashcrBalance;
        $cashs = Cash::orderBy('id','DESC')->paginate(15);
        return view('Register_page.cash_view',compact('cashAtHand','cashs'));
    }




}
