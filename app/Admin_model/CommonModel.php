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

}
