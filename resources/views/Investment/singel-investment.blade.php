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
                                                    <button type="button" class="btn btn-primary viewGuardianNidBtn" id="{{ $guardian->id }}">View Nid Image</button>
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
                                        <tr>
                                            <td>{{ $installment->voucher_no }}</td>
                                            <td>{{ date('d-m-y',strtotime($installment->date)) }}</td>
                                            <td>{{ number_format($installment->installment_amount,'2','.',',') }}</td>
                                            <td>
                                                @if($installment->collection_amount != null || $installment->status)
                                                    {{ number_format($installment->collection_amount,'2','.',',') }}
                                                @else
                                                    <button type="button" class="btn btn-warning btn-sm collectionBtn" id="{{ $installment->voucher_no }}">Collect</button>
                                                @endif
                                            </td>
                                            <td>{{ number_format($installment->rest_amount,'2','.',',') }}</td>
                                            <td>{!! $installment->status ? '<b class="text-success">'.strtoupper('payed').'</b>':'<b class="text-danger">'.strtoupper('due').'</b>' !!}</td>
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
@endsection

@section('page-script')
    {{--    <script src="{{ asset('assets/js/scripts/form.validation.script.min.js') }}"></script>--}}
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script !src="">
        $(function () {
            $('#allInstallmentsTable').DataTable();

            $('.collectionBtn').on('click',function () {
                var voucherNo = $(this).attr('id');
                swal({
                    content: {
                        element: "input",
                        attributes: {
                            placeholder: "BTD",
                            type: "number",
                        },
                    },
                    buttons: {
                        cancel: 'Not Now',
                        confirm: 'Pay Now'
                    },
                })
                    .then((value) => {
                        if (value) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type: 'post',
                                url: '/admin/investment-installment',
                                data: {
                                    "collection":value,
                                    "voucher_no":voucherNo,
                                },
                                success:function (data) {
                                    console.log(data);
                                    if(data == 'success'){
                                        swal("Payment has been taken!",{
                                            icon: "success",
                                        });
                                        location.reload();
                                    }else {
                                        swal("Invalid Entry!",{
                                            icon: "error",
                                        });
                                    }

                                }
                            })
                        } else {
                            swal("Please make payment as early you can!");
                        }
                    });
            });
        })
    </script>
@endsection
