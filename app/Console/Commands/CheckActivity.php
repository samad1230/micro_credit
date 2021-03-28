<?php

namespace App\Console\Commands;

use App\Accounts\Cash;
use App\Loan_Investment\Investment;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\MemberAccount;
use Illuminate\Console\Command;

class CheckActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:activity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will check all activity';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $cashDrBalance = Cash::all()->sum('dr');
        $cashcrBalance = Cash::all()->sum('cr');
        $cashAtHand = $cashDrBalance - $cashcrBalance - 1000;

        $todayDate = time();
        //check investment
       // $investments = Investment::where(['status'=>"0",'disburse_date'=>date('Y-m-d',$todayDate)])->get();

        $investments = Investment::where('status',"0")
            ->where('disburse_date','<=',date('Y-m-d',$todayDate))
            ->get();

        foreach ($investments as $investment){
            if($cashAtHand > $investment->investment_amount){
                for ($a = 0; $a <= $investment->installment_count; $a++ ){
                    if($a > 0) {
                        $installments = InvestmentReturnInstallment::all();
                        if (count($installments) == 0) {
                            $voucherNo = 1111;
                        } else {
                            $lastInstallment = InvestmentReturnInstallment::orderBy('id', 'DESC')->first();
                            $voucherNo = intval(str_replace('#', '', $lastInstallment->voucher_no)) + 1;
                        }
                        $investmentAmount = $investment->investment_amount;
                        if ($investment->downpayment != null) {
                            $investmentAmount = $investmentAmount - $investment->downpayment;
                        }
                        $interest = ($investmentAmount * $investment->interest_rate) / 100;
                        $installmentProfit = $interest / $investment->installment_count;

                        $duration = ($investment->investment_behaviour * $a) + 1;
                        $timestamp = time() + $duration * 24 * 60 * 60;

                        $installment = new InvestmentReturnInstallment();
                        $installment->investment_id = $investment->id;
                        $installment->date = date('Y-m-d', $timestamp);
                        $installment->voucher_no = '#' . $voucherNo;
                        $installment->installment_amount = $investment->installment_amount;
                        $installment->rest_amount = $investment->installment_amount;
                        $installment->installment_profit = $installmentProfit;
                        $installment->status = false;
                        $installment->save();
                    }
                }

                $investment->status = "1";
                $investment->save();

                $investmentAmount = $investment->investment_amount;
                if($investment->downpayment != null){
                    $investmentAmount = $investment->investment_amount - $investment->downpayment;
                }

                $memberaccount = MemberAccount::where('member_id',$investment->member->id)->first();
                $memberaccount->return_investment=$investmentAmount;
                $memberaccount->rest_investment=$investmentAmount;
                $memberaccount->save();

                $cash = new Cash();
                $cash->date = date('Y-m-d',time());
                $cash->description = 'Invest on '. $investment->member->name;
                $cash->cr = number_format($investmentAmount,'2','.','');
                $cash->save();
                sleep(3);
            }
        }
        //$installments = InvestmentReturnInstallment::all();
        //dd(count($investments));
    }

    //php artisan check:activity

}
