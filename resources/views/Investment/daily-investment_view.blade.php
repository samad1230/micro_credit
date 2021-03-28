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
                        <div class="card-title">{{ ucwords('daily installment amount') }}</div>
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

                                <tr>
                                    <th>{{ $sl}}</th>
                                    <td>{{ $installment->investment->member->name }}</td>
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
                                    <td>
                                        @if(@$saving->amount != null)
                                            {{ number_format($saving->amount,'2','.',',') }}
                                        @else
                                            <button type="button" class="btn btn-warning btn-sm savingcollectionBtn" id="{{ $installment->voucher_no }}">Saving</button>
                                        @endif
                                    </td>
                                    <td>{{ number_format($installment->rest_amount,'2','.',',') }}</td>
                                    <td>{!! $installment->status ? '<b class="text-success">'.strtoupper('payed').'</b>':'<b class="text-danger">'.strtoupper('due').'</b>' !!}</td>
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
@endsection

@section('page-script')
    {{--    <script src="{{ asset('assets/js/scripts/form.validation.script.min.js') }}"></script>--}}
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script !src="">
        $(function () {
            $('#allInvestmentsDataTable').DataTable();
        })
    </script>
@endsection
