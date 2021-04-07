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
                        <div class="card-title">{{ ucwords(' member accounts') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ ucwords('image') }}</th>
                                <th class="text-center">{{ ucwords('name') }}</th>
                                <th class="text-center">{{ ucwords('invest') }}</th>
                                <th class="text-center">{{ ucwords('payment') }}</th>
                                <th class="text-center">{{ ucwords('Inv-Blanch') }}</th>
                                <th class="text-center">{{ ucwords('penalty') }}</th>
                                <th class="text-center">{{ ucwords('saving') }}</th>
                                <th class="text-center">{{ ucwords('dps') }}</th>
                                <th class="text-center"><i class="i-Eye font-weight-bold"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($members as $member)
                                <tr>
                                    <th>{{ $i }}</th>
                                    <td>
                                        @if($member->member->nidImage->member_image != null)
                                            <img width="30px" src="{{ asset('Media/Member_Avature/'.$member->member->nidImage->member_image) }}" alt="Image">
                                        @endif
                                    </td>
                                    <td>{{ ucwords($member->member->name) }}</td>
                                    <td>{{ $member->return_investment != false ? $member->return_investment: ucwords('0') }}</td>
                                    <td>{{ $member->investment_pay != false ? $member->investment_pay: ucwords('0') }}</td>
                                    <td>{{ $member->rest_investment != false ? $member->rest_investment: ucwords('0') }}</td>

                                        @php
                                          $panaltyBalance = 0;
                                           foreach ($member->member->penaltys as $data){
                                               $panaltyBalance += $data->penalty;
                                           }
                                        @endphp
                                    <td>{{ $panaltyBalance}}</td>
                                    <td>{{ $member->saving_amount != false ? $member->saving_amount: ucwords('0') }}</td>
                                    <td>{{ $member->dps_amount != false ? $member->dps_amount: ucwords('0') }}</td>

                                    <td>
                                        <a href="">
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
                        <div class="text-center">
                            {{ $members->links() }}
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


