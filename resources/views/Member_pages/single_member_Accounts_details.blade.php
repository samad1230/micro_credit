@extends('layouts.master-layouts')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection
@section('page-css')
    <style>
        .rightdata{
            float: right;
            color: red;
            font-weight: bold;
        }
        .leftdata{
            color: red;
            font-weight: bold;
        }
        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: .6rem;
        }
    </style>
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-11 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4 o-hidden">
                                    @if($member->avatar_image != null)
                                        <img class="card-img-top" height="180px" src="{{ asset('Media/Member_Avature/'.$member->nidImage->member_image) }}" alt="{{ ucwords('avatar image') }}">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <span>{{ ucwords($member->name) }}</span>
                                        </h5>
                                        <p class="card-text">{{ $member->status != false ? '('.ucwords('active').')' : '('.ucwords('deactive').')'  }} {{" "."Member No : " .$member->member_no}}
                                            <br> {{"Ledger No : " .@$member->ledgerid}}<br>
                                                @foreach($member->Loans as $data)
                                                {{"Lone No : " .$data->investment_no}}
                                                @endforeach
                                        </p>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><b>Loan Amount : </b>ট {{ $investment->investment_return_amount }}</li>
                                        <li class="list-group-item"><b>Paid Money : </b>ট {{ $investpaid }}<span class="rightdata">{{" Paid Installment: "}}{{$totalpaid}}</span></li>
                                        <li class="list-group-item"><b>Blanch : </b> ট {{ $investdue }} <span class="rightdata">{{" Due Installment: "}}{{$totaldue}}</span></li>
                                        <li class="list-group-item"><b>Penalty : </b>ট {{ $investpanalti }}<span class="rightdata"></span></li>
                                        <li class="list-group-item leftdata"><b>Last Blanch : </b>ট {{ $investdue + $investpanalti }}</li>

                                        <li class="list-group-item"><b>Saving Amount : </b>{{ @$member->memberAccount->saving_amount }}</li>

                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4 o-hidden">
                                    <button type="button" class="btn btn-success btn-md savingwithrwal" id="{{$member->saveingac->id}}">{{ ucwords('saving withdrawal')}}</button>
                                    <br>
                                        <button type="button" class="btn btn-danger btn-md penaltyadd" id="{{$member->id}}">{{ ucwords('extra Penalty ') }}</button>
                                    <br>
                                    <button type="button" class="btn btn-info btn-md adjustment" id="{{$member->id}}">{{ ucwords('loan adjustment') }}</button>
                                    <br>


                                </div>
                            </div>
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


    <div class="modal fade" id="SavingCollectionwithrwal" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Saving Withdrawal</h4>
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
                    <form action="" class="saving_Withdrawal_data" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Member Name</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_name" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Savings No</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="saving" class="form-control" id="Savings_no" placeholder="Savings No" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Savings Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="SavingsAmount" class="form-control" id="SavingsAmount" placeholder="Savings Amount" onkeyup="checkFunction()" readonly="" >
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Withdrawal Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="SavingsWithdrawalAmount" class="form-control" id="WithdrawalAmount" placeholder="Withdrawal Amount" onchange="checkFunction()" required="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" id="saveidbtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="InstallmentduePenalty" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Installment Due Penalty</h4>
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
                    <form action="" class="InstallmentDataAmount" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Member Name</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_nameid" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Invest No</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="investno" class="form-control" id="invest_no" placeholder="Invest No" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Installment due Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="Installment_due_Amount" class="form-control" id="InstallmentAmount" placeholder="Installment Due Amount" readonly="" >
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Installment Count</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="Installment_count" class="form-control" id="Installmentcount" placeholder="Installment Count" readonly="" >
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Penalty Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="PenaltyAmount" class="form-control" id="Penalty_Amount" placeholder="Penalty Amount" onchange="checkFunction()" required="">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" id="" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="loanAdjustment" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Installment Adjustment </h4>
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
                    <form action="" class="Installmentadjustment" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" id="savingblanch" value="{{@$member->memberAccount->saving_amount}}">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Member Name</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Member Name" id="member_nameloan" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="">Invest No</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="investnodata" class="form-control" id="invest_number" placeholder="Invest No" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Installment due Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="Installment_dueAmount" class="form-control" id="Installmentdue_Amount" placeholder="Installment Due Amount" readonly="" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Installment Payment</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="Payment_amount" class="form-control"  placeholder="Installment Payment" id="install_payment" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Close Saving Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="SavingAmountclose" class="form-control" id="SavingAmount_close" placeholder="{{@$member->memberAccount->saving_amount." Taka"}}" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Discount Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="discountAmount" class="form-control"  placeholder="Discount Amount" id="dis_amount" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">Blanch Amount</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="" class="form-control"  placeholder="Blanch Amount" id="Blanch_amount" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit_data" class="btn btn-primary">Save</button>
                        </div>
                    </form>

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
                    <form action="" class="paymentCollection_data" method="POST"  enctype="multipart/form-data">
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
    <script src="{{asset('assets/js/scripts/form.validation.script.min.js')}}"></script>
    <script !src="">
        $(function () {
            $('.savingwithrwal').on('click',function () {
                var savingid = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url:'/SavingIdData/'+savingid,
                    success: function (data) {
                        $("#Savings_no").val(data.savingno);
                        $("#member_name").val(data.membername);
                        $("#SavingsAmount").val(data.savingamount);
                        $('.saving_Withdrawal_data').attr('action', '/SavingWithdrawalAmount/'+savingid);
                    }
                });
                $("#SavingCollectionwithrwal").modal('show');
            });



            $('.penaltyadd').on('click',function () {
                var memberid = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url:'/penaltyaddMember/'+memberid,
                    success: function (data) {
                        $("#member_nameid").val(data.membername);
                        $("#invest_no").val(data.investmentno);
                        $("#InstallmentAmount").val(data.panaltyamount);
                        $("#Installmentcount").val(data.installmentcount);
                        $('.InstallmentDataAmount').attr('action', '/InstallmentDuePenaltyCash/'+memberid);
                    }
                });
                $("#InstallmentduePenalty").modal('show');
            });

            $('.adjustment').on('click',function () {
                var memberid = $(this).attr('id');
                $.ajax({
                    type: 'GET',
                    url:'/InvestmentAdjust/'+memberid,
                    success: function (data) {
                        $("#member_nameloan").val(data.membername);
                        $("#invest_number").val(data.investmentno);
                        $("#Installmentdue_Amount").val(data.installment_rest);
                        $('.Installmentadjustment').attr('action', '/InstallmentAdjustAndClose/'+memberid);
                    }
                });
                $("#loanAdjustment").modal('show');
            });


        });

        function checkFunction() {
            var SavingsAmount = document.getElementById('SavingsAmount').value;
            var WithdrawalAmount = document.getElementById('WithdrawalAmount').value;
            var Savings = parseInt(SavingsAmount) ;
            var Withdrawal = parseInt(WithdrawalAmount) ;
            if(Withdrawal > Savings){
               alert("Withdrawal Amount Not Available");
                $('#saveidbtn').attr('disabled','disabled');
            }else{
                $('#saveidbtn').attr('disabled',false);
            }

            var Installmentdue_Amount = document.getElementById('Installmentdue_Amount').value;
            var install_payment = document.getElementById('install_payment').value;
            var SavingAmount_close = document.getElementById('SavingAmount_close').value;
            var Savingsavingblanch = document.getElementById('savingblanch').value;
            var dis_amount = document.getElementById('dis_amount').value;
            var paymentvalu = Installmentdue_Amount - install_payment;
            var savingminus = paymentvalu - SavingAmount_close;
            var lastblanch = savingminus - dis_amount;
            document.getElementById('Blanch_amount').value = '৳ '+ lastblanch;

            var SavingAmount = parseInt(SavingAmount_close) ;
            var savingblanch = parseInt(Savingsavingblanch) ;
            if(SavingAmount > savingblanch){
                alert("Withdrawal Amount Not Available");
                $('#SavingAmount_close').val('');
            }

            if(lastblanch != 0){
                //alert("Check Adjust Cash");
                $('#submit_data').attr('disabled','disabled');
            }else{
                $('#submit_data').attr('disabled',false);
            }
        }
    </script>

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
                    $("#member_name_penalty").val(data.membername);
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
                    $("#member_name_collection").val(data.membername);
                    $("#voucher_collection").val(data.voucher_no);
                    $("#due_voucher_amount").val(data.vouchercount);
                    $("#installment_amount").val(data.installment).css({"color": "blue", "font-weight": "bold"});
                    $("#due_installment").val(data.previusdue).css({"color": "red", "font-weight": "bold"});
                    $("#penalty_due").val(data.penaltydue).css({"color": "purple", "font-weight": "bold"});
                    document.getElementById("collection_pay").focus();
                    $('.paymentCollection_data').attr('action', '/Investment/Return-Collection/');
                }
            });
            $("#InvestmentCollection").modal('show');

        });
    </script>
@endsection
