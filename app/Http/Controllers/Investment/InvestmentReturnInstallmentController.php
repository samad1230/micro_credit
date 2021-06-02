<?php

namespace App\Http\Controllers\Investment;

use App\Accounts\Cash;
use App\Accounts\Collection;
use App\Accounts\Penalty;
use App\Http\Controllers\Controller;
use App\Loan_Investment\Investment;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Member;
use App\Member_model\MemberAccount;
use App\Member_model\MemberCloseLoan;
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


       $collection= $request->collection;
       $previusdue= $request->previusdue;
       $penalty_collection= $request->penalty_collection;

        $memberdata = InvestmentReturnInstallment::where(['voucher_no'=>$request->voucher_no])->first();

        $intallment = InvestmentReturnInstallment::where('investment_id',$memberdata->investment->id)->where('status','!=','1')->sum('rest_amount');

        $penalty = Penalty::where(['member_id'=>$memberdata->investment->member_id,'status'=>"0"])->sum('penalty');
        $installment = InvestmentReturnInstallment::where(['voucher_no'=>$request->voucher_no])->first();

        if ($penalty_collection !=null){

            $penaltydata =Penalty::where(['member_id'=>$memberdata->investment->member_id,'status'=>"0"])->first();

            if($penaltydata->penalty == intval($request->penalty_collection)){

                $cash = new Cash();
                $cash->date = date('Y-m-d',time());
                $cash->description = 'Penalty Return taken under '.$request->voucher_no;
                $cash->dr = number_format(intval($request->penalty_collection),'2','.','');
                $cash->save();

                $penaltydata->status = 1;
                $penaltydata->save();


            }elseif($penaltydata->penalty > intval($request->penalty_collection)){

                $cash = new Cash();
                $cash->date = date('Y-m-d',time());
                $cash->description = 'Penalty Return taken under '.$request->voucher_no;
                $cash->dr = number_format(intval($request->penalty_collection),'2','.','');
                $cash->save();

                $restAmount = $penaltydata->penalty - intval($request->penalty_collection);
                $penaltydata->penalty = $restAmount;
                $penaltydata->status = 0;
                $penaltydata->save();

            }else{
                $cash = new Cash();
                $cash->date = date('Y-m-d',time());
                $cash->description = 'Penalty Return taken under '.$request->voucher_no;
                $cash->dr = number_format(intval($request->penalty_collection),'2','.','');
                $cash->save();

                $penaltydata->status = "1";
                $penaltydata->save();

                $advanceAmountpenalty =  intval($request->penalty_collection) - $penaltydata->penalty;

                $nextpenaltydata = Penalty::where(['member_id'=>$memberdata->investment->member_id,'status'=>"0"])->orderBy('id','asc')->get();


                for ($v=0; $v < count($nextpenaltydata); $v++){

                    if($advanceAmountpenalty == $nextpenaltydata[$v]->penalty){
                        $penaltydata = $nextpenaltydata[$v];
                        $penaltydata->status = "1";
                        $penaltydata->save();
                        break;
                    }elseif ($advanceAmountpenalty > $nextpenaltydata[$v]->penalty){
                        $penaltydata = $nextpenaltydata[$v];
                        $penaltydata->status = "1";
                        $penaltydata->save();
                    }else{
                        $penaltydata = $nextpenaltydata[$v];
                        $penaltydata->penalty = $penaltydata->penalty - $advanceAmountpenalty;
                        $penaltydata->status = "0";
                        $penaltydata->save();
                        break;
                    }

                    if (count($nextpenaltydata) != $v) {
                        $advanceAmountpenalty = $advanceAmountpenalty - $nextpenaltydata[$v]->penalty;
                    }

                }

            }

        }

        if ($request->collection !=null){
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

                // return response()->json('success');

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

                //return response()->json('success');

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

                if ($collection > $previusdue){
                    $nextInstallments = $installment->investment->iRInstallments()->where('status','!=',"1")->orderBy('id','asc')->get();
                }elseif($collection < $previusdue){
                    $nextInstallments = $installment->investment->iRInstallments()->where('status','!=',"1")->orderBy('id','asc')->get();
                }else{
                    $nextInstallments = $installment->investment->iRInstallments()->where('status',"0")->orderBy('id','asc')->get();
                }

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

                $intallmentTotal = $intallment + $penalty;

                if ($intallmentTotal == intval($request->collection)){
                    $memberaccount= MemberAccount::find($memberdata->investment->member_id);

                    $loanClose = new MemberCloseLoan();
                    $loanClose->member_id=$memberdata->investment->member_id;
                    $loanClose->invest_no=$memberdata->investment->investment_no;
                    $loanClose->return_investment=$memberaccount->return_investment;
                    $loanClose->investment_pay=$memberaccount->investment_pay;
                    $loanClose->penalty=$penalty;
                    $loanClose->discount_payment=0;
                    $loanClose->saving_close=0;
                    $loanClose->save();

                    $memberaccount->return_investment= 0;
                    $memberaccount->discount_payment= 0;
                    $memberaccount->rest_investment= 0;
                    $memberaccount->investment_pay= 0;
                    $memberaccount->save();

                    $invest = Investment::where('investment_no',$memberdata->investment->investment_no)->first();
                    $invest->status="2";
                    $invest->save();

                    $menber = Member::find($memberdata->investment->member_id);
                    $menber->status="0";
                    $menber->save();

                    Penalty::where('member_id',$memberdata->investment->member_id)->delete();
                }

                //return response()->json('success');
            }
            $notification = array(
                'message' => 'Collection Added successfully!',
                'alert-type' => 'success'
            );
            return back()->with($notification);
        }else{
            $notification = array(
                'message' => 'Collection Added not successfully!',
                'alert-type' => 'warning'
            );
            return back()->with($notification);
        }

       // return response()->json('error');
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
