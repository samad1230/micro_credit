<?php

namespace App\Http\Controllers\Main_Controller;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('Dashboard.Admin_dashboard');
    }



    public function UserProficeUpdate(Request $request)
    {
        $name_new = $request->user_name;
        $name_old = $request->nameold;

        $user = Auth::user();

        if($request->has('oldpassword')){
            if(Hash::check($request->oldpassword,$user->password)){
                //$data= User::find($user);
                $user['password']=Hash::make($request->newpassword);
                $user->save();
            }
        }

        if ($name_old != $name_new){
            $username = $request->user_name;
        }else{
            $username = $request->nameold;
        }
        $id = Auth::user()->id;
        $profile = Auth::user()->image;
        $data = User::find($id);

        $data['name']=$username;
        $data['mobile']=$request->mobile;
        $profileimage=$request->profileimage;

        if($request->hasFile('profileimage')){
            $profileUserImage = Auth::user()->image;
            if($profileUserImage != null){
                $image = Auth::user()->image;
                $path = 'Media/user_profile/' . $image;
                unlink($path);
            }
            $x = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $x = str_shuffle($x);
            $x = substr($x, 0, 6) . '.PIB.';
            $profileImageFilename = time() . $x . $profileimage->getClientOriginalExtension();
            Image::make($profileimage->getRealPath())->resize(250, 200)->save(public_path('/Media/user_profile/' . $profileImageFilename));
            $data['image']=$profileImageFilename;

        }

        $data->save();

        $notification=array(
            'messege'=>'Successfully Profile Updated!',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }


}
