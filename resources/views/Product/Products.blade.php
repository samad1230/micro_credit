@extends('layouts.master-layouts')

@section('page-css')

@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-12 mx-auto">
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">{{ ucwords(' product add') }}</div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-md float-right" type="button" data-toggle="modal" data-target="#addproduct"><i class="i-Add text-white mr-2"></i> Add Products</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead class="btn-success">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ ucwords('ID') }}</th>
                                <th class="text-center">{{ ucwords('Product') }}</th>
                                <th class="text-center">{{ ucwords('Details') }}</th>
                                <th class="text-center">{{ ucwords('Price') }}</th>
                                <th class="text-center">{{ ucwords('purchase date') }}</th>
                                <th class="text-center">{{ ucwords('sell date') }}</th>
                                <th class="text-center">{{ ucwords('investment no') }}</th>
                                <th class="text-center">{{ ucwords('member id') }}</th>
                                <th class="text-center">{{ ucwords('status') }}</th>
                                <th class="text-center"><i class="i-Eye font-weight-bold"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($products as $row)
                                <tr>
                                    <td>{{ $i}}</td>
                                    <td>{{ $row->id != false ? $row->id: ucwords('0') }}</td>
                                    <td>{{ $row->product_name != false ? $row->product_name: ucwords('n/a') }}</td>
                                    <td>{{ $row->product_details != false ? $row->product_details: ucwords('n/a') }}</td>
                                    <td>{{ $row->sell_price != false ? $row->sell_price: ucwords('0') }}</td>
                                    <td>{{ $row->purchase_date != false ? $row->purchase_date: ucwords('0') }}</td>
                                    <td>{{ $row->sell_date != false ? $row->sell_date: ucwords('0') }}</td>
                                    <td>{{ $row->investment_no != false ? $row->investment_no: ucwords('0') }}</td>
                                    <td>{{ $row->member_id != false ? $row->member_id: ucwords('0') }}</td>
                                    <td>
                                        @if($row->status=="0")
                                        {!! '<b class="text-primary">'.strtoupper('stoke').'</b>' !!}
                                        @else
                                        {!! '<b class="text-danger">'.strtoupper('stoke out').'</b>' !!}
                                        @endif

                                    <td>
                                        <a href="#">
                                            <button type="button" class="btn btn-info btn-sm">{{ ucwords('view') }}</button>
                                        </a>
                                    </td>

                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $products->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addproduct" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Add Product</h4>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('Product.store')}}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Product Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="product_name" class="form-control" id="" placeholder="Name Of Product" required autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Product Details</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="product_details" class="form-control" id="" placeholder="Product Details" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Buy Price</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="buy_price" class="form-control" id="" placeholder="Buy Price" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Sell Price</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="sell_price" class="form-control" id="" placeholder="Sell Price" autocomplete="off" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Product Warranty</label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control" name="warranty" id="" required>
                                        <option value="">Select Warranty</option>
                                        <option value="6 Month">6 Month</option>
                                        <option value="1 Year">1 Year</option>
                                        <option value="3 Year">3 Year</option>
                                        <option value="5 Year">5 Year</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')



@endsection


