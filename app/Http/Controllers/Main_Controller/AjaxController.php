<?php

namespace App\Http\Controllers\Main_Controller;

use App\Accounts\Penalty;
use App\Http\Controllers\Controller;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Member;
use App\Member_model\MemberAccount;
use App\Member_model\Saving;
use App\Product_model\Product;
use Carbon\Carbon;
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


    public function InstallmentPenaltydata($id)
    {
        $newid = "#".$id;
        $allinvestment = InvestmentReturnInstallment::where('voucher_no',$newid)->first();

        $allvoucher = InvestmentReturnInstallment::where('investment_id',$allinvestment->investment_id)
            ->where('status',"2")
            ->orwhere('status',"0")
            ->get();

        $current = new Carbon();
        $today =  $current->format('Y-m-d');

        $x = 0;
        while($x < count($allvoucher)) {
            if ($today == $allvoucher[$x]->date) {
                break;
            }
            $investmentid[] = $allvoucher[$x]->id;
            $x++;
        }

        if (!empty($investmentid)){
            for ($i=0; count($investmentid) > $i; $i++ ){
                $previusinstallment_due[] = InvestmentReturnInstallment::where('id',$investmentid[$i])->get();
            }


            $previus_due=0;
            $vouchercount=0;

            for ($v=0; count($previusinstallment_due) > $v; $v++ ){
                $previus_due += $previusinstallment_due[$v][0]->rest_amount;
                $vouchercount = count($previusinstallment_due);
            }

            $previusdue=$previus_due;
            $voucher_count=$vouchercount;
        }else{
            $previusdue=0;
            $voucher_count=0;
        }

        $penalty = Penalty::where(['investment_id'=>$allinvestment->investment_id,'status'=>"0"])->sum('penalty');

        $data=[
            'voucher_no'=>$allinvestment->voucher_no,
            'membername'=>$allinvestment->investment->member->name,
            'installment'=>$allinvestment->installment_amount,
            'previusdue'=>$previusdue,
            'penaltydue'=>$penalty,
            'vouchercount'=>$voucher_count,
        ];

        return response()->json($data);
    }


    public function AllProductData()
    {
        $data = Product::where('status','0')->get();
        return response()->json($data);
    }

    public function AllProductDataByID($id)
    {
        $data = Product::where('id',$id)->first();
        return response()->json($data);
    }

}
