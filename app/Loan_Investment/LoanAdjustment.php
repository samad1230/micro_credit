<?php

namespace App\Loan_Investment;

use App\Accounts\Cash;
use App\Accounts\Collection;
use App\Accounts\Penalty;
use App\Member_model\Member;
use App\Member_model\MemberAccount;
use App\Member_model\MemberCloseLoan;
use Illuminate\Database\Eloquent\Model;

class LoanAdjustment extends Model
{
   public function LoanAdjustmentFinal($id,$Installment_dueAmount,$Payment,$discount,$savingamount,$investno)
   {
       if ($savingamount==null){
           $SavingAmountclose=0;
       }else{
           $SavingAmountclose=$savingamount;
       }
       $investment_payment = $Payment + $SavingAmountclose;
       $allpayment = $investment_payment + $discount;


       $memberac = MemberAccount::where('member_id',$id)->first();
       $investments = Investment::where(['member_id'=>$id,'status'=>"1"])->first();

       $memberaccount= MemberAccount::find($memberac->id);
       $penalty = Penalty::where('member_id',$id)->sum('penalty');

       $loanClose = new MemberCloseLoan();
       $loanClose->member_id=$memberac->id;
       $loanClose->invest_no=$investments->investment_no;
       $loanClose->return_investment=$memberaccount->return_investment;
       $loanClose->investment_pay=$memberac->investment_pay + $Payment;
       $loanClose->penalty=$penalty;
       $loanClose->discount_payment=$discount;
       $loanClose->saving_close=$SavingAmountclose;
       $loanClose->save();

       $memberaccount->return_investment= 0;
       $memberaccount->discount_payment= 0;
       $memberaccount->rest_investment= 0;
       $memberaccount->investment_pay= 0;
       $memberaccount->save();


       $cash = new Cash();
       $cash->date = date('Y-m-d',time());
       $cash->description = 'Investment Return installment taken under '.$memberac->member->name;
       $cash->dr = number_format(intval($investment_payment),'2','.','');
       $cash->save();


       $cashcollent = new Collection();
       $cashcollent->voucher_no="#ADJ : ".$memberac->id;
       $cashcollent->member_id=$memberac->id;
       $cashcollent->date=date('Y-m-d',time());
       $cashcollent->installment_amount=$investment_payment;
       $cashcollent->save();



       $installment = InvestmentReturnInstallment::where(['status'=>"0",'investment_id'=>$investments->id])->first();

       $installment->collection_amount = intval($allpayment);
       $installment->rest_amount = 0;
       $installment->status = "1";
       $installment->save();

       $advanceAmount =  $allpayment - $installment->installment_amount;
       $nextInstallments = $installment->investment->iRInstallments()->where('status',"0")->orderBy('id','asc')->get();

       for ($x=0; $x < count($nextInstallments); $x++) {

           if ($advanceAmount == $nextInstallments[$x]->rest_amount) {
               $installment = $nextInstallments[$x];
               $installment->rest_amount = 0;
               $installment->status = "1";
               $installment->save();
               break;
           } elseif ($advanceAmount > $nextInstallments[$x]->rest_amount) {
               $installment = $nextInstallments[$x];
               $installment->rest_amount = 0;
               $installment->status = "1";
               $installment->save();
           } else {
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

       $investments = Investment::where('investment_no',$investno)->first();
       $investments->status="2";
       $investments->save();

       $menber = Member::find($id);
       $menber->status="0";
       $menber->save();


       Penalty::where('member_id',$id)->delete();


    return "Done";
   }
}
