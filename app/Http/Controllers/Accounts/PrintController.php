<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Loan_Investment\InvestmentReturnInstallment;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function CollectionStatusprint()
    {
        if (isset($_COOKIE["CollectionStatusSearch"])){

            $statusdata = explode(",,", $_COOKIE["CollectionStatusSearch"]);
            $stat = $statusdata[0];
            $start = $statusdata[1];
            $end = $statusdata[2];

            if($stat){
                if ($stat=="due"){
                    $status= "0";
                }else{
                    $status= $stat;
                }
            }else{
                $status="";
            }
            if($start){
                $startdate=  $start;
            }else{
                $startdate="";
            }
            if($end){
                $enddate= $end;
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
            return view('Print_page.collection_status_print',compact('installments'));
        }

    }

}
