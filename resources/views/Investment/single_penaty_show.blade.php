@extends('layouts.master-layouts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ ucwords('member saving details') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allMembersDataTable">
                            <thead>
                            <tr>
                                <th class="text-center">SL</th>
                                <th class="text-center">{{ ucwords('date') }}</th>
                                <th class="text-center">{{ ucwords('voucher no') }}</th>
                                <th class="text-center">{{ ucwords('amount') }}</th>
                                <th class="text-center">{{ ucwords('status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($penaltydata as $member)
                                <tr>
                                    <th>{{ $i }}</th>
                                    <td>{{ $member->date}}</td>
                                    <td>{{ $member->voucher_no}}</td>
                                    <td>{{ $member->penalty}}</td>
                                    <td>
                                        @if($member->status==1)
                                            {!! '<b class="text-success">'.strtoupper('paid').'</b>' !!}
                                        @else
                                            {!! '<b class="text-danger">'.strtoupper('due').'</b>' !!}
                                        @endif

                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
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
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script !src="">
        $(function () {
            $('#allMembersDataTable').DataTable();
        })
    </script>
@endsection


