<?php

namespace App\Http\Controllers\Main_Controller;

use App\Http\Controllers\Controller;
use App\Loan_Investment\InvestmentReturnInstallment;
use App\Member_model\Saving;
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
        ];

        return response()->json($data);
    }
}
