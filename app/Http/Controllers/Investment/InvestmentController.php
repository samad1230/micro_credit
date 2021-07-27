<?php

namespace App\Http\Controllers\Investment;

use App\Accounts\Cash;
use App\Admin_model\CommonModel;
use App\Http\Controllers\Controller;
use App\Loan_Investment\GuardianImage;
use App\Loan_Investment\Investment;
use App\Loan_Investment\InvestmentProduct;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Guardian;
use App\Member_model\Member;
use App\Member_model\MemberAccount;
use App\Product_model\Product;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class InvestmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AddInvestment(Request $request){

        $member = Member::where('slag',$request->selected_member)->first();

        if ((count($member->guardians)) > 0){
            $this->validate($request,[
                'selected_member' => 'required',
                'investment_type' => 'required',
                'investment_behaviour' => 'required',
                'investment_amount' => 'required',
                'installment_count' => 'required',
                'interest_rate' => 'required',
                'sanction_date' => 'required',
                'disburse_date' => 'required',
            ]);
        }else{
            $this->validate($request,[
                'selected_member' => 'required',
                'guardian_name' => 'required|min:1|max:3',
                'guardian_phone' => 'required|min:1|max:3',
                'guardian_relation' => 'required|min:1|max:3',
                'guardian_nid_no' => 'required|min:1|max:3',
                'guardian_present_address' => 'required|min:1|max:3',
                'guardian_permanent_address' => 'required|min:1|max:3',
                'investment_type' => 'required',
                'investment_behaviour' => 'required',
                'investment_amount' => 'required',
                'installment_count' => 'required',
                'interest_rate' => 'required',
                'sanction_date' => 'required',
                'disburse_date' => 'required',
            ]);
        }



        $guardianNidImage = [];
        if($request->hasFile('guardian_nid_image')){
            foreach ($request->guardian_nid_image as $nid){
                $ImageType = $nid->getClientOriginalExtension();
                if ($ImageType != 'png'){
                    if ($ImageType != 'jpg'){
                        $notification = array(
                            'message' => 'Guardian NID image type is invalid! Image file should be png or jpg format.',
                            'alert-type' => 'error'
                        );

                        return back()->with($notification);
                    }
                }
                $guardianNidImage [] = $nid;
            }
        }
        if($request->has('guardian_name')){
            $dataCount = count($request->guardian_name);
            if ($dataCount != count($request->guardian_phone)&& $dataCount != count($request->father_name) && $dataCount != count($request->guardian_relation) && $dataCount != count($request->guardian_nid_no) && $dataCount != count($request->guardian_present_address) && $dataCount != count($request->guardian_permanent_address)){
                $notification = array(
                    'message' => 'You has been provide a wrong information about Guardian!',
                    'alert-type' => 'error'
                );

                return back()->with($notification);
            }
        }


        $no = time();
        $investmentNo = null;
        for($b = 0; $b < strlen($no); $b++){
            if($b == 3){
                $investmentNo = substr($no,0,3);
            }elseif ($b == 6){
                $investmentNo = $investmentNo . '-'. substr($no,3,3);
            }elseif ($b == 7){
                $investmentNo = $investmentNo . '-'. substr($no,6,strlen($no));
            }
        }

        $investmentAmount = $request->investment_amount;
        $interestRate = str_replace('%','',$request->interest_rate);
        if($request->has('downpayment') && $request->downpayment != null){
            $investmentAmount = $request->investment_amount - $request->downpayment;
        }
        $interest = ($investmentAmount * $interestRate) / 100;
        $investmentReturnAmount = $investmentAmount + round($interest);
        $installmentAmount = $investmentReturnAmount / $request->installment_count;

//        $cashDrBalance = Cash::all()->sum('dr');
//        $cashcrBalance = Cash::all()->sum('cr');
//        $cashAtHand = $cashDrBalance - $cashcrBalance;
//
//        if($investmentAmount > $cashAtHand){
//            $notification = array(
//                'message' => 'Don\'t have sufficient amount!',
//                'alert-type' => 'error'
//            );
//
//            return back()->with($notification);
//        }

        $member = Member::where('slag',$request->selected_member)->first();

        $investment = new Investment();
        $investment->member_id = $member->id;
        $investment->investment_no = $investmentNo;
        $investment->investment_type = $request->investment_type;
        $investment->investment_behaviour = $request->investment_behaviour;
        $investment->investment_amount = $request->investment_amount;
        $investment->installment_count = $request->installment_count;
        $investment->interest_rate = $interestRate;
        if($request->has('downpayment')){
            $investment->downpayment = $request->downpayment;
        }
        $investment->investment_return_amount = $investmentReturnAmount;
        $investment->investment_type = $request->investment_type;
        $investment->installment_amount = round($installmentAmount);
        $investment->sanction_date = date('Y-m-d',strtotime($request->sanction_date));
        $investment->disburse_date = date('Y-m-d',strtotime($request->disburse_date));
        $investment->save();



        if($request->has('guardian_name')) {
            // insert guardian
            for ($a = 0; $a < $dataCount; $a++) {
                $guardianData = new Guardian();
                $guardianData->member_id = $member->id;
                $guardianData->name = $request->guardian_name[$a];
                $guardianData->father_name = $request->father_name[$a];
                $guardianData->phone = $request->guardian_phone[$a];
                $guardianData->nid_no = $request->guardian_nid_no[$a];
                $guardianData->relational_status = $request->guardian_relation[$a];
                $guardianData->present_address = $request->guardian_present_address[$a];
                $guardianData->permanent_address = $request->guardian_permanent_address[$a];
                $guardianData->investment_for = $investmentNo;
                $guardianData->save();
                $guardian = $guardianData->id;


                $model_common = new CommonModel();
                $ImgNamenew = $model_common->ImageName();

                $guardianNid = new GuardianImage();
                if ($request->hasFile('guardian_nid_image')) {
                    $nuidimageFilename = time() . $ImgNamenew . $guardianNidImage[$a]->getClientOriginalExtension();
                    Image::make($guardianNidImage[$a]->getRealPath())->resize(450, 300)->save(public_path('/Media/Guardian_NUID/' . $nuidimageFilename));
                    $guardianNid->image = $nuidimageFilename;
                }
                $guardianNid->nid_no = $request->guardian_nid_no[$a];;
                $guardianNid->guardian_id = $guardian;
                $guardianNid->save();
            }
        }

        if(!$request->has('guardian_name')) {
            $members = Member::where('slag',$request->selected_member)->first();
            foreach ($members->guardians as $guardian){
                $guardianData = Guardian::find($guardian->id);
                $guardianData->investment_for = $investmentNo;
                $guardianData->save();
            }
        }

        $member->status = "1";
        $member->save();

        if ($request->investment_type=="product"){
            $product = new InvestmentProduct();
            $product->member_id=$member->id;
            $product->investment_no=$investmentNo;
            $product->product=$request->product_id;
            $product->product_details=$request->productdetails;
            $product->save();


            $data = Product::find($request->product_id);
            $data->investment_no=$investmentNo;
            $data->member_id=$member->id;
            $data->status="1";
            $data->save();
        }

        if($request->has('downpayment')){
            $cash = new Cash();
            $cash->date = date('Y-m-d',time());
            $cash->description = 'Capital Down Payment introduced by '.$member->name;
            $cash->dr = number_format(intval($request->downpayment),'2','.','');
            $cash->save();
        }


        $notification = array(
            'message' => 'Investment info has been saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }


    public function Investmentdata($id)
    {
        $invest = Investment::where('id',$id)->first();
        $data = [
            'id' => $invest->id,
            'investment_amount' => $invest->investment_amount,
            'member' => $invest->member->name,
            'installment_count' => $invest->installment_count,
            'downpayment' => $invest->downpayment,
            'interest_rate' => $invest->interest_rate,
            'installment_amount' => $invest->installment_amount,
            'disburse_date' => $invest->disburse_date,
            'investmentReturn' => $invest->investment_return_amount,
            'investment_type' => $invest->investment_type,
        ];
        return response()->json($data);
    }


    public function InvestmentDataupdate(Request $request,$id)
    {

        $investmentAmount = $request->investment_amount;
        $interestRate = str_replace('%','',$request->interest_rate);
        if($request->has('downpayment') && $request->downpayment != null){
            $investmentAmount = $request->investment_amount - $request->downpayment;
        }

        $interest = ($investmentAmount * $interestRate) / 100;
        $investmentReturnAmount = $investmentAmount + round($interest);
        $installmentAmount = $investmentReturnAmount / $request->installment_count;

        $investment = Investment::find($id);
        $investment->investment_amount = $request->investment_amount;
        $investment->installment_count = $request->installment_count;
        $investment->interest_rate = $interestRate;
        if($request->has('downpayment')){
            $investment->downpayment = $request->downpayment;
        }
        $investment->investment_return_amount = $investmentReturnAmount;
        $investment->installment_amount = round($installmentAmount);
        $investment->disburse_date = date('Y-m-d',strtotime($request->disburse_date));
        $investment->save();


        if($request->has('downpayment')){
            if ($request->old_downpayment < $request->downpayment){
               $down =  $request->downpayment - $request->old_downpayment;
            }else{
                $down = $request->downpayment;
            }

            $member = Member::where('id',$investment->member->id)->first();

            $cash = new Cash();
            $cash->date = date('Y-m-d',time());
            $cash->description = 'Capital Down Payment introduced by '.$member->name;
            $cash->dr = number_format(intval($down),'2','.','');
            $cash->save();
        }

        $cashDrBalance = Cash::all()->sum('dr');
        $cashcrBalance = Cash::all()->sum('cr');
        $cashAtHand = $cashDrBalance - $cashcrBalance;

        if ($request->has('downpayment') && $request->downpayment != null) {
            $investmentAmount = $request->investment_amount - $request->downpayment;
        }

        if ($request->disburse_status == "1") {
            if ($investmentAmount > $cashAtHand) {
                $notification = array(
                    'message' => 'Don\'t have sufficient amount!',
                    'alert-type' => 'error'
                );

                return back()->with($notification);
            }

            $investment = Investment::where('status',"0")
                ->where('id',$id)
                ->first();

            for ($a = 0; $a <= $investment->installment_count; $a++) {
                if ($a > 0) {
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

                    $duration = ($investment->investment_behaviour * $a);
                    $setdate = strtotime($request->installment_date) - $investment->investment_behaviour * 24 * 60 * 60;;
                    $timestamp = $setdate + $duration * 24 * 60 * 60;

                    $installment = new InvestmentReturnInstallment();
                    $installment->investment_id = $investment->id;
                    $installment->date = date('Y-m-d', $timestamp);
                    $installment->voucher_no = '#' . $voucherNo;
                    $installment->installment_amount = $investment->installment_amount;
                    $installment->rest_amount = $investment->installment_amount;
                    $installment->installment_profit = $installmentProfit;
                    $installment->status = "0";
                    $installment->save();
                }
            }

            $interest = ($investmentAmount * $interestRate) / 100;
            $investmentReturnAmount = $investmentAmount + round($interest);

            $memberaccount = MemberAccount::where('member_id',$investment->member->id)->first();
            $memberaccount->return_investment=$investmentReturnAmount;
            $memberaccount->rest_investment=$investmentReturnAmount;
            $memberaccount->save();


            $investment->disburse_date = date('Y-m-d',strtotime($request->disburse_date));
            $investment->status = "1";
            $investment->save();

            $investmentAmount = $investment->investment_amount;
            if($investment->downpayment != null){
                $investmentAmount = $investment->investment_amount - $investment->downpayment;
            }

            if($investment->investment_type !="product"){
                $cash = new Cash();
                $cash->date = date('Y-m-d',time());
                $cash->description = 'Invest on '. $investment->member->name;
                $cash->cr = number_format($investmentAmount,'2','.','');
                $cash->save();
            }
        } // investment sucess


        $notification = array(
            'message' => 'Investment info has been saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    }



    public function GuargianUpdate(Request $request,$id)
    {

        $guardianData = Guardian::find($id);
        $guardianData->name = $request->name;
        $guardianData->father_name = $request->father_name;
        $guardianData->phone = $request->phone;
        $guardianData->nid_no = $request->nid_no;
        $guardianData->relational_status = $request->relation;
        $guardianData->present_address = $request->present_address;
        $guardianData->permanent_address = $request->permanent_address;
        $guardianData->save();

        $model_common = new CommonModel();
        $ImgName =  $model_common->ImageName();

        $gurdian_nuid = GuardianImage::where('guardian_id',$id)->first();
        $nuidimage = $request->nid_image;

        if($request->hasFile('nid_image')){
            if ($gurdian_nuid->image !=null){
                $path = 'Media/Guardian_NUID/' . $gurdian_nuid->image;
                unlink($path);
            }
            $nuidimageFilename = time() . $ImgName . $nuidimage->getClientOriginalExtension();
            Image::make($nuidimage->getRealPath())->resize(450, 300)->save(public_path('/Media/Guardian_NUID/'.$nuidimageFilename));
            $gurdian_nuid->image=$nuidimageFilename;
        }
        $gurdian_nuid->nid_no = $request->nid_no;
        $gurdian_nuid->save();

        $notification = array(
            'message' => 'Guardian info has been saved successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    }


}
