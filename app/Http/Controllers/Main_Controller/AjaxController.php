<?php

namespace App\Http\Controllers\Main_Controller;

use App\Accounts\Penalty;
use App\Http\Controllers\Controller;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Member;
use App\Member_model\MemberAccount;
use App\Member_model\Saving;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AccountSavingData($id)
    {
        $saving = Saving::where('id',$id)->first();

        $data=[
            'savingno'=>$saving->savings_no,
            'membername'=>$saving->member->name,
            'savingamount'=>$saving->savings_blanch,
        ];

        return response()->json($data);
    }

    public function PenaltyaddByMember($id)
    {
        $todayDate = time();
        $member = Member::where('id',$id)->first();
        $investment = $member->Loans()->where('status','1')->first();
        $panaltyamount = $investment->iRInstallments()->where('date','<=',date('Y-m-d',$todayDate))
            ->where('status','!=',"2")
            ->where('status','!=',"1")
            ->sum('rest_amount');

        $panaltycount = $investment->iRInstallments()->where('date','<=',date('Y-m-d',$todayDate))
            ->where('status','!=',"2")
            ->where('status','!=',"1")
            ->get();

        $data=[
            'installmentcount'=>count($panaltycount),
            'panaltyamount'=>$panaltyamount,
            'membername'=>$member->name,
            'investmentno'=>$investment->investment_no,
        ];
        return response()->json($data);
    }

    public function AdjustInvestment($id)
    {
        $member = Member::where('id',$id)->first();
        $investment = $member->Loans()->where('status','1')->first();
        $due_installment = $investment->iRInstallments()->where('status',0)->get();

        $memberac = MemberAccount::where('member_id',$id)->first();
        $penalty = Penalty::where('member_id',$id)->sum('penalty');

        $data=[
            'installmentcount'=>count($due_installment),
            'installment_rest'=>$memberac->rest_investment+$penalty,
            'membername'=>$member->name,
            'investmentno'=>$investment->investment_no,
        ];

        return response()->json($data);
    }

}
