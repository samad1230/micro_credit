<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Capital;
use App\Accounts\Cash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CapitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function capitalIntroduce(Request $request){

        $this->validate($request,[
            'description' => 'required|min:1',
            'amount' => 'required|min:1'
        ]);

        if(count($request->description) != count($request->amount)){
            $notification = array(
                'message' => 'Invalid Entry!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

//        dd(number_format(intval($request->amount[0]),'2','.',''));
        $savedDataCount = 0;
        for ($i = 0; $i < count($request->description); $i++){
            if($request->description[$i] != null && $request->amount[$i] && intval($request->amount[$i]) > 0){
                $capitalIntroduce = new Capital();
                $capitalIntroduce->date = date('Y-m-d',time());
                $capitalIntroduce->description = 'Capital introduced by '.$request->description[$i];
                $capitalIntroduce->cr = number_format(intval($request->amount[$i]),'2','.','');
                $capitalIntroduce->save();

                $cash = new Cash();
                $cash->date = date('Y-m-d',time());
                $cash->description = 'Capital introduced by '.$request->description[$i];
                $cash->dr = number_format(intval($request->amount[$i]),'2','.','');
                $cash->save();

                $savedDataCount++;
            }
        }

        $notification = array(
            'message' => $savedDataCount.' Entry has been saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }


    public function capitalWithdrawal(Request $request){

        $this->validate($request,[
            'description' => 'required|min:1',
            'amount' => 'required|min:1'
        ]);

        if(count($request->description) != count($request->amount)){
            $notification = array(
                'message' => 'Invalid Entry!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        $total = 0;
        for($a = 0; $a < count($request->amount); $a++){
            $total = $total + intval($request->amount[$a]);
        }
        $cashDrBalance = Cash::all()->sum('dr');
        $cashcrBalance = Cash::all()->sum('cr');
        $cashAtHand = $cashDrBalance - $cashcrBalance;
        if($cashAtHand < $total){
            $notification = array(
                'message' => 'Don\'t have sufficient amount!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        $savedDataCount = 0;
        for ($i = 0; $i < count($request->description); $i++){
            if($request->description[$i] != null && $request->amount[$i] && intval($request->amount[$i]) > 0){
                $capitalIntroduce = new Capital();
                $capitalIntroduce->date = date('Y-m-d',time());
                $capitalIntroduce->description = 'Capital withdrawal by '.$request->description[$i];
                $capitalIntroduce->dr = number_format(intval($request->amount[$i]),'2','.','');
                $capitalIntroduce->save();

                $cash = new Cash();
                $cash->date = date('Y-m-d',time());
                $cash->description = 'Capital withdrawal by '.$request->description[$i];
                $cash->cr = number_format(intval($request->amount[$i]),'2','.','');
                $cash->save();

                $savedDataCount++;
            }
        }

        $notification = array(
            'message' => $savedDataCount.' Entry has been saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

}
