<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Loan_Investment\InvestmentReturnInstallment;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CollectionStatusSearch(Request $request)
    {
            if($request->status){
                if ($request->status=="due"){
                    $status= "0";
                }else{
                    $status= $request->status;
                }
            }else{
                $status="";
            }
            if($request->startdate){
                $startdate=  $request->startdate;
            }else{
                $startdate="";
            }
            if($request->enddate){
                $enddate= $request->enddate;
            }else{
                $enddate="";
            }

            if ($status !=null && $startdate !=null && $enddate !=null){
                $installments = InvestmentReturnInstallment::where('status',$status)
                ->where('date', '>=', $startdate)
                ->where('date', '<=', $enddate)
                ->paginate(20);
            }elseif ($status ==null && $startdate !=null && $enddate !=null){
                $installments = InvestmentReturnInstallment::where('date', '>=', $startdate)
                    ->where('date', '<=', $enddate)
                    ->paginate(20);
            }else{
                $todayDate = time();
                $installments = InvestmentReturnInstallment::where('date','<=',date('Y-m-d',$todayDate))
                    ->where('status','!=',"1")
                    ->orderBy('date','DESC')->paginate(20);
            }

            setcookie("CollectionStatusSearch", $status . ",," . $startdate. ",," . $enddate, time() + (300), "/");

            return view('Report_page.investment_status_view',compact('installments'));
        }

}
