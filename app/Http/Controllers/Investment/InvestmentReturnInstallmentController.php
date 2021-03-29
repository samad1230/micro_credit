<?php

namespace App\Http\Controllers\Investment;

use App\Accounts\Cash;
use App\Accounts\Collection;
use App\Http\Controllers\Controller;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\MemberAccount;
use App\Member_model\Saving;
use App\Member_model\SavingAccount;
use Illuminate\Http\Request;


class InvestmentReturnInstallmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function installmentInsert(Request $request){

        $installment = InvestmentReturnInstallment::where(['voucher_no'=>$request->voucher_no, 'status'=>"0"])->first();

        if($installment->rest_amount == intval($request->collection)){

            $installment->collection_amount = intval($request->collection);
            $installment->rest_amount = 0;
            $installment->status = "1";
            $installment->save();

            $cash = new Cash();
            $cash->date = date('Y-m-d',time());
            $cash->description = 'Investment Return installment taken under '.$request->voucher_no;
            $cash->dr = number_format(intval($request->collection),'2','.','');
            $cash->save();

            $memberaccount= MemberAccount::find($installment->investment->member->memberAccount->id);
            $memberaccount->investment_pay= $memberaccount->investment_pay + intval($request->collection);
            $memberaccount->rest_investment= $memberaccount->rest_investment - intval($request->collection);
            $memberaccount->save();

            $cashcollent = new Collection();
            $cashcollent->voucher_no=$request->voucher_no;
            $cashcollent->member_id=$installment->investment->member->id;
            $cashcollent->date=date('Y-m-d',time());
            $cashcollent->installment_amount=intval($request->collection);
            $cashcollent->save();

            return response()->json('success');

        } elseif ($installment->rest_amount > intval($request->collection)){

            $restAmount = $installment->rest_amount - intval($request->collection);
            $installment->collection_amount = intval($request->collection);
            $installment->rest_amount = $restAmount;
            $installment->status = "1";
            $installment->save();

            $cash = new Cash();
            $cash->date = date('Y-m-d',time());
            $cash->description = 'Investment Return installment taken under '.$request->voucher_no;
            $cash->dr = number_format(intval($request->collection),'2','.','');
            $cash->save();

            $nextInstallment = $installment->investment->iRInstallments()->where('status',"0")->orderBy('id','asc')->first();
            $nextInstallment->rest_amount = $nextInstallment->rest_amount + $restAmount;
            $nextInstallment->save();

            $memberaccount= MemberAccount::find($installment->investment->member->memberAccount->id);
            $memberaccount->investment_pay= $memberaccount->investment_pay + intval($request->collection);
            $memberaccount->rest_investment= $memberaccount->rest_investment - intval($request->collection);
            $memberaccount->save();

            $cashcollent = new Collection();
            $cashcollent->voucher_no=$request->voucher_no;
            $cashcollent->member_id=$installment->investment->member->id;
            $cashcollent->date=date('Y-m-d',time());
            $cashcollent->installment_amount=intval($request->collection);
            $cashcollent->save();

            return response()->json('success');

        }else{

            $installment->collection_amount = intval($request->collection);
            $installment->rest_amount = 0;
            $installment->status = "1";
            $installment->save();

            $cash = new Cash();
            $cash->date = date('Y-m-d',time());
            $cash->description = 'Investment Return installment taken under '.$request->voucher_no;
            $cash->dr = number_format(intval($request->collection),'2','.','');
            $cash->save();

            $memberaccount= MemberAccount::find($installment->investment->member->memberAccount->id);
            $memberaccount->investment_pay= $memberaccount->investment_pay + intval($request->collection);
            $memberaccount->rest_investment= $memberaccount->rest_investment - intval($request->collection);
            $memberaccount->save();

            $cashcollent = new Collection();
            $cashcollent->voucher_no=$request->voucher_no;
            $cashcollent->member_id=$installment->investment->member->id;
            $cashcollent->date=date('Y-m-d',time());
            $cashcollent->installment_amount=intval($request->collection);
            $cashcollent->save();

            $advanceAmount =  intval($request->collection) - $installment->installment_amount;
            $nextInstallments = $installment->investment->iRInstallments()->where('status',"0")->orderBy('id','asc')->get();

            for ($x=0; $x < count($nextInstallments); $x++){

                if($advanceAmount == $nextInstallments[$x]->rest_amount){
                    $installment = $nextInstallments[$x];
                    $installment->rest_amount = 0;
                    $installment->status = "1";
                    $installment->save();
                    break;
                }elseif ($advanceAmount > $nextInstallments[$x]->rest_amount){
                    $installment = $nextInstallments[$x];
                    $installment->rest_amount = 0;
                    $installment->status = "1";
                    $installment->save();
                }else{
                    $installment = $nextInstallments[$x];
                    $installment->rest_amount = $installment->rest_amount - $advanceAmount;
                    $installment->status = "0";
                    $installment->save();
                    break;
                }

                if (count($nextInstallments) != $x) {
                    $advanceAmount = $advanceAmount - $nextInstallments[$x]->installment_amount;
                }
            }
            return response()->json('success');
        }
        return response()->json('error');
    }

    public function SavingInstallment(Request $request)
    {
        $installment = InvestmentReturnInstallment::where(['voucher_no'=>$request->voucher_no])->first();

        $savingdata = Saving::where('id',$installment->investment->member->saveingac->id)->first();

        $saving= Saving::find($installment->investment->member->saveingac->id);
        $saving->savings_amount= $saving->savings_amount +intval($request->collection);

          if($saving->savings_profit == 0) {
              $saving->total_amount= $savingdata->savings_amount +intval($request->collection);
          }else{
              $saving->total_amount= $savingdata->savings_amount +intval($request->collection) + $savingdata->savings_profit;
          }

          if ($saving->savings_windrow == 0){
              $totalsaveamount = $savingdata->savings_amount + $savingdata->savings_profit +intval($request->collection);
              $saving->savings_blanch=$totalsaveamount;
          }else{
              $totalsaveamount = $savingdata->savings_amount + $savingdata->savings_profit +intval($request->collection);
              $savings_blanch = $totalsaveamount - $savingdata->savings_windrow;
              $saving->savings_blanch= $savings_blanch;
          }
         $saving->save();

        $saveCollection = new SavingAccount();
        $saveCollection->voucher_no=$request->voucher_no;
        $saveCollection->saving_id=$savingdata->id;
        $saveCollection->member_id=$savingdata->member_id;
        $saveCollection->date= date('Y-m-d',time());
        $saveCollection->amount= intval($request->collection);
        $saveCollection->save();

        $cash = new Cash();
        $cash->date = date('Y-m-d',time());
        $cash->description = 'Saving taken under '.$request->voucher_no;
        $cash->dr = number_format(intval($request->collection),'2','.','');
        $cash->save();

        $memberaccount= MemberAccount::find($installment->investment->member->memberAccount->id);
        $memberaccount->saving_amount= $memberaccount->saving_amount + intval($request->collection);
        $memberaccount->save();

        return response()->json('success');

    }


}
