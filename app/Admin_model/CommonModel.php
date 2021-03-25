<?php

namespace App\Admin_model;

use Illuminate\Database\Eloquent\Model;

class CommonModel extends Model
{
    public function slagdata()
    {
        $slag = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $slag = str_shuffle($slag);
        $slag = time() . substr($slag, 0, 6) . '.PIB.';
        return $slag;
    }

    public function ImageName()
    {
        $x = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $b = str_shuffle($x);
        $img = time() . substr($b, 0, 4) . '.PIB.';
        return $img;
    }

    public function InvestmentNo()
    {
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
        return $investmentNo;
    }


    public function SavingAcno()
    {
        $no = time();
        $savingAcno = null;
        for($b = 0; $b < strlen($no); $b++){
            if($b == 3){
                $savingAcno = substr($no,0,3);
            }elseif ($b == 6){
                $savingAcno = $savingAcno . '-'. substr($no,3,3);
            }elseif ($b == 7){
                $savingAcno = $savingAcno . '-'. substr($no,6,strlen($no));
            }
        }
        return $savingAcno;
    }

}
