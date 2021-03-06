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
                        <div class="card-title">{{ ucwords('all member') }}</div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover" id="allMembersDataTable">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ ucwords('image') }}</th>
                                <th class="text-center">{{ ucwords('member no') }}</th>
                                <th class="text-center">{{ ucwords('name') }}</th>
                                <th class="text-center">{{ ucwords('phone') }}</th>
                                <th class="text-center">{{ ucwords('nid no') }}</th>
                                <th class="text-center">{{ ucwords('status') }}</th>
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
                                        @if($member->nidImage->member_image != null)
                                            <img width="30px" src="{{ asset('Media/Member_Avature/'.$member->nidImage->member_image) }}" alt="Image">
                                        @endif
                                    </td>
                                    <td>{{ $member->member_no }}</td>
                                    <td>{{ ucwords($member->name) }}</td>
                                    <td>{{ $member->mobile }}</td>
                                    <td>{{ $member->nidImage->nuid_no }}</td>
                                    <td>{{ $member->status != false ? ucwords('active'): ucwords('deactive') }}</td>

                                    <td>
                                        <a href="{{ route('Member.show',$member->slag) }}">
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
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script !src="">
        $(function () {
            $('#allMembersDataTable').DataTable();
        })
    </script>
@endsection


