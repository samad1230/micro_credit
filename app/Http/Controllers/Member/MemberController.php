<?php

namespace App\Http\Controllers\Member;

use App\Admin_model\CommonModel;
use App\Http\Controllers\Controller;
use App\Member_model\Member;
use App\Member_model\MemberAccount;
use App\Member_model\NidImage;
use App\Member_model\Nominee;
use App\Member_model\Saving;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class MemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Member_pages.add-new-member');
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

        $this->validate($request,[
            'name' => 'required',
            'phone' => 'required|min:11|max:14',
            'father_name' => 'required',
            'income_source' => 'required',
            'nid_no' => 'required|min:10|max:17',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'nid_image' => 'required',
        ]);

        $model_common = new CommonModel();
        $slag =  $model_common->slagdata();
        $ImgName =  $model_common->ImageName();
        $SavingAcno =  $model_common->SavingAcno();
        $time = time();

        $current = new Carbon();
        $date =  $current->format('Y-m-d');

        $user_id =Auth::user()->id;

        $member = new Member();
        $member->member_no="#".$time;
        $member->ledgerid=$request->ledgerid;
        $member->name=$request->name;
        $member->mobile=$request->phone;
        $member->father_name=$request->father_name;
        $member->mother_name=$request->mothername;
        $member->occupation=$request->income_source;
        $member->age=$request->memberage;
        $member->gender=$request->gender;
        $member->religion=$request->religion;
        $member->marital_status=$request->Maritalstatus;
        $member->present_address=$request->present_address;
        $member->permanent_address=$request->permanent_address;
        $member->join_date=$date;
        $member->status="0";
        $member->slag=$slag;
        $member->user_id=$user_id;
        $member->save();
        $memberid = $member->id;

        $member_nuid = new NidImage();
        $member_nuid->member_id=$memberid;
        $member_nuid->nuid_no=$request->nid_no;

        $nuidimage = $request->nid_image;
        if($request->hasFile('nid_image')){
            $nuidimageFilename = time() . $ImgName . $nuidimage->getClientOriginalExtension();
            Image::make($nuidimage->getRealPath())->resize(450, 300)->save(public_path('/Media/Member_NUID/'.$nuidimageFilename));
            $member_nuid->nuid_image=$nuidimageFilename;
        }

        $avatarimage = $request->avatar_image;
        if($request->hasFile('avatar_image')){
            $avatarimageFilename = time() . $ImgName . $avatarimage->getClientOriginalExtension();
            Image::make($avatarimage->getRealPath())->resize(300, 300)->save(public_path('/Media/Member_Avature/'.$avatarimageFilename));
            $member_nuid->member_image=$avatarimageFilename;
        }
        $member_nuid->save();


        $saving = new Saving();
        $saving->member_id=$memberid;
        $saving->savings_no=$SavingAcno;
        $saving->opening_date=$date;
        $saving->save();

        $memberaccount = new MemberAccount();
        $memberaccount->member_id=$memberid;
        $memberaccount->saving_id=$SavingAcno;
        $memberaccount->save();

        $nominess = new Nominee();
        $nominess->member_id=$memberid;
        $nominess->name=$request->nominee;
        $nominess->age=$request->nomineeage;
        $nominess->relation=$request->nomineerelation;
        $nominess->father_name=$request->nomineefather;
        $nominess->save();

        $notification = array(
            'message' => 'Member has been created successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slag)
    {
        $member = Member::where('slag',$slag)->first();
        return view('Member_pages.memver_view_single',compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slag)
    {
        $model_common = new CommonModel();
        $ImgName =  $model_common->ImageName();

        $user_id =Auth::user()->id;

        $member = Member::where('slag',$slag)->first();
        $member->name=$request->name;
        $member->mobile=$request->phone;
        $member->ledgerid=$request->ledgerid;
        $member->father_name=$request->father_name;
        $member->occupation=$request->income_source;
        $member->present_address=$request->present_address;
        $member->permanent_address=$request->permanent_address;
        $member->user_id=$user_id;
        $member->save();

        $member_nuid = NidImage::where('member_id',$member->id)->first();
        $member_nuid->nuid_no=$request->nid_no;
        $nuidimage = $request->nid_image;

        if($request->hasFile('nid_image')){
            if ($member_nuid->nuid_image !=null){
                $path = 'Media/Member_NUID/' . $member_nuid->nuid_image;
                unlink($path);
            }
            $nuidimageFilename = time() . $ImgName . $nuidimage->getClientOriginalExtension();
            Image::make($nuidimage->getRealPath())->resize(450, 300)->save(public_path('/Media/Member_NUID/'.$nuidimageFilename));
            $member_nuid->nuid_image=$nuidimageFilename;
        }

        $avatarimage = $request->avatar_image;
        if($request->hasFile('avatar_image')){
            if ($member_nuid->member_image !=null){
                $path = 'Media/Member_Avature/' . $member_nuid->member_image;
                unlink($path);
            }

            $avatarimageFilename = time() . $ImgName . $avatarimage->getClientOriginalExtension();
            Image::make($avatarimage->getRealPath())->resize(300, 350)->save(public_path('/Media/Member_Avature/'.$avatarimageFilename));
            $member_nuid->member_image=$avatarimageFilename;
        }
        $member_nuid->save();

        $nominess = Nominee::where('member_id',$member->id)->first();
        if ($nominess==null){
            $nominess = new Nominee();
            $nominess->member_id=$member->id;
            $nominess->name=$request->nominee;
            $nominess->age=$request->nomineeage;
            $nominess->relation=$request->nomineerelation;
            $nominess->father_name=$request->nomineefather;
            $nominess->save();
        }else{
            $nominess = Nominee::find($nominess->id);
            $nominess->member_id=$member->id;
            $nominess->name=$request->nominee;
            $nominess->age=$request->nomineeage;
            $nominess->relation=$request->nomineerelation;
            $nominess->father_name=$request->nomineefather;
            $nominess->save();
        }


        $notification = array(
            'message' => 'Member has been Update successfully!',
            'alert-type' => 'success'
        );

        return back()->with($notification);
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
