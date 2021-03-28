<?php

namespace App\Http\Controllers\Main_Controller;

use App\Accounts\Capital;
use App\Accounts\Cash;
use App\Http\Controllers\Controller;
use App\Loan_Investment\Investment;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Guardian;
use App\Member_model\Member;
use App\Member_model\SavingCollection;
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

    public function addNewInvestment(){
        $cashDrBalance = Cash::all()->sum('dr');
        $cashcrBalance = Cash::all()->sum('cr');
        $cashAtHand = $cashDrBalance - $cashcrBalance;

        $members = Member::where('status',"0")->get();

        $investAmount = Investment::all()->sum('investment_amount');
        $dwnpayment = Investment::all()->sum('downpayment');
        $cashAtHand = $cashAtHand - 1000;
        return view('Investment.add-new_investment',compact('cashAtHand', 'members'));
    }


    public function PendingInvestment()
    {
        $cashDrBalance = Cash::all()->sum('dr');
        $cashcrBalance = Cash::all()->sum('cr');
        $cashAtHand = $cashDrBalance - $cashcrBalance;
        $investments = Investment::where('status','0')->get();
        return view('Investment.pending-investment',compact('investments','cashAtHand'));
    }

    public function ActiveAllInvestment()
    {
        $investments = Investment::where('status','1')->get();
        return view('Investment.active-investment',compact('investments'));
    }

    public function singelInvestment($investmentNo){
        $investment = Investment::where('investment_no',$investmentNo)->first();
        $guardians = $investment->member->guardians()->where('investment_for',$investmentNo)->get();
        $installments = $investment->iRInstallments()->orderBy('id','asc')->get();
        return view('Investment.singel-investment',compact('investment','guardians','installments'));

    }

    public function GuardianView($id)
    {
        $guardians = Guardian::where('id',$id)->first();
        return view('Investment.guargian-view',compact('guardians'));
    }

    public function DailyInstallment()
    {
        $todayDate = time();
        $installments = InvestmentReturnInstallment::where('status',"0")
            ->where('date','<=',date('Y-m-d',$todayDate))
            ->get();

        return view('Investment.daily-investment_view',compact('installments'));
    }


}
