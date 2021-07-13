@extends('layouts.master-layouts')

@section('page-css')
    <style>
        .modal-body {
            position: relative;
            flex: 1 1 auto;
            padding: 0.7rem;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-12 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <span>{{ ucwords('pending investments') }}</span>
                            <span class="float-right p-3 text-white {{ is_int(strpos($cashAtHand,'-')) != true ? 'bg-success' : 'bg-danger' }}" style="border-radius: 10px;">{!! ucwords('investable amount: ').number_format($cashAtHand,'2','.',',') !!}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allInvestmentsDataTable">
                            <thead>
                            <tr>
                                <th class="text-center">{{ ucwords('sl') }}</th>
                                <th class="text-center">{{ ucwords('member') }}</th>
                                <th class="text-center">{{ ucwords('section') }}</th>
                                <th class="text-center">{{ ucwords('investment') }}</th>
                                <th class="text-center">{{ ucwords('disburse') }}</th>
                                <th class="text-center">{{ ucwords('invest amount') }}</th>
{{--                                <th class="text-center">{{ ucwords('down-payment / savings') }}</th>--}}
                                <th class="text-center">{{ ucwords('interest') }}</th>
                                <th class="text-center">{{ ucwords('invest return') }}</th>
                                <th class="text-center">{{ ucwords('Update') }}</th>
                                <th class="text-center"><i class="i-Eye font-weight-bold"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $sl=1;?>
                            @foreach($investments as $investment)
                                <tr>
                                    <th>{{ $sl}}</th>
                                    <td>{{ $investment->member->name}}</td>
                                    <td>{{ date('d-m-Y',strtotime($investment->sanction_date)) }}</td>
                                    <td>{{ $investment->investment_no }}</td>
                                    <td>{{ date('d-m-Y',strtotime($investment->disburse_date)) }}</td>
                                    <td>{{ number_format($investment->investment_amount - $investment->downpayment,'2','.',',') }}</td>
{{--                                    <td>{{ $investment->downpayment != null ? ucwords('down-payment: '). number_format($investment->downpayment,'2','.',',') : ucwords('total savings: '). number_format($investment->savings_per_installment * ($investment->iRInstallments != null ? $investment->iRInstallments()->where('status',true)->count() : 0),'2','.',',') }}</td>--}}
                                    <td>{{ number_format($investment->interest_rate,'2','.',',') .'%' }}</td>
                                    <td>{{ number_format($investment->investment_return_amount,'2','.',',') }}</td>


                                    <td><button type="button" class="btn btn-warning btn-sm invest_update" id="{{ $investment->id }}">Update</button></td>
                                    <td>
                                        <a href="{{ route('admin.single-investment',$investment->investment_no) }}">
                                            <button type="button" class="btn btn-primary btn-sm">View</button>
                                        </a>
                                    </td>
                                </tr>
                                <?php $sl++;?>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="investmentupdatedata" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id=""></h4>
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
                    <form action="" class="investmentdata_update" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="old_downpayment" id="down_paymentstore">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="investmentAmount">{{ ucwords('Investment Amount') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="investment_amount" id="investmentAmount" type="number" placeholder="BDT" value="" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>
                        <div class="downpaymentform">

                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class=" " for="investmentRate">{{ ucwords('Interest') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="interest_rate" id="investmentRate" type="tel" placeholder="Investment rate at (%)" value="" required="required" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="installmentCount">{{ ucwords('Installment count') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="installment_count" id="installmentCount" type="number" placeholder="Number of Installment" value="" required="required" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="">{{ ucwords('investment ReturnAmount') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="return_investment" id="investmentReturnAmount" type="number" placeholder="BDT" value="" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="installmentAmount">{{ ucwords('per/Installment amount') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="installment_Amount" id="installmentAmount" onkeyup="checkFunction()">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">{{ ucwords('disburse date') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="disburse_date" id="disburseDate" type="date" value="" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">{{ ucwords('installment date') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" name="installment_date" id="installmentDate" type="date" value="" required="required">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="" for="Contact">{{ ucwords('disburse or wetting') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control" name="disburse_status" id="" required>
                                        <option value="">Select Status</option>
                                        <option value="1">{{ucwords('disbursement')}}</option>
                                        <option value="0">{{ucwords('wetting')}}</option>
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
    {{--    <script src="{{ asset('assets/js/scripts/form.validation.script.min.js') }}"></script>--}}
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script !src="">
        $(function () {
            $('#allInvestmentsDataTable').DataTable();
        })
    </script>

    <script>
        $(document).on("click", ".invest_update", function(e){
            e.preventDefault();
            var investid = $(this).attr('id');

            $.ajax({
                type: 'GET',
                url:'/investment/update/'+investid,
                success: function (data) {
                    if (data.investment_type=="cash"){
                        $('.downpaymentform').empty().append('');
                    }else{
                        $('.downpaymentform').empty().append('<div class="modal-body">\n' +
                            '                                <div class="row">\n' +
                            '                                    <div class="col-md-6">\n' +
                            '                                        <label class="" for="down_payment">Down Payment</label>\n' +
                            '                                    </div>\n' +
                            '                                    <div class="col-md-6">\n' +
                            '                                        <input class="form-control" name="downpayment" id="down_payment" type="number" placeholder="BDT" value="" onchange="checkFunction()">\n' +
                            '                                    </div>\n' +
                            '                                </div>\n' +
                            '                            </div>');
                    }

                    $('.modal-title').append("Investment Update for : "+data.member);
                    $("#down_payment").val(data.downpayment);
                    $("#down_paymentstore").val(data.downpayment);
                    $("#investmentAmount").val(data.investment_amount);
                    $("#investmentReturnAmount").val(data.investmentReturn);
                    $("#investmentRate").val(data.interest_rate);
                    $("#installmentCount").val(data.installment_count);
                    $("#installmentAmount").val(data.installment_amount);
                    $("#disburseDate").val(data.disburse_date);

                    $('.investmentdata_update').attr('action', '/Investment_Data_update/'+investid);
                }
            });


            $("#investmentupdatedata").modal('show');
            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;
            var day = dtToday.getDate();
            var year = dtToday.getFullYear();
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();

            var disburseMaxDate = year + '-' + month + '-' + (day);
            //$('#disburseDate').attr('min', disburseMaxDate);
            $('#disburseDate').attr(disburseMaxDate);
            $('#installmentDate').attr(disburseMaxDate);
        });

        function checkFunction() {
            var investmentAmount = document.getElementById('investmentAmount').value;
            var downpayment = document.getElementById('down_payment').value;
            var investmentRate = document.getElementById('investmentRate').value;
            var installmentCount = document.getElementById('installmentCount').value;
            var installmentAmount = document.getElementById('installmentAmount').value;
            var down_paymentstore = document.getElementById('down_paymentstore').value;


            if (down_paymentstore > downpayment ){
                downpayment = document.getElementById('down_payment').value = down_paymentstore;
            }

            if(downpayment.length > 0){
                investmentAmount = Math.round(document.getElementById('investmentAmount').value) - Math.round(downpayment);
            }

            var interest = (parseFloat(investmentAmount) * parseFloat(investmentRate)) / 100;
            var investmentReturnAmount = parseFloat(investmentAmount) + parseFloat(interest);
            document.getElementById('investmentReturnAmount').value = investmentReturnAmount;
            var installmentAmount = investmentReturnAmount / installmentCount;
            installmentAmount = installmentAmount.toFixed(2);

            document.getElementById('installmentAmount').value = '৳ ' + Math.round(installmentAmount);

        }
    </script>
@endsection
