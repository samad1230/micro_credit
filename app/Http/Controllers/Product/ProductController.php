<?php

namespace App\Http\Controllers\Product;

use App\Accounts\Cash;
use App\Http\Controllers\Controller;
use App\Product_model\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id','DESC')->paginate(20);

        return view('Product.Products',compact('products'));
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
        $user_id = Auth::user()->id;
        $this->validate($request,[
            'product_name' => 'required',
            'sell_price' => 'required',
        ]);

        $current = new Carbon();
        $crdate =  $current->format('Y-m-d');

        $data = new Product();
        $data->product_name=$request->product_name;
        $data->product_details=$request->product_details;
        $data->buy_price=$request->buy_price;
        $data->sell_price=$request->sell_price;
        $data->warranty=$request->warranty;
        $data->purchase_date= $crdate;
        $data->user_id=$user_id;
        $data->investment_no=0;
        $data->member_id=0;
        $data->save();

        $cash = new Cash();
        $cash->date = date('Y-m-d',time());
        $cash->description = 'Investment Purpose Product Buy : '. $request->product_name;
        $cash->cr = number_format($request->buy_price,'2','.','');
        $cash->save();

        $notification = array(
            'message' => 'Product Added successfully!',
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
        //
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
        //
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
