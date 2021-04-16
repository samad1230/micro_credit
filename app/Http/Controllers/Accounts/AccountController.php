<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Cash;
use App\Accounts\Penalty;
use App\Http\Controllers\Controller;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Member;
use App\Member_model\MemberAccount;
use App\Member_model\Saving;
use App\Member_model\SavingAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function PanaltiInsert(Request $request, $id)
    {
        $user_id =Auth::user()->id;
        $allinvestment = InvestmentReturnInstallment::where('voucher_no',$request->voucher)->first();

        $data = new Penalty();
        $data->member_id=$allinvestment->investment->member->id;
        $data->voucher_no=$request->voucher;
        $data->investment_id=$allinvestment->investment->id;
        $data->penalty=$request->PenaltyAmount;
        $data->date=date('Y-m-d',time());
        $data->user_id=$user_id;
        $data->save();

        $allinvestment->status="2";
        $allinvestment->save();

        $notification = array(
            'message' => 'Penalty info has been saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    }



    public function SavingCollectionSave(Request $request, $id)
    {

        $savingdata = Saving::where('id',$id)->first();

        $saveCollection = new SavingAccount();
        $saveCollection->voucher_no=$request->voucher_no;
        $saveCollection->saving_id=$id;
        $saveCollection->member_id=$savingdata->member_id;
        $saveCollection->date= date('Y-m-d',time());
        $saveCollection->amount= intval($request->savingAmount);
        $saveCollection->save();

        $cash = new Cash();
        $cash->date = date('Y-m-d',time());
        $cash->description = 'Saving taken under '.$savingdata->member->name;
        $cash->dr = number_format(intval($request->savingAmount),'2','.','');
        $cash->save();


        $saving= Saving::find($id);
        $saving->savings_amount= $saving->savings_amount +intval($request->savingAmount);

        if($saving->savings_profit == 0) {
            $saving->total_amount= $savingdata->savings_amount +intval($request->savingAmount);
        }else{
            $saving->total_amount= $savingdata->savings_amount +intval($request->savingAmount) + $savingdata->savings_profit;
        }

        if ($saving->savings_windrow == 0){
            $totalsaveamount = $savingdata->savings_amount + $savingdata->savings_profit +intval($request->savingAmount);
            $saving->savings_blanch=$totalsaveamount;
        }else{
            $totalsaveamount = $savingdata->savings_amount + $savingdata->savings_profit +intval($request->savingAmount);
            $savings_blanch = $totalsaveamount - $savingdata->savings_windrow;
            $saving->savings_blanch= $savings_blanch;
        }
        $saving->save();

        $memberac = MemberAccount::where('member_id',$savingdata->member_id)->first();

        if ($memberac==null){
            $memberaccount = new MemberAccount();
            $memberaccount->member_id=$savingdata->member_id;
            $memberaccount->saving_id=$savingdata->savings_no;
            $memberaccount->saving_amount=$request->savingAmount;
            $memberaccount->save();

        }else{
            $memberaccount= MemberAccount::find($memberac->id);
            $memberaccount->saving_amount= $memberaccount->saving_amount + intval($request->savingAmount);
            $memberaccount->save();
        }



        $notification = array(
            'message' => 'Saving Amount Saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    }


    public function SavingWithdrawalAmounts(Request $request,$id)
    {
        $savingdata = Saving::where('id',$id)->first();

        $cash = new Cash();
        $cash->date = date('Y-m-d',time());
        $cash->description = 'Saving Withdrawal under '.$savingdata->member->name;
        $cash->cr = number_format(intval($request->SavingsWithdrawalAmount),'2','.','');
        $cash->save();


        $saving= Saving::find($id);
        $saving->savings_windrow= $savingdata->savings_windrow + intval($request->SavingsWithdrawalAmount);
        $saving->savings_blanch = $savingdata->savings_blanch - intval($request->SavingsWithdrawalAmount);
        $saving->save();

        $memberac = MemberAccount::where('member_id',$savingdata->member_id)->first();

        $memberaccount= MemberAccount::find($memberac->id);
        $memberaccount->saving_amount= $memberaccount->saving_amount - intval($request->SavingsWithdrawalAmount);
        $memberaccount->save();


        $notification = array(
            'message' => 'Saving Amount Saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    public function InstallmentDuePenaltyCashSave(Request $request,$id)
    {
        $user_id =Auth::user()->id;
        $todayDate = time();
        $member = Member::where('id',$id)->first();
        $investment = $member->Loans()->where('status','1')->first();

        $investmentcount = $investment->iRInstallments()->where('date','<=',date('Y-m-d',$todayDate))
            ->where('status','!=',"2")
            ->where('status','!=',"1")
            ->get();
            $pnalty = $request->PenaltyAmount / count($investmentcount);
        for ($i=0; count($investmentcount) > $i; $i++){
            $data = new Penalty();
            $data->member_id=$id;
            $data->voucher_no=$investmentcount[$i]->voucher_no;
            $data->investment_id=$investment->id;
            $data->penalty=$pnalty;
            $data->date=date('Y-m-d',time());
            $data->user_id=$user_id;
            $data->save();

            $allinvestment = InvestmentReturnInstallment::where('voucher_no',$investmentcount[$i]->voucher_no)->first();
            $allinvestment->status="2";
            $allinvestment->save();
        }


        $notification = array(
            'message' => 'Penalty info has been saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }


    public function AdjustInvestment(Request $request,$id)
    {
        dd($request);
    }

}
