<?php

namespace App\Http\Controllers\Main_Controller;

use App\Admin_model\CompanyProfile;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CompanyProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = CompanyProfile::orderBy('id','DESC')->paginate(15);
        return view('Company.Company_profile',compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = new CompanyProfile();
        $company->name=$request->company;
        $company->address=$request->address;
        $company->contact=$request->contact;
        $company->license=$request->license;
        $company->owner=$request->owner;
        $company->vat=$request->vatno;

        $profileimage=$request->logo;

        if($request->hasFile('logo')){
            $x = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $x = str_shuffle($x);
            $x = substr($x, 0, 6) . '.PI_S.';
            $profileImageFilename = time() . $x . $profileimage->getClientOriginalExtension();
            Image::make($profileimage->getRealPath())->resize(250, 200)->save(public_path('/Media/company_profile/' . $profileImageFilename));
            $company->image=$profileImageFilename;
        }
        $company->save();

        $notification=array(
            'messege'=>'Successfully Company Profile Updated!',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $data = CompanyProfile::where('id',$id)->first();
       return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $company = CompanyProfile::find($id);
        $company->name=$request->company;
        $company->address=$request->address;
        $company->contact=$request->contact;
        $company->license=$request->license;
        $company->owner=$request->owner;
        $company->vat=$request->vatno;

        $profileimage=$request->logo;

        if($request->hasFile('logo')){
            $profileUserImage = $company->image;
            if($profileUserImage != null){
                $path = 'Media/company_profile/' . $profileUserImage;
                unlink($path);
            }
            $x = 'abcdefghijklmnopqrstuvwxyz0123456789';
            $x = str_shuffle($x);
            $x = substr($x, 0, 6) . '.PI_S.';
            $profileImageFilename = time() . $x . $profileimage->getClientOriginalExtension();
            Image::make($profileimage->getRealPath())->resize(250, 200)->save(public_path('/Media/company_profile/' . $profileImageFilename));
            $company->image=$profileImageFilename;
        }
        $company->save();

        $notification=array(
            'messege'=>'Successfully Company Profile Updated!',
            'alert-type'=>'success'
        );
        return Redirect()->back()->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
