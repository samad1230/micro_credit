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
                    <div class="card-header  ">
                        <div class="card-title">
                            <span>{{ ucwords('cash blanch details') }}</span>
                            <span class="float-right p-3 text-white {{ is_int(strpos($cashAtHand,'-')) != true ? 'bg-primary' : 'bg-danger' }}" style="border-radius: 10px; margin-right: 10px;">{!! ucwords('cash : ').number_format($cashAtHand,'2','.',',') !!}</span>
                            <span class="float-right p-3 text-white {{ is_int(strpos($cashcrBalance,'-')) != true ? 'bg-warning' : 'bg-danger' }}" style="border-radius: 10px; margin-right: 10px;">{!! ucwords('Credit : ').number_format($cashcrBalance,'2','.',',') !!}</span>

                            <span class="float-right p-3 text-white {{ is_int(strpos($cashDrBalance,'-')) != true ? 'bg-success' : 'bg-danger' }}" style="border-radius: 10px;margin-right: 10px;">{!! ucwords('debit : ').number_format($cashDrBalance,'2','.',',') !!}</span>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="">
                            <thead class="thead-dark">
                            <tr>
                                <th class="text-center">SL</th>
                                <th class="text-center">{{ ucwords('Date') }}</th>
                                <th class="text-center">{{ ucwords('description') }}</th>
                                <th class="text-center">{{ ucwords('debit') }}</th>
                                <th class="text-center">{{ ucwords('Credit') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($cashs as $data)
                                <tr>
                                    <th>{{ $i }}</th>
                                    <td>{{ $data->date }}</td>
                                    <td>{{ ucwords($data->description) }}</td>
                                    <td>{{$data->dr == null ? ucwords('0'): $data->dr }}</td>
                                    <td>{{$data->cr == null ? ucwords('0'): $data->cr }}</td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $cashs->links() }}
                        </div>
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


