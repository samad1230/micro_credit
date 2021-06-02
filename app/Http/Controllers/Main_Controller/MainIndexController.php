<?php

namespace App\Http\Controllers\Main_Controller;

use App\Accounts\Capital;
use App\Accounts\Cash;
use App\Accounts\Collection;
use App\Accounts\Penalty;
use App\Http\Controllers\Controller;
use App\Loan_Investment\Investment;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Collectionsaving;
use App\Member_model\Guardian;
use App\Member_model\Member;

use App\Member_model\MemberAccount;
use App\Member_model\MemberCloseLoan;
use App\Member_model\Saving;
use App\Member_model\SavingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('Register_page.cash_view',compact('cashAtHand','cashs','cashcrBalance','cashDrBalance'));
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
        $installmentlastdate = $investment->iRInstallments()->orderBy('id','DESC')->first();

        $panaltyBalance = 0;
        foreach ($investment->member->penaltys->where('status','0') as $data){
            $panaltyBalance += $data->penalty;
        }

        $restamount = 0;
        $collection_amount= 0;
        foreach ($installments as $last){
            $restamount += $last->rest_amount;
            $collection_amount += $last->collection_amount;
        }

        return view('Investment.singel-investment',compact('investment','guardians','installments','installmentlastdate','panaltyBalance','restamount','collection_amount'));

    }

    public function GuardianView($id)
    {
        $guardians = Guardian::where('id',$id)->first();
        return view('Investment.guargian-view',compact('guardians'));
    }

    public function DailyInstallment()
    {
        $todayDate = time();
        $installments = InvestmentReturnInstallment::where('date','<=',date('Y-m-d',$todayDate))
            ->where('status','!=',"2")
            ->where('status','!=',"1")
            //->orderBy('date','DESC')
            ->paginate(20);

        $today_installment_due = InvestmentReturnInstallment::where('date','<=',date('Y-m-d',$todayDate))
            ->where('status','!=','1')
            ->sum('installment_amount');

        $today_installment_sum = InvestmentReturnInstallment::where('date','=',date('Y-m-d',$todayDate))->sum('installment_amount');

        $today_collention_sum = Collection::where('date','=',date('Y-m-d',$todayDate))->sum('installment_amount');

        $today_saving_sum = SavingAccount::where('date','=',date('Y-m-d',$todayDate))
            ->sum('amount');

        $today_penalty_sum = Cash::where('date','=',date('Y-m-d',$todayDate)) ->where('description', 'LIKE', '%' . "Penalty Return taken under" . '%')->sum('dr');



        return view('Investment.daily-investment_view',compact('installments','today_installment_due','today_installment_sum','today_collention_sum','today_saving_sum','today_penalty_sum'));
    }


    public function InstallmentAmountdata($id)
    {
        $newid = "#".$id;
        $allinvestment = InvestmentReturnInstallment::where('voucher_no',$newid)->first();

        $data=[
            'voucher_no'=>$allinvestment->voucher_no,
            'membername'=>$allinvestment->investment->member->name,
        ];
        return response()->json($data);
    }


    public function MemberSavingAc()
    {
        $saving = Saving::where('status','1')->orderBy('id','DESC')->get();
        return view('Member_pages.member_saving',compact('saving'));
    }

    public function MemberSavingAccount_details($id)
    {
        $saving = SavingAccount::where('saving_id',$id)->orderBy('date','DESC')->get();
        return view('Member_pages.member_saving_details',compact('saving'));
    }


    public function AccountForMember()
    {
        $members = MemberAccount::orderBy('id','DESC')->paginate(15);
        return view('Member_pages.member_accounts',compact('members'));
    }

    public function AccountDetailForMember($slag)
    {
        $member = Member::where('slag',$slag)->first();
        $investment = Investment::where('member_id',$member->id)->where('status',1)->first();
        //$investment = Investment::where('member_id',$member->id)->first();
        $investpaid = InvestmentReturnInstallment::where('investment_id',$investment->id)->sum('collection_amount');
        $investdue = InvestmentReturnInstallment::where('investment_id',$investment->id)->where('status','!=','1')->sum('rest_amount');
        $investpanalti = Penalty::where('investment_id',$investment->id)->where('status','0')->sum('penalty');

        $totaldue = InvestmentReturnInstallment::where('investment_id',$investment->id)->where('status',0)->count();
        $totalpaid = InvestmentReturnInstallment::where('investment_id',$investment->id)->where('status',1)->count();
        $totalpnalti = InvestmentReturnInstallment::where('investment_id',$investment->id)->where('status',2)->count();

        $installments = $investment->iRInstallments()->where('status','!=','1')->orderBy('id','asc')->get();

        return view('Member_pages.single_member_Accounts_details',compact('member','investment','investpaid','investdue','investpanalti','totaldue','totalpaid','totalpnalti','installments'));
    }


    public function InvestCloseDetails()
    {
        $members = MemberCloseLoan::orderBy('id','DESC')->paginate(15);
        return view('Investment.Closeing_Investment',compact('members'));
    }

    public function CloseLoneDetailsView($investmentNo)
    {
        $investment = Investment::where('investment_no',$investmentNo)->first();
        $installments = $investment->iRInstallments()->orderBy('id','asc')->get();
        $installmentlastdate = $investment->iRInstallments()->orderBy('id','DESC')->first();

        $panaltyBalance = 0;
        foreach ($investment->member->penaltys as $data){
            $panaltyBalance += $data->penalty;
        }

        $restamount = 0;
        $collection_amount= 0;
        foreach ($installments as $last){
            $restamount += $last->rest_amount;
            $collection_amount += $last->collection_amount;
        }

        $closeingdata = MemberCloseLoan::where('invest_no',$investmentNo)->first();

        return view('Investment.close_invest_details',compact('investment','installments','installmentlastdate','panaltyBalance','restamount','collection_amount','closeingdata'));
    }

    public function DetailsPenalty()
    {
        $penaltydata = Penalty::select('member_id', DB::raw('SUM(penalty) as penaltyamount '))
            ->where('status','0')
            ->groupBy('member_id')
            ->get();
        return view('Investment.user_penaty_detail',compact('penaltydata'));
    }

    public function SinglePenaltyShow($id)
    {
        $penaltydata = Penalty::where('member_id',$id)->get();
        return view('Investment.single_penaty_show',compact('penaltydata'));
    }

    public function CollectionStatus()
    {
        $todayDate = time();
        $installments = InvestmentReturnInstallment::where('date','<=',date('Y-m-d',$todayDate))
            ->where('status','!=',"1")
            ->orderBy('date','DESC')->paginate(20);
        return view('Report_page.investment_status_view',compact('installments'));
    }




}
