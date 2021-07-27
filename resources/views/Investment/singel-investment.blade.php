@extends('layouts.master-layouts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-11 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            {{ ucwords('investment number: ').$investment->investment_no }}
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="text-muted font-weight-bold"><u>{{ ucwords('receivable info') }}</u></h5>
                                <ul class="list-unstyled">
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('member no: ').'</span>'.$investment->member->member_no !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('name: ').'</span>'.$investment->member->name !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('phone: ').'</span>'.$investment->member->mobile !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('nid no: ').'</span>'.$investment->member->nidImage->nuid_no !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('income source: ').'</span>'.$investment->member->occupation !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('Investment Status: ').'</span>'!!}{{ $investment->status ? ucwords('active'):ucwords('dactive') }}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('present address: ').'</span>'.$investment->member->present_address !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('permanent address: ').'</span>'.$investment->member->permanent_address !!}</li>
                                    <---------------------->
                                    <li>{!! '<span class="font-weight-bold text-danger">'.ucwords('investment end date : ').@$installmentlastdate->date .'</span>' !!}</li>
                                    <li>{!! '<span class="font-weight-bold text-danger">'.ucwords(' collection amount : ').$collection_amount.'</span>' !!}</li>
                                    <li>{!! '<span class="font-weight-bold text-danger">'.ucwords(' penalty amount : ').$panaltyBalance.'</span>' !!}</li>
                                   @php
                                       $lastamount = $restamount + $panaltyBalance;
                                   @endphp
                                    <li>{!! '<span class="font-weight-bold text-danger">'.ucwords(' last investment amount : '). $lastamount.'</span>' !!}</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted font-weight-bold"><u>{{ ucwords('investment info') }}</u></h5>
                                <ul class="list-unstyled">
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('sanction date: ').'</span>'.date('d-M-Y',strtotime($investment->sanction_date)) !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('disburse date: ').'</span>'.date('d-M-Y',strtotime($investment->disburse_date)) !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('investment no: ').'</span>'.$investment->investment_no !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('investment type: ').'</span>'.strtoupper($investment->investment_type) !!}</li>
                                    <li>
                                        {!! '<span class="text-muted font-weight-bold">'.ucwords('installment behaviour: ').'</span>'.($investment->investment_behaviour < 7 ? strtoupper('daily') : ($investment->investment_behaviour == 7 ? strtoupper('weekly'):($investment->investment_behaviour > 7 ?strtoupper('monthly'):''))) !!}
                                    </li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('investment amount: ').'</span>'.number_format($investment->investment_amount,'2','.',',') !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('installment count: ').'</span>'.$investment->installment_count !!}</li>
                                    <li>{!! $investment->downpayment != null ?'<span class="text-muted font-weight-bold">'.ucwords('down-payment: ').'</span>'.number_format($investment->downpayment,'2','.',','):'<span class="text-muted font-weight-bold">'.ucwords('savings per installment: ').'</span>'.number_format($investment->savings_per_installment,'2','.',',') !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('interest rate: ').'</span>'.$investment->interest_rate.'%' !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('installment amount: ').'</span>'.$investment->installment_amount !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('rest installment count: ').'</span>'.$investment->iRInstallments()->where('status',false)->count() !!}</li>
                                    <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('investment will return amount: ').'</span>'.number_format($investment->investment_return_amount,'2','.',',') !!}</li>
                                    <li>{!! $investment->savings_per_installment != null ?'<span class="text-muted font-weight-bold">'.ucwords('total savings: ').'</span>'.number_format(($investment->savings_per_installment * $investment->iRInstallments()->where('status',true)->count()),'2','.',','):'' !!}</li>
                                </ul>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            @php
                                $i = 0;
                            @endphp
                            @foreach($guardians as $guardian)
                                <div class="col-md-4" data-aos="fade-right" data-aos-duration="2000">
                                    <div class="media mb-5">
                                        <div class="media-body">
                                            @php
                                                $i++;
                                            @endphp
                                            <h5 class="text-muted font-weight-bold">{{ ucwords('guardian '). ($i >10 ? $i : '0'.$i) }}</h5>
                                            <ul class="list-unstyled">
                                                <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('name: ').'</span>'.$guardian->name !!}</li>
                                                <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('phone: ').'</span>'.$guardian->phone !!}</li>
                                                <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('nid no: ').'</span>'.$guardian->nid_no !!}</li>
                                                <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('relation: ').'</span>'.$guardian->relational_status !!}</li>
                                                <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('present address: ').'</span>'.$guardian->present_address !!}</li>
                                                <li>{!! '<span class="text-muted font-weight-bold">'.ucwords('permanent address: ').'</span>'.$guardian->permanent_address !!}</li>
                                                <br>
                                                <li>
                                                    <a href="{{ route('guardian.view',$guardian->id) }}">
                                                        <button type="button" class="btn btn-info btn-sm">{{ ucwords('guardian view') }}</button>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                            <hr>

                            @if($investment->status)
                                <h5 class="text-muted font-weight-bold"><u>{{ ucwords('installment info') }}</u></h5>
                                <table class="table table-striped table-hover" id="allInstallmentsTable">
                                    <thead>
                                    <tr>
                                        <th class="text-center">{{ ucwords('voucher no') }}</th>
                                        <th class="text-center">{{ ucwords('installment date') }}</th>
                                        <th class="text-center">{{ ucwords('installment') }}</th>
                                        <th class="text-center">{{ ucwords('collection') }}</th>
                                        <th class="text-center">{{ ucwords('balance') }}</th>
                                        <th class="text-center">{{ ucwords('status') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($installments as $installment)
                                        @php

                                            $todayDate = time();
                                            $today = date('Y-m-d',$todayDate);
                                        @endphp
                                        <tr>
                                            <td>{{ $installment->voucher_no }}</td>
                                            <td>{{ date('d-m-y',strtotime($installment->date)) }}</td>
                                            <td>{{ number_format($installment->installment_amount,'2','.',',') }}</td>
                                            <td>
                                                @if($installment->status =='1')
                                                    {{ number_format($installment->collection_amount,'2','.',',') }}
                                                @elseif(date('Y-m-d',strtotime($installment->date)) <= $today && $installment->status !='2')
                                                    <button type="button" class="btn btn-warning btn-sm collectionBtnModel" id="{{ $installment->voucher_no }}">Collect</button>
                                                    <button type="button" class="btn btn-danger btn-sm penaltyfine" id="{{ $installment->voucher_no }}">{{ucwords('penalty')}}</button>
                                                @elseif($installment->status =='2')
                                                    <button type="button" class="btn btn-warning btn-sm collectionBtnModel" id="{{ $installment->voucher_no }}">Collect</button>
                                                @else
                                                    <button type="button" class="btn btn-warning btn-sm collectionBtnModel" id="{{ $installment->voucher_no }}">Collect</button>
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
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
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
                                    <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_name_penalty" readonly>
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
                    //console.log(data);
                    $("#member_name_collection").val(data.membername);
                    $("#voucher_collection").val(data.voucher_no);
                    $("#due_voucher_amount").val(data.vouchercount);
                    $("#installment_amount").val(data.installment).css({"color": "blue", "font-weight": "bold"});
                    $("#due_installment").val(data.previusdue).css({"color": "red", "font-weight": "bold"});
                    $("#penalty_due").val(data.penaltydue).css({"color": "purple", "font-weight": "bold"});
                    document.getElementById("collection_pay").focus();
                    //$('.paymentCollection_data').attr('action', '/Investment/Return-Collection/');
                }
            });
            $("#InvestmentCollection").modal('show');

        });
    </script>

@endsection
