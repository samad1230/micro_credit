@extends('layouts.master-layouts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endsection

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{ ucwords(' member accounts') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allInstallmentsTable">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ ucwords('name') }}</th>
                                <th class="text-center">{{ ucwords('invest') }}</th>
                                <th class="text-center">{{ ucwords('penalty') }}</th>
                                <th class="text-center"><i class="i-Eye font-weight-bold"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($penaltydata as $penalty)
                                <tr>
                                    <th>{{ $i }}</th>
                                    <td>{{ ucwords($penalty->member->name) }}</td>
                                        @foreach($penalty->member->Loans as $row)
                                        @endforeach
                                    <td>{{ ucwords($row->investment_no) }}</td>
                                    <td>{{ $penalty->penaltyamount != false ? $penalty->penaltyamount: ucwords('0') }}</td>
                                    <td>
                                        <a href="{{ route('penalty.show',$penalty->member->id) }}">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')

    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/payment_saving.js') }}"></script>

@endsection


