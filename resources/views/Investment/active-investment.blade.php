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
                        <div class="card-title">{{ ucwords('active investments') }}</div>
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
                                <th class="text-center">{{ ucwords('interest') }}</th>
                                <th class="text-center">{{ ucwords('invest return') }}</th>
                                <th class="text-center">{{ ucwords('status') }}</th>
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
                                    <td>{{ number_format($investment->investment_amount,'2','.',',') }}</td>
                                    <td>{{ number_format($investment->interest_rate,'2','.',',') .'%' }}</td>
                                    <td>{{ number_format($investment->investment_return_amount,'2','.',',') }}</td>
                                    <td>{{ $investment->status ? ucwords('active'):ucwords('dactive') }}</td>
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
