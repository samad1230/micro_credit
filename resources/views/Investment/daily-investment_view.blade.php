@extends('layouts.master-layouts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ ucwords('daily collection details') }}</div>
                        <span class="float-right p-2 text-white font-weight-bold {{ is_int(strpos(@$today_penalty_sum,'-')) != true ? 'bg-primary' : 'bg-danger' }}" style="border-radius: 10px; margin-right: 10px;">{!! ucwords('penalty : ').number_format(@$today_penalty_sum,'2','.',',') !!}</span>

                        <span class="float-right p-2 text-primary font-weight-bold {{ is_int(strpos(@$today_saving_sum,'-')) != true ? 'bg-warning' : 'bg-danger' }}" style="border-radius: 10px; margin-right: 10px;">{!! ucwords('today saving : ').number_format(@$today_saving_sum,'2','.',',') !!}</span>

                        <span class="float-right p-2 text-white font-weight-bold {{ is_int(strpos($today_collention_sum,'-')) != true ? 'bg-success' : 'bg-danger' }}" style="border-radius: 10px;margin-right: 10px;">{!! ucwords('today collection : ').number_format($today_collention_sum,'2','.',',') !!}</span>

                        <span class="float-right p-2 text-white font-weight-bold {{ is_int(strpos($today_installment_due,'-')) != true ? 'bg-danger' : 'bg-danger' }}" style="border-radius: 10px;margin-right: 10px;">{!! ucwords('installment due : ').number_format($today_installment_due,'2','.',',') !!}</span>


                        <span class="float-right p-2 text-white font-weight-bold {{ is_int(strpos($today_installment_sum,'-')) != true ? 'bg-primary' : 'bg-danger' }}" style="border-radius: 10px; margin-right: 10px;">{!! ucwords('today Installment : ').number_format($today_installment_sum,'2','.',',') !!}</span>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allInvestmentsDataTable">
                            <thead>
                            <tr>
                                <th class="text-center">{{ ucwords('sl') }}</th>
                                <th class="text-center">{{ ucwords('voucher no') }}</th>
                                <th class="text-center">{{ ucwords('name') }}</th>
                                <th class="text-center">{{ ucwords('installment date') }}</th>
                                <th class="text-center">{{ ucwords('installment') }}</th>
                                <th class="text-center">{{ ucwords('collection') }}</th>
                                <th class="text-center">{{ ucwords('saving') }}</th>
                                <th class="text-center">{{ ucwords('balance') }}</th>
                                <th class="text-center">{{ ucwords('status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl=1;?>
                            @foreach($installments as $installment)
                                @php
                                    $savingac = \App\Member_model\SavingAccount::where('voucher_no',$installment->voucher_no)->first();

                                    $penalty = \App\Accounts\Penalty::where('voucher_no',$installment->voucher_no)->first();
                                    $todayDate = time();
                                   $today = date('Y-m-d',$todayDate);
                                @endphp
                                <tr>
                                    <th>{{ $sl}}</th>
                                    <td>{{ $installment->voucher_no }}</td>
                                    <td>{{ $installment->investment->member->name }}</td>
                                    <td>{{ date('d-m-Y',strtotime($installment->date)) }}</td>
                                    <td>{{ number_format($installment->installment_amount,'2','.',',') }}</td>

                                    <td>
                                        @if($installment->collection_amount != null || $installment->status !='0')
                                            {{ number_format($installment->collection_amount,'2','.',',') }}
                                        @elseif(date('Y-m-d',strtotime($installment->date)) ==$today)
                                            <button type="button" class="btn btn-warning btn-sm collectionBtnModel" id="{{ $installment->voucher_no }}">Collect</button>
                                        @elseif($installment->status =='2')

                                            {{ number_format($penalty->penalty,'2','.',',') }}
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm collectionBtnModel" id="{{ $installment->voucher_no }}">Collect</button>
                                            <button type="button" class="btn btn-danger btn-sm penaltyfine" id="{{ $installment->voucher_no }}">{{ucwords('penalty')}}</button>

                                        @endif
                                    </td>
                                    <td>
                                        @if($savingac != null)
                                            {{ number_format($savingac->amount,'2','.',',') }}
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm savingcollectionBtn" id="{{ $installment->voucher_no }}">Saving</button>
                                        @endif
                                    </td>
                                    <td>{{ number_format($installment->rest_amount,'2','.',',') }}</td>
                                    <td>
                                        @if($installment->status =='1' && $installment->rest_amount=='0' )
                                            {!! '<b class="text-success">'.strtoupper('paid').'</b>' !!}
                                        @elseif($installment->status =='0')
                                            {!! '<b class="text-danger">'.strtoupper('due').'</b>' !!}
                                        @elseif($installment->status =='1' && $installment->rest_amount !='0')
                                            {!! '<b class="text-primary">'.strtoupper('unpaid').'</b>' !!}
                                        @else
                                            {!! '<b class="text-danger">'.strtoupper('penalty add').'</b>' !!}
                                        @endif
                                    </td>
                                </tr>
                                <?php $sl++;?>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $installments->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="modal fade" id="InvestmentCollection" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Payment Collection</h4>
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
                    <form action="{{route('Investment.ReturnCollection')}}" class="" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="memberName">{{ ucwords('member name') }}</label>
                                <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_name_collection" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="memberPhone">{{ ucwords('Voucher No') }}</label>
                                <input type="text" name="voucher_no" class="form-control" id="voucher_collection" placeholder="Voucher No" readonly>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="memberPhone">{{ ucwords('due voucher') }}</label>
                                <input type="text" class="form-control" id="due_voucher_amount" placeholder="Voucher Count" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="memberName">{{ ucwords('installment *') }}</label>
                                <input type="text" name="installment_amount" class="form-control" placeholder="Installment Amount" id="installment_amount" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="memberPhone">{{ ucwords('previous installment *') }}</label>
                                <input type="text" name="previusdue" class="form-control" id="due_installment" placeholder="Installment Due" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="memberPhone">{{ ucwords('penalty due *') }}</label>
                                <input type="text" name="penaltydue" class="form-control" id="penalty_due" placeholder="Penalty Due Amount " readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label for="memberName"><b>{{ ucwords('installment collection*') }}</b></label>
                                <input type="text" name="collection" class="form-control" placeholder="Payment Collection" autocomplete="off" id="collection_pay">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="memberPhone"><b>{{ ucwords('penalty collection *') }}</b></label>
                                <input type="text" name="penalty_collection" class="form-control"  placeholder="Penalty Collection" autocomplete="off">
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

    <div class="modal fade" id="Penaltyupdate" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Update Penalty</h4>
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
                    <form action="" class="editsupplier_data" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class=" " for="">Member Name</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_name" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class=" " for="">Voucher No</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="voucher" class="form-control" id="voucher_no" placeholder="Voucher No" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="Contact">Penalty Amount</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="PenaltyAmount" class="form-control"  placeholder="Penalty Amount" autocomplete="off" id="penalty_amount" autofocus>
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
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/payment_saving.js') }}"></script>

    <script !src="">
        $(document).on("click", ".penaltyfine", function(e){
            e.preventDefault();
            var voucherNo = $(this).attr('id');
            var voucher = voucherNo.replace('#', '');
            $.ajax({
                type: 'GET',
                url:'/Penalty/Installment/amount/'+voucher,

                success: function (data) {
                    $("#voucher_no").val(data.voucher_no);
                    $("#member_name").val(data.membername);
                    document.getElementById("penalty_amount").focus();
                    $('.editsupplier_data').attr('action', '/PanaltiInsert/'+voucher);
                }
            });

            $("#Penaltyupdate").modal('show');

        });


        $(document).on("click", ".collectionBtnModel", function(e){
            e.preventDefault();
            var voucherNo = $(this).attr('id');
            var voucher = voucherNo.replace('#', '');
            $.ajax({
                type: 'GET',
                url:'/Collection/Installment/amount/'+voucher,
                success: function (data) {
                   // console.log(data);
                    $("#member_name_collection").val(data.membername);
                    $("#voucher_collection").val(data.voucher_no);
                    $("#due_voucher_amount").val(data.vouchercount);
                    $("#installment_amount").val(data.installment).css({"color": "blue", "font-weight": "bold"});
                    $("#due_installment").val(data.previusdue).css({"color": "red", "font-weight": "bold"});
                    $("#penalty_due").val(data.penaltydue).css({"color": "purple", "font-weight": "bold"});
                    document.getElementById("collection_pay").focus();
                    //$('.paymentCollection_data').attr('action', '/Investment/ReturnCollection/');
                }
            });
            $("#InvestmentCollection").modal('show');

        });
    </script>
@endsection
